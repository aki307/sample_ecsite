@extends('layouts.app')

@section('content')
    <div class="text-center">
        <h1>出品する</h1>
    </div>

    <div class="row">
        <div class="col-sm-6 offset-sm-3">

            {!! Form::open(['route' => 'registerItem.confirm', 'files' => true]) !!}
                <div class="form-group">
                    {!! Form::label('item_name', '商品名') !!}
                    {!! Form::text('item_name', old('item_name'), ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('list_price', '定価') !!}
                    {!! Form::text('list_price', old('list_price'), ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('sale_price', '売値') !!}
                    {!! Form::text('sale_price', old('sale_price'),['class' => 'form-control']) !!}
                </div>
                
                <div class="form-group">
                    <p>【必須】商品イメージ（メイン）</p>
                    <input type="file" name="item_image">
                    <p>商品イメージ（サブ）</p>
                    <div id="drop-zone" style="border: 1px solid; padding: 30px;">
                    <p>ファイルをドラッグ＆ドロップもしくは</p>
            　　　　　　<input type="file" multiple name="item_images[]" id="file-input">
                </div>
                <h2>アップロードした画像</h2>
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
                    {!! Form::label('description', '商品の説明') !!}
                    {!! Form::textarea('description',old('description'),['class' => 'form-control']) !!}
                </div>

                {!! Form::submit('確認する', ['class' => 'btn btn-primary btn-block']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection