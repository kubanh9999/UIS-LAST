@extends('admin.layout')
@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Danh sách sản phẩm</h4>
                    <h6>Quản lý sản phẩm của bạn</h6>
                </div>
                <div class="page-btn">
                    <a href="{{ route('admin.products.create') }}" class="btn btn-success"><i class="fa-solid fa-plus"></i>Thêm sản phẩm</a>
                </div>
            </div>
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <div class="table-top">
                        <div class="search-set">
                            <div class="search-path">
                                <a class="btn btn-success" id="filter_search">
                                    <img src="{{ asset('assets/img/icons/filter.svg') }}" alt="img">

                                </a>
                            </div>
                            <div class="search-input">
                                <a class="btn btn-searchset"><img src="{{ asset('assets/img/icons/search-white.svg') }}"
                                        alt="img"></a>
                            </div>
                        </div>
                        <div class="wordset">
                            <ul>   
                                <li>
                                    <a href="{{route('admin.products.index')}}" class="btn btn-success" style="text-decoration: none; color: white; float: right">Trang trái cây</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card mb-0" id="filter_inputs">
                        <div class="card-body pb-0">
                            <div class="row">
                                <div class="col-lg-12 col-sm-12">
                                    <div class="row">
                                        <div class="col-lg col-sm-6 col-12">
                                            <div class="form-group">
                                                    <select class="select">
                                                    <option>Choose Product</option>
                                                    <option>Macbook pro</option>
                                                    <option>Orange</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg col-sm-6 col-12">
                                            <div class="form-group">
                                                <select class="select">
                                                    <option>Choose Category</option>
                                                    <option>Computers</option>
                                                    <option>Fruits</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg col-sm-6 col-12">
                                            <div class="form-group">
                                                <select class="select">
                                                    <option>Choose Sub Category</option>
                                                    <option>Computer</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg col-sm-6 col-12">
                                            <div class="form-group">
                                                <select class="select">
                                                    <option>Brand</option>
                                                    <option>N/D</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg col-sm-6 col-12 ">
                                            <div class="form-group">
                                                <select class="select">
                                                    <option>Price</option>
                                                    <option>150.00</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-1 col-sm-6 col-12">
                                            <div class="form-group">
                                                <a class="btn btn-success ms-auto"><img
                                                        src="{{ asset('assets/img/icons/search-whites.svg') }}"
                                                        alt="img"></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  

                    <div class="table-responsive">
                        <table class="table  datanew">
                            <thead>
                                <tr>
                                    <th>
                                        <label class="checkboxs">
                                            <input type="checkbox" id="select-all">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </th>
                                    <th>ID</th>
                                    <th>Tên Sản Phẩm</th>
                                    <th>Hình ảnh</th>
                                    <th>Danh mục</th>
                                    <th>Giá</th>
                                    <th>Tồn kho</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ProductType as $item)
                                    <tr>
                                        <td>
                                            <label class="checkboxs">
                                                <input type="checkbox">
                                                <span class="checkmarks"></span>
                                            </label>
                                        </td>
                                        <td>{{ $item->id }}</td>
                                        <td contenteditable="true" class="editable-field" data-id="{{ $item->id }}" data-field="name">{{ $item->name }}</td>
                                            @php
                                                $imagePath = $item->image;
                                                if (strpos($imagePath, 'uploads/products') === false) {
                                                    $imagePath = 'layouts/img/' . $item->image; // Nếu không chứa, thêm 'layouts/img'
                                                }
                                            @endphp
                                        <td>
                                            <img src="{{ asset($imagePath) }}" alt="Ảnh sản phẩm" width="100">
{{--                                            <img src="{{ asset('storage/' . $item->image) }}" alt="Ảnh sản phẩm" width="100">--}}
{{--                                                php artisan storage:link--}}
                                        </td>
                                        <td>{{ $item->category_id }}</td>
                                        <td contenteditable="true" class="editable-field" data-id="{{ $item->id }}" data-field="price">{{ number_format($item->price, 0) }} VND</td>
                                        <td contenteditable="true" class="editable-field" data-id="{{ $item->id }}" data-field="stock">{{ $item->stock }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center align-items-center">
                                                <a class="action-link me-3" href="{{ route('admin.products.show', $item->id) }}">
                                                    <img src="{{ asset('assets/img/icons/eye.svg') }}" alt="img" class="icon">
                                                </a>
                                                <a class="action-link me-3" href="{{ route('admin.gift.edit', $item->id) }}">
                                                    <i class="fa-solid fa-pen-to-square icon"></i>
                                                </a>
                                                <form class="action-link me-3" id="delete-form-{{ $item->id }}" action="{{ route('admin.gift_baskets.destroy', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn delete-btn" onclick="confirmDelete({{ $item->id }})">
                                                        <i class="fa-solid fa-trash icon"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Mã xử lý chỉnh sửa trường
        document.querySelectorAll(".editable-field").forEach(cell => {
            let initialValue = cell.innerText.trim();

            cell.addEventListener("focus", function () {
                initialValue = this.innerText.trim();
            });

            cell.addEventListener("focusout", function () {
                let value = this.innerText.trim();
                let productId = this.getAttribute("data-id");
                let field = this.getAttribute("data-field");

                if (value !== initialValue) {
                    if (field === "price") {
                        value = value.replace(/[^0-9]/g, '');
                    }

                    fetch(`/admin/products/update-field`, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-Token": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                        },
                        body: JSON.stringify({
                            id: productId,
                            field: field,
                            value: value
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(`${field.charAt(0).toUpperCase() + field.slice(1)} đã được cập nhật!`);
                            if (field === "price") {
                                this.innerText = new Intl.NumberFormat('vi-VN').format(value) + " VND";
                            }
                        } else {
                            alert("Cập nhật thất bại, vui lòng thử lại!");
                        }
                    })
                    .catch(error => console.error("Lỗi:", error));
                }
            });
        });

        // Xác nhận xóa sản phẩm
        function confirmDelete(id) {
            if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }
    });
</script>




</script>
