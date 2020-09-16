@extends('layouts.main_only')

@section('content')
    <div class="text-center">
        <h1 style="background-color:#ffffff;">ログインしてください</h1>
    </div>

    <div class="row">
        <div class="col-sm-6 offset-sm-3">

            {!! Form::open(['route' => 'login.post']) !!}
                <div class="form-group">
                    {!! Form::label('email', 'アドレス：') !!}
                    {!! Form::email('email', old('email'), ['class' => 'form-control', 'style' =>'width:50%;']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('password', 'パスワード：') !!}
                    {!! Form::password('password', ['class' => 'form-control', 'style' =>'width:50%;']) !!}
                </div>

                {!! Form::submit('ログイン', ['class' => 'btn btn-primary btn-block', 'style' => 'box-sizing:border-box;
            width:50%; background-color:#887f69;color:#ffffff;font-size:18px']) !!}
            {!! Form::close() !!}

            <p class="mt-2"> {!! link_to_route('signup.get', '会員登録する') !!}</p>
        </div>
    </div>
@endsection