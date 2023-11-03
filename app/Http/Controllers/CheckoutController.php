<?php

namespace App\Http\Controllers;

use Ankurk91\LaravelShoppingCart\Facades\ShoppingCart;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CheckoutController extends Controller
{
    public function checkout(Request $request){
 // step 1: login to paymob
 $response = Http::withHeaders([
    'content-type' => 'application/json'
])->post('https://accept.paymobsolutions.com/api/auth/tokens',[
    "api_key"=> env('PAYMOB_API_KEY')
]);
$json=$response->json();




// $order = CombinedOrder::query()->findOrFail($order_id);
// $grand_total = $order->grand_total;

$grand_total = ShoppingCart::subtotal();

// step 2: send order data
$response_final=Http::withHeaders([
    'content-type' => 'application/json'
])->post('https://accept.paymobsolutions.com/api/ecommerce/orders',[
    "auth_token"=>$json['token'],
    "delivery_needed"=>"false",
    "amount_cents"=>$grand_total*100,
    // "merchant_order_id" => 19,
]);

$json_final=$response_final->json();

    //    dd($json_final);
$user = Auth::user();
// $name = $user->name;
// if ((count(explode(" ",$name)) == 1)) {
//     $first_name = $name;$last_name=$name;
// } else {
//     $first_name = explode(" ",$name)[0];
//     $last_name = explode(" ",$name)[1];
// }
//  step 3: send customer data
$response_final_final=Http::withHeaders([
    'content-type' => 'application/json'
])->post('https://accept.paymobsolutions.com/api/acceptance/payment_keys',[
    "auth_token"=>$json['token'],
    "expiration"=> 36000,
    "amount_cents"=>$json_final['amount_cents'],
    "order_id"=>$json_final['id'],
    "billing_data"=>[
        "first_name"            => $user->first_name,
        "last_name"             => $user->last_name,
        "phone_number"          => $user->phone ?: "NA",
        "email"                 => $user->email,
        "apartment"             => "NA",
        "floor"                 => "NA",
        "street"                => $user->address?: "NA",
        "building"              => "NA",
        "shipping_method"       => "NA",
        "postal_code"           => $user->postal_code?: "NA",
        "city"                  => $user->city?: "NA",
        "state"                 => $user->state ?: "NA",
        "country"               => $user->country?: "NA",
    ],
    "currency"=>"EGP",
    "integration_id"=>4321280
]);

$response_final_final_json=$response_final_final->json();


return redirect('https://accept.paymobsolutions.com/api/acceptance/iframes/'. 798139 .'?payment_token=' . $response_final_final_json['token']);

// if ($payment_method == 'paymob_mobile_wallet_payment') {
//     $response_iframe =Http::withHeaders([
//         'content-type' => 'application/json'
//     ])->post('https://accept.paymob.com/api/acceptance/payments/pay',[
//         "source"=>[
//             "identifier"=> $iframe_id_or_wallet_number,
// //                "identifier"=> "01010101010",
//             "subtype"=> "WALLET"
//         ],
//         "payment_token"=>$response_final_final_json['token'],
//     ]);
//     return redirect($response_iframe->json()['redirect_url']);
// } else {
//     return redirect('https://accept.paymobsolutions.com/api/acceptance/iframes/'. $iframe_id_or_wallet_number .'?payment_token=' . $response_final_final_json['token']);
// }
}


    public function callback(Request $request): RedirectResponse
    {
        $payment_details = json_encode($request->all());
        if ($request->success === "true")
        {
            // return (new CheckoutController)->checkout_done(3, $payment_details);
            //write the code to put the order in database


            $cartCollection = ShoppingCart::all();
            $user = auth()->user();

            $order = $user->orders()->create([]);
            //use the auth or user that logged in  use after that

            $total_price = ShoppingCart::subtotal();



            foreach ($cartCollection as $product_id) {
                    $product = Product::findOrfail($product_id->id);

                    $order->products()->attach($product_id,['quantity' => $product_id->quantity]);

                    $product->update([
                        'stock'=> $product->stock - $product_id->quantity,
                    ]);
            }
            // dd($request->all());

            $order->update([
                'total_price'=> $total_price,
            ]);

            ShoppingCart::clear();


            session()->flash('success','Payment done');
            return redirect()->route('index');
        } else {
            session()->flash('success','Payment Failed');
            return redirect()->route('index');
        }
    }

}




// <?php

// namespace App\Http\Controllers\Payment;

// use App\Http\Controllers\CheckoutController;
// use App\Http\Controllers\Controller;
// use App\Models\CombinedOrder;
// use App\Models\Order;
// use App\Utility\NotificationUtility;
// use Illuminate\Http\JsonResponse;
// use Illuminate\Http\RedirectResponse;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Http;

// class PaymobController extends Controller
// {
//     /**
//      * Display checkout page.
//      *
//      * @param $payment_method
//      * @param $integration_id
//      * @param $order_id
//      * @param $iframe_id_or_wallet_number
//      * @return RedirectResponse
//      */
//     public function checkingOut($payment_method, $integration_id, $order_id, $iframe_id_or_wallet_number): RedirectResponse
//     {

//     }


// }