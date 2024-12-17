@extends('admin.layout')

@section('content')
    <div class="page-wrapper">
        <div class="content">
            <div class="page-header">
                <div class="page-title">
                    <h4>Chi Tiết Bình Luận</h4>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <h5>ID Bình Luận: <span class="text-primary">{{ $comment->id }}</span></h5>
                        {{-- <p><strong>Tên Người Dùng:</strong> {{ $item->user->name ?? null }}</p> --}}
                        <p><strong>Nội Dung:</strong> {{ $comment->content }}</p>
                        <p><strong>Trạng Thái:</strong> 
                            @if ($comment->status == 0) <span class="badge bg-warning">Chưa duyệt</span>
                            @elseif ($comment->status == 1) <span class="badge bg-success">Đã duyệt</span>
                            @elseif ($comment->status == 2) <span class="badge bg-secondary">Đã ẩn</span>
                            @endif
                        </p>
                        <p><strong>Ngày Tạo:</strong> {{ $comment->created_at->format('Y-m-d H:i:s') }}</p>
                        <p><strong>Sản Phẩm:</strong> {{ $comment->product->name ?? null}}</p>
                    </div>

                    <h6 class="mt-4">Trả Lời:</h6>
                    @if($comment->replies->isEmpty())
                        <p class="text-muted">Không có câu trả lời nào.</p>
                    @else
                        <ul class="list-group">
                            @foreach ($comment->replies as $reply)
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <strong>{{ $reply->user->name ?? 'Người dùng cũ' }}</strong>
                                        <small class="text-muted">{{ $reply->created_at->format('Y-m-d H:i:s') }}</small>
                                    </div>
                                    <p class="mb-1">{{ $reply->content }}</p>
                                    <div>
                                        <form action="{{ route('admin.comments.replies.delete', $reply->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa câu trả lời này không?');">Xóa</button>
                                        </form>
                                        @if($reply->status == 0)
                                            <form action="{{ route('admin.comments.replies.approve', $reply->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Bạn có chắc muốn duyệt câu trả lời này không?');">Duyệt</button>
                                            </form>
                                        @endif
                                        @if($reply->status == 1)
                                            <form action="{{ route('admin.comments.replies.hide', $reply->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Bạn có chắc muốn ẩn câu trả lời này không?');">Ẩn</button>
                                            </form>
                                        @endif
                                        @if($reply->status == 2)
                                            <form action="{{ route('admin.comments.replies.unhide', $reply->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Bạn có chắc muốn hiện lại câu trả lời này không?');">Hiện lại</button>
                                            </form>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    <a href="{{ route('admin.comments.management') }}" class="btn btn-primary mt-4">Quay lại</a>
                </div>
            </div>
        </div>
    </div>
@endsection
