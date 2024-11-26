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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->string('address');
            $table->string('status');
            $table->string('payment_method');
            $table->unsignedBigInteger('discounts_id')->nullable(); // Thêm nullable nếu không phải lúc nào cũng có discount
            $table->unsignedBigInteger('user_id');  
            $table->decimal('total_amount', 8, 2); 
            $table->string('token')->nullable();
            $table->timestamp('order_date'); 
            $table->timestamps();
            
            // Đảm bảo cột tồn tại trước khi tạo khóa ngoại
            $table->foreign('discounts_id')->references('id')->on('discounts')->onDelete('restrict');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
