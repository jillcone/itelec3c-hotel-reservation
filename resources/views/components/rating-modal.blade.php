{{-- Rating Modal --}}
<div
    id="ratingModal"
    class="hidden fixed inset-0 z-50 flex items-center justify-center p-6"
    aria-labelledby="modal-title"
    role="dialog"
    aria-modal="true"
>
    {{-- Background overlay --}}
    <div class="absolute inset-0 bg-black/90 backdrop-blur-xl" onclick="closeRatingModal()"></div>

    {{-- Modal panel --}}
    <div
        id="ratingModalPanel"
        class="relative w-full max-w-md overflow-hidden rounded-3xl bg-white shadow-2xl ring-1 ring-black/5
               transform transition duration-200 ease-out scale-95 opacity-0 translate-y-2 p-6"
        tabindex="-1"
    >
            {{-- Header --}}
            <div class="bg-gradient-to-br from-white to-slate-50 pb-5 text-center">
                <h3 id="modal-title" class="text-2xl font-semibold text-slate-900">
                    Rate Your Experience
                </h3>
                <p class="mt-2 text-sm text-slate-600">
                    Share your thoughts about your stay at Aurum Hotel
                </p>

                <form id="ratingForm" class="mt-6 space-y-5" novalidate>
                    @csrf

                    {{-- Name Input --}}
                    <div class="text-left">
                        <label for="reviewerName" class="block text-sm font-medium text-slate-700">Your Name</label>
                        <input
                            type="text"
                            id="reviewerName"
                            name="name"
                            required
                            maxlength="255"
                            autocomplete="name"
                            class="mt-1 block w-full rounded-xl border-slate-300 shadow-sm px-4 py-3
                                   focus:border-slate-900 focus:ring-slate-900 sm:text-sm"
                            placeholder="Enter your name"
                        />
                    </div>

                    {{-- Star Rating --}}
                    <div class="text-center">
                        <div class="flex items-center justify-center gap-3 mb-2">
                            <label class="block text-sm font-medium text-slate-700">Rating</label>
                            <span id="ratingLabel" class="text-xs text-slate-500">No rating yet</span>
                        </div>

                        <input type="hidden" id="ratingValue" name="rating" value="0" required />

                        <div
                            class="flex items-center justify-center gap-1"
                            id="starRating"
                            role="radiogroup"
                            aria-label="Star rating"
                        >
                            @for ($i = 1; $i <= 5; $i++)
                                <button
                                    type="button"
                                    class="star-btn p-1 text-4xl leading-none transition-colors duration-200
                                           hover:text-yellow-400 focus:outline-none focus:ring-2 focus:ring-slate-900/30 rounded-lg"
                                    data-rating="{{ $i }}"
                                    role="radio"
                                    aria-checked="false"
                                    aria-label="{{ $i }} star{{ $i > 1 ? 's' : '' }}"
                                    style="color: #cbd5e1;"
                                >&#9733;</button>
                            @endfor
                        </div>

                        <p id="ratingError" class="mt-1 text-sm text-red-600 hidden">Please select a rating.</p>
                    </div>

                    {{-- Comment Textarea --}}
                    <div class="text-left">
                        <div class="flex items-center justify-between gap-3">
                            <label for="reviewComment" class="block text-sm font-medium text-slate-700">Your Review</label>
                            <span id="charCount" class="text-xs text-slate-500">0/1000</span>
                        </div>

                        <textarea
                            id="reviewComment"
                            name="comment"
                            rows="4"
                            required
                            maxlength="1000"
                            class="mt-1 block w-full rounded-xl border-slate-300 shadow-sm px-4 py-3
                                   focus:border-slate-900 focus:ring-slate-900 sm:text-sm"
                            placeholder="Tell us about your experience..."
                        ></textarea>
                    </div>
                </form>
            </div>

            {{-- Actions --}}
            <div class="bg-slate-50 py-4 flex flex-col sm:flex-row-reverse gap-3">
                <button
                    id="submitReviewBtn"
                    type="button"
                    onclick="submitRating()"
                    class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm
                           px-5 py-2.5 bg-slate-900 text-sm font-medium text-white hover:bg-slate-800
                           focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900 transition disabled:opacity-60"
                >
                    Submit Review
                </button>

                <button
                    type="button"
                    onclick="closeRatingModal()"
                    class="w-full inline-flex justify-center rounded-xl border border-slate-300 shadow-sm
                           px-5 py-2.5 bg-white text-sm font-medium text-slate-700 hover:bg-slate-50
                           focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition"
                >
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let selectedRating = 0;

    const ratingText = (n) => {
        if (!n) return 'No rating yet';
        const labels = ['Poor', 'Fair', 'Good', 'Very good', 'Excellent'];
        return `${n}/5 • ${labels[n - 1]}`;
    };

    function openRatingModal() {
        const modal = document.getElementById('ratingModal');
        const panel = document.getElementById('ratingModalPanel');

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        // Reset star rating to initial state
        selectedRating = 0;
        const starButtons = document.querySelectorAll('.star-btn');
        starButtons.forEach(btn => {
            btn.style.color = '#cbd5e1'; // slate-300
        });
        document.getElementById('ratingLabel').textContent = ratingText(0);

        // Animate in (Tailwind classes)
        requestAnimationFrame(() => {
            panel.classList.remove('scale-95', 'opacity-0', 'translate-y-2');
            panel.classList.add('scale-100', 'opacity-100', 'translate-y-0');
            panel.focus();
        });
    }

    function closeRatingModal() {
        const modal = document.getElementById('ratingModal');
        const panel = document.getElementById('ratingModalPanel');

        // Animate out
        panel.classList.add('scale-95', 'opacity-0', 'translate-y-2');
        panel.classList.remove('scale-100', 'opacity-100', 'translate-y-0');

        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            resetRatingForm();
        }, 180);
    }

    function resetRatingForm() {
        const form = document.getElementById('ratingForm');
        form.reset();

        selectedRating = 0;
        document.getElementById('ratingValue').value = 0;
        document.getElementById('ratingError').classList.add('hidden');

        // Reset stars with inline styles
        const starButtons = document.querySelectorAll('.star-btn');
        starButtons.forEach(btn => {
            btn.style.color = '#cbd5e1'; // slate-300
        });

        // Reset char count
        document.getElementById('charCount').textContent = '0/1000';
        document.getElementById('submitReviewBtn').disabled = false;
        document.getElementById('submitReviewBtn').innerHTML = 'Submit Review';
    }

    function setStars(value) {
        const starButtons = document.querySelectorAll('.star-btn');
        console.log('setStars called with value:', value, 'found buttons:', starButtons.length);

        starButtons.forEach((starBtn, idx) => {
            const active = idx < value;
            console.log(`Star ${idx + 1}: active=${active}`);

            if (active) {
                starBtn.style.color = '#fbbf24'; // yellow-400
                starBtn.classList.add('text-yellow-400');
                starBtn.classList.remove('text-slate-300');
            } else {
                starBtn.style.color = '#cbd5e1'; // slate-300
                starBtn.classList.add('text-slate-300');
                starBtn.classList.remove('text-yellow-400');
            }

            starBtn.setAttribute('aria-checked', active ? 'true' : 'false');
            console.log(`Star ${idx + 1} final color:`, starBtn.style.color);
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        const starButtons = document.querySelectorAll('.star-btn');
        const comment = document.getElementById('reviewComment');
        const charCount = document.getElementById('charCount');
        const ratingLabel = document.getElementById('ratingLabel');

        // Debug: Check if star buttons are found
        console.log('Found star buttons:', starButtons.length);

        // Stars: click + hover preview
        starButtons.forEach((btn) => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const rating = parseInt(btn.dataset.rating, 10) || 0;
                selectedRating = rating;
                console.log('Star clicked:', rating, 'selectedRating:', selectedRating);

                document.getElementById('ratingValue').value = selectedRating;
                document.getElementById('ratingError').classList.add('hidden');

                setStars(selectedRating);
                ratingLabel.textContent = ratingText(selectedRating);
            });

            btn.addEventListener('mouseenter', () => {
                const hoverRating = parseInt(btn.dataset.rating, 10) || 0;
                starButtons.forEach((star, index) => {
                    if (index < hoverRating) {
                        star.style.color = '#fbbf24'; // yellow-400
                    } else {
                        star.style.color = '#cbd5e1'; // slate-300
                    }
                });
                ratingLabel.textContent = ratingText(hoverRating);
            });

            btn.addEventListener('mouseleave', () => {
                starButtons.forEach((star, index) => {
                    if (index < selectedRating) {
                        star.style.color = '#fbbf24'; // yellow-400
                    } else {
                        star.style.color = '#cbd5e1'; // slate-300
                    }
                });
                ratingLabel.textContent = ratingText(selectedRating);
            });
        });

        // Character counter
        comment.addEventListener('input', () => {
            const len = comment.value.length;
            charCount.textContent = `${len}/1000`;
        });
    });

    async function submitRating() {
        const name = document.getElementById('reviewerName').value.trim();
        const rating = parseInt(document.getElementById('ratingValue').value, 10);
        const comment = document.getElementById('reviewComment').value.trim();

        if (!name) {
            document.getElementById('reviewerName').focus();
            if (window.ensureSwal) {
                window.ensureSwal().then(Swal => {
                    if (Swal) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Name Required',
                            text: 'Please enter your name',
                            confirmButtonColor: '#0f172a',
                        });
                    } else {
                        console.error('SweetAlert not available');
                    }
                });
            } else {
                console.error('ensureSwal not available');
            }
            return;
        }

        if (!rating || Number.isNaN(rating)) {
            document.getElementById('ratingError').classList.remove('hidden');
            return;
        }

        if (!comment) {
            document.getElementById('reviewComment').focus();
            if (window.ensureSwal) {
                window.ensureSwal().then(Swal => {
                    if (Swal) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Review Required',
                            text: 'Please write a review',
                            confirmButtonColor: '#0f172a',
                        });
                    } else {
                        console.error('SweetAlert not available');
                    }
                });
            } else {
                console.error('ensureSwal not available');
            }
            return;
        }

        const csrfToken = document.querySelector('input[name="_token"]').value;
        const submitBtn = document.getElementById('submitReviewBtn');

        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
                <span>Submitting...</span>
            </div>
        `;

        try {
            const response = await fetch('{{ route("reviews.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ name, rating, comment }),
            });

            const data = await response.json().catch(() => ({}));

            if (!response.ok || !data.success) {
                throw new Error(data.message || 'Failed to submit review');
            }

            closeRatingModal();

            if (window.ensureSwal) {
                const Swal = await window.ensureSwal();
                if (Swal) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thank You!',
                        text: data.message || 'Your review has been submitted.',
                        confirmButtonColor: '#0f172a',
                    });
                }
            }
        } catch (error) {
            console.error('Error submitting review:', error);

            if (window.ensureSwal) {
                const Swal = await window.ensureSwal();
                if (Swal) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to submit your review. Please try again.',
                        confirmButtonColor: '#0f172a',
                    });
                }
            }
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Submit Review';
        }
    }

    // Close on escape key
    document.addEventListener('keydown', (e) => {
        const modal = document.getElementById('ratingModal');
        if (!modal.classList.contains('hidden') && e.key === 'Escape') {
            closeRatingModal();
        }
    });
</script>
