<x-layouts.app title="Dashboard">
    <div class="min-h-[calc(100vh-4rem)] bg-white">
        <div class="container-xl py-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <aside class="lg:col-span-3">
                    <div class="rounded-2xl border border-slate-200 bg-white p-4">
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
                                @elseif (auth()->user()->role === 'Employee')
                                    <a href="{{ route('dashboard.rooms') }}" class="block rounded-xl px-3 py-2 border border-slate-200 hover:bg-slate-50">Rooms</a>
                                    <a href="{{ route('dashboard.amenities') }}" class="block rounded-xl px-3 py-2 border border-slate-200 hover:bg-slate-50">Amenities</a>
                                    <a href="{{ route('dashboard.reservations') }}" class="block rounded-xl px-3 py-2 border border-slate-200 hover:bg-slate-50">Reservations</a>
                                    <a href="{{ route('dashboard.approvals') }}" class="block rounded-xl px-3 py-2 border border-slate-200 hover:bg-slate-50">Approve Reservations</a>
                                @else
                                    <a href="{{ route('dashboard.rooms') }}" class="block rounded-xl px-3 py-2 border border-slate-200 hover:bg-slate-50">Rooms & Availability</a>
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
                    <div class="rounded-2xl border border-slate-200 bg-white p-6">
                        {{ $slot }}
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-layouts.app>
