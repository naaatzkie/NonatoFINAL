<x-app-layout>
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <a href="{{ route('found-items.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-400 hover:text-blue-600 transition mb-6 font-medium">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
        Back to Found Items
    </a>

    <div class="mb-7">
        <h1 class="text-2xl font-extrabold text-gray-900">Report a Found Item</h1>
        <p class="text-gray-500 mt-1 text-sm">Fill in the details so the owner can identify and claim it.</p>
    </div>

    <form method="POST" action="{{ route('found-items.store') }}" enctype="multipart/form-data" class="space-y-5">
        @csrf

        {{-- Item Details --}}
        <div class="bg-white rounded-2xl overflow-hidden" style="box-shadow:0 2px 16px rgba(59,130,246,0.08)">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center gap-3">
                <div class="w-1 h-5 rounded-full" style="background:linear-gradient(135deg,#1d4ed8,#3b82f6)"></div>
                <h2 class="text-xs font-bold text-gray-600 uppercase tracking-widest">Item Details</h2>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <x-input-label for="item_name" value="What was found? *" />
                    <x-text-input id="item_name" name="item_name" type="text" class="mt-1 block w-full"
                                  placeholder="e.g. Black iPhone 14" value="{{ old('item_name') }}" required />
                    <x-input-error :messages="$errors->get('item_name')" class="mt-1" />
                </div>
                {{-- Aligned 2-col grid --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="category" value="Category *" />
                        <select id="category" name="category" required
                                class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select…</option>
                            @foreach(['Electronics','Clothing','Accessories','Documents','Bags','Keys','Wallet','Jewelry','Sports','Other'] as $cat)
                                <option value="{{ $cat }}" @selected(old('category')===$cat)>{{ $cat }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="brand" value="Brand (optional)" />
                        <x-text-input id="brand" name="brand" type="text" class="mt-1 block w-full"
                                      placeholder="e.g. Apple" value="{{ old('brand') }}" />
                        <x-input-error :messages="$errors->get('brand')" class="mt-1" />
                    </div>
                </div>
                <div>
                    <x-input-label for="color" value="Color *" />
                    <x-text-input id="color" name="color" type="text" class="mt-1 block w-full"
                                  placeholder="e.g. Black, Silver" value="{{ old('color') }}" required />
                    <x-input-error :messages="$errors->get('color')" class="mt-1" />
                </div>
            </div>
        </div>

        {{-- When & Where --}}
        <div class="bg-white rounded-2xl overflow-hidden" style="box-shadow:0 2px 16px rgba(59,130,246,0.08)">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center gap-3">
                <div class="w-1 h-5 rounded-full" style="background:linear-gradient(135deg,#1d4ed8,#3b82f6)"></div>
                <h2 class="text-xs font-bold text-gray-600 uppercase tracking-widest">When &amp; Where</h2>
            </div>
            <div class="p-6 space-y-4">
                {{-- Aligned 2-col grid matching Item Details above --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="date_found" value="Date Found *" />
                        <x-text-input id="date_found" name="date_found" type="date" class="mt-1 block w-full"
                                      value="{{ old('date_found', date('Y-m-d')) }}" required />
                        <x-input-error :messages="$errors->get('date_found')" class="mt-1" />
                    </div>
                    <div>
                        <x-input-label for="time_found" value="Time Found *" />
                        <x-text-input id="time_found" name="time_found" type="time" class="mt-1 block w-full"
                                      value="{{ old('time_found') }}" required />
                        <x-input-error :messages="$errors->get('time_found')" class="mt-1" />
                    </div>
                </div>
                <div>
                    <x-input-label for="place_found" value="Place Found *" />
                    <x-text-input id="place_found" name="place_found" type="text" class="mt-1 block w-full"
                                  placeholder="e.g. Library 2nd Floor, Cafeteria" value="{{ old('place_found') }}" required />
                    <x-input-error :messages="$errors->get('place_found')" class="mt-1" />
                </div>
            </div>
        </div>

        {{-- Photo --}}
        <div class="bg-white rounded-2xl overflow-hidden" style="box-shadow:0 2px 16px rgba(59,130,246,0.08)">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center gap-3">
                <div class="w-1 h-5 rounded-full" style="background:linear-gradient(135deg,#1d4ed8,#3b82f6)"></div>
                <h2 class="text-xs font-bold text-gray-600 uppercase tracking-widest">Photo <span class="normal-case font-normal text-gray-400">(optional)</span></h2>
            </div>
            <div class="p-6" x-data="{ preview: null }">
                <label for="image" class="flex flex-col items-center justify-center w-full border-2 border-dashed border-blue-100 rounded-xl cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition group" style="height:160px">
                    <template x-if="!preview">
                        <div class="flex flex-col items-center text-gray-400 group-hover:text-blue-500 transition">
                            <svg width="36" height="36" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/>
                            </svg>
                            <p class="text-sm font-semibold mt-2">Click to upload</p>
                            <p class="text-xs text-gray-300 mt-0.5">PNG, JPG, WEBP — max 2MB</p>
                        </div>
                    </template>
                    <template x-if="preview">
                        <img :src="preview" class="h-full w-full object-contain rounded-xl p-2">
                    </template>
                    <input id="image" name="image" type="file" accept="image/*" class="hidden"
                           @change="preview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null">
                </label>
                <x-input-error :messages="$errors->get('image')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center justify-between pt-2">
            <a href="{{ route('found-items.index') }}" class="text-sm text-gray-400 hover:text-gray-600 transition font-medium">Cancel</a>
            <button type="submit" class="inline-flex items-center gap-2 text-white text-sm font-bold px-7 py-3 rounded-xl transition"
                    style="background:linear-gradient(135deg,#1d4ed8,#3b82f6);box-shadow:0 4px 14px rgba(59,130,246,0.4)">
                Submit Report
            </button>
        </div>
    </form>
</div>
</x-app-layout>
