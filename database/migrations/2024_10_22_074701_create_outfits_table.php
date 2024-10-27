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
        Schema::create('outfits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->foreignId('head_id')->nullable()->constrained('clothing_items')->onDelete('set null');
            $table->foreignId('top_id')->nullable()->constrained('clothing_items')->onDelete('set null');
            $table->foreignId('bottom_id')->nullable()->constrained('clothing_items')->onDelete('set null');
            $table->foreignId('footwear_id')->nullable()->constrained('clothing_items')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outfits');
    }
};
