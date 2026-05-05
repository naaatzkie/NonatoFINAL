<x-app-layout>
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <a href="{{ route('lost-items.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 mb-5 transition">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
        Back
    </a>

    <h1 class="text-2xl font-bold text-gray-900 mb-1">Post a Lost Item</h1>
    <p class="text-sm text-gray-500 mb-6">Describe what you lost so others can help you find it.</p>

    <form method="POST" action="{{ route('lost-items.store') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
            <div class="px-5 py-3 bg-gray-50 border-b border-gray-100">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">Item Details</p>
            </div>
            <div class="p-5 space-y-4">
                <div>
                    <x-input-label for="item_name" value="What did you lose? *" />
                    <x-text-input id="item_name" name="item_name" type="text" class="mt-1 block w-full"
                                  placeholder="e.g. Blue Jansport Backpack" value="{{ old('item_name') }}" required />
                    <x-input-error :messages="$errors->get('item_name')" class="mt-1" />
                </div>
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
                                      placeholder="e.g. Nike, Samsung" value="{{ old('brand') }}" />
                        <x-input-error :messages="$errors->get('brand')" class="mt-1" />
                    </div>
                </div>
                <div>
                    <x-input-label for="color" value="Color *" />
                    <x-text-input id="color" name="color" type="text" class="mt-1 block w-full"
                                  placeholder="e.g. Blue, Black" value="{{ old('color') }}" required />
                    <x-input-error :messages="$errors->get('color')" class="mt-1" />
                </div>
                <div>
                    <x-input-label for="description" value="Additional Description (optional)" />
                    <textarea id="description" name="description" rows="3"
                              class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm text-sm focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Any identifying marks, stickers, contents…">{{ old('description') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-1" />
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
            <div class="px-5 py-3 bg-gray-50 border-b border-gray-100">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">When &amp; Where</p>
            </div>
            <div class="p-5 space-y-4">
                <div>
                    <x-input-label for="date_lost" value="Date Lost *" />
                    <x-text-input id="date_lost" name="date_lost" type="date" class="mt-1 block w-full"
                                  value="{{ old('date_lost', date('Y-m-d')) }}" required />
                    <x-input-error :messages="$errors->get('date_lost')" class="mt-1" />
                </div>
                <div>
                    <x-input-label for="last_seen_location" value="Last Seen Location *" />
                    <x-text-input id="last_seen_location" name="last_seen_location" type="text" class="mt-1 block w-full"
                                  placeholder="e.g. Gym, Parking Lot B" value="{{ old('last_seen_location') }}" required />
                    <x-input-error :messages="$errors->get('last_seen_location')" class="mt-1" />
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">
            <div class="px-5 py-3 bg-gray-50 border-b border-gray-100">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-widest">Photo <span class="normal-case font-normal">(optional)</span></p>
            </div>
            <div class="p-5" x-data="{ preview: null }">
                <label for="image" class="flex flex-col items-center justify-center w-full border-2 border-dashed border-gray-200 rounded-xl cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition group" style="height:160px">
                    <template x-if="!preview">
                        <div class="flex flex-col items-center text-gray-400 group-hover:text-blue-500 transition">
                            <svg width="36" height="36" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                            <p class="text-sm font-medium mt-2">Click to upload</p>
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

        <div class="flex items-center justify-between pt-1">
            <a href="{{ route('lost-items.index') }}" class="text-sm text-gray-400 hover:text-gray-600 transition">Cancel</a>
            <button type="submit" class="inline-flex items-center gap-2 bg-gray-900 hover:bg-gray-700 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition shadow">
                Post Lost Item
            </button>
        </div>
    </form>
</div>
</x-app-layout>
