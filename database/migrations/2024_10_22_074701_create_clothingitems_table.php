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
        Schema::create('clothingitems', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['head', 'top', 'bottom', 'footwear']);
            $table->string('name');
            $table->string('image_path'); // Add this line to include the image path column
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clothingitems');
    }
};
