<x-layouts.app title="About Us – Aurum Hotel">

<section class="bg-white">
    <div class="container-xl py-20">
        <div class="max-w-3xl">
            <h1 class="text-4xl sm:text-5xl font-semibold tracking-tight">
                About Aurum Hotel
            </h1>

            <p class="mt-6 text-lg text-slate-700 leading-relaxed">
                Aurum Hotel was created with a single philosophy:  
                <span class="font-medium text-slate-900">
                    quiet luxury, thoughtful design, and effortless comfort.
                </span>
            </p>

            <p class="mt-6 text-slate-600 leading-relaxed">
                We believe that a world-class hotel experience is not defined by excess,
                but by intention. From calm interiors and premium linens to seamless
                service and refined amenities, every detail is curated to help guests
                rest, focus, and feel genuinely welcomed.
            </p>

            <p class="mt-6 text-slate-600 leading-relaxed">
                Located in the heart of the city, Aurum Hotel serves business travelers,
                couples, and families seeking a refined stay without unnecessary
                complexity.
            </p>

            <div class="mt-10 grid sm:grid-cols-3 gap-6">
                <div class="rounded-3xl border border-slate-200 p-6">
                    <div class="text-2xl font-semibold">2019</div>
                    <div class="text-sm text-slate-600 mt-1">Established</div>
                </div>
                <div class="rounded-3xl border border-slate-200 p-6">
                    <div class="text-2xl font-semibold">4.9★</div>
                    <div class="text-sm text-slate-600 mt-1">Guest Rating</div>
                </div>
                <div class="rounded-3xl border border-slate-200 p-6">
                    <div class="text-2xl font-semibold">24/7</div>
                    <div class="text-sm text-slate-600 mt-1">Concierge</div>
                </div>
            </div>

            <div class="mt-12">
                <a href="{{ url('/') }}#book"
                   class="btn btn-primary">
                    Book Your Stay
                </a>
            </div>
        </div>
    </div>
</section>

</x-layouts.app>
