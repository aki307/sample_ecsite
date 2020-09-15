<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'ItemsController@top');

// テスト
Route::get('test', 'ItemsController@test');

//ユーザ登録
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup.get');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

//ログイン機能
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout.get');

//Webhook機能
Route::post('webhook', 'ShippingsController@webhook');

// 【クレジット決済成功ルート】
       Route::post('creditComplete','ShippingsController@creditComplete');
//ログインしないと利用できない機能
Route::group(['middleware' => ['auth']], function (){
    //商品登録機能
    Route::get('registerItem', 'ItemsController@index')->name('registerItem.get');
    Route::post('registerItemConfirm', 'ItemsController@registerItemConfirm')->name('registerItem.confirm');
    Route::post('registerItemComplete', 'ItemsController@registerItemComplete')->name('registerItem.complete');
    //検索機能
    Route::get('searchItem', 'ItemsController@searchItem')->name('searchItem');
    // 【クレジット決済成功ルート】
       Route::get('creditComplete',function(){
           return view('users.credit_complete');
       });
    
    Route::group(['prefix' => 'users/{id}'], function(){
        //カートの中身を表示する
       Route::get('myCart', 'UserCartController@index')->name('myCart');
       //出品したものをみる(出品一覧)
       Route::get('showMyItems', 'ItemsController@showMyItems')->name('showMyItems');
       //  デザインを見る
       Route::get('showMyItemDesign', 'ItemsController@showMyItemDesign')->name('showMyItemDesign');
       // 各商品の注文一覧(出品一覧から)
       Route::get('orderMyItem', 'ItemsController@orderMyItem')->name('orderMyItem');
       //決済する
       Route::get('payment', 'ShippingsController@index')->name('payment');
       //入力内容（お届け先など）をセッションにて一時保存
       Route::post('paymentSessiom', 'ShippingsController@session')->name('paymentSession');
       //入力内容（お届け先など）の確認画面
       Route::get('paymentConfirm', 'ShippingsController@confirm')->name('paymentConfirm');
       //支払完了画面(お届け先登録)
       Route::post('paymentRegister', 'ShippingsController@register')->name('paymentRegister');
       //支払完了画面表示(商品登録および完了画面表示)
       Route::get('paymentComplete', 'ShippingItemsController@complete')->name('paymentComplete');
       //決済一覧表示機能
       Route::get('paymentTable', 'ShippingsController@table')->name('paymentTable');
       //出品した商品の状態（入金および配送状況）
       Route::get('myItemsStatus', 'ShippingItemsController@showMyItemsStatus')->name('showMyItemsStatus');
    });
    
    Route::group(['prefix' => 'items/{id}'], function() {
        //商品詳細ページへ
       Route::get('item', 'ItemsController@show')->name('item.show'); 
       //カートに商品を入れる
       Route::get('addItemButton', 'UserCartController@add')->name('addItemButton');
       //各商品の個数を決める
       Route::post('countItem', 'UserCartController@countItem')->name('countItem');
       
    });
    
    
    Route::group(['prefix' => 'shippingItems/{id}'], function(){
        // 出品者が見るお客様の注文の詳細ページ
        Route::get('myItemOrderDetail', 'ShippingItemsController@myItemOrderDetail')->name('myItemOrderDetail');
    });
    // お客様自身が見る注文詳細ページ
    Route::group(['prefix' => 'shippings/{id}'], function(){
        Route::get('myOrderDetail', 'ShippingsController@myOrderDetail')->name('myOrderDetail');
        
        //支払方法の変更
       Route::post('paymentChange', 'ShippingsController@paymentChange')->name('paymentChange');
    });
});