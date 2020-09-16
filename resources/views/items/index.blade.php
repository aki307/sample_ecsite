@extends('layouts.main_only')

@section('content')
    <div class="text-center">
        <h1 style="color:#887f69; font-weight:600; margin:0; padding:0; background-color:#ffffff">出品する</h1>
    </div>

    
        <div class="twelve columns">

            {!! Form::open(['route' => 'registerItem.confirm', 'files' => true]) !!}
                <div class="form-group" style="margin-top:10px">
                  <p style="display:inline-block; font-weight:600;color:#9d1a2d; border:#9d1a2d solid 1px;">必須</p>
                    {!! Form::label('item_name', '商品名', ['style'=> 'display:inline-block;']) !!}
                    {!! Form::text('item_name', old('item_name'), ['class' => 'form-control', 'style'=> 'width:100%']) !!}
                </div>

                <div class="form-group">
                    <p style="display:inline-block; font-weight:600;color:#9d1a2d; border:#9d1a2d solid 1px;">必須</p>
                    {!! Form::label('list_price', '定価', ['style'=> 'display:inline-block;']) !!}
                    {!! Form::text('list_price', old('list_price'), ['class' => 'form-control', 'style'=> 'width:100%']) !!}
                </div>

                <div class="form-group">
                    <p style="display:inline-block; font-weight:600;color:#9d1a2d; border:#9d1a2d solid 1px;">必須</p>
                    {!! Form::label('sale_price', '売値', ['style'=> 'display:inline-block;']) !!}
                    {!! Form::text('sale_price', old('sale_price'),['class' => 'form-control', 'style'=> 'width:100%']) !!}
                </div>
                
                <div class="form-group">
                    <p style="display:inline-block; font-weight:600;color:#9d1a2d; border:#9d1a2d solid 1px;">必須</p>
                    <p style="font-weight:600; font-size:15px; display:inline-block;margin-bottom:5px">商品イメージ（メイン）</p>
                    <input type="file" name="item_image" style="display:block;">
                    <p style="font-weight:600; font-size:15px">商品イメージ（サブ）</p>
                    <div id="drop-zone" style="border: 1px solid; padding: 30px; background-color:#ffffff;">
                    <p>ファイルをドラッグ＆ドロップもしくは</p>
            　　　　　　<input type="file" multiple name="item_images[]" id="file-input">
                </div>
                <h5>アップロードした画像</h5>
                <div id="preview"></div>
                <script type="text/javascript">
                var dropZone = document.getElementById('drop-zone');
var preview = document.getElementById('preview');
var fileInput = document.getElementById('file-input');
dropZone.addEventListener('dragover', function(e) {
  e.stopPropagation();
  e.preventDefault();
  this.style.background = '#e1e7f0';
}, false);
dropZone.addEventListener('dragleave', function(e) {
  e.stopPropagation();
  e.preventDefault();
  this.style.background = '#ffffff';
}, false);
fileInput.addEventListener('change', function (e) {
  e.stopPropagation();
  e.preventDefault();
  this.style.background = '#ffffff'; //背景色を白に戻す
  var files = e.target.files; //ドロップしたファイルを取得
  if (files.length > 9) return alert('アップロードできるファイルは1つだけです。');
  fileInput.files = files; //inputのvalueをドラッグしたファイルに置き換える。
                    
  for (var i = 0; i < files.length; i++) {
    previewFile(files[i], i);
  }
});
dropZone.addEventListener('drop', function(e) {
  e.stopPropagation();
  e.preventDefault();
  this.style.background = '#ffffff'; //背景色を白に戻す
  var files = e.dataTransfer.files; //ドロップしたファイルを取得
  if (files.length > 9) return alert('アップロードできるファイルは1つだけです。');
  fileInput.files = files; //inputのvalueをドラッグしたファイルに置き換える。
                    
  for (var i = 0; i < files.length; i++) {
    previewFile(files[i], i);
  }
}, false);
function previewFile(file, i) {
/* FileReaderで読み込み、プレビュー画像を表示。 */
  var fr = new FileReader();
  fr.readAsDataURL(file);
  fr.onload = function() {
    var img = document.createElement('img');
    img.setAttribute('src', fr.result);
    img.setAttribute('width', '20%');
    img.setAttribute('height', '30%');
    img.setAttribute('id', 'sub-image' + i);
    preview.appendChild(img);
    var button = document.createElement('button');
    button.setAttribute('type', 'button');
    button.setAttribute('class', 'btn btn-danger');
    button.setAttribute('id', 'sub-image-button' + i);
    button.setAttribute('value', '削除');
    button.setAttribute('onclick', "getId(this)");
    preview.appendChild(button);
  };
}
function getId(ele){
  console.log(ele);
  var button_id = ele.id;
  var id_value = Number(button_id.substr(16));
  $('#' + button_id).remove();
  $('#sub-image' + id_value).remove();
  // fileInput = document.getElementById('file-input');
  // fileInput.files = files;
  var dt = new DataTransfer();
  for(var i=0; i<fileInput.files.length; i++){
    if(i !== id_value){
  　dt.items.add(fileInput.files[i]);
    }
  }
  fileInput.files = dt.files;
}
            </script>
                </div>

                <div class="form-group">
                    <p style="display:inline-block; font-weight:600;color:#9d1a2d; border:#9d1a2d solid 1px;">必須</p>
                    {!! Form::label('description', '商品の説明',['style'=> 'display:inline-block;']) !!}
                    {!! Form::textarea('description',old('description'),['class' => 'form-control', 'style'=> 'width:100%']) !!}
                </div>

                {!! Form::submit('確認する', ['class' => 'btn btn-primary btn-block','id' => 'item_confirm_submit', 'style' => 'box-sizing:border-box; width:100%; max-width:550px']) !!}
            {!! Form::close() !!}
        </div>
    
@endsection