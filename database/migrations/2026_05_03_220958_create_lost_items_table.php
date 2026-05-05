<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('lost_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('item_name');
            $table->string('category');
            $table->string('brand')->nullable();
            $table->string('color');
            $table->date('date_lost');
            $table->string('last_seen_location');
            $table->text('description')->nullable();
            $table->string('image_path')->nullable();
            $table->enum('status', ['missing', 'found'])->default('missing');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lost_items');
    }
};
