@extends('layouts.main_only')

@section('content')
    <div class="text-center">
        <h1 style="background-color:#ffffff;">登録してください</h1>
    </div>

    <div class="row">
        <div class="col-sm-6 offset-sm-3">

            {!! Form::open(['route' => 'signup.post']) !!}
                <div class="form-group">
                    <p style="display:inline-block; font-weight:600;color:#9d1a2d; border:#9d1a2d solid 1px;">必須</p>
                    {!! Form::label('name_kanji', '姓名：',['style'=> 'display:inline-block;']) !!}
                    {!! Form::text('name_kanji', old('name_kanji'), ['class' => 'form-control', 'style'=> 'width:100%']) !!}
                </div>
                
                <div class="form-group">
                    <p style="display:inline-block; font-weight:600;color:#9d1a2d; border:#9d1a2d solid 1px;">必須</p>
                    {!! Form::label('name_kana', '姓名（かな）：',['style'=> 'display:inline-block;']) !!}
                    {!! Form::text('name_kana', old('name_kana'), ['class' => 'form-control', 'style'=> 'width:100%']) !!}
                </div>

                <div class="form-group">
                    <p style="display:inline-block; font-weight:600;color:#9d1a2d; border:#9d1a2d solid 1px;">必須</p>
                    {!! Form::label('email', 'アドレス：',['style'=> 'display:inline-block;']) !!}
                    {!! Form::email('email', old('email'), ['class' => 'form-control', 'style'=> 'width:100%']) !!}
                </div>

                <div class="form-group">
                    <p style="display:inline-block; font-weight:600;color:#9d1a2d; border:#9d1a2d solid 1px;">必須</p>
                    {!! Form::label('password', 'パスワード：',['style'=> 'display:inline-block;']) !!}
                    {!! Form::password('password', ['class' => 'form-control', 'style'=> 'width:100%']) !!}
                </div>

                <div class="form-group">
                    <p style="display:inline-block; font-weight:600;color:#9d1a2d; border:#9d1a2d solid 1px;">必須</p>
                    {!! Form::label('password_confirmation', 'パスワード：
                    （確認）',['style'=> 'display:inline-block;']) !!}
                    {!! Form::password('password_confirmation', ['class' => 'form-control', 'style'=> 'width:100%']) !!}
                </div>

                {!! Form::submit('利用規約に同意して、登録する', ['class' => 'btn btn-primary btn-block', 'style' => 'box-sizing:border-box; width:100%; max-width:550px;color:#ffffff; background-color:#9d1a2d']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
