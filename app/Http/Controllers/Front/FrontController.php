<?php

namespace App\Http\Controllers\Front;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Models\Category;
use App\Models\Course;
use App\Models\Blog;
use App\Models\Cart;
use App\Models\PlanPurchase;
use App\Models\PriceOption;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Front\CartController;
use App\Models\UserCourse;
use GrahamCampbell\ResultType\Success;

class FrontController extends Controller
{
    public function index()
    {
        $blogs = Blog::where('status', '1')->take(3)->get();
        return view('front.index', compact('blogs'));
    }

    public function about()
    {
        return view('front.pages.about');
    }

    public function service()
    {
        return view('front.pages.service');
    }

    public function training()
    {
        // dd(Auth::user()->id);
        $categories = Category::where('status', '1')->get();
        $userCourses = UserCourse::where('user_id',Auth::user()->id ?? '')->get();
        $data =[];
        foreach($userCourses as $key=>$value){
            $data[]=$value->course_id;
        }
        // dd($data);
        return view('front.pages.training', compact('categories','data'));
    }

    public function categoryFilter(Request $request)
    {
        $id = $request->id;
        // dd($id);
        $courses = Course::where('category_id', $id)->get();

        return view('front.pages.categories_filter', compact('courses'));
    }

    public function trainingDetails(Request $request)
    {
        $id = base64_decode($request->id);
        $course_details = Course::where('id', $id)->first();
        return view('front.pages.training-details', compact('course_details'));
    }

    public function courseDetail(Request $request)
    {
        // dd(Str::uuid()->toString());
        $id = base64_decode(urldecode($request->id));
        // dd($id);
        $course = Course::where('status', '1')->where('id', $id)->first();
        // dd($course);
        return view('front.pages.courseDetail', compact('course'));
    }


    public function checkoutPayment()
    {
        $plan_data = DB::table('plan_purchases')->where('user_id', Auth::user()->id)->get();
        return view('front.pages.checkout', compact('plan_data'));
    }

    public function removePlanPurchase(Request $request)
    {
        $plan_id = base64_decode($request->id);
        // dd($plan_id);
        $user_id = Auth::user()->id;
        DB::beginTransaction();
        try {
            $plan = PlanPurchase::find($plan_id);

            if ($plan && $plan->user_id == $user_id) {

                $plan->delete();

                // Commit the transaction
                DB::commit();
                return response()->json([
                    'success' => true
                ]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            return $e;
        }
    }

    public function blog()
    {
        $blogs = Blog::where('status', '1')->get();
        return view('front.pages.blog', compact('blogs'));
    }

    public function blogDetails(Request $request)
    {
        $blog_id = base64_decode($request->id);
        $blogData = Blog::where('id', $blog_id)->first();

        return view('front.pages.blog-details', compact('blogData'));
    }

    public function contact()
    {
        return view('front.pages.contact');
    }

    public function enquirySave(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name'        => 'required|regex:/^[a-zA-Z ]+$/u|min:1|max:255',
            'email'       => 'required|email|unique:contacts',
            'phone'       => 'required|min:10|numeric',
            'subject'     => 'required',
            'message'     => 'required',
        ]);

        // $validator = Validator::make($request->all(), $rules);

        // if ($validator->fails()) {

        //     return response()->json([
        //         'success'   => false,
        //         'msg'       => 'Error Occurred',
        //         'errors'    => $validator->errors(),
        //         'error'     =>'validation',
        //     ]);
        // }

        DB::beginTransaction();
        try {

            $data = [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'subject' => $request->input('subject'),
                'message' => $request->input('message'),
                'created_at' => date('Y-m-d H:i:s')
            ];
            DB::table('contacts')->insert($data);

            DB::commit();
            return response()->json([
                'success'   =>  true,
                'msg'       =>  'Contact form submit Successfully',
                'url'           => url('contact'),
                'errors'        => []
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            return $e;
        }
    }

    public function subscriptionPlan(Request $request)
    {
        $price_id   = base64_decode($request->price_id);

        $course_price = DB::table('course_prices')->where('id', $price_id)->first();

        $userId     = $request->user_id;
        $course_id    = $course_price->course_id;
        $pricing      = $course_price->pricing;
        $subscription_plan = $course_price->subscription_plan;


        DB::beginTransaction();
        try {


            $data = [
                'user_id'     => $userId,
                'course_id'   => $course_id,
                'pricing'     => $pricing,
                'subscription_plan' => $subscription_plan,
                'created_at' => date('Y-m-d H:i:s')
            ];
            DB::table('plan_purchases')->insert($data);

            DB::commit();
            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            return $e;
        }
    }

    public function courseEnrol(Request $request, $id = null)
    {
        if(!isset($id))
        {
            return redirect()->back()->with('msg', 'Error Occurred');
        }
        $data = $request->all();
        $data['course_id'] = $id;
        $carted = Helper::addToCart($data);
        // dd($carted);
        if (!$carted['success']) {
            return redirect(back())->with('msg', 'Error Occurred');
        }
        if ($data['enrolType'] == urlencode(base64_encode(config('constants.enrolTypes.buy_now.id'))))
        {
            // return redirect()->to(route('checkout', urlencode(base64_encode($carted['cart_id']))));
            return redirect()->to(route('cart.index'));
        }
        return redirect()->back()->with([
            'carted' => true,
            'msg' => 'Course Added to Cart'
        ]);
    }

    public function checkout($content = null)
    {
        $data = [];
        if (isset($content))
        {
            $item = Course::find(base64_decode(urldecode($content['course_id'])));
            $item['priceOption'] = PriceOption::find(base64_decode(urldecode($content['priceOptionId'])));
            $data['items'][] = $item;
            $user = Auth::user();
        }
        return view('front.pages.checkout',);
    }

    public function subscriptionOneTime(Request $request)
    {
        // dd($request->all());
        $courseId   = base64_decode($request->course_id);
        $price_id   = base64_decode($request->price);
        $userId     = Auth::user()->id;

        DB::beginTransaction();
        try {
            $data = [
                'course_id'   => $courseId,
                'pricing'     => $price_id,
                'user_id'     => $userId,
                //'subscription_plan' => $subscription_plan,
                'created_at' => date('Y-m-d H:i:s')
            ];
            DB::table('plan_purchases')->insert($data);

            DB::commit();
            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            return $e;
        }
    }

    public function checkoutSave(Request $request)
    {
        DB::beginTransaction();
        try {
            $courseId = $request->course_id;

            $courseIds = implode(',', $courseId);

            $unique = Str::uuid()->toString();

            $data = [
                'unique_id'   => $unique,
                'course_id'   => $courseIds,
                'pricing'     => $request->total_pricing,
                'user_id'     => $request->user_id,
                'status'      => 'pending',
                'created_at'  => date('Y-m-d H:i:s')
            ];
            $paymentsId = DB::table('payments')->insertGetId($data);

            DB::commit();
            return response()->json([
                'success' => true,
                'ids'     => $paymentsId
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            return $e;
        }
    }


    public function enrolModal(Request $request, $id = null)
    {
        $courseId = base64_decode(urldecode($id));
        if (!Auth::check()) {
            $request['courseId'] = $courseId;
            return $this->authModal($request);
        }
        $data['course'] = Course::find($courseId);

        return response()->json([
            'parentId' => '#modalContent',
            'modalId' => '#modalCommon',
            'view' => view('components.enrolModal', $data)->render()
        ]);
    }


    public function authModal(Request $request)
    {
        if (Auth::check()) {
            return response()->json([
                'success' => false,
                'msg' => 'Already Logged In'
            ]);
        }
        $form = $request->get('form');
        $courseId = $request->get('courseId');

        if ($form === 'register') {
            return response()->json([
                'parentId' => '#enrolModalContent',
                'modalId' => '#enrolModal',
                'view' => view('components.signUp',['courseId' => $courseId])->render()
            ]);
        }
        return response()->json([
            'parentId' => '#enrolModalContent',
            'modalId' => '#enrolModal',
            'view' => view('components.login',['courseId' => $courseId])->render()
        ]);
    }

    public function ccAvenueCallBack(Request $request)
    {
        return 'Error Occurred in Payment';
    }
}
