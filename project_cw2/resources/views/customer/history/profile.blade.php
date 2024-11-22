@extends('admin.mainprofile')

@section('content')
    <table class="table">
        <thead>
        <tr>
      
            <th>Tên Khách Hàng</th>
            <th>Số Điện Thoại</th>
            <th>Email</th>
            <th>Ngày Đặt hàng</th>
            <th style="width: 100px">&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        @foreach($customers as $key => $customer)
            <tr>

                <td>{{ $customer->name }}</td>
                <td>{{ $customer->phone }}</td>
                <td>{{ $customer->email }}</td>
                <td>{{ $customer->created_at }}</td>
                <td>
                    <a class="btn btn-primary btn-sm" href="/customer/customers/view/{{ $customer->id }}">
                        <i class="fas fa-eye"></i>
                    </a>

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {!! $customers->links() !!}
    </div>
@endsection


