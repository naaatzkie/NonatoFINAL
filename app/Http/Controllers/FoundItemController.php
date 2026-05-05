<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFoundItemRequest;
use App\Models\FoundItem;
use App\Models\LostItem;
use App\Notifications\MatchFoundNotification;
use Illuminate\Http\Request;

class FoundItemController extends Controller
{
    public function index(Request $request)
    {
        $query = FoundItem::with('user')->latest();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('item_name', 'like', "%$s%")
                  ->orWhere('category', 'like', "%$s%")
                  ->orWhere('brand', 'like', "%$s%")
                  ->orWhere('color', 'like', "%$s%")
                  ->orWhere('place_found', 'like', "%$s%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $items = $query->paginate(12)->withQueryString();

        return view('found-items.index', compact('items'));
    }

    public function create()
    {
        return view('found-items.create');
    }

    public function store(StoreFoundItemRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('found-items', 'public');
        }

        unset($data['image']);
        $foundItem = FoundItem::create($data);

        // Match against open lost items
        $this->notifyMatches($foundItem);

        return redirect()->route('found-items.index')
            ->with('success', 'Item reported successfully!');
    }

    public function show(FoundItem $foundItem)
    {
        return view('found-items.show', ['item' => $foundItem]);
    }

    public function claim(FoundItem $foundItem)
    {
        $foundItem->update(['status' => 'claimed']);
        return back()->with('success', 'Item marked as claimed.');
    }

    private function notifyMatches(FoundItem $foundItem): void
    {
        LostItem::with('user')
            ->where('status', 'missing')
            ->where(function ($q) use ($foundItem) {
                $q->where('category', $foundItem->category)
                  ->orWhere('color', 'like', "%{$foundItem->color}%")
                  ->orWhere('item_name', 'like', "%{$foundItem->item_name}%");

                if (!empty($foundItem->brand)) {
                    $q->orWhere('brand', 'like', "%{$foundItem->brand}%");
                }
            })
            ->get()
            ->each(function (LostItem $lostItem) use ($foundItem) {
                // Avoid duplicate notifications for the same pair
                $alreadyNotified = $lostItem->user->notifications()
                    ->where('type', MatchFoundNotification::class)
                    ->whereJsonContains('data->found_item_id', $foundItem->id)
                    ->whereJsonContains('data->lost_item_id', $lostItem->id)
                    ->exists();

                if (!$alreadyNotified) {
                    $lostItem->user->notify(new MatchFoundNotification($lostItem, $foundItem));
                }
            });
    }
}
