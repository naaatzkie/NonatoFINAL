<x-app-layout>
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Notifications</h1>
        <p class="text-sm text-gray-500 mt-1">Possible matches between lost and found items.</p>
    </div>

    @if($notifications->isEmpty())
        <div class="bg-white border border-gray-200 rounded-2xl py-20 text-center">
            <div class="bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4" style="width:56px;height:56px">
                <svg width="26" height="26" fill="none" stroke="#9ca3af" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/>
                </svg>
            </div>
            <p class="font-semibold text-gray-700">No notifications yet</p>
            <p class="text-sm text-gray-400 mt-1">You'll be notified when a found item matches something you lost.</p>
        </div>
    @else
        <div class="space-y-3">
            @foreach($notifications as $notification)
                <div class="bg-white border border-gray-200 rounded-2xl p-5 flex gap-4 items-start">
                    <div class="rounded-xl flex items-center justify-center shrink-0 bg-blue-50" style="width:44px;height:44px">
                        <svg width="22" height="22" fill="none" stroke="#3b82f6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="6"/><line x1="16.5" y1="16.5" x2="21" y2="21"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900">Possible Match Found</p>
                        <p class="text-sm text-gray-600 mt-0.5">{{ $notification->data['message'] }}</p>
                        <div class="flex flex-wrap gap-3 mt-3">
                            <a href="{{ route('found-items.show', $notification->data['found_item_id']) }}"
                               class="inline-flex items-center gap-1.5 text-xs font-semibold bg-gray-900 hover:bg-gray-700 text-white px-3 py-1.5 rounded-lg transition">
                                View Found Item
                            </a>
                            <a href="{{ route('lost-items.show', $notification->data['lost_item_id']) }}"
                               class="inline-flex items-center gap-1.5 text-xs font-semibold border border-gray-300 text-gray-700 hover:bg-gray-50 px-3 py-1.5 rounded-lg transition">
                                View Lost Item
                            </a>
                        </div>
                    </div>
                    <div class="shrink-0 text-xs text-gray-400 whitespace-nowrap">
                        {{ $notification->created_at->diffForHumans() }}
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-6">{{ $notifications->links() }}</div>
    @endif
</div>
</x-app-layout>
