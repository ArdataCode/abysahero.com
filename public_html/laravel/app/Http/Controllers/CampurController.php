<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterProvinsi;
use App\Models\MasterKabupaten;
use App\Models\MasterKecamatan;
use App\Models\User;
use Carbon\Carbon;
use Auth;
use App\Mail\RegisterEmailAwal;
use App\Mail\RegisterEmail;
use App\Mail\ResetPassword;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class CampurController extends Controller
{
    public function index()
    {
        return view('utama/Home');
    }
    public function storeregister(Request $request)
    {
        $cekemail = User::where('username',$request->email)->get();
        $ceknowa = User::where('no_wa',$request->no_wa)->get();
        if (count($cekemail)>0) {
            return response()->json([
                'status' => false,
                'message' => 'Email sudah digunakan'
            ]);
            dd('Error');
        }

        $dataemailawal = [
            'nama' => $request->name,
            'email' => $request->email
        ];
        $mail = new RegisterEmailAwal($dataemailawal);
        Mail::to($request->email)->send($mail);

        $data['username'] = $request->email;
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['no_wa'] = $request->no_wa;
        $data['jenis_kelamin'] = $request->jenis_kelamin;
        $data['alamat'] = $request->alamat;
        $data['provinsi'] = $request->provinsi;
        $data['kabupaten'] = $request->kabupaten;
        $data['kecamatan'] = $request->kecamatan;
        $data['user_level'] = 2;
        $data['is_active'] = 0;
        $data['password'] = bcrypt($request->password);
        $data['created_at'] = Carbon::now()->toDateTimeString();
        $data['updated_at'] = Carbon::now()->toDateTimeString();
        $createdata = User::create($data);
        if($createdata){
            $dataemail = [
                'id'=> Crypt::encrypt($createdata->id),
                'name' => $request->name,
                'email' => $request->email
            ];
            $mail = new RegisterEmail($dataemail);
            Mail::to($request->email)->send($mail);

            return response()->json([
                'status' => true,
                'message' => 'Berhasil daftar. Silahkan cek email inbox/spam untuk aktivasi akun'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Gagal. Mohon coba kembali!'
            ]);
        }
    }
    public function lupapassword()
    {
        $user = "";
        $data_param = [
            'user'
        ];  
        return view('auth/lupapassword')->with(compact($data_param));
    }
    public function aktivasi($id)
    {
        $iduser = Crypt::decrypt($id);
        $data['is_active'] = 1;
        $data['email_verified_at'] = Carbon::now()->toDateTimeString();
        $data['updated_by'] = $iduser;
        $data['updated_at'] = Carbon::now()->toDateTimeString();

        User::find($iduser)->update($data);

        return view('utama/Aktivasi');
    }
    public function getKabupaten(Request $request)
    {
        $kabupaten = MasterKabupaten::where('id_prov',$request->valProvinsi)->get(['id_kab AS id', 'nama as text'])->toArray();

        return response()->json([
            'status' => true,
            'kabupaten' => $kabupaten
        ]);
    }
    public function getKecamatan(Request $request)
    {
        $kecamatan = MasterKecamatan::where('id_kab',$request->valKab)->get(['id_kec AS id', 'nama as text'])->toArray();

        return response()->json([
            'status' => true,
            'kecamatan' => $kecamatan
        ]);
    }
    public function cekusername(Request $request)
    { 
        $cekUsername = User::where('username','=',$request->username)->get();
        $jumlah = count($cekUsername); 
        if ($jumlah>0) {
            return response()->json([
                'status' => false
            ]);
        }else{
            return response()->json([
                'status' => true
            ]);
        }
    }
    public function resetpassword(Request $request)
    {
        $random = Str::random(6);
        $user = User::where('username',$request->username)->first();
        if ($user) {
            $data['password'] = bcrypt($random);
            $data['updated_by'] = Auth::id();
            $data['updated_at'] = Carbon::now()->toDateTimeString();
            $updatedata = User::find($user->id)->update($data);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'User tidak ditemukan!'
            ]);
            dd('Error');
        }
        
        if($updatedata){
            $dataemail = [
                'nama'=> $user->name,
                'email'=> $request->username,
                'password' => $random
            ];
            $mail = new ResetPassword($dataemail);
            Mail::to($request->username)->send($mail);

            return response()->json([
                'status' => true,
                'message' => 'Berhasil reset password. Silahkan cek email inbox/spam'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Gagal. Mohon coba kembali!'
            ]);
        }
    }
    
}
