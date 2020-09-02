
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));

// const app = new Vue({
//     el: '#app'
// });

// ハンバーガーメニュー
$(document).ready(function(){
    $("#sp_navi_toggle").click(function(){
        $(".sp_navi_toggle").slideToggle();
    });
});

// カラーセル
// import {tns} from 'tiny-slider';

import { tns } from "../../../node_modules/tiny-slider/src/tiny-slider"

if($('.my-slider').length){
var slider = tns({
    container: '.my-slider',
    items: 1,
    slideBy: 'page',
    autoplay: true
});
}
// ページトップにスクロールする
$(document).ready(function(){
    $('#pagetop_screen').on('click', (e) => {
        $('html, body').animate({ scrollTop: 0 }, 600);
    });
});

// 商品の写真のスライドショー
$(window).ready(function(){
   $("#list_img img").click(function(){
       var img_src = $(this).attr("src");
       $("#display_img img").attr("src", img_src);
   });
});


