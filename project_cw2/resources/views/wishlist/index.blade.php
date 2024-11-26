@extends('admin.mainprofile')

@section('content')
    <table class="table">
        
        <thead>
        <tr>
            <th>Tên Sản Phẩm</th>
            <th>Hình Ảnh</th>
            <th>Giá</th>
            <th style="width: 100px">&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($wishlists as $wishlist)
            <tr>
                <td>{{ $wishlist->product->name }}</td>
                <td><img src="../thumb/{{$wishlist->product->thumb}}" alt="{{ $wishlist->name }}" height="200px"></td>
                <td>{{ number_format($wishlist->product->price, 0, ',', '.') }} VND</td>
                <td>
                    <a class="btn btn-primary btn-sm" href="">
                        <i class="fas fa-trash-alt"></i>
                    </a>

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
       
    </div>
@endsection


