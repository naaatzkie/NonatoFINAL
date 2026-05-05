<x-app-layout>

{{-- Hero --}}
<div style="background:linear-gradient(135deg,#0f172a 0%,#1e3a8a 50%,#1d4ed8 100%);padding:60px 0 80px">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-8">
            <div>
                <div style="display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.2);border-radius:999px;padding:6px 14px;margin-bottom:20px">
                    <svg width="14" height="14" fill="none" stroke="#93c5fd" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="11" cy="11" r="6"/><line x1="16.5" y1="16.5" x2="21" y2="21"/></svg>
                    <span style="color:#93c5fd;font-size:11px;font-weight:700;letter-spacing:0.1em;text-transform:uppercase">Found Items Board</span>
                </div>
                <h1 style="font-size:clamp(2rem,5vw,3rem);font-weight:900;color:white;line-height:1.1;letter-spacing:-0.02em">Something Found,<br><span style="color:#93c5fd">Could It Be Yours?</span></h1>
                <p style="color:#bfdbfe;margin-top:16px;font-size:15px;max-width:420px;line-height:1.7">Browse items that have been turned in. Search by name, color, or location to find what you lost.</p>
            </div>
            <a href="{{ route('found-items.create') }}"
               style="display:inline-flex;align-items:center;gap:10px;background:white;color:#1d4ed8;font-weight:800;font-size:14px;padding:14px 24px;border-radius:16px;box-shadow:0 8px 32px rgba(0,0,0,0.25);white-space:nowrap;text-decoration:none;transition:transform 0.2s"
               onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" viewBox="0 0 24 24"><line x1="12" y1="4" x2="12" y2="20"/><line x1="4" y1="12" x2="20" y2="12"/></svg>
                Report Found Item
            </a>
        </div>
    </div>
</div>

{{-- Wave --}}
<div style="background:linear-gradient(135deg,#0f172a,#1d4ed8);line-height:0;margin-top:-1px">
    <svg viewBox="0 0 1440 50" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="display:block;width:100%;height:50px">
        <path d="M0 50 C480 0 960 0 1440 50 L1440 50 L0 50 Z" fill="#f8faff"/>
    </svg>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" style="padding-top:40px;padding-bottom:60px">

    @if(session('success'))
        <div style="display:flex;align-items:center;gap:12px;background:#f0fdf4;border:1px solid #86efac;color:#166534;padding:14px 18px;border-radius:14px;font-size:14px;font-weight:600;margin-bottom:24px">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Filter Bar --}}
    <div style="background:white;border-radius:20px;padding:24px;margin-bottom:32px;box-shadow:0 4px 24px rgba(59,130,246,0.10)">
        <p style="font-size:13px;font-weight:700;color:#374151;margin-bottom:16px;text-transform:uppercase;letter-spacing:0.05em">Filter Items</p>
        <form method="GET" action="{{ route('found-items.index') }}" style="display:flex;flex-wrap:wrap;gap:12px;align-items:flex-end">
            <div style="flex:1;min-width:180px">
                <label style="display:block;font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:8px">Search</label>
                <div style="position:relative">
                    <svg width="16" height="16" fill="none" stroke="#9ca3af" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" style="position:absolute;left:12px;top:50%;transform:translateY(-50%)"><circle cx="11" cy="11" r="6"/><line x1="16.5" y1="16.5" x2="21" y2="21"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Name, color, brand, place…"
                           style="width:100%;padding:10px 12px 10px 38px;border:1.5px solid #e5e7eb;border-radius:12px;font-size:14px;background:#f9fafb;outline:none;box-sizing:border-box"
                           onfocus="this.style.borderColor='#3b82f6';this.style.background='white'" onblur="this.style.borderColor='#e5e7eb';this.style.background='#f9fafb'">
                </div>
            </div>
            <div style="min-width:150px">
                <label style="display:block;font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:8px">Category</label>
                <select name="category" style="width:100%;padding:10px 12px;border:1.5px solid #e5e7eb;border-radius:12px;font-size:14px;background:#f9fafb;outline:none">
                    <option value="">All Categories</option>
                    @foreach(['Electronics','Clothing','Accessories','Documents','Bags','Keys','Wallet','Jewelry','Sports','Other'] as $cat)
                        <option value="{{ $cat }}" @selected(request('category')===$cat)>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
            <div style="min-width:130px">
                <label style="display:block;font-size:11px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:8px">Status</label>
                <select name="status" style="width:100%;padding:10px 12px;border:1.5px solid #e5e7eb;border-radius:12px;font-size:14px;background:#f9fafb;outline:none">
                    <option value="">All</option>
                    <option value="unclaimed" @selected(request('status')==='unclaimed')>Unclaimed</option>
                    <option value="claimed"   @selected(request('status')==='claimed')>Claimed</option>
                </select>
            </div>
            <div style="display:flex;gap:8px;align-items:center">
                <button type="submit" style="background:linear-gradient(135deg,#1d4ed8,#3b82f6);color:white;font-size:14px;font-weight:700;padding:10px 24px;border-radius:12px;border:none;cursor:pointer;box-shadow:0 4px 12px rgba(59,130,246,0.4)">
                    Search
                </button>
                @if(request()->hasAny(['search','category','status']))
                    <a href="{{ route('found-items.index') }}" style="font-size:13px;color:#9ca3af;text-decoration:none;padding:0 8px">Clear</a>
                @endif
            </div>
        </form>
    </div>

    @if(!$items->isEmpty())
        <p style="font-size:14px;color:#6b7280;margin-bottom:20px">
            Showing <strong style="color:#111827">{{ $items->total() }}</strong> item{{ $items->total()!==1?'s':'' }}
        </p>
    @endif

    @if($items->isEmpty())
        <div style="background:white;border-radius:24px;padding:80px 24px;text-align:center;box-shadow:0 4px 24px rgba(59,130,246,0.08)">
            <div style="width:72px;height:72px;background:linear-gradient(135deg,#eff6ff,#dbeafe);border-radius:20px;display:flex;align-items:center;justify-content:center;margin:0 auto 20px">
                <svg width="34" height="34" fill="none" stroke="#3b82f6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><circle cx="11" cy="11" r="6"/><line x1="16.5" y1="16.5" x2="21" y2="21"/></svg>
            </div>
            <p style="font-size:18px;font-weight:800;color:#111827">No items found</p>
            <p style="font-size:14px;color:#9ca3af;margin-top:6px">Try adjusting your filters or check back later.</p>
        </div>
    @else
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:20px">
            @foreach($items as $item)
                <a href="{{ route('found-items.show', $item) }}"
                   style="background:white;border-radius:20px;overflow:hidden;display:flex;flex-direction:column;text-decoration:none;box-shadow:0 2px 12px rgba(59,130,246,0.08);border:1px solid rgba(224,234,255,0.8);transition:all 0.3s cubic-bezier(0.4,0,0.2,1)"
                   onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 20px 40px rgba(59,130,246,0.15)'"
                   onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 2px 12px rgba(59,130,246,0.08)'">
                    <div style="position:relative;aspect-ratio:4/3;background:linear-gradient(135deg,#f0f7ff,#e8f0fe);overflow:hidden">
                        @if($item->image_path)
                            <img src="{{ Storage::url($item->image_path) }}" alt="{{ $item->item_name }}"
                                 style="width:100%;height:100%;object-fit:cover;transition:transform 0.5s ease"
                                 onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                        @else
                            <div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center">
                                <svg width="40" height="40" fill="none" stroke="#bfdbfe" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                <span style="font-size:11px;color:#bfdbfe;margin-top:8px;font-weight:500">No photo</span>
                            </div>
                        @endif
                        <span style="position:absolute;top:10px;right:10px;font-size:11px;font-weight:700;padding:4px 10px;border-radius:999px;border:1.5px solid rgba(255,255,255,0.5);{{ $item->status==='unclaimed' ? 'background:rgba(16,185,129,0.9);color:white' : 'background:rgba(107,114,128,0.85);color:white' }}">
                            {{ ucfirst($item->status) }}
                        </span>
                    </div>
                    <div style="padding:16px 18px;display:flex;flex-direction:column;flex:1">
                        <span style="font-size:10px;font-weight:800;color:#3b82f6;background:#eff6ff;padding:3px 8px;border-radius:6px;text-transform:uppercase;letter-spacing:0.08em;display:inline-block">{{ $item->category }}</span>
                        <h3 style="font-size:15px;font-weight:700;color:#111827;margin-top:8px;line-height:1.3">{{ $item->item_name }}</h3>
                        <div style="margin-top:auto;padding-top:12px;border-top:1px solid #f3f4f6;display:flex;flex-direction:column;gap:6px">
                            <div style="display:flex;align-items:center;gap:6px;font-size:12px;color:#6b7280">
                                <svg width="13" height="13" fill="none" stroke="#60a5fa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                <span style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ $item->place_found }}</span>
                            </div>
                            <div style="display:flex;align-items:center;gap:6px;font-size:12px;color:#6b7280">
                                <svg width="13" height="13" fill="none" stroke="#60a5fa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                {{ \Carbon\Carbon::parse($item->date_found)->format('M d, Y') }}
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
        <div style="margin-top:40px">{{ $items->links() }}</div>
    @endif
</div>
</x-app-layout>
