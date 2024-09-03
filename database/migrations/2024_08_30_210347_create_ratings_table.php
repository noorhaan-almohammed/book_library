<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('book_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->integer('rating');
            $table->text('review')->nullable();
            $table->unique(['user_id' , 'book_id'] , 'user_rate');
            $table->timestamps();
        });
        DB::statement('ALTER TABLE ratings ADD CONSTRAINT check_rating_range CHECK (rating >= 1 AND rating <= 5)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
