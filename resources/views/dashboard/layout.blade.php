<x-layouts.app title="Dashboard">
    <div class="min-h-[calc(100vh-4rem)] bg-white">
        <div class="container-xl py-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <aside class="lg:col-span-3">
                    <div class="rounded-2xl border border-slate-200 bg-white p-4">
                        <a href="{{ url('/') }}" class="flex items-center gap-3 mb-4">
                            <div class="h-10 w-10 rounded-2xl overflow-hidden grid place-items-center">
                                <img src="{{ asset('images/gallery/aurum-logo-only.svg') }}" alt="Aurum logo" class="h-full w-full object-cover" />
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-slate-900">Aurum Hotel</div>
                                <div class="text-[11px] text-slate-500 -mt-0.5">World-class stays</div>
                            </div>
                        </a>

                        <div class="text-xs text-slate-500">Signed in as</div>
                        <div class="mt-1 font-semibold text-slate-900">{{ auth()->user()->username }}</div>
                        <div class="mt-0.5 text-xs text-slate-500">Role: {{ auth()->user()->role }}</div>

                        <div class="mt-4 border-t border-slate-200 pt-4">
                            <nav class="space-y-2 text-sm">
                                <a href="{{ route('dashboard') }}"
                                   class="block rounded-xl px-3 py-2 border border-slate-200 hover:bg-slate-50">
                                    Dashboard
                                </a>

                                @if (auth()->user()->role === 'Admin')
                                    <a href="{{ route('dashboard.users') }}" class="block rounded-xl px-3 py-2 border border-slate-200 hover:bg-slate-50">Users</a>
                                    <a href="{{ route('dashboard.logs') }}" class="block rounded-xl px-3 py-2 border border-slate-200 hover:bg-slate-50">Logs</a>
                                    <a href="{{ route('dashboard.rooms') }}" class="block rounded-xl px-3 py-2 border border-slate-200 hover:bg-slate-50">Rooms</a>
                                    <a href="{{ route('dashboard.amenities') }}" class="block rounded-xl px-3 py-2 border border-slate-200 hover:bg-slate-50">Amenities</a>
                                    <a href="{{ route('dashboard.reservations') }}" class="block rounded-xl px-3 py-2 border border-slate-200 hover:bg-slate-50">Reservations</a>
                                    <a href="{{ route('dashboard.approvals') }}" class="block rounded-xl px-3 py-2 border border-slate-200 hover:bg-slate-50">Approve Reservations</a>
                                    <a href="{{ route('dashboard.reviews') }}" class="block rounded-xl px-3 py-2 border border-slate-200 hover:bg-slate-50">Manage Reviews</a>
                                @elseif (auth()->user()->role === 'Employee')
                                    <a href="{{ route('dashboard.rooms') }}" class="block rounded-xl px-3 py-2 border border-slate-200 hover:bg-slate-50">Rooms</a>
                                    <a href="{{ route('dashboard.amenities') }}" class="block rounded-xl px-3 py-2 border border-slate-200 hover:bg-slate-50">Amenities</a>
                                    <a href="{{ route('dashboard.reservations') }}" class="block rounded-xl px-3 py-2 border border-slate-200 hover:bg-slate-50">Reservations</a>
                                    <a href="{{ route('dashboard.approvals') }}" class="block rounded-xl px-3 py-2 border border-slate-200 hover:bg-slate-50">Approve Reservations</a>
                                    <a href="{{ route('dashboard.reviews') }}" class="block rounded-xl px-3 py-2 border border-slate-200 hover:bg-slate-50">Manage Reviews</a>
                                @else
                                    <a href="{{ route('dashboard.my-reservations') }}" class="block rounded-xl px-3 py-2 border border-slate-200 hover:bg-slate-50">My Reservations</a>
                                    <a href="{{ route('dashboard.reserve') }}" class="block rounded-xl px-3 py-2 border border-slate-200 hover:bg-slate-50">Reserve a Room</a>
                                @endif
                            </nav>
                        </div>

                        <div class="mt-4">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full btn btn-secondary">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </aside>

                <section class="lg:col-span-9">
                    @if (auth()->user() && (auth()->user()->role === 'Admin' || auth()->user()->role === 'Employee'))
                        <div class="mb-6">
                            <nav class="flex flex-wrap space-x-1 bg-slate-100 p-1 rounded-xl">
                                <a href="{{ route('dashboard') }}" class="tab-link {{ request()->routeIs('dashboard') && !request()->routeIs('dashboard.*') ? 'active' : '' }}">Overview</a>
                                @if (auth()->user()->role === 'Admin')
                                    <a href="{{ route('dashboard.users') }}" class="tab-link {{ request()->routeIs('dashboard.users*') ? 'active' : '' }}">Users</a>
                                    <a href="{{ route('dashboard.logs') }}" class="tab-link {{ request()->routeIs('dashboard.logs') ? 'active' : '' }}">Logs</a>
                                @endif
                                <a href="{{ route('dashboard.rooms') }}" class="tab-link {{ request()->routeIs('dashboard.rooms*') ? 'active' : '' }}">Rooms</a>
                                <a href="{{ route('dashboard.amenities') }}" class="tab-link {{ request()->routeIs('dashboard.amenities*') ? 'active' : '' }}">Amenities</a>
                                <a href="{{ route('dashboard.reservations') }}" class="tab-link {{ request()->routeIs('dashboard.reservations*') && !request()->routeIs('dashboard.approvals*') ? 'active' : '' }}">Reservations</a>
                                <a href="{{ route('dashboard.approvals') }}" class="tab-link {{ request()->routeIs('dashboard.approvals*') ? 'active' : '' }}">Approvals</a>
                                <a href="{{ route('dashboard.reviews') }}" class="tab-link {{ request()->routeIs('dashboard.reviews') ? 'active' : '' }}">Reviews</a>
                            </nav>
                        </div>
                    @endif

                    <div class="rounded-2xl border border-slate-200 bg-white p-6">
                        {{ $slot }}
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-layouts.app>

<style>
    .tab-link {
        flex-1 text-center px-4 py-2 text-sm font-medium rounded-lg transition-colors duration-200;
        @apply text-slate-600 hover:text-slate-900 hover:bg-white;
    }
    .tab-link.active {
        @apply bg-white text-slate-900 shadow-sm;
    }
</style>
