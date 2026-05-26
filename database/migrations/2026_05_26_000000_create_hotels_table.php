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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('destination_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('type'); // 'hotel' or 'airbnb'
            $table->string('location');
            $table->text('description');
            $table->decimal('price_per_night', 10, 2);
            $table->decimal('rating', 3, 2)->default(5.00);
            $table->integer('rooms_available')->default(5);
            $table->json('amenities')->nullable();
            $table->string('image_url')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
