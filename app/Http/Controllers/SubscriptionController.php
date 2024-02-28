<?php

namespace App\Http\Controllers;

use Stripe\Plan;
use Stripe\Stripe;
use App\Models\User;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use PhpParser\Node\Stmt\TryCatch;
use App\Http\Middleware\isEmployer;
use Illuminate\Support\Facades\URL;

class SubscriptionController extends Controller
{   
    const WEAKLY_AMOUNT = 20;
    const MONTHLY_AMOUNT = 80;
    const YEARLY_AMOUNT = 200;
    const CURRENCY = 'USD';

    // public function __construct()
    // {
    //     $this->middleware(['auth',isEmployer::class]);
    // }
    //
    public function subscribe(){

        return view('subscription.index');
    }

    public function initiatePayment(Request $request){
          
        $plans = [
            'weekly'=>[
                'name' =>'weekly',
                'description' => 'weekly payment',
                'amount'      =>self::WEAKLY_AMOUNT,
                'currency' =>self::CURRENCY,
                'quantity'   =>'1'
            ],
            'monthly'=>[
                'name' =>'monthly',
                'description' => 'monthly payment',
                'amount'      =>self::MONTHLY_AMOUNT,
                'currency' =>self::CURRENCY,
                'quantity'   =>'1'
            ],
            'yearly'=>[
                'name' =>'yearly',
                'description' => 'yearly payment',
                'amount'      =>self::YEARLY_AMOUNT,
                'currency' =>self::CURRENCY,
                'quantity'   =>'1'
            ],
        ];
        
        Stripe::setApiKey("sk_test_51O947gGrxBXaHLx6sMYxIiDbT8eVrvvR9JM6YfFcRILH8FWb5njOqvFXrDqGzKZ36AIXEb4jjlQx377QdY7Exm7300rh3bFCis");
        try {

               $selectPlan = null;
               if($request->is('pay/weekly')){
                  $selectPlan = $plans['weekly'];
                  $billlingEnds = now()->addWeek()->startOfDay()->toString();
               }elseif($request->is('pay/monthly')){
                  $selectPlan = $plans['monthly'];
                  $billlingEnds = now()->addMonth()->startOfDay()->toString();
               }elseif($request->is('pay/yearly')){
                  $selectPlan = $plans['yearly'];
                  $billlingEnds = now()->addYear()->startOfDay()->toString();
               }

               if($selectPlan) {
                $successURl = URL::signedRoute('payment.success',[
                    'plan' => $selectPlan['name'],
                    'billing_ends' => $billlingEnds
                ]);

                $session =Session::create([
                    'payment_method_types' => ['card'],
                    'line_items' => [[
                        'price_data' => [
                            'currency' => $selectPlan['currency'],
                            'product_data' => [
                                'name' => $selectPlan['name'],
                                'description' => $selectPlan['description'], // Note: 'description' is optional here
                            ],
                            'unit_amount' => $selectPlan['amount'] * 100, // Stripe expects amounts in cents
                        ],
                        'quantity' => $selectPlan['quantity'],
                    ]],
                    'mode' => 'payment',
                    'success_url' => $successURl,
                    'cancel_url' => route('payment.cancel'),
                ]);
                
                    //    dd($session);
                return redirect($session->url);
            }
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json($th);
        }
    }

    public function paymentSuccess(Request $request){

        $plan = $request->plan;
        $billlingEnds = $request->billing_ends;

        User::where('id',$request->user()->id)->update([
            'plan'=>$plan,
             'billingEnds' =>$billlingEnds,
             'status' =>'paid'
        ]);
    return redirect()->route('dashboard')->with('success','payment was successfully processs');
    }

    public function cancel(){
         
        return redirect()->route('dashboard')->with('error','payment was unsuccessfull');

    }
}
