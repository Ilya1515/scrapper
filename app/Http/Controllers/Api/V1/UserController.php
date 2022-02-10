<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function subEmail(Request $request)
    {
        $user = User::find($request['id']);

        if (!$user) {
            return response()->json(['error' => 'Пользователь не найдет']);
        }
        $user->email_delivery = 1;
        $user->save();
        return ['succses' => $user];
    }


    public function unsubEmail(Request $request)
    {
        $user = User::find($request['id']);

        if (!$user) {
            return response()->json(['error' => 'Пользователь не найдет']);
        }
        $user->email_delivery = 0;
        $user->save();
        return ['succses' => $user];
    }
    public function getWish(Request $request)
    {
        $user = User::find($request['id']);

        if (!$user) {
            return response()->json(['error' => 'Пользователь не найдет']);
        }

        $wish = $user->wishes;

        return response()->json(['items' => $wish]);
    }

    public function addWish(Request $request)
    {

        $user = User::find($request['user_id']);

        if (!$user) {
            return response()->json(['error' => 'Пользователь не найдет']);
        }
        $wishes = $user->wishes;

        foreach ($wishes as $wish) {
            if ($wish['id'] == $request['item_id'])  return response()->json(['error' => 'Товар уже в списке']);
        }

        $user->wishes()->attach($request['item_id']);

        return response()->json(['messege' => 'Успешно']);
    }
    public function deleteWish(Request $request)
    {
        $user = User::find($request['user_id']);

        if (!$user) {
            return response()->json(['error' => 'Пользователь не найдет']);
        }
        $user->wishes()->detach($request['item_id']);
        $items = $user->wishes;
        return response()->json(['messege' => 'Удалено', 'items' => $items]);
    }
}