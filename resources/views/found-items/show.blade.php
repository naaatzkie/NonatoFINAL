<x-app-layout>
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <a href="{{ route('found-items.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-blue-600 transition mb-6 font-medium">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
        Back to Found Items
    </a>

    @if(session('success'))
        <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm font-medium">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl overflow-hidden" style="box-shadow:0 4px 30px rgba(0,0,0,0.08);border:1px solid #e8edf5">
        <div class="flex flex-col md:flex-row">

            {{-- Image --}}
            <div class="md:w-2/5 flex items-center justify-center" style="background:linear-gradient(135deg,#f8faff,#eff6ff);min-height:280px">
                @if($item->image_path)
                    <img src="{{ Storage::url($item->image_path) }}" alt="{{ $item->item_name }}"
                         class="w-full h-full object-contain p-6" style="max-height:400px">
                @else
                    <div class="flex flex-col items-center py-16">
                        <svg width="56" height="56" fill="none" stroke="#bfdbfe" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        <p class="text-sm text-blue-200 mt-3 font-medium">No photo provided</p>
                    </div>
                @endif
            </div>

            {{-- Details --}}
            <div class="md:w-3/5 p-7 flex flex-col border-t md:border-t-0 md:border-l border-gray-100">
                <div class="flex items-start justify-between gap-3 mb-6">
                    <div>
                        <span class="text-xs font-bold text-blue-500 uppercase tracking-widest">{{ $item->category }}</span>
                        <h1 class="text-2xl font-extrabold text-gray-900 mt-1">{{ $item->item_name }}</h1>
                        <p class="text-sm text-gray-400 mt-1">Reported by <span class="text-gray-600 font-semibold">{{ $item->user->name }}</span></p>
                    </div>
                    <span class="shrink-0 text-xs font-bold px-3 py-1.5 rounded-full uppercase tracking-wide"
                          style="{{ $item->status==='unclaimed' ? 'background:#d1fae5;color:#065f46' : 'background:#f3f4f6;color:#6b7280' }}">
                        {{ $item->status }}
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-3 mb-6">
                    @foreach([['Brand', $item->brand ?: '—'], ['Color', $item->color], ['Date Found', \Carbon\Carbon::parse($item->date_found)->format('M d, Y')], ['Time Found', \Carbon\Carbon::parse($item->time_found)->format('g:i A')]] as [$label, $value])
                        <div class="rounded-xl p-3.5" style="background:#f8faff;border:1px solid #e8edf5">
                            <p class="text-xs text-gray-400 font-medium mb-0.5">{{ $label }}</p>
                            <p class="font-bold text-gray-800 text-sm">{{ $value }}</p>
                        </div>
                    @endforeach
                    <div class="col-span-2 rounded-xl p-3.5" style="background:#f8faff;border:1px solid #e8edf5">
                        <p class="text-xs text-gray-400 font-medium mb-0.5">Place Found</p>
                        <p class="font-bold text-gray-800 text-sm">{{ $item->place_found }}</p>
                    </div>
                </div>

                @if($item->status === 'unclaimed')
                    <div class="mt-auto space-y-4">
                        <div class="rounded-xl p-4" style="background:linear-gradient(135deg,#eff6ff,#dbeafe);border:1px solid #bfdbfe">
                            <p class="text-xs font-bold text-blue-600 uppercase tracking-widest mb-3">Contact the Finder</p>
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
                        <form method="POST" action="{{ route('found-items.claim', $item) }}">
                            @csrf @method('PATCH')
                            <button type="submit" onclick="return confirm('Mark this item as claimed?')"
                                    class="w-full flex items-center justify-center gap-2 text-white text-sm font-bold px-5 py-3.5 rounded-xl transition"
                                    style="background:linear-gradient(135deg,#1d4ed8,#3b82f6);box-shadow:0 4px 14px rgba(59,130,246,0.4)">
                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                Mark as Claimed
                            </button>
                        </form>
                    </div>
                @else
                    <div class="mt-auto pt-4 border-t border-gray-100 flex items-center gap-2 text-sm text-gray-400">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        This item has already been claimed.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
</x-app-layout>
