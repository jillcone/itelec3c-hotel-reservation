<x-dashboard.layout>
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight">Manage Reviews</h1>
            <p class="mt-2 text-sm text-slate-600">Approve or reject customer reviews.</p>
        </div>
        <div>
            <button id="openFeaturedModal" class="btn btn-primary">Choose which review is shown</button>
        </div>
    </div>

    <div class="mt-6 rounded-2xl border border-slate-200 bg-white overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full table-fixed text-sm break-words">
                <thead class="bg-slate-50 text-slate-600">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold">Customer</th>
                    <th class="px-4 py-3 text-left font-semibold">Rating</th>
                    <th class="px-4 py-3 text-left font-semibold">Review</th>
                    <th class="px-4 py-3 text-left font-semibold">Date</th>
                    <th class="px-4 py-3 text-left font-semibold">Status</th>
                    <th class="px-4 py-3 text-left font-semibold">Actions</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                @forelse ($reviews as $review)
                    <tr class="hover:bg-slate-50/60">
                        <td class="px-4 py-3 font-medium text-slate-900">{{ $review->name }}</td>
                        <td class="px-4 py-3 text-slate-700">
                            <div class="flex items-center gap-1">
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg class="h-4 w-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-slate-300' }}" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    </svg>
                                @endfor
                                <span class="ml-1 text-sm">{{ $review->rating }}/5</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-slate-700 max-w-xs truncate" title="{{ $review->comment }}">{{ $review->comment }}</td>
                        <td class="px-4 py-3 text-slate-700">{{ $review->created_at->format('M j, Y') }}</td>
                        <td class="px-4 py-3 text-slate-700">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $review->is_approved ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $review->is_approved ? 'Approved' : 'Pending' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-slate-700">
                            @if (!$review->is_approved)
                                <div class="flex items-center gap-2">
                                    <form method="POST" action="{{ route('dashboard.reviews.approve', $review->id) }}"
                                          data-swal-confirm
                                          data-swal-title="Approve review?"
                                          data-swal-text="This will approve the review for potential display on the website."
                                          data-swal-confirm-text="Yes, approve">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Approve</button>
                                    </form>
                                    <form method="POST" action="{{ route('dashboard.reviews.reject', $review->id) }}"
                                          data-swal-confirm
                                          data-swal-title="Reject review?"
                                          data-swal-text="This will permanently delete the review."
                                          data-swal-confirm-text="Yes, reject">
                                        @csrf
                                        <button type="submit" class="btn btn-soft">Reject</button>
                                    </form>
                                </div>
                            @else
                                <span class="text-slate-500 text-sm">Already approved</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-slate-500">No reviews found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $reviews->links() }}
    </div>

    <!-- Featured Reviews Modal -->
<div
    id="featuredModal"
    class="fixed inset-0 z-50 hidden flex items-center justify-center
           bg-slate-900/80 backdrop-blur-sm"
>
    <div
        class="card card-hover w-full max-w-3xl max-h-[90vh] flex flex-col
               bg-white-500 rounded-2xl shadow-2xl p-6"
    >
        <!-- Header -->
        <div class="px-6 py-4 border-b border-slate-200">
            <h2 class="text-xl font-semibold text-slate-900">
                Select Featured Reviews
            </h2>
            <p class="text-sm text-slate-600 mt-1">
                Choose which approved reviews to display on the homepage
            </p>
        </div>

        <!-- Body -->
        <div id="featuredReviewsList" class="overflow-y-auto flex-1 px-6 py-4">
            <!-- Skeleton loader for initial state -->
            <div id="reviewsSkeleton" class="space-y-4">
                @for ($i = 0; $i < 3; $i++)
                    <div class="animate-pulse">
                        <div class="flex items-start gap-4 p-4 rounded-lg border border-slate-200">
                            <div class="w-4 h-4 bg-slate-200 rounded flex-shrink-0 mt-1"></div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <div class="h-4 bg-slate-200 rounded w-24"></div>
                                    <div class="flex gap-1">
                                        @for ($j = 0; $j < 5; $j++)
                                            <div class="w-3 h-3 bg-slate-200 rounded"></div>
                                        @endfor
                                    </div>
                                </div>
                                <div class="space-y-1">
                                    <div class="h-3 bg-slate-200 rounded w-full"></div>
                                    <div class="h-3 bg-slate-200 rounded w-3/4"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>

            <!-- Loading state (shown when fetching data) -->
            <div id="loadingState" class="text-center py-12 text-slate-500 hidden">
                <div class="relative">
                    <!-- Modern pulsing dots animation -->
                    <div class="flex items-center justify-center space-x-2">
                        <div class="w-3 h-3 bg-slate-400 rounded-full animate-bounce" style="animation-delay: 0ms"></div>
                        <div class="w-3 h-3 bg-slate-400 rounded-full animate-bounce" style="animation-delay: 150ms"></div>
                        <div class="w-3 h-3 bg-slate-400 rounded-full animate-bounce" style="animation-delay: 300ms"></div>
                    </div>
                    <!-- Elegant ring spinner as backup -->
                    <div class="mt-6 relative">
                        <div class="w-12 h-12 border-4 border-slate-200 border-t-slate-600 rounded-full animate-spin mx-auto"></div>
                        <div class="absolute inset-0 w-12 h-12 border-4 border-transparent border-t-emerald-500 rounded-full animate-spin mx-auto" style="animation-direction: reverse; animation-duration: 1.5s;"></div>
                    </div>
                </div>
                <p class="mt-4 text-sm font-medium text-slate-600">Loading reviews...</p>
                <p class="mt-1 text-xs text-slate-400">Please wait while we fetch the latest reviews</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="px-6 py-4 border-t border-slate-200 flex justify-end gap-3">
            <button id="closeFeaturedModal" class="btn btn-soft mt-4">
                Cancel
            </button>
            <button id="saveFeaturedReviews" class="btn btn-primary mt-4">
                Save Changes
            </button>
        </div>
    </div>
</div>


    <script>
        const modal = document.getElementById('featuredModal');
        const openBtn = document.getElementById('openFeaturedModal');
        const closeBtn = document.getElementById('closeFeaturedModal');
        const saveBtn = document.getElementById('saveFeaturedReviews');
        const reviewsList = document.getElementById('featuredReviewsList');

        let reviews = [];

        openBtn.addEventListener('click', async () => {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            // Show skeleton initially
            document.getElementById('reviewsSkeleton').classList.remove('hidden');
            document.getElementById('loadingState').classList.add('hidden');
            
            await loadReviews();
        });

        closeBtn.addEventListener('click', () => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        });

        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        });

        async function loadReviews() {
            try {
                // Switch to loading animation
                document.getElementById('reviewsSkeleton').classList.add('hidden');
                document.getElementById('loadingState').classList.remove('hidden');
                
                const response = await fetch('{{ route('dashboard.reviews.featured') }}');
                reviews = await response.json();
                
                if (reviews.length === 0) {
                    reviewsList.innerHTML = `
                        <div class="text-center py-8 text-slate-500">
                            <p>No approved reviews available.</p>
                        </div>
                    `;
                    return;
                }

                reviewsList.innerHTML = reviews.map(review => `
                    <label class="flex items-start gap-4 p-4 rounded-lg border border-slate-200 hover:border-slate-300 hover:bg-slate-50 cursor-pointer mb-3">
                        <input type="checkbox" class="review-checkbox mt-1 h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500" 
                               data-review-id="${review.id}" 
                               ${review.is_featured ? 'checked' : ''}>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-medium text-slate-900">${review.name}</span>
                                <div class="flex items-center gap-1">
                                    <div class="flex items-center gap-0.5">
                                        ${Array.from({length: 5}, (_, i) => `
                                            <svg class="h-3.5 w-3.5 ${i < review.rating ? 'text-yellow-400' : 'text-slate-300'}" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                            </svg>
                                        `).join('')}
                                    </div>
                                    <span class="text-xs text-slate-500">${review.rating}/5</span>
                                </div>
                            </div>
                            <p class="text-sm text-slate-600">${review.comment}</p>
                        </div>
                    </label>
                `).join('');

                // Add event listeners to checkboxes to limit selection to 6
                const checkboxes = reviewsList.querySelectorAll('.review-checkbox');
                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', async () => {
                        const checkedBoxes = reviewsList.querySelectorAll('.review-checkbox:checked');
                        if (checkedBoxes.length > 6) {
                            checkbox.checked = false;
                            const Swal = await window.ensureSwal();
                            if (Swal) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Maximum Selection Reached',
                                    text: 'You can select a maximum of 6 reviews to feature.',
                                    confirmButtonText: 'OK'
                                });
                            }
                        }
                    });
                });
            } catch (error) {
                console.error('Error loading reviews:', error);
                reviewsList.innerHTML = `
                    <div class="text-center py-8 text-red-500">
                        <p>Error loading reviews. Please try again.</p>
                    </div>
                `;
            }
        }

        saveBtn.addEventListener('click', async () => {
            const checkboxes = reviewsList.querySelectorAll('.review-checkbox:checked');
            const featuredIds = Array.from(checkboxes).map(cb => parseInt(cb.dataset.reviewId));

            if (featuredIds.length === 0) {
                const Swal = await window.ensureSwal();
                if (Swal) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'No Reviews Selected',
                        text: 'Please select at least one review to feature.',
                        confirmButtonText: 'OK'
                    });
                }
                return;
            }

            if (featuredIds.length > 6) {
                const Swal = await window.ensureSwal();
                if (Swal) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Too Many Reviews Selected',
                        text: 'You can select a maximum of 6 reviews to feature.',
                        confirmButtonText: 'OK'
                    });
                }
                return;
            }

            try {
                saveBtn.disabled = true;
                saveBtn.innerHTML = `
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
                        <span>Saving...</span>
                    </div>
                `;

                const response = await fetch('{{ route('dashboard.reviews.featured.update') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ featured_ids: featuredIds })
                });

                const result = await response.json();

                if (result.success) {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                    window.location.reload();
                } else {
                    const Swal = await window.ensureSwal();
                    if (Swal) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Update Failed',
                            text: 'Error updating featured reviews. Please try again.',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            } catch (error) {
                console.error('Error saving reviews:', error);
                const Swal = await window.ensureSwal();
                if (Swal) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Update Failed',
                        text: 'Error updating featured reviews. Please try again.',
                        confirmButtonText: 'OK'
                    });
                }
            } finally {
                saveBtn.disabled = false;
                saveBtn.innerHTML = 'Save Changes';
            }
        });
    </script>
</x-dashboard.layout>