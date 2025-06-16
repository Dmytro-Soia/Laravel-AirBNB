<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title');
            $table->string('photos');
            $table->string('description');
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            $table->integer('rooms');
            $table->integer('max_people');
            $table->integer('price');
            $table->string('country');
            $table->string('city');
            $table->string('street');
            $table->decimal('lat', 9, 6);
            $table->decimal('lon', 9, 6);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartments');
    }
};
