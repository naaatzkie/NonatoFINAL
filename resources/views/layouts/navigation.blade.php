<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 sticky top-0 z-50" style="box-shadow:0 1px 20px rgba(0,0,0,0.06)">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            {{-- Logo --}}
            <div class="flex items-center gap-10">
                <a href="{{ route('found-items.index') }}" class="flex items-center gap-2.5 shrink-0">
                    <div style="width:36px;height:36px;background:linear-gradient(135deg,#1d4ed8,#3b82f6);border-radius:10px;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(59,130,246,0.4)">
                        <svg width="18" height="18" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="6"/><line x1="16.5" y1="16.5" x2="21" y2="21"/>
                        </svg>
                    </div>
                    <span class="font-bold text-gray-900 text-base tracking-tight">Lost<span class="text-blue-600">&</span>Found</span>
                </a>

                {{-- Desktop Nav --}}
                <div class="hidden sm:flex items-center gap-2">
                    <a href="{{ route('found-items.index') }}"
                       class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all
                              {{ request()->routeIs('found-items.index','found-items.show') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/>
                        </svg>
                        Found Items
                    </a>
                    <a href="{{ route('lost-items.index') }}"
                       class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all
                              {{ request()->routeIs('lost-items.index','lost-items.show') ? 'bg-blue-50 text-blue-700 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/>
                        </svg>
                        Lost Items
                    </a>
                    <div class="w-px h-5 bg-gray-200 mx-1"></div>
                    <a href="{{ route('found-items.create') }}"
                       class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold transition-all border
                              {{ request()->routeIs('found-items.create') ? 'bg-blue-600 text-white border-blue-600' : 'text-gray-700 border-gray-200 hover:border-blue-400 hover:text-blue-600 hover:bg-blue-50' }}">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" viewBox="0 0 24 24">
                            <line x1="12" y1="4" x2="12" y2="20"/><line x1="4" y1="12" x2="20" y2="12"/>
                        </svg>
                        Report Found
                    </a>
                    <a href="{{ route('lost-items.create') }}"
                       class="flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold text-white transition-all"
                       style="background:linear-gradient(135deg,#1d4ed8,#3b82f6);box-shadow:0 2px 8px rgba(59,130,246,0.35)">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" viewBox="0 0 24 24">
                            <line x1="12" y1="4" x2="12" y2="20"/><line x1="4" y1="12" x2="20" y2="12"/>
                        </svg>
                        Post Lost Item
                    </a>
                </div>
            </div>

            {{-- Right side --}}
            <div class="hidden sm:flex items-center gap-3">
                @php $unread = auth()->user()->unreadNotifications->count(); @endphp
                <a href="{{ route('notifications.index') }}" class="relative p-2.5 rounded-lg text-gray-500 hover:bg-gray-50 hover:text-blue-600 transition-all">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/>
                    </svg>
                    @if($unread > 0)
                        <span class="absolute top-1 right-1 bg-red-500 text-white font-bold rounded-full flex items-center justify-center" style="width:16px;height:16px;font-size:10px">
                            {{ $unread > 9 ? '9+' : $unread }}
                        </span>
                    @endif
                </a>

                <x-dropdown align="right" width="56">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-2.5 pl-2 pr-3 py-2 rounded-xl hover:bg-gray-50 transition-all border border-transparent hover:border-gray-200">
                            <div class="text-white rounded-full flex items-center justify-center font-bold text-xs uppercase" style="width:32px;height:32px;background:linear-gradient(135deg,#1d4ed8,#3b82f6)">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <span class="hidden md:block text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                            <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20" class="text-gray-400">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <div class="px-4 py-3 border-b border-gray-100 bg-gray-50">
                            <p class="text-xs text-gray-400 mb-0.5">Signed in as</p>
                            <p class="text-sm font-semibold text-gray-800 leading-tight">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500 truncate leading-tight">{{ Auth::user()->email }}</p>
                        </div>
                        <x-dropdown-link :href="route('profile.edit')">
                            <div class="flex items-center gap-2">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                Profile
                            </div>
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();this.closest('form').submit();">
                                <div class="flex items-center gap-2 text-red-500">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                                    Log Out
                                </div>
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- Mobile hamburger --}}
            <button @click="open=!open" class="sm:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100">
                <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" viewBox="0 0 24 24">
                    <line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div x-show="open" x-cloak x-transition class="sm:hidden border-t border-gray-100 bg-white px-4 py-4 space-y-1">
        <a href="{{ route('found-items.index') }}" class="flex items-center gap-2 px-4 py-3 rounded-xl text-sm font-medium {{ request()->routeIs('found-items.index','found-items.show') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">Found Items</a>
        <a href="{{ route('lost-items.index') }}" class="flex items-center gap-2 px-4 py-3 rounded-xl text-sm font-medium {{ request()->routeIs('lost-items.index','lost-items.show') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-50' }}">Lost Items</a>
        <a href="{{ route('found-items.create') }}" class="flex items-center gap-2 px-4 py-3 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50">Report Found Item</a>
        <a href="{{ route('lost-items.create') }}" class="flex items-center gap-2 px-4 py-3 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50">Post Lost Item</a>
        <a href="{{ route('notifications.index') }}" class="flex items-center gap-2 px-4 py-3 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50">
            Notifications
            @if($unread > 0)
                <span class="bg-red-500 text-white text-xs font-bold rounded-full px-1.5 py-0.5">{{ $unread }}</span>
            @endif
        </a>
        <div class="border-t border-gray-100 pt-4 mt-2">
            <div class="flex items-center gap-3 px-4 py-2 mb-2">
                <div class="text-white rounded-full flex items-center justify-center font-bold text-sm uppercase" style="width:38px;height:38px;background:linear-gradient(135deg,#1d4ed8,#3b82f6)">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                </div>
            </div>
            <x-responsive-nav-link :href="route('profile.edit')">Profile</x-responsive-nav-link>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault();this.closest('form').submit();">Log Out</x-responsive-nav-link>
            </form>
        </div>
    </div>
</nav>
