<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Comment;
use App\Models\Discount;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Payment;
use App\Models\Shipment;
use App\Models\Favorite;
use App\Models\GiftWrapping;
use App\Models\ProductType;
use App\Models\ProductInGift;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Category::factory(3)->create();
        Product::factory(6)->create();
        User::factory(3)->create();
        Order::factory(3)->create();
        OrderDetail::factory(3)->create();
        Comment::factory(3)->create();
        Discount::factory(3)->create();
        Post::factory(3)->create();
        PostCategory::factory(3)->create();
        Shipment::factory(3)->create();
        Payment::factory(3)->create();
        Favorite::factory(3)->create();
        GiftWrapping::factory(3)->create();
        ProductType::factory(3)->create();
        ProductInGift::factory(3)->create();
        ProductImage::factory(3)->create();
    }
}
