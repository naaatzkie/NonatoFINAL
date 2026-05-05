<x-app-layout>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Lost Items</h1>
            <p class="text-sm text-gray-500 mt-1">Recently posted missing items — recognise something? Contact the owner.</p>
        </div>
        <a href="{{ route('lost-items.create') }}"
           class="inline-flex items-center gap-2 bg-gray-900 hover:bg-gray-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition shrink-0">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" viewBox="0 0 24 24"><line x1="12" y1="4" x2="12" y2="20"/><line x1="4" y1="12" x2="20" y2="12"/></svg>
            Post Lost Item
        </a>
    </div>

    @if(session('success'))
        <div class="mb-5 flex items-center gap-2 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm font-medium">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Filters --}}
    <form method="GET" action="{{ route('lost-items.index') }}"
          class="bg-white border border-gray-200 rounded-2xl p-4 mb-6 flex flex-wrap gap-3 items-end">
        <div class="flex-1 min-w-[180px]">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Search</label>
            <div class="relative">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><circle cx="11" cy="11" r="6"/><line x1="16.5" y1="16.5" x2="21" y2="21"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Name, color, brand, location…"
                       class="w-full pl-9 pr-3 py-2 border border-gray-200 rounded-xl text-sm bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400">
            </div>
        </div>
        <div class="min-w-[150px]">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Category</label>
            <select name="category" class="w-full border border-gray-200 rounded-xl text-sm py-2 px-3 bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">All Categories</option>
                @foreach(['Electronics','Clothing','Accessories','Documents','Bags','Keys','Wallet','Jewelry','Sports','Other'] as $cat)
                    <option value="{{ $cat }}" @selected(request('category')===$cat)>{{ $cat }}</option>
                @endforeach
            </select>
        </div>
        <div class="min-w-[130px]">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">Status</label>
            <select name="status" class="w-full border border-gray-200 rounded-xl text-sm py-2 px-3 bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">All</option>
                <option value="missing" @selected(request('status')==='missing')>Missing</option>
                <option value="found"   @selected(request('status')==='found')>Found</option>
            </select>
        </div>
        <div class="flex gap-2 items-center">
            <button type="submit" class="bg-gray-900 hover:bg-gray-700 text-white text-sm font-semibold px-5 py-2 rounded-xl transition">Filter</button>
            @if(request()->hasAny(['search','category','status']))
                <a href="{{ route('lost-items.index') }}" class="text-sm text-gray-400 hover:text-gray-600">Clear</a>
            @endif
        </div>
    </form>

    @if(!$items->isEmpty())
        <p class="text-sm text-gray-500 mb-4"><span class="font-semibold text-gray-700">{{ $items->total() }}</span> item{{ $items->total()!==1?'s':'' }} listed</p>
    @endif

    @if($items->isEmpty())
        <div class="bg-white border border-gray-200 rounded-2xl py-20 text-center">
            <div class="bg-blue-50 rounded-2xl flex items-center justify-center mx-auto mb-4" style="width:56px;height:56px">
                <svg width="28" height="28" fill="none" stroke="#3b82f6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/></svg>
            </div>
            <p class="font-semibold text-gray-700">No lost items posted yet</p>
            <p class="text-sm text-gray-400 mt-1">Lost something? Let others know.</p>
            <a href="{{ route('lost-items.create') }}" class="inline-flex items-center gap-1.5 mt-4 text-sm text-blue-600 hover:text-blue-800 font-medium">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" viewBox="0 0 24 24"><line x1="12" y1="4" x2="12" y2="20"/><line x1="4" y1="12" x2="20" y2="12"/></svg>
                Post a lost item
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            @foreach($items as $item)
                <a href="{{ route('lost-items.show', $item) }}"
                   class="group bg-white border border-gray-200 rounded-2xl overflow-hidden hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 flex flex-col">
                    <div class="relative bg-gray-50 overflow-hidden" style="height:176px">
                        @if($item->image_path)
                            <img src="{{ Storage::url($item->image_path) }}" alt="{{ $item->item_name }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        @else
                            <div class="absolute inset-0 flex flex-col items-center justify-center" style="color:#d1d5db">
                                <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                <span style="font-size:11px;margin-top:6px">No photo</span>
                            </div>
                        @endif
                        <span class="absolute top-2 right-2 text-xs font-bold px-2.5 py-1 rounded-full
                            {{ $item->status==='missing' ? 'bg-red-500 text-white' : 'bg-green-500 text-white' }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </div>
                    <div class="p-4 flex flex-col flex-1 gap-2">
                        <div>
                            <p class="text-xs font-semibold text-blue-500 uppercase tracking-wide">{{ $item->category }}</p>
                            <h3 class="font-semibold text-gray-900 text-sm mt-0.5">{{ $item->item_name }}</h3>
                        </div>
                        <div class="mt-auto pt-2 border-t border-gray-100 space-y-1.5 text-xs text-gray-500">
                            <div class="flex items-center gap-1.5">
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                <span class="truncate">{{ $item->last_seen_location }}</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                {{ \Carbon\Carbon::parse($item->date_lost)->format('M d, Y') }}
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        <div class="mt-8">{{ $items->links() }}</div>
    @endif
</div>
</x-app-layout>
