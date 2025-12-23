<x-dashboard.layout>
    <h1 class="text-2xl font-semibold tracking-tight">Approve Reservations</h1>
    <p class="mt-2 text-sm text-slate-600">Approve pending reservations.</p>

    <div class="mt-6 rounded-2xl border border-slate-200 bg-white overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full table-fixed text-sm break-words">
                <thead class="bg-slate-50 text-slate-600">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold">Customer</th>
                    <th class="px-4 py-3 text-left font-semibold">Room</th>
                    <th class="px-4 py-3 text-left font-semibold">Check-in</th>
                    <th class="px-4 py-3 text-left font-semibold">Check-out</th>
                    <th class="px-4 py-3 text-left font-semibold">Amenities</th>
                    <th class="px-4 py-3 text-left font-semibold">Total</th>
                    <th class="px-4 py-3 text-left font-semibold">Receipt</th>
                    <th class="px-4 py-3 text-left font-semibold">Status</th>
                    <th class="px-4 py-3 text-left font-semibold">Actions</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                @forelse ($pendingReservations as $reservation)
                    <tr class="hover:bg-slate-50/60">
                        <td class="px-4 py-3 font-medium text-slate-900">{{ $reservation->user?->full_name ?? '—' }}</td>
                        <td class="px-4 py-3 text-slate-700">{{ $reservation->room?->room_number ?? '—' }}</td>
                        <td class="px-4 py-3 text-slate-700">{{ optional($reservation->check_in_date)->format('Y-m-d') }}</td>
                        <td class="px-4 py-3 text-slate-700">{{ optional($reservation->check_out_date)->format('Y-m-d') }}</td>
                        <td class="px-4 py-3 text-slate-700">
                            @if ($reservation->amenities->isNotEmpty())
                                {{ $reservation->amenities->pluck('amenity_name')->implode(', ') }}
                            @else
                                —
                            @endif
                        </td>
                        <td class="px-4 py-3 text-slate-700">₱{{ number_format((float) $reservation->total_price, 2) }}</td>
                        <td class="px-4 py-3 text-slate-700">
                            @if (!empty($reservation->payment_receipt_path))
                                <a
                                    class="inline-flex items-center gap-1 text-sky-600 underline hover:text-sky-700"
                                    href="{{ route('dashboard.reservations.receipt', $reservation->reservation_id) }}"
                                    target="_blank"
                                    rel="noopener"
                                >
                                    <span>View</span>
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H18m0 0v4.5M18 6l-7.5 7.5" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6H7.5A1.5 1.5 0 0 0 6 7.5v9A1.5 1.5 0 0 0 7.5 18h9a1.5 1.5 0 0 0 1.5-1.5v-3" />
                                    </svg>
                                </a>
                            @else
                                —
                            @endif
                        </td>
                        <td class="px-4 py-3 text-slate-700">{{ $reservation->reservation_status }}</td>
                        <td class="px-4 py-3 text-slate-700">
                            <div class="flex items-center gap-2">
                                    <form method="POST" action="{{ route('dashboard.approvals.approve', $reservation->reservation_id) }}"
                                          data-swal-confirm
                                          data-swal-title="Approve reservation?"
                                          data-swal-text="This will mark the reservation as approved."
                                          data-swal-confirm-text="Yes, approve">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Approve</button>
                                </form>
                                    <form method="POST" action="{{ route('dashboard.approvals.reject', $reservation->reservation_id) }}"
                                          data-swal-confirm
                                          data-swal-title="Reject reservation?"
                                          data-swal-text="This will mark the reservation as rejected."
                                          data-swal-confirm-text="Yes, reject">
                                    @csrf
                                    <button type="submit" class="btn btn-soft">Reject</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="px-4 py-6 text-center text-slate-500">No pending reservations.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $pendingReservations->links() }}
    </div>
</x-dashboard.layout>
