<footer class="bg-slate-950 text-white">
    <div class="container-xl py-14">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">

            {{-- Brand --}}
            <div>
                <div class="flex items-center gap-3">
                    <div class="h-9 w-9 rounded-2xl overflow-hidden grid place-items-center">
                        <img src="{{ asset('images/gallery/aurum-logo-only.svg') }}" alt="Aurum logo" class="h-full w-full object-cover" />
                    </div>
                    <span class="text-lg font-semibold">Aurum Hotel</span>
                </div>

                <p class="mt-4 text-sm text-white/60 leading-relaxed max-w-sm">
                    A calm, refined hotel experience focused on comfort,
                    thoughtful design, and effortless stays.
                </p>
            </div>

            {{-- Navigation --}}
            <div>
                <h4 class="text-sm font-semibold tracking-wide">Explore</h4>
                <ul class="mt-4 space-y-2 text-sm text-white/60">
                    <li><a href="{{ url('/') }}#rooms" class="hover:text-white transition">Rooms</a></li>
                    <li><a href="{{ url('/') }}#amenities" class="hover:text-white transition">Amenities</a></li>
                    <li><a href="{{ url('/') }}#dining" class="hover:text-white transition">Dining</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-white transition">About Us</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <h4 class="text-sm font-semibold tracking-wide">Contact</h4>
                <ul class="mt-4 space-y-2 text-sm text-white/60">
                    <li>123 Sunset Avenue</li>
                    <li>City Center, Philippines</li>
                    <li>+63 949 959 3866</li>
                    <li>info@aurumhotel.com</li>
                </ul>
            </div>

            {{-- Newsletter / CTA --}}
            <div>
                <h4 class="text-sm font-semibold tracking-wide">Stay Updated</h4>
                <p class="mt-4 text-sm text-white/60">
                    Receive updates and exclusive offers.
                </p>

                <form class="mt-4 flex gap-2">
                    <input
                        type="email"
                        placeholder="Email address"
                        class="w-full rounded-xl bg-white/10 border border-white/20 px-3 py-2 text-sm text-white placeholder-white/40 focus:outline-none focus:border-white/40"
                    />
                    <button
                        type="button"
                        class="rounded-xl bg-white text-slate-950 px-4 py-2 text-sm font-medium hover:bg-slate-100 transition"
                    >
                        →
                    </button>
                </form>
            </div>
        </div>

        {{-- Second Row - Rate Us --}}
        <div class="mt-12 pt-12 border-t border-white/10">
            <div class="max-w-md mx-auto text-center">
                <p class="text-lg font-semibold text-white">Enjoyed your Stay?</p>
                <p class="mt-2 text-sm text-white/60">Rate our Service</p>
                <div class="mt-4 text-yellow text-2xl">
                    ★★★★★
                </div>
                <button
                    type="button"
                    onclick="openRatingModal()"
                    class="mt-6 rounded-xl bg-white text-slate-950 px-8 py-3 text-base font-semibold hover:bg-slate-100 transition shadow-lg"
                >
                    Rate Us!
                </button>
            </div>
        </div>

        {{-- Bottom --}}
        <div class="mt-12 pt-6 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-white/50">
            <p>
                © {{ date('Y') }} Aurum Hotel. All rights reserved.
            </p>
            <div class="flex gap-4">
                <a href="{{ route('privacy') }}" class="hover:text-white transition">Privacy Policy</a>
                <a href="{{ route('terms') }}" class="hover:text-white transition">Terms</a>

            </div>
        </div>
    </div>
</footer>
