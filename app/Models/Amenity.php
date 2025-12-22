<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Amenity extends Model
{
    use HasFactory;

    protected $primaryKey = 'amenity_id';

    protected $fillable = [
        'amenity_name',
        'description',
        'price_per_use',
    ];

    protected function casts(): array
    {
        return [
            'price_per_use' => 'decimal:2',
        ];
    }

    public function reservations(): BelongsToMany
    {
        return $this->belongsToMany(Reservation::class, 'amenity_reservation', 'amenity_id', 'reservation_id')
            ->withPivot(['price_per_use'])
            ->withTimestamps();
    }
}
