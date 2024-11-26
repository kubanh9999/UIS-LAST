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
        Schema::create('gift_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gift_id'); // Liên kết đến bảng gifts
            $table->unsignedBigInteger('product_id'); // Liên kết đến bảng products
            $table->integer('quantity');
            $table->decimal('price', 8, 2);
            $table->decimal('total_price', 8, 2);   
            $table->timestamps();

            // Khóa ngoại
            $table->foreign('gift_id')->references('id')->on('gifts')->onDelete('restrict');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gift_details');
    }
};
