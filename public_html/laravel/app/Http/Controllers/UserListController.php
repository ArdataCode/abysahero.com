<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserLevel;
use App\Models\BatasMengerjakan;
use App\Models\MasterProvinsi;
use App\Models\UPaketSoalMst;
use App\Models\UPaketSoalKecermatanMst;
use App\Models\UPaketSoalKecermatanSoalMst;
use App\Models\UPaketSoalKecermatanSoalDtl;
use App\Models\Transaksi;
use App\Models\MemberDtl;
use Carbon\Carbon;
use File;
use Auth;
use Illuminate\Support\Facades\Crypt;


class UserListController extends Controller
{
    private $menubar;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $menu = "user";
        $submenu="user";
        $judul = "User";
        $provinsi = MasterProvinsi::all();
        $userlevel = auth()->user()->user_level;
        $userid = auth()->user()->id;
        $data = User::where('user_level','<>',1)->orderBy('user_level','asc')->orderBy('created_at','desc')->get();
        // if($userlevel==1){
        // }else{
        //     $data = User::where('user_level','=',4)->where('fk_affiliate',$userid)->orderBy('created_at','desc')->get();
        // }
        $data_param = [
            'submenu','menu','data','provinsi','judul'
        ];

        return view('master/userlist')->with(compact($data_param));

    }

    public function store(Request $request)
    {
        $cekemail = User::where('username',$request->email_add)->get();
        if (count($cekemail)>0) {
            return response()->json([
                'status' => false,
                'message' => 'Email sudah digunakan'
            ]);
            dd('Error');
        }
        $data['username'] = $request->email_add;
        $data['name'] = $request->name_add;
        $data['email'] = $request->email_add;
        $data['no_wa'] = $request->no_wa_add;
        $data['jenis_kelamin'] = $request->jenis_kelamin_add;
        $data['alamat'] = $request->alamat_add;
        $data['provinsi'] = $request->provinsi_add;
        $data['kabupaten'] = $request->kabupaten_add;
        $data['kecamatan'] = $request->kecamatan_add;
        $data['user_level'] = 2;
        $data['password'] = bcrypt($request->email_add); 
        $data['is_active'] = 1;
        $data['created_at'] = Carbon::now()->toDateTimeString();
        $data['updated_at'] = Carbon::now()->toDateTimeString();
        $createdata = User::create($data);
        if($createdata){
            return response()->json([
                'status' => true,
                'message' => 'Berhasil tambah user'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Gagal. Mohon coba kembali!'
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $data['name'] = $request->name[0];
        $data['no_wa'] = $request->no_wa[0];
        $data['jenis_kelamin'] = $request->jenis_kelamin[0];
        $data['alamat'] = $request->alamat[0];
        $data['provinsi'] = $request->provinsi[0];
        $data['kabupaten'] = $request->kabupaten[0];
        $data['kecamatan'] = $request->kecamatan[0];
        // $data['is_active'] = $request->is_active[0];
        $data['updated_by'] = Auth::id();
        $data['updated_at'] = Carbon::now()->toDateTimeString();

        User::find($id)->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diubah'
        ]);
    }

    public function destroy($id)
    {
        // $data['deleted_by'] = Auth::id();
        // $data['deleted_at'] = Carbon::now()->toDateTimeString();
        $updateData = User::find($id)->forceDelete();
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }

    public function reset(Request $request)
    {
        $user = User::find($request->iduser);
        $dataUpdate['password'] = bcrypt($user->username); 
        $updatePwdUser = User::find($request->iduser)->update($dataUpdate);
        if($updatePwdUser){
            return response()->json([
                'status' => true,
                'message' => 'Password '.$user->username.' berhasil direset'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Password gagal direset, silahkan coba lagi!'
            ]);
        }

    }
    public function lihathasilujian($id)
    {
        $menu = "user";
        $submenu="";
        $user = User::find($id);
        $data = UPaketSoalMst::where('fk_user_id',$id)->where('is_mengerjakan',0)->orderBy('created_at','desc')->get();
        $datakecermatan = UPaketSoalKecermatanMst::where('fk_user_id',$id)->where('is_mengerjakan',2)->orderBy('created_at','desc')->get();
        $data_param = [
            'submenu','menu','data','user','datakecermatan'
        ];

        return view('master/lihathasilujian')->with(compact($data_param));
    }

    public function lihatdetailhasil($id)
    {
        $id = Crypt::decrypt($id);
        $menu = "user";
        $submenu="";
        $upaketsoalmst = UPaketSoalMst::find($id);
        $user = User::find($upaketsoalmst->fk_user_id);
        $data_param = [
            'submenu','menu','upaketsoalmst','user'
        ];
        return view('master/detailhasil')->with(compact($data_param)); 
    }

    public function lihatdetailhasilkecermatan($id)
    {
        $id = Crypt::decrypt($id);
        $menu = "hasilujian";
        $submenu="";
        $upaketsoalmst = UPaketSoalKecermatanMst::find($id);
        $soalmst = UPaketSoalKecermatanSoalMst::where('fk_u_paket_soal_kecermatan_mst',$id)->get();
        
        $cekbenar = UPaketSoalKecermatanSoalDtl::where('fk_u_paket_soal_kecermatan_mst',$upaketsoalmst->id)->where('benar_salah',1)->get();
        $ceksalah = UPaketSoalKecermatanSoalDtl::where('fk_u_paket_soal_kecermatan_mst',$upaketsoalmst->id)->where('benar_salah',0)->get();
        $hitungsoaldtl = UPaketSoalKecermatanSoalDtl::where('fk_u_paket_soal_kecermatan_mst',$upaketsoalmst->id)->get();

        $data_param = [
            'submenu','menu','upaketsoalmst','soalmst','cekbenar','ceksalah','hitungsoaldtl'
        ];
        return view('master/detailhasilkecermatan')->with(compact($data_param)); 
        
    }

    public function lihattransaksi($id)
    {
        $id = Crypt::decrypt($id);
        $menu = "user";
        $submenu="";
        $user=User::find($id);
        $data = Transaksi::where('fk_user_id',$id)->orderBy('expired','desc')->get();
        $data_param = [
            'submenu','menu','data','user'
        ];
        return view('master/lihattransaksi')->with(compact($data_param)); 
    }
    public function updatestatuspembayaran(Request $request, $id)
    {
        if($request->status[0]==1){
            $transaksi = Transaksi::find($id);
            $memberdtl = MemberDtl::where('fk_master_member',$transaksi->fk_master_member_id)->get();
            $batas = $request->batas_mengerjakan[0];
            
            foreach($memberdtl as $key){
                // $idmember = MemberDtl::where('fk_paket_soal_mst',$key->fk_paket_soal_mst)->where('jenis',$key->jenis)->pluck('fk_master_member')->all();
                // $cekmax = Transaksi::whereIn('fk_master_member_id',$idmember)->where('fk_user_id',$transaksi->fk_user_id)->get();
                // dd($cekmax->max('batas_mengerjakan'));
                $x = BatasMengerjakan::where('jenis',$key->jenis)->where('fk_paket_soal_mst',$key->fk_paket_soal_mst)->where('fk_user_id',$transaksi->fk_user_id)->first();
                if($x){
                    $batasnewpengerjaan = $x->batas_mengerjakan + $batas;
                    if($batasnewpengerjaan>99999){
                        $data['batas_mengerjakan'] = 99999;
                    }else{
                        $data['batas_mengerjakan'] = $batasnewpengerjaan;
                    }
                    BatasMengerjakan::find($x->id)->update($data);
                }else{
                    $data['fk_user_id'] = $transaksi->fk_user_id;
                    $data['batas_mengerjakan'] = $batas;
                    $data['jenis'] = $key->jenis;
                    $data['fk_paket_soal_mst'] = $key->fk_paket_soal_mst;
                    $data['created_by'] =  Auth::id();
                    $data['created_at'] = Carbon::now()->toDateTimeString();
                    $data['updated_by'] = Auth::id();
                    $data['updated_at'] = Carbon::now()->toDateTimeString();
                    BatasMengerjakan::create($data);
                }
            }
        }
        $datatransaksi['status'] = $request->status[0];
        $datatransaksi['updated_by'] = Auth::id();
        $datatransaksi['updated_at'] = Carbon::now()->toDateTimeString();

        Transaksi::find($id)->update($datatransaksi);

        return response()->json([
            'status' => true,
            'message' => 'Status berhasil diperbarui'
        ]);
    }
}
