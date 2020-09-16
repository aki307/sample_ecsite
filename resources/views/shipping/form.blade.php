@extends('layouts.main_only')

@section('content')
        <div class="twelve columns">
            
            {!! Form::open(['route' => ['paymentSession', $user], 'files' => true]) !!}
                <h5 style="background-color:#ffffff;">お届け先を指定してください</h5>
                <h5 style="background-color:#ffffff;">お届け先住所が記載されていますか？または、新しいお届け先を記載してください。</h5>
                <div class="form-group">
                    <p style="display:inline-block; font-weight:600;color:#9d1a2d; border:#9d1a2d solid 1px;">必須</p>
                    {!! Form::label('user_name', '姓名：（漢字）', ['style'=> 'display:inline-block;']) !!}
                    {!! Form::text('user_name', old('user_name'), ['class' => 'form-control' ,'style' => 'width:100%;']) !!}
                </div>
                
                <div class="form-group">
                    <p style="display:inline-block; font-weight:600;color:#9d1a2d; border:#9d1a2d solid 1px;">必須</p>
                    {!! Form::label('postal_corder', '郵便番号：',['style'=> 'display:inline-block;']) !!}
                    <p style="font-weight:600;color:#9d1a2d;">※数字のみの入力でお願いします</p>
                    {!! Form::text('postal_corder', old('postal_corder') , ['class' =>'form-control']) !!}
                    
                    <select class="form-control" name="prefIndex">
                    @foreach(config('pref') as $index => $name)
                        <option value="{{ $index }}">{{ $name }}</option>
                    @endforeach
                    </select>
                </div>
                
                
                <div class="form-group">
                    <p style="display:inline-block; font-weight:600;color:#9d1a2d; border:#9d1a2d solid 1px;">必須</p>
                    {!! Form::label('address1', '住所１：',['style'=> 'display:inline-block;'] ) !!}
                    {!! Form::text('address1', old('address1'), ['class' =>'form-control','style' => 'width:100%;']) !!}
                </div>
                
                 <div class="form-group">
                     <p style="display:inline-block; font-weight:600;color:#9d1a2d; border:#9d1a2d solid 1px;">必須</p>
                    {!! Form::label('address2', '住所２：',['style'=> 'display:inline-block;'] ) !!}
                    {!! Form::text('address2', old('address2'), ['class' =>'form-control','style' => 'width:100%;']) !!}
                </div>
                
                <div class="form-group">
                <h5 style="background-color:#ffffff;">支払方法を選んでください</h5>
                <p style="display:inline-block; font-weight:600;color:#9d1a2d; border:#9d1a2d solid 1px;">必須</p>
                <h5 style="background-color:#ffffff;display:inline-block">支払方法を選び、必要な情報を入力してください。</h5>
                <select class="form-control" name="payment" style="display:block;">
                    @foreach(config('payment') as $index => $name)
                        <option value="{{ $index }}">{{ $name }}</option>
                    @endforeach
                </select>
                
                </div>
                
                {!! Form::submit('確認する', ['class' => 'btn btn-primary btn-block','id' => 'item_confirm_submit', 'style' => 'box-sizing:border-box; width:100%;  left:0%']) !!}
            {!! Form::close() !!}
                
        </div>
@endsection