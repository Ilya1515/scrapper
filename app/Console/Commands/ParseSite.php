<?php

namespace App\Console\Commands;

use Weidner\Goutte\GoutteFacade as Goutte;
use App\Models\Items;
use Illuminate\Console\Command;

class ParseSite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:site';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pasrsing farfetch';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {


        $info = [
            'baseHref' => 'https://www.farfetch.com',
            'mainLink' => 'https://www.farfetch.com/ru/shopping/men/sale/shoes-2/items.aspx',
            'store_name' => 'farfetch',
            'brand_selector' => '.css-hu5jv1-ProductCardInfoClamp p.css-14ahplz-Body-BodyBold-ProductCardBrandName',
            'name_selector' => '.css-hu5jv1-ProductCardInfoClamp p.css-4y8w0i-Body',
            'old_price_selector' => '.css-q58lfc-PriceBrief p.css-8erht-Footnote-PriceOriginal',
            'price_selector' => '.css-q58lfc-PriceBrief p.css-7pd6gc-Body-PriceFinal',
            'img_selector' => '.e1qgvhur0>meta',
            'url_selector' => '.css-n5nq0d-ProductCardLink',
        ];



        $crawler = Goutte::request('GET', $info['mainLink']);

        $arr = [];

        $crawler->filter($info['brand_selector'])
            ->each(function ($node, $i) use (&$arr) {

                $arr[$i]['brand'] = $node->text();
            });

        $crawler->filter($info['name_selector'])
            ->each(function ($node, $i) use (&$arr) {

                $arr[$i]['name'] = $node->text();
            });

        $crawler->filter($info['old_price_selector'])
            ->each(function ($node, $i)  use (&$arr) {

                $text = htmlentities($node->text());

                $arr[$i]['old_price'] = (int)str_replace([' ', '&nbsp;', '₽'], '', $text);
            });

        $crawler->filter($info['price_selector'])
            ->each(function ($node, $i) use (&$arr) {

                $text = htmlentities($node->text());

                $arr[$i]['price'] = (int)str_replace([' ', '&nbsp;', '₽'], '', $text);
            });

        $helpArr = [];

        $crawler->filter($info['img_selector'])->each(function ($node, $i) use (&$arr, &$helpArr) {

            if ($i % 2 === 0) {

                $helpArr[] = $node->attr('content');
            }
            foreach ($helpArr as $key => $img) {

                $arr[$key]['image'] = $img;
            }
        });

        $crawler->filter($info['url_selector'])->each(function ($node, $i) use (&$arr, $info) {
            $arr[$i]['url'] = $info['baseHref'] . $node->attr('href');
        });
        if (!count(($arr))) {
            $this->error('Something went wrong!');
        }

        foreach ($arr as $index => $item) {
            $arr[$index]['store_name'] = $info['store_name'];
            Items::create($arr[$index]);
        }

        // var_dump($arr);

        $this->info(count($arr));

        return count($arr);
    }
}