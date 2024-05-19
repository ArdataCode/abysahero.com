<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\MasterMember;
use App\Models\Transaksi;
use App\Models\MasterRekening;
use App\Models\User;
use Carbon\Carbon;
use Auth;

class PaymentController extends Controller
{
    private $apiKey;
    private $merchantId;
    private $callbackdb;
    private $sandboxmode;

    public function __construct()
    {
        // $this->middleware('auth');

        if(request()->getHttpHost()=="127.0.0.1:8000"){
            $this->apiKey = "8da5a86dc7d22265d20879c25b0f111f";
            $this->merchantId = "D12146";
            $this->callbackdb = "https://apps.rumahbinlatofficial.com/public/api/callbackorder";
            $this->sandboxmode = true;
        }else if(request()->getHttpHost()=="eliansandy.com"){
            $this->apiKey = "b68a8636867b408341ccfa031f5b5fe7";
            $this->merchantId = "DS12788";
            $this->callbackdb = "https://eliansandy.com/public/api/callbackorder";
            $this->sandboxmode = true;
        }

    }
    public function createorder(Request $request)
    {
        $mastermemberid = Crypt::decrypt($request->mastermemberid);
        $mastermember = MasterMember::find($mastermemberid);
        $merchantOrderId    = time();

        $responcreate['merchant_order_id'] = $merchantOrderId;
        $responcreate['fk_user_id'] = Auth::id();
        $responcreate['fk_master_member_id'] = $mastermember->id;
        $responcreate['harga'] = $mastermember->harga;
        $responcreate['batas_mengerjakan'] = $mastermember->batas_mengerjakan;
        $responcreate['status'] = 0;
        $responcreate['expired'] = Carbon::now()->addMinutes(180)->toDateTimeString();
        $responcreate['created_by'] = Auth::id();
        $responcreate['created_at'] = Carbon::now()->toDateTimeString();
        $responcreate['updated_by'] = Auth::id();
        $responcreate['updated_at'] = Carbon::now()->toDateTimeString();
        $createdata = Transaksi::create($responcreate);
        if($createdata){
            return response()->json([
                'status' => true,
                'message' => 'Halaman akan diarahakan otomatis. Mohon Tunggu...',
                'id' => Crypt::encrypt($createdata->id)
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Gagal, mohon coba kembali !'
            ]);
        }

    }
    public function detailbayar($id)
    {
        $menu = 'transaksi';
        $submenu='';
        $rek = MasterRekening::all();
        $id = Crypt::decrypt($id);
        $transaksi = Transaksi::find($id);
        $membermst = MasterMember::find($transaksi->fk_master_member_id); 

        $data_param = [
            'menu','submenu','transaksi','membermst','rek'
        ];  
        return view('user/detailbayar')->with(compact($data_param));
    }
    public function createorderduitku(Request $request)
    {
        $mastermemberid = Crypt::decrypt($request->mastermemberid);
        $mastermember = MasterMember::find($mastermemberid);
        
        if ($mastermember) {               
                $duitkuConfig = new \Duitku\Config($this->apiKey, $this->merchantId);
                $duitkuConfig->setSandboxMode($this->sandboxmode);
                $paymentAmount      = $mastermember->harga; // Amount
                $email              = Auth::user()->email; // your customer email
                $phoneNumber        = ""; // your customer phone number (optional)
                $productDetails     = "Member ".$mastermember->judul;
                $merchantOrderId    = time(); // from merchant, unique   
                $additionalParam    = ''; // optional
                $merchantUserInfo   = ''; // optional
                $customerVaName     = Auth::user()->name; // display name on bank confirmation display
                $callbackUrl        = $this->callbackdb; // url for callback
                $returnUrl          = url('transaksi'); // url for redirect
                $expiryPeriod       = 180; // set the expired time in minutes
        
                // Customer Detail
                $firstName          = Auth::user()->name;
                $lastName           = "";
        
                // Address
                $alamat             = "Jl. Kembangan Raya";
                $city               = "Jakarta";
                $postalCode         = "11530";
                $countryCode        = "ID";
        
                $address = array(
                    'firstName'     => $firstName,
                    'lastName'      => $lastName,
                    'address'       => $alamat,
                    'city'          => $city,
                    'postalCode'    => $postalCode,
                    'phone'         => $phoneNumber,
                    'countryCode'   => $countryCode
                );
        
                $customerDetail = array(
                    'firstName'         => $firstName,
                    'lastName'          => $lastName,
                    'email'             => $email,
                    'phoneNumber'       => $phoneNumber
                    // 'billingAddress'    => $address,
                    // 'shippingAddress'   => $address
                );
        
                // Item Details
                $item1 = array(
                    'name'      => $productDetails,
                    'price'     => $paymentAmount,
                    'quantity'  => 1
                );
        
                $itemDetails = array(
                    $item1
                );
        
                $params = array(
                    'paymentAmount'     => $paymentAmount,
                    'merchantOrderId'   => $merchantOrderId,
                    'productDetails'    => $productDetails,
                    'additionalParam'   => $additionalParam,
                    'merchantUserInfo'  => $merchantUserInfo,
                    'customerVaName'    => $customerVaName,
                    'email'             => $email,
                    'phoneNumber'       => $phoneNumber,
                    'itemDetails'       => $itemDetails,
                    'customerDetail'    => $customerDetail,
                    'callbackUrl'       => $callbackUrl,
                    'returnUrl'         => $returnUrl,
                    'expiryPeriod'      => $expiryPeriod
                );
        
                try {
                    // createInvoice Request
                    $responseDuitkuPop = \Duitku\Pop::createInvoice($params, $duitkuConfig);
                    $datarespon = json_decode($responseDuitkuPop);
                    $responcreate['payment_url'] = $datarespon->paymentUrl;
                    $responcreate['reference'] = $datarespon->reference;
                    $responcreate['merchant_order_id'] = $merchantOrderId;
                    $responcreate['fk_user_id'] = Auth::id();
                    $responcreate['fk_master_member_id'] = $mastermember->id;
                    $responcreate['harga'] = $mastermember->harga;
                    $responcreate['status'] = 0;
                    $responcreate['expired'] = Carbon::now()->addMinutes(180)->toDateTimeString();
                    $responcreate['created_by'] = Auth::id();
                    $responcreate['created_at'] = Carbon::now()->toDateTimeString();
                    $responcreate['updated_by'] = Auth::id();
                    $responcreate['updated_at'] = Carbon::now()->toDateTimeString();
                    Transaksi::create($responcreate);

                    header('Content-Type: application/json');
                    echo $responseDuitkuPop;
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            
        }
    }

    public function callbackorder(Request $request)
    {
        try {
            $duitkuConfig = new \Duitku\Config($this->apiKey, $this->merchantId);
            $duitkuConfig->setSandboxMode($this->sandboxmode);
            $callback = \Duitku\Pop::callback($duitkuConfig);
            header('Content-Type: application/json');
            $notif = json_decode($callback);
            $merchantOrderId = $notif->merchantOrderId;
        	
            if ($notif->resultCode == "00") {
                $data['status'] = 1;
                $updatecallback = Transaksi::where('merchant_order_id',$merchantOrderId)->update($data);
            } else if ($notif->resultCode == "01") {
                $data['status'] = 2;
                $updatecallback = Transaksi::where('merchant_order_id',$merchantOrderId)->update($data);
            }
        } catch (Exception $e) {
            http_response_code(400);
            echo $e->getMessage();
        }
    }

    public function callbackordertest(Request $request)
    {
        $merchantOrderId = $notif->merchantOrderId;
        $data['status'] = 1;
        $updatecallback = Transaksi::where('merchant_order_id',$merchantOrderId)->update($data);
    }
}
