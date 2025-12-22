<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use App\Models\UserLog;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $today = now()->toDateString();

        $totalReservations = Reservation::count();
        $todayCheckIns = Reservation::whereDate('check_in_date', $today)->count();
        $todayCheckOuts = Reservation::whereDate('check_out_date', $today)->count();
        $totalRevenue = (float) Reservation::sum('total_price');

        $roomsTotal = Room::count();
        $roomsAvailable = Room::where('availability_status', 'available')->count();
        $roomsUnavailable = max($roomsTotal - $roomsAvailable, 0);

        $myReservations = Reservation::where('user_id', $user->user_id)->count();

        return view('dashboard.index', compact(
            'today',
            'totalReservations',
            'todayCheckIns',
            'todayCheckOuts',
            'totalRevenue',
            'roomsTotal',
            'roomsAvailable',
            'roomsUnavailable',
            'myReservations'
        ));
    }

    public function users()
    {
        $users = User::query()
            ->orderBy('user_id')
            ->get();

        return view('dashboard.users', compact('users'));
    }

    public function usersStore(Request $request)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:50'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        User::create([
            'full_name' => $validated['full_name'],
            'role' => $validated['role'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('dashboard.users')->with('success', 'User added.');
    }

    public function usersUpdate(Request $request, int $userId)
    {
        $user = User::query()->where('user_id', $userId)->firstOrFail();

        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:50'],
            'username' => ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore($user->user_id, 'user_id')],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->user_id, 'user_id')],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        $user->fill([
            'full_name' => $validated['full_name'],
            'role' => $validated['role'],
            'username' => $validated['username'],
            'email' => $validated['email'],
        ]);

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('dashboard.users')->with('success', 'User updated.');
    }

    public function usersDestroy(int $userId)
    {
        User::query()->where('user_id', $userId)->delete();

        return redirect()->route('dashboard.users')->with('success', 'User deleted.');
    }

    public function logs()
    {
        $logs = UserLog::query()
            ->with('user')
            ->orderByDesc('date_time')
            ->limit(200)
            ->get();

        return view('dashboard.logs', compact('logs'));
    }

    public function rooms()
    {
        $rooms = Room::query()
            ->orderBy('room_number')
            ->get();

        return view('dashboard.rooms', compact('rooms'));
    }

    public function roomsStore(Request $request)
    {
        $validated = $request->validate([
            'room_number' => ['required', 'string', 'max:255', 'unique:rooms,room_number'],
            'room_type' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'capacity' => ['required', 'integer', 'min:1'],
            'price_per_night' => ['required', 'numeric', 'min:0'],
            'availability_status' => ['required', 'string', 'max:255'],
        ]);

        Room::create($validated);

        return redirect()->route('dashboard.rooms')->with('success', 'Room added.');
    }

    public function roomsUpdate(Request $request, int $roomId)
    {
        $room = Room::query()->where('room_id', $roomId)->firstOrFail();

        $validated = $request->validate([
            'room_number' => ['required', 'string', 'max:255', Rule::unique('rooms', 'room_number')->ignore($room->room_id, 'room_id')],
            'room_type' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'capacity' => ['required', 'integer', 'min:1'],
            'price_per_night' => ['required', 'numeric', 'min:0'],
            'availability_status' => ['required', 'string', 'max:255'],
        ]);

        $room->update($validated);

        return redirect()->route('dashboard.rooms')->with('success', 'Room updated.');
    }

    public function roomsDestroy(int $roomId)
    {
        Room::query()->where('room_id', $roomId)->delete();

        return redirect()->route('dashboard.rooms')->with('success', 'Room deleted.');
    }

    public function amenities()
    {
        $amenities = Amenity::query()
            ->orderBy('amenity_name')
            ->get();

        return view('dashboard.amenities', compact('amenities'));
    }

    public function amenitiesStore(Request $request)
    {
        $validated = $request->validate([
            'amenity_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price_per_use' => ['required', 'numeric', 'min:0'],
        ]);

        Amenity::create($validated);

        return redirect()->route('dashboard.amenities')->with('success', 'Amenity added.');
    }

    public function amenitiesUpdate(Request $request, int $amenityId)
    {
        $amenity = Amenity::query()->where('amenity_id', $amenityId)->firstOrFail();

        $validated = $request->validate([
            'amenity_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price_per_use' => ['required', 'numeric', 'min:0'],
        ]);

        $amenity->update($validated);

        return redirect()->route('dashboard.amenities')->with('success', 'Amenity updated.');
    }

    public function amenitiesDestroy(int $amenityId)
    {
        Amenity::query()->where('amenity_id', $amenityId)->delete();

        return redirect()->route('dashboard.amenities')->with('success', 'Amenity deleted.');
    }

    public function reservations()
    {
        $reservations = Reservation::query()
            ->with(['user', 'room', 'amenities'])
            ->orderByDesc('created_at')
            ->get();

        $users = User::query()->orderBy('full_name')->get();
        $rooms = Room::query()->orderBy('room_number')->get();

        return view('dashboard.reservations', compact('reservations', 'users', 'rooms'));
    }

    public function reservationsStore(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,user_id'],
            'room_id' => ['required', 'integer', 'exists:rooms,room_id'],
            'check_in_date' => ['required', 'date'],
            'check_out_date' => ['required', 'date', 'after:check_in_date'],
            'reservation_status' => ['required', 'string', 'max:255'],
        ]);

        $room = Room::query()->where('room_id', $validated['room_id'])->firstOrFail();
        $nights = max(1, now()->parse($validated['check_in_date'])->diffInDays(now()->parse($validated['check_out_date'])));
        $totalPrice = $nights * (float) $room->price_per_night;

        Reservation::create([
            'user_id' => $validated['user_id'],
            'room_id' => $validated['room_id'],
            'check_in_date' => $validated['check_in_date'],
            'check_out_date' => $validated['check_out_date'],
            'total_price' => $totalPrice,
            'reservation_status' => $validated['reservation_status'],
        ]);

        return redirect()->route('dashboard.reservations')->with('success', 'Reservation added.');
    }

    public function reservationsUpdate(Request $request, int $reservationId)
    {
        $reservation = Reservation::query()->where('reservation_id', $reservationId)->firstOrFail();

        $validated = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,user_id'],
            'room_id' => ['required', 'integer', 'exists:rooms,room_id'],
            'check_in_date' => ['required', 'date'],
            'check_out_date' => ['required', 'date', 'after:check_in_date'],
            'reservation_status' => ['required', 'string', 'max:255'],
        ]);

        $room = Room::query()->where('room_id', $validated['room_id'])->firstOrFail();
        $nights = max(1, now()->parse($validated['check_in_date'])->diffInDays(now()->parse($validated['check_out_date'])));
        $totalPrice = $nights * (float) $room->price_per_night;

        $reservation->update([
            'user_id' => $validated['user_id'],
            'room_id' => $validated['room_id'],
            'check_in_date' => $validated['check_in_date'],
            'check_out_date' => $validated['check_out_date'],
            'total_price' => $totalPrice,
            'reservation_status' => $validated['reservation_status'],
        ]);

        return redirect()->route('dashboard.reservations')->with('success', 'Reservation updated.');
    }

    public function reservationsDestroy(int $reservationId)
    {
        Reservation::query()->where('reservation_id', $reservationId)->delete();

        return redirect()->route('dashboard.reservations')->with('success', 'Reservation deleted.');
    }

    public function approvals()
    {
        $pendingReservations = Reservation::query()
            ->with(['user', 'room', 'amenities'])
            ->where(function ($q) {
                $q->where('reservation_status', 'pending')
                    ->orWhere('reservation_status', 'Pending');
            })
            ->orderByDesc('created_at')
            ->get();

        return view('dashboard.approvals', compact('pendingReservations'));
    }

    public function approvalsApprove(int $reservationId)
    {
        $reservation = Reservation::query()
            ->where('reservation_id', $reservationId)
            ->firstOrFail();

        $reservation->update(['reservation_status' => 'approved']);

        Room::query()
            ->where('room_id', $reservation->room_id)
            ->update(['availability_status' => 'unavailable']);

        return redirect()->route('dashboard.approvals')->with('success', 'Reservation approved.');
    }

    public function approvalsReject(int $reservationId)
    {
        Reservation::query()
            ->where('reservation_id', $reservationId)
            ->update(['reservation_status' => 'rejected']);

        return redirect()->route('dashboard.approvals')->with('success', 'Reservation rejected.');
    }

    public function myReservations(Request $request)
    {
        $user = $request->user();

        $reservations = Reservation::query()
            ->with(['room', 'amenities'])
            ->where('user_id', $user->user_id)
            ->orderByDesc('created_at')
            ->get();

        return view('dashboard.my-reservations', compact('reservations'));
    }

    public function reserve(Request $request)
    {
        return $this->reserveWithFilters($request);
    }

    private function reserveWithFilters(Request $request)
    {
        $validated = $request->validate([
            'check_in_date' => ['nullable', 'date'],
            'check_out_date' => ['nullable', 'date', 'after:check_in_date'],
            'guests' => ['nullable', 'integer', 'min:1'],
            'room_type' => ['nullable', 'string', 'max:255'],
        ]);

        $checkIn = $validated['check_in_date'] ?? null;
        $checkOut = $validated['check_out_date'] ?? null;
        $guests = $validated['guests'] ?? null;
        $roomType = $validated['room_type'] ?? null;

        $availableRooms = Room::query()
            ->where('availability_status', 'available')
            ->when($guests, fn ($q) => $q->where('capacity', '>=', $guests))
            ->when($roomType && strtolower($roomType) !== 'any', fn ($q) => $q->where('room_type', $roomType))
            ->when($checkIn && $checkOut, function ($q) use ($checkIn, $checkOut) {
                $q->whereDoesntHave('reservations', function ($rq) use ($checkIn, $checkOut) {
                    $rq->whereNotIn('reservation_status', ['rejected', 'Rejected', 'cancelled', 'Cancelled'])
                        ->where('check_in_date', '<', $checkOut)
                        ->where('check_out_date', '>', $checkIn);
                });
            })
            ->orderBy('room_number')
            ->get();

        $amenities = Amenity::query()
            ->orderBy('amenity_name')
            ->get();

        return view('dashboard.reserve', [
            'availableRooms' => $availableRooms,
            'amenities' => $amenities,
            'checkIn' => $checkIn,
            'checkOut' => $checkOut,
            'guests' => $guests,
            'roomType' => $roomType,
        ]);
    }

    public function reserveStore(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'room_id' => ['required', 'integer', 'exists:rooms,room_id'],
            'check_in_date' => ['required', 'date'],
            'check_out_date' => ['required', 'date', 'after:check_in_date'],
            'amenity_ids' => ['nullable', 'array'],
            'amenity_ids.*' => ['integer', 'exists:amenities,amenity_id'],
        ]);

        $room = Room::query()->where('room_id', $validated['room_id'])->firstOrFail();
        if ($room->availability_status !== 'available') {
            return redirect()->route('dashboard.reserve', $request->only(['check_in_date', 'check_out_date', 'guests', 'room_type']))
                ->with('error', 'Selected room is not available.');
        }

        $hasConflict = Reservation::query()
            ->where('room_id', $room->room_id)
            ->whereNotIn('reservation_status', ['rejected', 'Rejected', 'cancelled', 'Cancelled'])
            ->where('check_in_date', '<', $validated['check_out_date'])
            ->where('check_out_date', '>', $validated['check_in_date'])
            ->exists();

        if ($hasConflict) {
            return redirect()->route('dashboard.reserve', $request->only(['check_in_date', 'check_out_date', 'guests', 'room_type']))
                ->with('error', 'That room is already reserved for the selected dates.');
        }

        $nights = max(1, now()->parse($validated['check_in_date'])->diffInDays(now()->parse($validated['check_out_date'])));
        $baseTotal = $nights * (float) $room->price_per_night;

        $amenityIds = $validated['amenity_ids'] ?? [];
        $amenities = Amenity::query()
            ->whereIn('amenity_id', $amenityIds)
            ->get(['amenity_id', 'price_per_use']);

        $amenitiesTotal = (float) $amenities->sum(fn ($a) => (float) $a->price_per_use);
        $totalPrice = $baseTotal + $amenitiesTotal;

        $reservation = Reservation::create([
            'user_id' => $user->user_id,
            'room_id' => $room->room_id,
            'check_in_date' => $validated['check_in_date'],
            'check_out_date' => $validated['check_out_date'],
            'total_price' => $totalPrice,
            'reservation_status' => 'pending',
        ]);

        if ($amenities->isNotEmpty()) {
            foreach ($amenities as $amenity) {
                $reservation->amenities()->attach($amenity->amenity_id, [
                    'price_per_use' => $amenity->price_per_use,
                ]);
            }
        }

        return redirect()->route('dashboard.my-reservations')->with('success', 'Reservation created and is pending approval.');
    }
}
