<?php

namespace App\Http\Controllers;

use App\Truck;
use App\Account;
use App\GiftCard;
use App\Product_Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Customer;
use App\CustomerGroup;
use App\Warehouse;
use App\Biller;
use App\Brand;
use App\Category;
use App\Product;
use App\Unit;
use App\Tax;
use App\Sale;
use App\Delivery;
use App\PosSetting;
use App\Product_Warehouse;
use App\Payment;
use App\Coupon;
use App\PaymentWithCheque;
use App\PaymentWithGiftCard;
use App\PaymentWithCreditCard;
use App\PaymentWithPaypal;
use App\User;
use App\Variant;
use App\ProductVariant;
use DB;
use App\GeneralSetting;
use Stripe\Stripe;
use NumberToWords\NumberToWords;
use Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Mail\UserNotification;
use Illuminate\Support\Facades\Mail;
use Srmklive\PayPal\Services\ExpressCheckout;
use Srmklive\PayPal\Services\AdaptivePayments;
use GeniusTS\HijriDate\Date;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TruckController extends Controller
{
    public function index()
    {
        $lims_truck_all = Truck::with('unit')->get();
        $lims_product_all = Product::all();
        return view('truck.index', compact('lims_truck_all', $lims_product_all));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        Truck::create($request->all());
        return redirect()->route("trucks.index")->with("message", "Truck inserted successfully");
    }

    public function show(Truck $truck)
    {
        //
    }

    public function edit(Truck $truck)
    {
        //
    }

    public function update(Request $request, $id)
    {
        Truck::find($id)->update($request->all());
        return redirect()->route("trucks.index")->with("message", "Truck updated successfully");
    }
    public function add_payment(Request $request)
    {
        
        $data = $request->all();
        if(!$data['amount'])
            $data['amount'] = 0.00;
        
        $lims_sale_data = Sale::find($data['sale_id']);
        $lims_customer_data = Customer::find($lims_sale_data->customer_id);
        $lims_sale_data->paid_amount += $data['amount'];
        $balance = $lims_sale_data->grand_total - $lims_sale_data->paid_amount;
        if($balance > 0 || $balance < 0)
            $lims_sale_data->payment_status = 2;
        elseif ($balance == 0)
            $lims_sale_data->payment_status = 4;
        $lims_sale_data->save();

        if($data['paid_by_id'] == 1)
            $paying_method = 'Cash';
        elseif ($data['paid_by_id'] == 2)
            $paying_method = 'Gift Card';
        elseif ($data['paid_by_id'] == 3)
            $paying_method = 'Credit Card';
        elseif($data['paid_by_id'] == 4)
            $paying_method = 'Cheque';
        elseif($data['paid_by_id'] == 5)
            $paying_method = 'Paypal';
        else
            $paying_method = 'Deposit';

        $lims_payment_data = new Payment();
        $lims_payment_data->user_id = Auth::id();
        $lims_payment_data->sale_id = $lims_sale_data->id;
        $lims_payment_data->account_id = $data['account_id'];
        $data['payment_reference'] = 'spr-' . date("Ymd") . '-'. date("his");
        $lims_payment_data->payment_reference = $data['payment_reference'];
        $lims_payment_data->amount = $data['amount'];
        $lims_payment_data->change = $data['paying_amount'] - $data['amount'];
        $lims_payment_data->paying_method = $paying_method;
        $lims_payment_data->payment_note = $data['payment_note'];
        $lims_payment_data->save();

        $lims_payment_data = Payment::latest()->first();
        $data['payment_id'] = $lims_payment_data->id;

        if($paying_method == 'Gift Card'){
            $lims_gift_card_data = GiftCard::find($data['gift_card_id']);
            $lims_gift_card_data->expense += $data['amount'];
            $lims_gift_card_data->save();
            PaymentWithGiftCard::create($data);
        }
        elseif($paying_method == 'Credit Card'){
            $lims_pos_setting_data = PosSetting::latest()->first();
            Stripe::setApiKey($lims_pos_setting_data->stripe_secret_key);
            $token = $data['stripeToken'];
            $amount = $data['amount'];

            $lims_payment_with_credit_card_data = PaymentWithCreditCard::where('customer_id', $lims_sale_data->customer_id)->first();

            if(!$lims_payment_with_credit_card_data) {
                // Create a Customer:
                $customer = \Stripe\Customer::create([
                    'source' => $token
                ]);
                
                // Charge the Customer instead of the card:
                $charge = \Stripe\Charge::create([
                    'amount' => $amount * 100,
                    'currency' => 'usd',
                    'customer' => $customer->id,
                ]);
                $data['customer_stripe_id'] = $customer->id;
            }
            else {
                $customer_id = 
                $lims_payment_with_credit_card_data->customer_stripe_id;

                $charge = \Stripe\Charge::create([
                    'amount' => $amount * 100,
                    'currency' => 'usd',
                    'customer' => $customer_id, // Previously stored, then retrieved
                ]);
                $data['customer_stripe_id'] = $customer_id;
            }
            $data['customer_id'] = $lims_sale_data->customer_id;
            $data['charge_id'] = $charge->id;
            PaymentWithCreditCard::create($data);
        }
        elseif ($paying_method == 'Cheque') {
            PaymentWithCheque::create($data);
        }
        elseif ($paying_method == 'Paypal') {
            $provider = new ExpressCheckout;
            $paypal_data['items'] = [];
            $paypal_data['items'][] = [
                'name' => 'Paid Amount',
                'price' => $data['amount'],
                'qty' => 1
            ];
            $paypal_data['invoice_id'] = $lims_payment_data->payment_reference;
            $paypal_data['invoice_description'] = "Reference: {$paypal_data['invoice_id']}";
            $paypal_data['return_url'] = url('/sale/paypalPaymentSuccess/'.$lims_payment_data->id);
            $paypal_data['cancel_url'] = url('/sale');

            $total = 0;
            foreach($paypal_data['items'] as $item) {
                $total += $item['price']*$item['qty'];
            }

            $paypal_data['total'] = $total;
            $response = $provider->setExpressCheckout($paypal_data);
            return redirect($response['paypal_link']);
        }
        elseif ($paying_method == 'Deposit') {
            $lims_customer_data->expense += $data['amount'];
            $lims_customer_data->save();
        }
        $message = 'Payment created successfully';
        if($lims_customer_data->email){
            $mail_data['email'] = $lims_customer_data->email;
            $mail_data['sale_reference'] = $lims_sale_data->reference_no;
            $mail_data['payment_reference'] = $lims_payment_data->payment_reference;
            $mail_data['payment_method'] = $lims_payment_data->paying_method;
            $mail_data['grand_total'] = $lims_sale_data->grand_total;
            $mail_data['paid_amount'] = $lims_payment_data->amount;
            try{
                Mail::send( 'mail.payment_details', $mail_data, function( $message ) use ($mail_data)
                {
                    $message->to( $mail_data['email'] )->subject( 'Payment Details' );
                });
            }
            catch(\Exception $e){
                $message = 'Payment created successfully. Please setup your <a href="setting/mail_setting">mail setting</a> to send mail.';
            }
            
        }
        return redirect()->back()->with('message', $message);
        // return redirect('sales')->with('message', $message);
    }

    public function transactionDetails($id)
    {
        $lims_gift_card_list = GiftCard::where("is_active", true)->get();
        $lims_truck_data = Truck::with('delivery')->find($id);
        $lims_account_list = Account::where('is_active', true)->get();
        return view('truck.transaction_details', compact('lims_account_list', 'lims_truck_data','lims_gift_card_list'));
    }

    public function daytransactionDetails($id)
    {     
        $start_date='1988-04-18'; 
        $end_date=date('Y-m-d');
        $truck_id=$id;
        $truck_data= DB::table('trucks')->get();
        $get_truck_data = Truck::find($truck_id);
        $sql="select deliveries.reference_no, deliveries.created_at, sum(product_sales.total)total, sum(product_sales.qty)qty, products.name,products.id, products.weight
                from deliveries 
                left JOIN product_sales on deliveries.sale_id=product_sales.sale_id
                left join products on product_sales.product_id=products.id
                where deliveries.truck_id='".$truck_id."' and deliveries.status<3 group by id order by created_at asc";    
        $lims_truck_data=DB::select(DB::raw($sql));
        return view('truck.day_transaction_details', compact('lims_truck_data', 'truck_data', 'get_truck_data', 'truck_id', 'start_date','end_date'));
    }    
    public function daytransaction(Request $request){
        $start_date=$request->input('start_date'); 
        $end_date=$request->input('end_date');            
        $truck_id=$request->input('trucks_id');
        $truck_data= DB::table('trucks')->get();
        $get_truck_data = Truck::find($truck_id);
        
        $sql="select deliveries.reference_no, deliveries.created_at, sum(product_sales.total)total, sum(product_sales.qty)qty, products.name,products.id, products.weight
                    from deliveries 
                    left JOIN product_sales on deliveries.sale_id=product_sales.sale_id
                    left join products on product_sales.product_id=products.id
                    where deliveries.truck_id='".$truck_id."' and deliveries.status<3 and DATE_FORMAT(deliveries.created_at,'%Y-%m-%d') BETWEEN '".$start_date."' and '".$end_date."' group by id order by created_at asc";    
        $lims_truck_data=DB::select(DB::raw($sql));
        
        return view('truck.day_transaction_details', compact('lims_truck_data', 'truck_data','get_truck_data', 'truck_id', 'start_date','end_date'));
    }
    public function getsalestatus($id){
        return Sale::find($id);
    }
    public function change_status(Request $request){
        $id= $request->input('sale_id');
        $sale_data = Sale::find($id);
        $data = [
                'sale_status'     => $request->input('sale_status')
        ];
        $sale_data->update($data);
        return redirect()->back()->with('message', "Sale Status updated successfully");
    }
    public function destroy($id)
    {
        Truck::find($id)->delete();
        return redirect()->route("trucks.index")->with("not_permitted", "Truck deleted successfully");
    }
   
}
