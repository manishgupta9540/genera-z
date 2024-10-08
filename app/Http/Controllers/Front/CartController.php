<?php

namespace App\Http\Controllers\Front;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Course;
use App\Models\PriceOption;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if ($user) {
            $data['carts'] = $user->carts;
        }
        else{
            $data['carts'] = session()->get('cart', []);
        }
        return view('front.pages.cart',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function checkout(Request $request, $id = null, $priceId = null)
    {
        $user = Auth::user();
        $id = base64_decode(urldecode($id));
        $priceIds = base64_decode(urldecode($priceId));

        $course = Course::find($id);
        $pricesAmount = PriceOption::with('course')->find($priceIds);
        if (!$pricesAmount && $course) {
            $items[] = $course;
        } elseif ($pricesAmount) {
            $items[] = $pricesAmount;
        } else {
            if ($id) {
                $cartItem = Cart::find($id);
                if ($cartItem) {
                    $items[] = $cartItem;
                } else {
                    $items = $user->carts;
                }
            } else {
                $items = $user->carts;
            }
        }

        if (empty($items)) {
            return redirect()->route('cart.index');
        }

        return view('front.pages.checkout', compact('id', 'items','priceIds'));
    }




    public function getCourseData(Request $request)
    {
        $course_id = $request->input('course_id');
        $course = Course::find($course_id);

        if ($course) {
            $items = [];
            $id = '';
            $html = view('front.pages.checkout', compact('course', 'items', 'id'))->render();

            return response()->json(['html' => $html]);
        }

        return response()->json(['error' => 'Course not found'], 404);
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
        $time = Carbon::now();
        $time->addMonths(3);
        dd($time->format('Y-m-d H:i:s'));
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
        $decodedId = base64_decode($id);

        // Delete the record from the cart table
        $deleted = Cart::where('id', $decodedId)->delete();
        if ($deleted) {
            return response()->json(['success' => 'Item deleted successfully.']);
        } else {
            return response()->json(['error' => 'Failed to delete item.']);
        }


    }

    public function addToCart(Request $request)
    {
        $data = $request->all();
        $carted = Helper::addToCart($data);
        $msg = $carted ? 'Course Added To Cart' : 'Error Adding To Cart';

        if ($request->ajax()) {
            return response()->json([
                'success' => $carted,
                'msg' => $msg,
            ]);
        }

        return redirect()->back()->with('msg', $msg);
    }

}
