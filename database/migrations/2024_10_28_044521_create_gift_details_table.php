<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGiftDetailsTable extends Migration
{
    public function up(): void
    {
        Schema::create('gift_details', function (Blueprint $table) {
            $table->id(); // ID của bản ghi
            $table->unsignedBigInteger('product_in_gift'); // ID của giỏ quà từ bảng product_in_gift
            $table->unsignedBigInteger('product_id'); // ID của sản phẩm
            $table->integer('quantity'); // Số lượng sản phẩm
            $table->decimal('price', 8, 2); // Giá sản phẩm
            $table->decimal('total_price', 8, 2); // Tổng giá sản phẩm
            $table->timestamps();

            // Khóa ngoại
            $table->foreign('product_in_gift')->references('id')->on('product_in_gift')->onDelete('cascade'); // Liên kết với bảng product_in_gift
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade'); // Liên kết với bảng products
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gift_details');
    }
}
