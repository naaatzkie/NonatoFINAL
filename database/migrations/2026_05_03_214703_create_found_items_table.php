<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('found_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('item_name');
            $table->string('category');
            $table->string('brand')->nullable();
            $table->string('color');
            $table->date('date_found');
            $table->time('time_found');
            $table->string('place_found');
            $table->string('image_path')->nullable();
            $table->enum('status', ['unclaimed', 'claimed'])->default('unclaimed');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('found_items');
    }
};
