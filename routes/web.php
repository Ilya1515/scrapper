<?php

use App\Models\Items;
use Illuminate\Support\Facades\Route;
use Weidner\Goutte\GoutteFacade as Goutte;
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

Route::get('/', function () {
    return view('index');
});

Route::get('/test', function () {

    $baseHref = 'https://www.farfetch.com';

    $crawler = Goutte::request('GET', 'https://www.farfetch.com/ru/shopping/men/sale/shoes-2/items.aspx');

    $arr = [];

    $titles = $crawler->filter('.css-hu5jv1-ProductCardInfoClamp p.css-14ahplz-Body-BodyBold-ProductCardBrandName')
        ->each(function ($node, $i) use (&$arr) {

            $arr[$i]['brand'] = $node->text();
        });

    $names = $crawler->filter('.css-hu5jv1-ProductCardInfoClamp p.css-4y8w0i-Body')
        ->each(function ($node, $i) use (&$arr) {

            $arr[$i]['name'] = $node->text();
        });

    $oldPrices = $crawler->filter('.css-q58lfc-PriceBrief p.css-8erht-Footnote-PriceOriginal')
        ->each(function ($node, $i)  use (&$arr) {

            $text = htmlentities($node->text());

            $arr[$i]['old_price'] = (int)str_replace([' ', '&nbsp;', '₽'], '', $text);
        });

    $prices = $crawler->filter('.css-q58lfc-PriceBrief p.css-7pd6gc-Body-PriceFinal')
        ->each(function ($node, $i) use (&$arr) {

            $text = htmlentities($node->text());

            $arr[$i]['price'] = (int)str_replace([' ', '&nbsp;', '₽'], '', $text);
        });

    $helpArr = [];

    $imgs  =  $crawler->filter('.e1qgvhur0>meta')->each(function ($node, $i) use (&$arr, &$helpArr) {

        if ($i % 2 === 0) {

            $helpArr[] = $node->attr('content');
        }
        foreach ($helpArr as $key => $img) {

            $arr[$key]['image'] = $img;
        }
    });

    $links  =  $crawler->filter('.css-n5nq0d-ProductCardLink')->each(function ($node, $i) use (&$arr, $baseHref) {
        $arr[$i]['url'] = $baseHref . $node->attr('href');
    });


    foreach ($arr as $index => $item) {
        $arr[$index]['store_name'] = 'farfetch';
        Items::create($arr[$index]);
    }

    // echo "<pre>";
    // var_dump($arr);
    // echo "</pre>";

    // return view('index');
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');