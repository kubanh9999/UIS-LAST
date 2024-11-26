<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGiftTableMigrationUnique   extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gifts', function (Blueprint $table) {
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
            $table->unsignedBigInteger('product_type_id'); // Thêm product_type_id để liên kết với bảng product_types
            $table->timestamps();

            // Đảm bảo cột tồn tại trước khi tạo khóa ngoại
            $table->foreign('discounts_id')->references('id')->on('discounts')->onDelete('restrict');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('product_type_id')->references('id')->on('product_types')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gifts');
    }
}
