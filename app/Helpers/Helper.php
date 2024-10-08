<?php

namespace App\Helpers;

use App\Models\Cart;
use App\Models\UserAssignment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Helper
{
    public static function get_user_permission()
    {
        $role = Auth::user()->role_id;
        $action = DB::table('role_permissions')->where('role_id', $role)->first();
        $permission = explode(',', $action->permission_id ?? '');
        // dd($permission);
        return $permission;
    }

    static function getAddPageById($id = null)
    {
        if (isset($id)) {
            foreach (config('addPages') as $value) {
                if ($id == $value['id']) {
                    return $value;
                }
            }
        }
    }

    public static function addToCart($data)
    {
        $user = Auth::user();
        $courseId = base64_decode(urldecode($data['course_id']));
        $priceOptionId = isset($data['price_option_id']) ? base64_decode(urldecode($data['price_option_id'])) : null;

        try {
            if ($user) {
                $cartedItem = Cart::updateOrCreate([
                    'user_id' => $user->id,
                    'course_id' => $courseId
                ], [
                    'price_option_id' => $priceOptionId,
                    'user_id' => $user->id,
                    'course_id' => $courseId
                ]);
                
                $sessionCart = session()->get('cart', []);
                foreach ($sessionCart as $item) {
                    Cart::updateOrCreate([
                        'user_id' => $user->id,
                        'course_id' => $item['course_id']
                    ], [
                        'price_option_id' => $item['price_option_id'],
                        'user_id' => $user->id,
                        'course_id' => $courseId
                    ]);
                }
    
                session()->forget('cart');
            } else {
                
                $cart = session()->get('cart', []);

                $exists = false;
                foreach ($cart as &$item) {
                    if ($item['course_id'] == $courseId) {
                        $item['price_option_id'] = $priceOptionId;
                        $exists = true;
                        break;
                    }
                }
    
                if (!$exists) {
                    $cart[] = [
                        'course_id' => $courseId,
                        'price_option_id' => $priceOptionId,
                    ];
                }
    
                session()->put('cart', $cart);
            }
        } catch (\Throwable $th) {
            return false;
        }
        return [
            'success' => true,
            'cart_id' => isset($cartedItem) ? $cartedItem->id : null
        ];
    }

    static function getCartCount() {
        $user = Auth::user();
        if ($user) {
            return count($user->carts);
        }
        $cart = session()->get('cart', []);
        return count($cart);
    }

    static function getRouteNames()
    {
        $middlewareArray = ['auth','student-auth','student-details'];
        return collect(Route::getRoutes())
        ->filter(function ($route) use ($middlewareArray) {
            $middlewares = $route->middleware();
            $name = $route->getName();
            return !empty(array_intersect($middlewareArray, $middlewares)) && !empty($name);
        })
        ->map(function ($route) {
            $name = $route->getName();
            return [
                'id' => $name,
                'name' => ucwords(str_replace(['-', '.', '_'], ' ', $name)),
            ];
        })
        ->values();
    }

    static function startAssignment($id=null) {
        if($id){
            UserAssignment::create([
                
            ]);
        }
    }
    
}
