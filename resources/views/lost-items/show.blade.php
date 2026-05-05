<x-app-layout>
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <a href="{{ route('lost-items.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 mb-6 transition">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
        Back to Lost Items
    </a>

    @if(session('success'))
        <div class="mb-5 flex items-center gap-2 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm font-medium">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden shadow-sm">
        <div class="flex flex-col md:flex-row">

            {{-- Image --}}
            <div class="md:w-2/5 bg-gray-50 flex items-center justify-center" style="min-height:280px">
                @if($item->image_path)
                    <img src="{{ Storage::url($item->image_path) }}" alt="{{ $item->item_name }}"
                         class="w-full h-full object-contain p-6" style="max-height:380px">
                @else
                    <div class="flex flex-col items-center py-16" style="color:#d1d5db">
                        <svg width="48" height="48" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        <p class="text-sm mt-2">No photo</p>
                    </div>
                @endif
            </div>

            {{-- Details --}}
            <div class="md:w-3/5 p-6 sm:p-8 flex flex-col border-t md:border-t-0 md:border-l border-gray-100">
                <div class="flex items-start justify-between gap-3 mb-5">
                    <div>
                        <p class="text-xs font-bold text-blue-500 uppercase tracking-widest mb-1">{{ $item->category }}</p>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $item->item_name }}</h1>
                        <p class="text-sm text-gray-400 mt-1">Posted by <span class="text-gray-600 font-medium">{{ $item->user->name }}</span></p>
                    </div>
                    <span class="shrink-0 text-xs font-bold px-3 py-1.5 rounded-full uppercase
                        {{ $item->status==='missing' ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-700' }}">
                        {{ $item->status }}
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-3 mb-5">
                    <div class="bg-gray-50 rounded-xl p-3">
                        <p class="text-xs text-gray-400 mb-0.5">Brand</p>
                        <p class="font-semibold text-gray-800 text-sm">{{ $item->brand ?: '—' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-3">
                        <p class="text-xs text-gray-400 mb-0.5">Color</p>
                        <p class="font-semibold text-gray-800 text-sm">{{ $item->color }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-3 col-span-2">
                        <p class="text-xs text-gray-400 mb-0.5">Date Lost</p>
                        <p class="font-semibold text-gray-800 text-sm">{{ \Carbon\Carbon::parse($item->date_lost)->format('F d, Y') }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-3 col-span-2">
                        <p class="text-xs text-gray-400 mb-0.5">Last Seen Location</p>
                        <p class="font-semibold text-gray-800 text-sm">{{ $item->last_seen_location }}</p>
                    </div>
                    @if($item->description)
                        <div class="bg-gray-50 rounded-xl p-3 col-span-2">
                            <p class="text-xs text-gray-400 mb-0.5">Description</p>
                            <p class="text-gray-800 text-sm leading-relaxed">{{ $item->description }}</p>
                        </div>
                    @endif
                </div>

                <div class="mt-auto">
                    <div class="bg-blue-50 border border-blue-100 rounded-xl p-4">
                        <p class="text-xs font-bold text-blue-600 uppercase tracking-widest mb-3">Contact the Owner</p>
                        <div class="space-y-2 text-sm text-gray-700">
                            <div class="flex items-center gap-2">
                                <svg width="15" height="15" fill="none" stroke="#60a5fa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                {{ $item->user->name }}
                            </div>
                            <div class="flex items-center gap-2">
                                <svg width="15" height="15" fill="none" stroke="#60a5fa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                                {{ $item->user->email }}
                            </div>
                            <div class="flex items-center gap-2">
                                <svg width="15" height="15" fill="none" stroke="#60a5fa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81 19.79 19.79 0 01.01 1.18 2 2 0 012 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
                                {{ $item->user->contact_number ?? '—' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
