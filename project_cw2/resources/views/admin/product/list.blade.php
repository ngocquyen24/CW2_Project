@extends('admin.main')

@section('content')
<table class="table">
    <thead>
        <tr>
            <th style="width: 50px">ID</th>
            <th>Tên Sản Phẩm</th>
            <th>Danh Mục</th>
            <th>Giá Gốc</th>
            <th>Giá Khuyến Mãi</th>
            <th>Ảnh</th>
            <th>Active</th>
            <th>Update</th>
            <th style="width: 100px">&nbsp;</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
        <tr>
            <!-- Hiển thị ID gốc -->
            <td>{{ $product->id }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->menu->name }}</td>
            <td>{{ $product->price }}</td>
            <td>{{ $product->price_sale }}</td>
            <td><img src="/thumb/{{ $product->thumb }}" alt="IMG" style="width: 100px"></td>
            <td>{!! \App\Helpers\Helper::active($product->active) !!}</td>
            <td>{{ $product->updated_at }}</td>
            <td>
                <!-- Sử dụng ID mã hóa trong URL -->
                <a class="btn btn-primary btn-sm" href="{{ route('admin.products.edit', ['encrypted_id' => \Crypt::encrypt($product->id)]) }}">
                    <i class="fas fa-edit"></i>
                </a>
                <a href="#" class="btn btn-danger btn-sm"
                    onclick="removeRow('{{ \Crypt::encrypt($product->id) }}', '/admin/products/destroy')">
                    <i class="fas fa-trash"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="d-flex justify-content-center">
    {!! $products->links() !!}
</div>
@endsection