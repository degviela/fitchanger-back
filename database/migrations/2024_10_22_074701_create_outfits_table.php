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
            $table->string('name');
            $table->UnsignedBigInteger('user_id');
            $table->UnsignedBigInteger('head_id');
            $table->UnsignedBigInteger('top_id');
            $table->UnsignedBigInteger('bottom_id');
            $table->UnsignedBigInteger('footwear_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('head_id')->references('id')->on('clothing_items')->onDelete('cascade');
            $table->foreign('top_id')->references('id')->on('clothing_items')->onDelete('cascade');
            $table->foreign('bottom_id')->references('id')->on('clothing_items')->onDelete('cascade');
            $table->foreign('footwear_id')->references('id')->on('clothing_items')->onDelete('cascade');
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
