<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\User;
use App\Helpers\Helper;
use App\Models\Payment;
use App\Models\UserCourse;
use App\Models\Course;
use App\Models\PriceOption;
use Illuminate\Http\Request;
use App\Models\PaymentCourse;
use App\Models\khdaCertificate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{

    public function handleCallback(Request $request)
    {
        if (!(isset($request->encResp) && isset($request->orderNo) )) {
            return redirect(route('home'));
        }
        $queryString = $this->decrypt($request->encResp, config('ccavenue.encryption_key'));
        parse_str($queryString, $data);
        $userId = Payment::where('order_id',$data['order_id'])->pluck('user_id')->first();
        $user = User::find($userId);
        Auth::login($user);
        $auth = Auth::user();
        $currentTime = Carbon::now();

        $payment = Payment::updateOrCreate([
            'order_id' => $data['order_id'],
            'amount' => $data['amount']
        ],[
            'tracking_id' => $data['tracking_id'],
            'user_id' => $auth->id,
            'success' => $data['order_status'] == 'Success',
            'bank_ref_no' => $data['bank_ref_no'] == 'null' ? null : $data['bank_ref_no'],
            'order_status' => $data['order_status'],
            'success_at' => $currentTime->format('Y-m-d H:i:s')
        ]);

        if ($payment && $payment->success) {
            $paymentCourseIds = $payment->paymentCourses->pluck('course_id')->toArray();

            foreach ($auth->carts as $value) {
                if (in_array($value->course_id,$paymentCourseIds)) {
                    $auth->carts->find($value->id)->delete();
                }
            }

            foreach ($payment->paymentCourses as $value) {
                $lastExpiry = UserCourse::where([
                    'user_id' => $auth->id,
                    'course_id' => $value->course_id,
                ])->orderBy('expires_at','desc')->pluck('expires_at')->first();
                if ($lastExpiry) {
                    $currentTime = Carbon::parse($lastExpiry);
                }
                UserCourse::updateOrCreate([
                    'payment_id' => $payment->id,
                    'course_id' => $value->course_id,
                ],[
                    'payment_id' => $payment->id,
                    'user_id' => $auth->id,
                    'course_id' => $value->course_id,
                    'price_option_id' => $value->price_option_id,
                    'expires_at' => $currentTime->copy()->addMonths($value->duration())->format('Y-m-d H:i:s'),
                ]);
            }
            $view = 'front.payments.paymentSuccess';
        }
        else {
            $view = 'front.payments.paymentFailure';
        }
        return redirect()->route('home')->with([
            'popup' => true,
            'popupContent' => view($view)->render()
        ]);
    }



    public function initiatePayment(Request $request, $id = null,$priceId = null)
    {
        $plainData = [];
        $auth = Auth::user();
        $plainData['merchant_id'] = config('ccavenue.merchant_id');
        $plainData['redirect_url'] = route('handleCallback');
        $plainData['order_id'] = $orderId = hrtime(true);
        $plainData['currency'] = 'AED';
        $totalAmount = 0;

        DB::beginTransaction();
        try {
            $payment = new Payment();
            $payment->order_id = $orderId;
            $payment->user_id = $auth->id;
            $payment->save();
            $priceIds =base64_decode(urldecode($priceId));
            $course = Course::find(base64_decode(urldecode($id)));
            $pricesAmount = PriceOption::with('course')->find($priceIds);
            $items = [];
            $totalAmount = 0;
            $courseId = 0;
            $priceId = NULL;
            if ($pricesAmount && $course) {
                $totalAmount += $pricesAmount->price();
                $courseId = $pricesAmount->course_id;
                $priceId = $pricesAmount->id ;
            } elseif ($course) {
                $totalAmount += $course->price();
                $courseId += $course->id;
                $priceId =NULL;
            } elseif ($id) {
                $item = Cart::find(base64_decode(urldecode($id)));
                if ($item) {
                    $totalAmount += $item->price();
                }
            } else {
                $items = $auth->carts;
            }
                if(!empty($items)){
                    foreach ($items as $item) {
                        PaymentCourse::create([
                            'payment_id' => $payment->id,
                            'course_id' => $item->course_id ?? $courseId ,
                            'price_option_id' => $item->price_option_id ?? $priceId ,
                            'amount' =>$item->price(),
                        ]);
                        $totalAmount += $item->price();
                    }
                }else{
                    PaymentCourse::create([
                        'payment_id' => $payment->id,
                        'course_id' => $item->course_id ?? $courseId ,
                        'price_option_id' => $item->price_option_id ?? $priceId ,
                        'amount' =>$totalAmount,
                    ]);
                }

                $taxAmount = $totalAmount *5/100;
                $finalAmount = $totalAmount + $taxAmount;
            $payment->amount = $plainData['amount'] =  $finalAmount;
            $queryString = http_build_query($plainData);
            $encryptedData = $this->encrypt($queryString, config('ccavenue.encryption_key'));
            $payment->save();
            DB::commit();
            return view('front.payments.paymentInitiate', compact('encryptedData'));
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function checkEmailUnique(Request $request)
    {
        $emailExists = khdaCertificate::where('email', $request->email)->exists();

        if ($emailExists) {
            return response()->json(false);
        }
        return response()->json(true);
    }

    public function attestedKHDAPayment(Request $request)
    {
        $request->validate([
            'name_arabic' => 'required',
            'username_english' => 'required|regex:/^[a-zA-Z]+$/u|min:1|max:255',
            'religion' => 'required',
            'gender' => 'required',
            'dob' => 'required|date',
            'email' => 'required|email|unique:khda_certificates,email',
            'nationality' => 'required',
            'passport_number' => 'required',
        ]);

        $plainData = [];
        $auth = Auth::user();
        $plainData['merchant_id'] = config('ccavenue.merchant_id');
        $plainData['redirect_url'] = route('successPayment');
        $plainData['order_id'] = $orderId = hrtime(true);
        $plainData['currency'] = 'AED';
        $totalAmount = 80;
        // dd($plainData);
        DB::beginTransaction();
        try {
            if($request->file('passport_image'))
            {
                $image = $request->file('passport_image');
                $date = date('YmdHis');
                $no = str_shuffle('123456789023456789034567890456789905678906789078908909000987654321987654321876543217654321654321543214321321211');
                $random_no = substr($no, 0, 2);
                $final_image_name = $date.$random_no.'.'.$image->getClientOriginalExtension();

                $destination_path = public_path('/uploads/passport/');
                if(!File::exists($destination_path))
                {
                    File::makeDirectory($destination_path, $mode = 0777, true, true);
                }
                $image->move($destination_path , $final_image_name);

            }
            $data = [
                'student_id' => Auth::user()->id,
                'name_in_arabic' => $request->name_arabic,
                'name_in_english' => $request->username_english,
                'religion' => $request->religion,
                'gender' => $request->gender,
                'dob' => $request->dob,
                'email' => $request->email,
                'nationality' =>$request->nationality,
                'passport_number' =>$request->passport_number,
                'amount' => 80,
                'order_id' => $orderId,
                'passport_image' => !empty($final_image_name) ? $final_image_name:NULL
            ];

               $insert= khdaCertificate::create($data);
             $plainData['amount'] = $totalAmount;
                // if($insert==true){
                $queryString = http_build_query($plainData);

                $encryptedData = $this->encrypt($queryString, config('ccavenue.encryption_key'));
                DB::commit();

                return view('front.payments.paymentInitiate', compact('encryptedData'));

            // }
        } catch (\Throwable $th) {

            DB::rollBack();
            throw $th;
        }
    }

    public function successPayment(Request $request){

        try {
            // $id=Auth::user();
            // dd($id);
            $queryString = $this->decrypt($request->encResp, config('ccavenue.encryption_key'));
            parse_str($queryString, $data);
            $certificate = khdaCertificate::where('order_id', $data['order_id'])->first();
            $user = User::find($certificate->student_id);
            Auth::login($user);
            if ($certificate) {
                $certificate->status = $data['order_status'] ? 1 : 0;
                $certificate->order_id = $data['order_id'] ;
                $certificate->save();
                $mail = $certificate->email;
                $name = $certificate->name_in_english;
                $emailAddresses = ['info@generationz.education', $mail];
                    Mail::send('mails.khda_certificate', ['certificate' => $certificate], function ($message) use ($emailAddresses) {
                        $message->to($emailAddresses) // Send to all addresses
                                ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME', 'Generation-Z')) // Sender
                                ->subject("Khda Certificate Successful!");
                    });


            }
            DB::commit();
            return redirect()->route('student.dashboard')->with('success','Payment submit successfully done');
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    function encrypt($plainText, $key)
    {
        $key = $this->hextobin(md5($key));
        $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
        $openMode = openssl_encrypt($plainText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
        $encryptedText = bin2hex($openMode);
        return $encryptedText;
    }

    function decrypt($encryptedText, $key)
    {
        $key = $this->hextobin(md5($key));
        $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
        $encryptedText = $this->hextobin($encryptedText);
        $decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
        return $decryptedText;
    }

    function hextobin($hexString)
    {
        $length = strlen($hexString);
        $binString = "";
        $count = 0;
        while ($count < $length) {
            $subString = substr($hexString, $count, 2);
            $packedString = pack("H*", $subString);
            if ($count == 0) {
                $binString = $packedString;
            } else {
                $binString .= $packedString;
            }

            $count += 2;
        }
        return $binString;
    }

}
