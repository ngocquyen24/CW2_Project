@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @if  ($errors->any())


@endif

@elseif (Session::has('success'))
<div class="alert alert-success">
        {{ Session::get('success') }}
    </div>



@elseif (Session::has('error'))
<div class="alert alert-danger">
        {{ Session::get('error') }}
    </div>
@endif

