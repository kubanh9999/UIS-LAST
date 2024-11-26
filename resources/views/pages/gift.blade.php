@extends('layouts.master')
@section('title', 'Giỏ quà')
@section('content')

<main class="main-content py-4">
    <div class="container">
        <!-- Tiêu đề -->
        <div class="row mb-4">
            <div class="col-md-12 text-center">
                <h2 class="display-5">Chọn Trái Cây cho Giỏ Quà: <strong>{{ $basket->name }}</strong></h2>
            </div>
        </div>

        <!-- Hình ảnh giỏ quà -->
        <div class="row justify-content-center mb-4">
            <div class="col-md-4 text-center">
                <img src="{{ asset('layouts/img/' .  $basket->image) }}" alt="{{ $basket->name }}" class="img-fluid rounded shadow" style="width: 100%; max-width: 300px;">
            </div>
        </div>

        <!-- Form chọn trái cây -->
        <form action="{{ route('cart.addGiftBasketToCart', $basket->id) }}" method="POST">
            @csrf

            <div class="row">
                @foreach($fruits as $fruit)
                    <div class="col-md-3 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-body text-center">
                                <!-- Checkbox chọn trái cây -->
                                <input type="checkbox" name="fruits[{{ $fruit->id }}]" value="1" id="fruit_{{ $fruit->id }}" class="form-check-input">
                                
                                <label for="fruit_{{ $fruit->id }}" class="form-check-label">
                                    <!-- Hình ảnh trái cây -->
                                    <img src="{{ asset('layouts/img/' .  $fruit->image) }}" alt="{{ $fruit->name }}" class="img-fluid rounded mb-2" style="max-width: 150px;">
                                    <!-- Tên trái cây -->
                                    <p class="card-text">{{ $fruit->name }}</p>
                                </label>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Nút Thêm vào giỏ hàng -->
            <div class="row justify-content-center mt-4">
                <div class="col-md-6 text-center">
                    <button type="submit" class="btn btn-success btn-lg">
                        Thêm Giỏ Quà vào Giỏ Hàng
                    </button>
                </div>
            </div>
        </form>
    </div>
</main>

@endsection
