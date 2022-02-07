<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Items;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Weidner\Goutte\GoutteFacade as Goutte;

class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = Items::select('brand', 'price', 'name', 'old_price', 'description', 'url', 'image')->orderByDesc('price')->get();


        $brands = Items::select('brand')->distinct()->get();

        return ['items' => $items, 'brands' => $brands];
    }

    public function brand(Request $request)
    {
        $items = Items::select('brand', 'price', 'name', 'old_price', 'description', 'url', 'image',  'store_name')->whereIn('brand', $request->all())->get();


        return ['items' => $items];
    }

    public function stores(Request $request)
    {
        $items = Items::select('brand', 'price', 'name', 'old_price', 'description', 'url', 'image', 'store_name')->whereIn('store_name', $request->all())->get();


        return ['items' => $items];
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}