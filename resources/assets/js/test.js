// 【カートページ】個数変更仕様
// PC
function entryChange(item_id){
  // phpにて変更
  var item_number_select = 'item_number_select' + item_id;
  var item_number_describe = 'item_number_describe' + item_id;
  var pc_item_number_form = 'pc_item_number_form' + item_id;
  var item_number_button = 'item_number_button' + item_id;
  var item_number = document.getElementsByClassName(item_number_select);
  var dw = '';
    
    
  switch(item_number[0].value){
  case '0':
    dw = '0';
    document.getElementsByClassName(item_number_describe)[0].value = dw;
    document.getElementsByClassName(pc_item_number_form)[0].submit();
    break;
  case '1':
    dw = '1';
    document.getElementsByClassName(item_number_describe)[0].value = dw;
    document.getElementsByClassName(pc_item_number_form)[0].submit();
    break;
  case '2':
    dw = '2';
    document.getElementsByClassName(item_number_describe)[0].value = dw;
    document.getElementsByClassName(pc_item_number_form)[0].submit();
    break;
  case '3':
    dw = '3';
    document.getElementsByClassName(item_number_describe)[0].value = dw;
    document.getElementsByClassName(pc_item_number_form)[0].submit();
    break;
  case '4':
    dw = '4';
    document.getElementsByClassName(item_number_describe)[0].value = dw;
    document.getElementsByClassName(pc_item_number_form)[0].submit();
    break;
  case '5':
    dw = '5';
    document.getElementsByClassName(item_number_describe)[0].value = dw;
    document.getElementsByClassName(pc_item_number_form)[0].submit();
    break;
  case '6':
    dw = '6';
    document.getElementsByClassName(item_number_describe)[0].value = dw;
    document.getElementsByClassName(pc_item_number_form)[0].submit();
    break;
  case '7':
    dw = '7';
    document.getElementsByClassName(item_number_describe)[0].value = dw;
    document.getElementsByClassName(pc_item_number_form)[0].submit();
    break;
  case '8':
    dw = '8';
    document.getElementsByClassName(item_number_describe)[0].value = dw;
    document.getElementsByClassName(pc_item_number_form)[0].submit();
    break;
  case '9':
    dw = '9';
    document.getElementsByClassName(item_number_describe)[0].value = dw;
    document.getElementsByClassName(pc_item_number_form)[0].submit();
    break;
  case '10':
    document.getElementsByClassName(item_number_describe)[0].style.display="inline-block";
    document.getElementsByClassName(item_number_button)[0].style.display="inline-block";
    document.getElementsByClassName(item_number_select)[0].style.display="none";
    break;
  }
};
// スマホ
function sp_item_number (counter, item_id){
  
  var plus = 1;
  var minus = 1;
  var item = "sp_item_number_describe" + item_id;
  var sp_item_number_describe = document.getElementsByClassName(item)[0].value;
  var item_number = parseInt(sp_item_number_describe ,10);
  switch(counter){
  case 'trash':
    item_number = 0;
    document.getElementsByClassName(item)[0].value= item_number;
    sp_cart_item_number(item_id);
    break;
  case 'plus':
    item_number += plus;
    document.getElementsByClassName(item)[0].value= item_number;
    console.log(item_number);
    sp_cart_item_number(item_id);
    break;
  case 'minus':
    item_number -= minus;
    document.getElementsByClassName(item)[0].value= item_number;
    console.log(item_number);
    sp_cart_item_number(item_id);
    break;
  case 'delete':
    item_number = 0;
    document.getElementsByClassName(item)[0].value= item_number;
    sp_cart_item_number(item_id);
    break;
  }
  
}
function sp_cart_item_number(item_id){
   var sp_item_number_form_box = "sp_item_number_form-box" + item_id;
  document.getElementsByClassName(sp_item_number_form_box)[0].submit();
}