<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('amenity_reservation', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('reservation_id');
            $table->unsignedBigInteger('amenity_id');

            // Snapshot price at time of booking
            $table->decimal('price_per_use', 10, 2);

            $table->timestamps();

            $table->unique(['reservation_id', 'amenity_id']);

            $table->foreign('reservation_id')
                ->references('reservation_id')
                ->on('reservations')
                ->cascadeOnDelete();

            $table->foreign('amenity_id')
                ->references('amenity_id')
                ->on('amenities')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('amenity_reservation');
    }
};
