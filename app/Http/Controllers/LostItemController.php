<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLostItemRequest;
use App\Models\FoundItem;
use App\Models\LostItem;
use App\Notifications\MatchFoundNotification;
use Illuminate\Http\Request;

class LostItemController extends Controller
{
    public function index(Request $request)
    {
        $query = LostItem::with('user')->latest();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('item_name', 'like', "%$s%")
                  ->orWhere('category', 'like', "%$s%")
                  ->orWhere('brand', 'like', "%$s%")
                  ->orWhere('color', 'like', "%$s%")
                  ->orWhere('last_seen_location', 'like', "%$s%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $items = $query->paginate(12)->withQueryString();

        return view('lost-items.index', compact('items'));
    }

    public function create()
    {
        return view('lost-items.create');
    }

    public function store(StoreLostItemRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('lost-items', 'public');
        }

        unset($data['image']);
        $lostItem = LostItem::create($data);

        // Notify the poster if any existing found items match
        $this->notifyMatches($lostItem);

        return redirect()->route('lost-items.index')
            ->with('success', 'Lost item posted successfully!');
    }

    public function show(LostItem $lostItem)
    {
        return view('lost-items.show', ['item' => $lostItem]);
    }

    private function notifyMatches(LostItem $lostItem): void
    {
        FoundItem::with('user')
            ->where('status', 'unclaimed')
            ->where(function ($q) use ($lostItem) {
                $q->where('category', $lostItem->category)
                  ->orWhere('color', 'like', "%{$lostItem->color}%")
                  ->orWhere('item_name', 'like', "%{$lostItem->item_name}%");

                if (!empty($lostItem->brand)) {
                    $q->orWhere('brand', 'like', "%{$lostItem->brand}%");
                }
            })
            ->get()
            ->each(function (FoundItem $foundItem) use ($lostItem) {
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
