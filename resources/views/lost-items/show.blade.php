<x-app-layout>
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <a href="{{ route('lost-items.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-blue-600 transition mb-6 font-medium">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
        Back to Lost Items
    </a>

    @if(session('success'))
        <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm font-medium">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl overflow-hidden" style="box-shadow:0 4px 30px rgba(0,0,0,0.08)">
        <div class="flex flex-col md:flex-row">

            {{-- Image --}}
            <div class="md:w-2/5 flex items-center justify-center" style="background:linear-gradient(135deg,#f8faff,#eff6ff);min-height:280px">
                @if($item->image_path)
                    <img src="{{ Storage::url($item->image_path) }}" alt="{{ $item->item_name }}"
                         class="w-full h-full object-contain p-6" style="max-height:400px">
                @else
                    <div class="flex flex-col items-center py-16">
                        <svg width="56" height="56" fill="none" stroke="#bfdbfe" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/>
                        </svg>
                        <p class="text-sm text-blue-200 mt-3 font-medium">No photo provided</p>
                    </div>
                @endif
            </div>

            {{-- Details --}}
            <div class="md:w-3/5 p-7 flex flex-col border-t md:border-t-0 md:border-l border-gray-100">

                {{-- Prominent top row: status + category --}}
                <div class="flex items-center gap-2 mb-3">
                    <span class="inline-block text-xs font-bold text-blue-500 bg-blue-50 px-2.5 py-1 rounded-lg uppercase tracking-widest">{{ $item->category }}</span>
                    <span class="text-xs font-bold px-2.5 py-1 rounded-lg uppercase tracking-wide"
                          style="{{ $item->status==='missing' ? 'background:#fee2e2;color:#991b1b' : 'background:#d1fae5;color:#065f46' }}">
                        {{ $item->status }}
                    </span>
                </div>

                <h1 class="text-2xl font-extrabold text-gray-900 mb-1">{{ $item->item_name }}</h1>
                <p class="text-sm text-gray-400 mb-6">Posted by <span class="text-gray-600 font-semibold">{{ $item->user->name }}</span></p>

                {{-- Uniform 2-col grid for all details --}}
                <div class="grid grid-cols-2 gap-3 mb-6">
                    <div class="rounded-xl p-3.5" style="background:#f8faff">
                        <p class="text-xs text-gray-400 font-medium mb-0.5">Brand</p>
                        <p class="font-bold text-gray-800 text-sm">{{ $item->brand ?: '—' }}</p>
                    </div>
                    <div class="rounded-xl p-3.5" style="background:#f8faff">
                        <p class="text-xs text-gray-400 font-medium mb-0.5">Color</p>
                        <p class="font-bold text-gray-800 text-sm">{{ $item->color }}</p>
                    </div>
                    <div class="rounded-xl p-3.5" style="background:#f8faff">
                        <p class="text-xs text-gray-400 font-medium mb-0.5">Date Lost</p>
                        <p class="font-bold text-gray-800 text-sm">{{ \Carbon\Carbon::parse($item->date_lost)->format('M d, Y') }}</p>
                    </div>
                    <div class="rounded-xl p-3.5" style="background:#f8faff">
                        <p class="text-xs text-gray-400 font-medium mb-0.5">Last Seen</p>
                        <p class="font-bold text-gray-800 text-sm truncate">{{ $item->last_seen_location }}</p>
                    </div>
                    @if($item->description)
                        <div class="col-span-2 rounded-xl p-3.5" style="background:#f8faff">
                            <p class="text-xs text-gray-400 font-medium mb-0.5">Description</p>
                            <p class="text-gray-700 text-sm leading-relaxed">{{ $item->description }}</p>
                        </div>
                    @endif
                </div>

                {{-- Contact box with hover shadow for interactivity --}}
                <div class="mt-auto rounded-xl p-4 transition-shadow hover:shadow-md cursor-default"
                     style="background:linear-gradient(135deg,#eff6ff,#dbeafe);border:1px solid #bfdbfe">
                    <p class="text-xs font-bold text-blue-700 uppercase tracking-widest mb-3">Contact the Owner</p>
                    <div class="space-y-2.5 text-sm">
                        <div class="flex items-center gap-2.5 text-gray-700">
                            <svg width="15" height="15" fill="none" stroke="#1d4ed8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            <span class="font-medium">{{ $item->user->name }}</span>
                        </div>
                        <div class="flex items-center gap-2.5 text-gray-700">
                            <svg width="15" height="15" fill="none" stroke="#1d4ed8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            {{ $item->user->email }}
                        </div>
                        <div class="flex items-center gap-2.5 text-gray-700">
                            <svg width="15" height="15" fill="none" stroke="#1d4ed8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.81 19.79 19.79 0 01.01 1.18 2 2 0 012 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
                            {{ $item->user->contact_number ?? '—' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
