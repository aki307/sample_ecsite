@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-6 offset-sm-3">
            
            {!! Form::open(['route' => ['paymentSession', $user], 'files' => true]) !!}
                <h5>お届け先を指定してください</h5>
                <h5>お届け先住所が記載されていますか？または、新しいお届け先を記載してください。</h5>
                <div class="form-group">
                    {!! Form::label('user_name', '姓名：（漢字）') !!}
                    {!! Form::text('user_name', old('user_name'), ['class' => 'form-control' ]) !!}
                </div>
                
                <div class="form-group">
                    {!! Form::label('postal_corder', '郵便番号：') !!}
                    {!! Form::text('postal_corder', old('postal_corder') , ['class' =>'form-control']) !!}
                    
                    <select class="form-control" name="prefIndex">
                    @foreach(config('pref') as $index => $name)
                        <option value="{{ $index }}">{{ $name }}</option>
                    @endforeach
                    </select>
                </div>
                
                
                <div class="form-group">
                    {!! Form::label('address1', '住所１：' ) !!}
                    {!! Form::text('address1', old('address1'), ['class' =>'form-control']) !!}
                </div>
                
                 <div class="form-group">
                    {!! Form::label('address2', '住所２：' ) !!}
                    {!! Form::text('address2', old('address2'), ['class' =>'form-control']) !!}
                </div>
                
                <div class="form-group">
                <h5>支払方法を選んでください</h5>
                <h5>支払方法を選び、必要な情報を入力してください。</h5>
                <select class="form-control" name="payment">
                    @foreach(config('payment') as $index => $name)
                        <option value="{{ $index }}">{{ $name }}</option>
                    @endforeach
                </select>
                
                </div>
                
                {!! Form::submit('確認する', ['class' => 'btn btn-primary btn-block']) !!}
            {!! Form::close() !!}
                
        </div>
        
    </div>
@endsection