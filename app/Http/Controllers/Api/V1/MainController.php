<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Models\Items;
use App\Mail\emailDelivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;


class MainController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Items::select('brand', 'id', 'price', 'name', 'old_price', 'description', 'url', 'image')
            ->orderByDesc('price')->get();

        $brands = $this->getAllBrands();
        $max_price = $items->max('price');

        $min_price = $items->min('price');

        $data = [
            'items' => $items,
            'brands' => $brands,
            'max_price' => $max_price,
            'min_price' => $min_price
        ];

        return $data;
    }
    public function getAllBrands()
    {
        return Items::select('brand')->distinct()->get();
    }
    public function filter(Request $request)
    {
        $sort_flag = 'desc';
        $brands = $this->getAllBrands();
        if ($request->sort_flag == 2) {
            $sort_flag = 'asc';
        }

        if (count($request->brand)) {

            $brands =  $request->brand;
        }
        $items = DB::table('items')
            ->where('price', '>=', $request->min_price)
            ->where('price', '<=', $request->max_price)

            ->whereIn('brand', $brands)

            ->orderBy('price', $sort_flag)->get();
        $max_price = $items->max('price');

        $min_price = $items->min('price');
        $data = [
            'items' => $items,
            'max_price' => $max_price,
            'min_price' => $min_price
        ];
        return $data;
    }

    public function getBrand(Request $request)
    {
        $items = Items::select('brand', 'id', 'price', 'name', 'old_price', 'description', 'url', 'image',  'store_name')->whereIn('brand', $request->all())->get();

        return ['items' => $items];
    }

    public function getStores(Request $request)
    {
        $items = Items::select('brand', 'price', 'name', 'old_price', 'description', 'url', 'image', 'store_name')
            ->whereIn('store_name', $request->all())->get();

        return ['items' => $items];
    }

    public function sendEmail($data)
    {
        $users = User::select('email', 'email_delivery')
            ->where('email_delivery', 1)->get();

        foreach ($users as $recipient) {
            Mail::to($recipient->email)->send(new emailDelivery($data));
        }
    }
}