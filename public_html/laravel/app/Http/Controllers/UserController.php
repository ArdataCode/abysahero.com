<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MasterMember;
use App\Models\MemberDtl;
use App\Models\MasterSoal;
use App\Models\PaketSoalMst;
use App\Models\PaketSoalKtg;
use App\Models\PaketSoalDtl;
use App\Models\KategoriSoal;
use App\Models\UPaketSoalMst;
use App\Models\UPaketSoalDtl;
use App\Models\UPaketSoalKtg;
use App\Models\PaketSoalKecermatanMst;
use App\Models\UPaketSoalKecermatanMst;
use App\Models\PaketSoalKecermatanDtl;
use App\Models\MasterSoalKecermatan;
use App\Models\KategoriSoalKecermatan;
use App\Models\UPaketSoalKecermatanSoalMst;
use App\Models\DtlSoalKecermatan;
use App\Models\UPaketSoalKecermatanSoalDtl;
use Illuminate\Support\Facades\Redirect;
use App\Models\Transaksi;
use App\Models\BatasMengerjakan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Auth;
use Hash;
use File;
use DB;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index($id)
    {
        $id = Crypt::decrypt($id);
        $menu = "home";
        $submenu="";
        $member = MasterMember::find($id);
        $paket = MemberDtl::where('fk_master_member',$id)->get();
        $data_param = [
            'submenu','menu','member','paket'
        ];
        return view('user/paketdetail')->with(compact($data_param)); 
    }
    public function transaksi(){
        $menu = "transaksi";
        $submenu="";
        $data = Transaksi::where('fk_user_id',Auth::user()->id)->orderBy('created_at','desc')->get();
        $data_param = [
            'submenu','menu','data'
        ];
        return view('user/transaksi')->with(compact($data_param)); 
    }
    public function rankingpaket($id){
        $id = Crypt::decrypt($id);
        $menu = "kerjakansoal";
        $submenu="";
        $datapaket = PaketSoalMst::find($id);

        if(Auth::user()->user_level==1){
            $extend = "layouts.SkydashAdmin";
        }else{
            $extend = "layouts.Skydash";
        }

        $udatapaket =UPaketSoalMst::select('*', DB::raw('AVG(nilai) as totalnilai'))->where('fk_paket_soal_mst',$id)->where('is_mengerjakan',0)->groupBy('fk_user_id')->orderBy('totalnilai','desc')->get();
                 
        // $udatapaket = UPaketSoalMst::where('fk_paket_soal_mst',$id)->get();
        $data_param = [
            'submenu','menu','datapaket','udatapaket','extend'
        ];
        return view('user/rankingpaket')->with(compact($data_param)); 
    }
    public function rankingpaketkec($id){
        $id = Crypt::decrypt($id);
        $menu = "kerjakansoal";
        $submenu="";
        $datapaket = PaketSoalKecermatanMst::find($id);

        $udatapaket =UPaketSoalKecermatanMst::select('*', DB::raw('AVG(nilai) as totalnilai'))->where('fk_paket_soal_kecermatan_mst',$id)->where('is_mengerjakan',2)->groupBy('fk_user_id')->orderBy('totalnilai','desc')->get();

        if(Auth::user()->user_level==1){
            $extend = "layouts.SkydashAdmin";
        }else{
            $extend = "layouts.Skydash";
        }
                 
        // $udatapaket = UPaketSoalMst::where('fk_paket_soal_mst',$id)->get();
        $data_param = [
            'submenu','menu','datapaket','udatapaket','extend'
        ];
        return view('user/rankingpaketkec')->with(compact($data_param)); 
    }
    public function kerjakansoal()
    {
        $menu = "kerjakansoal";
        $submenu="";
        $paket = PaketSoalMst::all();
        $paketkecermatan = PaketSoalKecermatanMst::all();
        
        $ceksedangmengerjakan = UPaketSoalMst::where('fk_user_id',Auth::id())->where('is_mengerjakan',1)->first();
        if ($ceksedangmengerjakan) {
            
            $upaketsoalmst = UPaketSoalMst::find($ceksedangmengerjakan->id);
            $now = Carbon::now()->toDateTimeString();

            $data_param = [
                'submenu','menu','upaketsoalmst','now'
            ];
            return view('user/ujian')->with(compact($data_param));
            dd('Error'); 
        }
        $ceksedangmengerjakan = UPaketSoalKecermatanMst::where('fk_user_id',Auth::id())->where('is_mengerjakan',1)->first();
        if ($ceksedangmengerjakan) {
            
            $upaketsoalmst = UPaketSoalKecermatanMst::find($ceksedangmengerjakan->id);
            $upaketsoaldtl = UPaketSoalKecermatanSoalDtl::where('fk_u_paket_soal_kecermatan_mst',$ceksedangmengerjakan->id)->get();
            $soalmst = UPaketSoalKecermatanSoalMst::where('fk_u_paket_soal_kecermatan_mst',$ceksedangmengerjakan->id)->where('is_mengerjakan',1)->first();

            if(!$soalmst){
                $soalmst = UPaketSoalKecermatanSoalMst::where('fk_u_paket_soal_kecermatan_mst',$ceksedangmengerjakan->id)->where('is_mengerjakan',0)->first();
                if($soalmst){
                    $dataupdate['mulai'] = Carbon::now()->toDateTimeString();
                    $dataupdate['selesai'] = Carbon::now()->addSeconds($soalmst->waktu)->toDateTimeString();
                    $dataupdate['is_mengerjakan'] = 1;
                    UPaketSoalKecermatanSoalMst::find($soalmst->id)->update($dataupdate);
                    $soalmst = UPaketSoalKecermatanSoalMst::find($soalmst->id);
                }else{
                    $data_param = [
                        'submenu','menu','paket','paketkecermatan'
                    ];
                    return view('user/kerjakansoal')->with(compact($data_param)); 
                    dd('Error'); 
                }
            }

            $now = Carbon::now()->toDateTimeString();
                
            $data_param = [
                'submenu','menu','upaketsoalmst','soalmst','upaketsoaldtl','now'
            ];
            return view('user/ujiankecermatan')->with(compact($data_param));
            dd('Error'); 
        }
       
        $data_param = [
            'submenu','menu','paket','paketkecermatan'
        ];
        return view('user/kerjakansoal')->with(compact($data_param)); 
    }
    public function mulaiujian(Request $request,$id)
    {
        $idpaketsoalmst = Crypt::decrypt($request->id_paket_soal_mst[0]);

        $ceksedangmengerjakan = UPaketSoalMst::where('fk_user_id',Auth::id())->where('is_mengerjakan',1)->first();
        if ($ceksedangmengerjakan) {
            return response()->json([
                'status' => false,
                'message' => 'Harap refresh halaman terlebih dahulu'
            ]);
            dd('Error');
        }

        $cekmemberdtl = MemberDtl::where('fk_paket_soal_mst',$idpaketsoalmst)->where('jenis',1)->pluck('fk_master_member')->all();

        $cekbatasbaru = BatasMengerjakan::where('fk_user_id','=',Auth::user()->id)->where('jenis',1)->where('fk_paket_soal_mst',$idpaketsoalmst)->first();
        if($cekbatasbaru){
            $batas = $cekbatasbaru->batas_mengerjakan;
            $cekfree = MasterMember::whereIn('id',$cekmemberdtl)->where('harga','<=',0)->get();
            if(count($cekfree)>0){
                $batas = $batas + $cekfree->max('batas_mengerjakan');
            }
        }else{
            $ceksudahada = Transaksi::where('fk_user_id','=',Auth::user()->id)->whereIn('fk_master_member_id',$cekmemberdtl)->where('status',1)->first();
            if($ceksudahada){
               $databatas['batas_mengerjakan'] = $ceksudahada->max('batas_mengerjakan'); 
               $databatas['fk_user_id'] = Auth::user()->id; 
               $databatas['fk_paket_soal_mst'] = $idpaketsoalmst; 
               $databatas['jenis'] = 1; 
               $databatas['created_by'] = Auth::id();
               $databatas['created_at'] = Carbon::now()->toDateTimeString();
               $databatas['updated_by'] = Auth::id();
               $databatas['updated_at'] = Carbon::now()->toDateTimeString();
               BatasMengerjakan::create($databatas);
               $batas = $ceksudahada->max('batas_mengerjakan');

                $cekfree = MasterMember::whereIn('id',$cekmemberdtl)->where('harga','<=',0)->get();
                if(count($cekfree)>0){
                   $batas = $batas + $cekfree->max('batas_mengerjakan');
                }
            }else{
                $cekfree = MasterMember::whereIn('id',$cekmemberdtl)->where('harga','<=',0)->get();
                if(count($cekfree)>0){
                    $batas = $cekfree->max('batas_mengerjakan');
                }else{
                    return response()->json([
                        'status' => false,
                        'message' => 'Update member terlebih dahulu untuk mengerjakan paket soal ini!' 
                    ]);
                    dd('Error'); 
                }
            }
            
             
        }

        $cekberapakali = UPaketSoalMst::where('fk_user_id',Auth::id())->where('fk_paket_soal_mst',$idpaketsoalmst)->get();
        
        if($batas>=99999){

        }else{
            if(count($cekberapakali)>=$batas){
                return response()->json([
                    'status' => false,
                    'message' => 'Anda sudah mengerjakan sampai batas pengerjaan. Update member terlebih dahulu untuk mengerjakan paket soal ini!' 
                ]);
                dd('Error');  
            }
        }

        $paketsoalmst = PaketSoalMst::find($idpaketsoalmst);
        $paketsoalktg = PaketSoalKtg::where('fk_paket_soal_mst',$idpaketsoalmst)->get();
   
        if($paketsoalmst){
            $data1['fk_user_id'] = Auth::id();
            $data1['fk_paket_soal_mst'] = $paketsoalmst->id;
            $data1['judul'] = $paketsoalmst->judul;
            $data1['kkm'] = $paketsoalmst->kkm;
            $data1['jenis_penilaian'] = $paketsoalmst->jenis_penilaian;
            $data1['nilai'] = 0;
            $data1['waktu'] = $paketsoalmst->waktu;
            $data1['mulai'] = Carbon::now()->toDateTimeString();
            $data1['selesai'] = Carbon::now()->addMinutes($paketsoalmst->waktu)->toDateTimeString();
            $data1['is_mengerjakan'] = 1;
            $data1['total_soal'] = $paketsoalmst->total_soal;
            $data1['ket'] = $paketsoalmst->ket;
            $data1['created_by'] = Auth::id();
            $data1['created_at'] = Carbon::now()->toDateTimeString();
            $data1['updated_by'] = Auth::id();
            $data1['updated_at'] = Carbon::now()->toDateTimeString();
            $upaketsoalmst = UPaketSoalMst::create($data1);
            $nomor = 1;
            foreach ($paketsoalktg as $key) {
                $data2['fk_user_id'] = Auth::id();
                $data2['fk_u_paket_soal_mst'] = $upaketsoalmst->id;
                $ktgsoal = KategoriSoal::find($key->fk_kategori_soal);
                $data2['judul'] = $ktgsoal->judul;
                $data2['ket'] = $ktgsoal->ket;
                $data2['kkm'] = $key->kkm;
                $data2['jumlah_soal'] = $key->jumlah_soal;
                $data2['created_by'] = Auth::id();
                $data2['created_at'] = Carbon::now()->toDateTimeString();
                $data2['updated_by'] = Auth::id();
                $data2['updated_at'] = Carbon::now()->toDateTimeString(); 
                $upaketsoalktg = UPaketSoalKtg::create($data2);
                
                $paketsoaldtl = PaketSoalDtl::where('fk_paket_soal_mst',$idpaketsoalmst)->where('fk_paket_soal_ktg',$key->id)->inRandomOrder()->get();

                foreach ($paketsoaldtl as $key2) {
                    $data3['fk_user_id'] = Auth::id();
                    $data3['fk_u_paket_soal_ktg'] = $upaketsoalktg->id;
                    $data3['fk_u_paket_soal_mst'] = $upaketsoalmst->id; 
                    $mastersoal = MasterSoal::find($key2->fk_master_soal);
                    $data3['no_soal'] = $nomor;
                    $data3['soal'] = $mastersoal->soal;
                    $data3['a'] = $mastersoal->a;
                    $data3['b'] = $mastersoal->b;
                    $data3['c'] = $mastersoal->c;
                    $data3['d'] = $mastersoal->d;
                    $data3['e'] = $mastersoal->e;
                    $data3['point_a'] = $mastersoal->point_a;
                    $data3['point_b'] = $mastersoal->point_b;
                    $data3['point_c'] = $mastersoal->point_c;
                    $data3['point_d'] = $mastersoal->point_d;
                    $data3['point_e'] = $mastersoal->point_e;
                    $maxpoint = max($mastersoal->point_a,$mastersoal->point_b,$mastersoal->point_c,$mastersoal->point_d,$mastersoal->point_e);
                    $data3['max_point'] = $maxpoint;
                    $data3['jawaban'] = $mastersoal->jawaban;
                    $data3['pembahasan'] = $mastersoal->pembahasan;
                    $data3['created_by'] = Auth::id();
                    $data3['created_at'] = Carbon::now()->toDateTimeString();
                    $data3['updated_by'] = Auth::id();
                    $data3['updated_at'] = Carbon::now()->toDateTimeString();
                    $upaketsoaldtl = UPaketSoalDtl::create($data3);
                    $nomor++;
                }
            }
            return response()->json([
                'status' => true,
                'id' => Crypt::encrypt($upaketsoalmst->id),
                'message' => 'Halaman akan diarahkan otomatis, mohon tunggu...'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }
    public function mulaiujiankecermatan(Request $request,$id)
    {
        $idpaketsoalmst = Crypt::decrypt($request->id_paket_soal_mst[0]);
        $ceksedangmengerjakan = UPaketSoalKecermatanMst::where('fk_user_id',Auth::id())->where('is_mengerjakan',1)->first();
        if ($ceksedangmengerjakan) {
            return response()->json([
                'status' => false,
                'message' => 'Harap refresh halaman terlebih dahulu'
            ]);
            dd('Error');
        }

        $cekmemberdtl = MemberDtl::where('fk_paket_soal_mst',$idpaketsoalmst)->where('jenis',2)->pluck('fk_master_member')->all();

        $cekbatasbaru = BatasMengerjakan::where('fk_user_id','=',Auth::user()->id)->where('jenis',2)->where('fk_paket_soal_mst',$idpaketsoalmst)->first();
        if($cekbatasbaru){
            $batas = $cekbatasbaru->batas_mengerjakan;

            $cekfree = MasterMember::whereIn('id',$cekmemberdtl)->where('harga','<=',0)->get();
            if(count($cekfree)>0){
                $batas = $batas + $cekfree->max('batas_mengerjakan');
            }
        }else{
            $ceksudahada = Transaksi::where('fk_user_id','=',Auth::user()->id)->whereIn('fk_master_member_id',$cekmemberdtl)->where('status',1)->first();
            if($ceksudahada){
               $databatas['batas_mengerjakan'] = $ceksudahada->max('batas_mengerjakan'); 
               $databatas['fk_user_id'] = Auth::user()->id; 
               $databatas['fk_paket_soal_mst'] = $idpaketsoalmst; 
               $databatas['jenis'] = 2; 
               $databatas['created_by'] = Auth::id();
               $databatas['created_at'] = Carbon::now()->toDateTimeString();
               $databatas['updated_by'] = Auth::id();
               $databatas['updated_at'] = Carbon::now()->toDateTimeString();
               BatasMengerjakan::create($databatas);
               $batas = $ceksudahada->max('batas_mengerjakan');

                $cekfree = MasterMember::whereIn('id',$cekmemberdtl)->where('harga','<=',0)->get();
                if(count($cekfree)>0){
                    $batas = $batas + $cekfree->max('batas_mengerjakan');
                }
            }else{
                $cekfree = MasterMember::whereIn('id',$cekmemberdtl)->where('harga','<=',0)->get();
                if(count($cekfree)>0){
                    $batas = $cekfree->max('batas_mengerjakan');
                }else{
                    return response()->json([
                        'status' => false,
                        'message' => 'Update member terlebih dahulu untuk mengerjakan paket soal ini!' 
                    ]);
                    dd('Error');  
                }
            }
        }
        

        $cekberapakali = UPaketSoalKecermatanMst::where('fk_user_id',Auth::id())->where('fk_paket_soal_kecermatan_mst',$idpaketsoalmst)->get();
       
        if($batas>=99999){

        }else{
            if(count($cekberapakali)>=$batas){
                return response()->json([
                    'status' => false,
                    'message' => 'Anda sudah mengerjakan sampai batas pengerjaan. Update member terlebih dahulu untuk mengerjakan paket soal ini!' 
                ]);
                dd('Error');  
            }
        }

        $paketsoalmst = PaketSoalKecermatanMst::find($idpaketsoalmst);
        $paketsoaldtl = PaketSoalKecermatanDtl::where('fk_paket_soal_kecermatan_mst',$idpaketsoalmst)->inRandomOrder()->get();
    
        if($paketsoalmst){
            $data1['fk_user_id'] = Auth::id();
            $data1['fk_paket_soal_kecermatan_mst'] = $paketsoalmst->id;
            $data1['judul'] = $paketsoalmst->judul;
            $data1['kkm'] = $paketsoalmst->kkm;
            $data1['nilai'] = 0;
            $data1['mulai'] = Carbon::now()->toDateTimeString();
            $data1['is_mengerjakan'] = 1;
            $data1['total_soal'] = $paketsoalmst->total_soal;
            $data1['ket'] = $paketsoalmst->ket;
            $data1['created_by'] = Auth::id();
            $data1['created_at'] = Carbon::now()->toDateTimeString();
            $data1['updated_by'] = Auth::id();
            $data1['updated_at'] = Carbon::now()->toDateTimeString();
            $upaketsoalmst = UPaketSoalKecermatanMst::create($data1);

            foreach ($paketsoaldtl as $key) {
                $mastersoal = MasterSoalKecermatan::find($key->fk_master_soal_kecermatan);
                $dtlsoal = DtlSoalKecermatan::where('fk_master_soal_kecermatan',$key->fk_master_soal_kecermatan)->inRandomOrder()->get();

                $ktgsoal = KategoriSoalKecermatan::find($mastersoal->fk_kategori_soal_kecermatan);

                $data2['fk_u_paket_soal_kecermatan_mst'] = $upaketsoalmst->id;
                $data2['fk_kategori_soal_kecermatan'] = $key->fk_kategori_soal_kecermatan;
                $data2['judul_kategori'] = $ktgsoal->judul;
                $data2['karakter'] = $mastersoal->karakter;
                $data2['kiasan'] = $mastersoal->kiasan;
                $data2['waktu'] = $mastersoal->waktu;
                $data2['created_by'] = Auth::id();
                $data2['created_at'] = Carbon::now()->toDateTimeString();
                $data2['updated_by'] = Auth::id();
                $data2['updated_at'] = Carbon::now()->toDateTimeString();
                $usoalmst = UPaketSoalKecermatanSoalMst::create($data2);

                $detik_mulai=$mastersoal->waktu;
                foreach($dtlsoal as $key2){
                    $data3['fk_u_paket_soal_kecermatan_mst'] = $upaketsoalmst->id;
                    $data3['fk_u_paket_soal_kecermatan_soal_mst'] = $usoalmst->id;
                    $data3['soal'] = $key2->soal;
                    $data3['jawaban'] = $key2->jawaban;
                    $data3['waktu'] = $key2->waktu;
                    $data3['detik_mulai'] = $detik_mulai;
                    $detik_mulai = $detik_mulai - $key2->waktu;
                    $data3['detik_akhir'] = $detik_mulai+1;
                    $data3['created_by'] = Auth::id();
                    $data3['created_at'] = Carbon::now()->toDateTimeString();
                    $data3['updated_by'] = Auth::id();
                    $data3['updated_at'] = Carbon::now()->toDateTimeString();
                    $usoaldtl = UPaketSoalKecermatanSoalDtl::create($data3);
                }
            }
            
            return response()->json([
                'status' => true,
                'id' => Crypt::encrypt($upaketsoalmst->id),
                'message' => 'Halaman akan diarahkan otomatis, mohon tunggu...'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }

    public function ujian($id)
    {
        $idupaketsoalmst = Crypt::decrypt($id);
        $menu = "kerjakansoal";
        $submenu="";
        $upaketsoalmst = UPaketSoalMst::find($idupaketsoalmst);
        $now = Carbon::now()->toDateTimeString();

        if ($upaketsoalmst->is_mengerjakan==0) {
            return Redirect::to(url('hasilujian')); 
        }else{
            $data_param = [
                'submenu','menu','upaketsoalmst','now'
            ];
            return view('user/ujian')->with(compact($data_param)); 
        }
    }
    // public function ujiankecermatan($id)
    // {
    //     $idupaketsoalmst = Crypt::decrypt($id);
    //     $menu = "kerjakansoal";
    //     $submenu="";
    //     $upaketsoalmst = UPaketSoalKecermatanMst::find($idupaketsoalmst);

    //     if ($upaketsoalmst->is_mengerjakan==0) {
    //         return Redirect::to(url('hasilujian')); 
    //     }else{
    //         $data_param = [
    //             'submenu','menu','upaketsoalmst'
    //         ];
    //         return view('user/ujiankecermatan')->with(compact($data_param)); 
    //     }
    // }
    public function updatejawaban(Request $request)
    {
        $upaketsoaldtl = UPaketSoalDtl::find($request->idpaketdl);
        $cekismengerjakan = UPaketSoalMst::find($upaketsoaldtl->fk_u_paket_soal_mst);
        if($cekismengerjakan->is_mengerjakan==0){
            return response()->json([
                'status' => false,
                'message' => 'Tidak dapat menyimpan jawaban karena ujian telah selesai'
            ]);
            dd('Error');
        }
        if($cekismengerjakan->jenis_penilaian==1){
            $data['jawaban_user'] = $request->jawaban;
            
            if (stripos($upaketsoaldtl->jawaban, $request->jawaban) !== FALSE) {
                $data['benar_salah'] = 1;
                $data['cek_benar'] = 1;
            }else{
                $data['benar_salah'] = 0;
                $data['cek_benar'] = 0;
            }
            $updateJawaban = UPaketSoalDtl::find($request->idpaketdl)->update($data);
    
            // $upaketsoalktg = UPaketSoalKtg::where('fk_u_paket_soal_mst',$upaketsoaldtl->fk_u_paket_soal_mst)->get();
            // foreach ($upaketsoalktg as $key) {
            //     $jumlahbenar = UPaketSoalDtl::where('fk_u_paket_soal_ktg',$key->id)->where('fk_u_paket_soal_mst',$upaketsoaldtl->fk_u_paket_soal_mst)->where('benar_salah',1)->get();
                
            //     if($key->jumlah_soal==0){
            //         $nilai = 0;
            //     }else{
            //         $nilai = (count($jumlahbenar)/$key->jumlah_soal)*100;
            //     }
    
            //     $datanilai['nilai'] = (int)$nilai;
            //     if($datanilai['nilai']>100){
            //         $datanilai['nilai']=100;
            //     }
            //     UPaketSoalKtg::find($key->id)->update($datanilai);
            // }
            // $totalsoal = UPaketSoalDtl::where('fk_u_paket_soal_mst',$upaketsoaldtl->fk_u_paket_soal_mst)->get();
            // $totalbenar = UPaketSoalDtl::where('fk_u_paket_soal_mst',$upaketsoaldtl->fk_u_paket_soal_mst)->where('benar_salah',1)->get();
            // $nilaiakhir = count($totalbenar) / count($totalsoal) * 100;
            // $datanilaiakhir['nilai'] = (int) $nilaiakhir;
            // UPaketSoalMst::find($upaketsoaldtl->fk_u_paket_soal_mst)->update($datanilaiakhir);
        }elseif($cekismengerjakan->jenis_penilaian==2){
            $databenarsalah = 0;
            $getpoint = UPaketSoalDtl::find($request->idpaketdl);
            foreach(explode(',', $request->jawaban) as $datadtl){
                $datapoint = "point_".$datadtl;
                $databenarsalah = $databenarsalah + $getpoint->$datapoint;
            }

            if (stripos($upaketsoaldtl->jawaban, $request->jawaban) !== FALSE) {
                $data['cek_benar'] = 1;
            }else{
                $data['cek_benar'] = 0;
            }

            $data['jawaban_user'] = $request->jawaban;
            $data['benar_salah'] = $databenarsalah;
            
            $updateJawaban = UPaketSoalDtl::find($request->idpaketdl)->update($data);
            
            // $upaketsoalktg = UPaketSoalKtg::where('fk_u_paket_soal_mst',$upaketsoaldtl->fk_u_paket_soal_mst)->get();
        
            // foreach ($upaketsoalktg as $key) {
            //     $jumlahbenar = UPaketSoalDtl::where('fk_u_paket_soal_ktg',$key->id)->where('fk_u_paket_soal_mst',$upaketsoaldtl->fk_u_paket_soal_mst)->get();
            //     if(count($jumlahbenar)>0){
            //         $jumlahpoint = $jumlahbenar->sum("benar_salah");
            //         $maxhpoint = $jumlahbenar->sum("max_point");

            //         if($maxhpoint==0){
            //             $nilaipoint = 0;
            //         }else{
            //             $nilaipoint = $jumlahpoint/$maxhpoint*100;
            //         }
    
            //         $nilaipoint = (int)$nilaipoint;
            //         if($nilaipoint<0){
            //             $nilaipoint = 0;
            //         }
            //         $datanilai['nilai'] = $nilaipoint;
            //         $datanilai['point'] = $jumlahbenar->sum('benar_salah');
    
            //         UPaketSoalKtg::find($key->id)->update($datanilai);
            //     }
            // }

            // $totalbenar = UPaketSoalDtl::where('fk_u_paket_soal_mst',$upaketsoaldtl->fk_u_paket_soal_mst)->get();
            // $pointtotalbenar = $totalbenar->sum('benar_salah'); 
            
            // $pointmax = $totalbenar->sum('max_point');
            // if($pointmax==0){
            //     $nilai_point = 0;
            // }else{
            //     $nilai_point = $pointtotalbenar/$pointmax*100;
            // }
            // $nilai_point = (int) $nilai_point;
            
            // if ($nilai_point<0) {
            //     $nilai_point = 0;
            // }
            // $datanilaiakhir['nilai'] = $nilai_point;
            // $datanilaiakhir['point'] = $totalbenar->sum('benar_salah'); 
            // UPaketSoalMst::find($upaketsoaldtl->fk_u_paket_soal_mst)->update($datanilaiakhir);
            
        }
        
        if ($updateJawaban) {
            return response()->json([
                'status' => true,
                'message' => 'Berhasil simpan jawaban'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Gagal simpan, harap coba lagi'
            ]);
        }
    }

    public function updatejawabankecermatan(Request $request)
    {
        $upaketsoaldtl = UPaketSoalKecermatanSoalDtl::find($request->idpaketdl);
        $cekismengerjakan = UPaketSoalKecermatanMst::find($upaketsoaldtl->fk_u_paket_soal_kecermatan_mst);

        if($cekismengerjakan->is_mengerjakan!=1){
            return response()->json([
                'status' => false,
                'message' => 'Tidak dapat menyimpan jawaban karena ujian telah selesai'
            ]);
            dd('Error');
        }
        $data['jawaban_user'] = $request->jawaban;

        if ($upaketsoaldtl->jawaban == $request->jawaban) {
            $data['benar_salah'] = 1;
        }else{
            $data['benar_salah'] = 0;
        }
        $updateJawaban = UPaketSoalKecermatanSoalDtl::find($request->idpaketdl)->update($data);

        $jumlahsoal = UPaketSoalKecermatanSoalDtl::where('fk_u_paket_soal_kecermatan_mst',$upaketsoaldtl->fk_u_paket_soal_kecermatan_mst)->get();
        $jumlahsoal = count($jumlahsoal);
        $jumlahbenar = UPaketSoalKecermatanSoalDtl::where('fk_u_paket_soal_kecermatan_mst',$upaketsoaldtl->fk_u_paket_soal_kecermatan_mst)->where('benar_salah',1)->get();
        $jumlahbenar = count($jumlahbenar);

        if($jumlahsoal>0){
            $nilai = $jumlahbenar/$jumlahsoal*100;
        }else{
            $nilai = 0;
        }

        $datanilai['nilai'] = (int)$nilai;
        UPaketSoalKecermatanMst::find($upaketsoaldtl->fk_u_paket_soal_kecermatan_mst)->update($datanilai);



        // $upaketsoalktg = UPaketSoalKtg::where('fk_u_paket_soal_mst',$upaketsoaldtl->fk_u_paket_soal_mst)->get();
        // foreach ($upaketsoalktg as $key) {
        //     $jumlahbenar = UPaketSoalDtl::where('fk_u_paket_soal_ktg',$key->id)->where('fk_u_paket_soal_mst',$upaketsoaldtl->fk_u_paket_soal_mst)->where('benar_salah',1)->get();
            
        //     if($key->jumlah_soal==0){
        //         $nilai = 0;
        //     }else{
        //         $nilai = (count($jumlahbenar)/$key->jumlah_soal)*100;
        //     }

        //     $datanilai['nilai'] = (int)$nilai;
        //     if($datanilai['nilai']>100){
        //         $datanilai['nilai']=100;
        //     }
        //     UPaketSoalKtg::find($key->id)->update($datanilai);
        // }
        // $totalsoal = UPaketSoalDtl::where('fk_u_paket_soal_mst',$upaketsoaldtl->fk_u_paket_soal_mst)->get();
        // $totalbenar = UPaketSoalDtl::where('fk_u_paket_soal_mst',$upaketsoaldtl->fk_u_paket_soal_mst)->where('benar_salah',1)->get();
        // $nilaiakhir = count($totalbenar) / count($totalsoal) * 100;
        // $datanilaiakhir['nilai'] = (int) $nilaiakhir;
        // UPaketSoalMst::find($upaketsoaldtl->fk_u_paket_soal_mst)->update($datanilaiakhir);
        
        if ($updateJawaban) {
            return response()->json([
                'status' => true,
                'message' => 'Berhasil simpan jawaban'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Gagal simpan, harap coba lagi'
            ]);
        }
    }
    public function hasilujian(){
        $menu = "hasilujian";
        $submenu="";
        $status = 1;
        $cekaktif = MemberDtl::whereHas('master_member_r', function ($q) use ($status) {
            $q->where('status', $status);
        })->pluck('fk_paket_soal_mst')->all();
        $data = UPaketSoalMst::whereIn('fk_paket_soal_mst',$cekaktif)->where('fk_user_id',Auth::user()->id)->where('is_mengerjakan',0)->orderBy('created_at','desc')->get();
        $datakecermatan = UPaketSoalKecermatanMst::where('fk_user_id',Auth::user()->id)->where('is_mengerjakan',2)->orderBy('created_at','desc')->get();
        $data_param = [
            'submenu','menu','data','datakecermatan'
        ];
        return view('user/hasilujian')->with(compact($data_param)); 
    }
    public function selesaiujian(Request $request)
    {
        $id = Crypt::decrypt($request->idpaketmst);

        $dataupaketsoalmst = UPaketSoalMst::find($id);

        if($dataupaketsoalmst->jenis_penilaian==1){
            $upaketsoalktg = UPaketSoalKtg::where('fk_u_paket_soal_mst',$id)->get();
            foreach ($upaketsoalktg as $key) {
                $jumlahbenar = UPaketSoalDtl::where('fk_u_paket_soal_ktg',$key->id)->where('fk_u_paket_soal_mst',$id)->where('benar_salah',1)->get();
                
                if($key->jumlah_soal==0){
                    $nilai = 0;
                }else{
                    $nilai = (count($jumlahbenar)/$key->jumlah_soal)*100;
                }
    
                $datanilai['nilai'] = (int)$nilai;
                if($datanilai['nilai']>100){
                    $datanilai['nilai']=100;
                }
                UPaketSoalKtg::find($key->id)->update($datanilai);
            }
            $totalsoal = UPaketSoalDtl::where('fk_u_paket_soal_mst',$id)->get();
            $totalbenar = UPaketSoalDtl::where('fk_u_paket_soal_mst',$id)->where('benar_salah',1)->get();
            $nilaiakhir = count($totalbenar) / count($totalsoal) * 100;
            $datanilaiakhir['nilai'] = (int) $nilaiakhir;
            UPaketSoalMst::find($id)->update($datanilaiakhir);
        }elseif($dataupaketsoalmst->jenis_penilaian==2){
            $upaketsoalktg = UPaketSoalKtg::where('fk_u_paket_soal_mst',$id)->get();
        
            foreach ($upaketsoalktg as $key) {
                $jumlahbenar = UPaketSoalDtl::where('fk_u_paket_soal_ktg',$key->id)->where('fk_u_paket_soal_mst',$id)->get();
                if(count($jumlahbenar)>0){
                    $jumlahpoint = $jumlahbenar->sum("benar_salah");
                    $maxhpoint = $jumlahbenar->sum("max_point");

                    if($maxhpoint==0){
                        $nilaipoint = 0;
                    }else{
                        $nilaipoint = $jumlahpoint/$maxhpoint*100;
                    }
    
                    $nilaipoint = (int)$nilaipoint;
                    if($nilaipoint<0){
                        $nilaipoint = 0;
                    }
                    $datanilai['nilai'] = $nilaipoint;
                    $datanilai['point'] = $jumlahbenar->sum('benar_salah');
    
                    UPaketSoalKtg::find($key->id)->update($datanilai);
                }
            }

            $totalbenar = UPaketSoalDtl::where('fk_u_paket_soal_mst',$id)->get();
            $pointtotalbenar = $totalbenar->sum('benar_salah'); 
            
            $pointmax = $totalbenar->sum('max_point');
            if($pointmax==0){
                $nilai_point = 0;
            }else{
                // $nilai_point = $pointtotalbenar/$pointmax*100; Persentase Rata-rata
                $nilai_point = $pointtotalbenar/$dataupaketsoalmst->total_soal;
            }
            $nilai_point = (int) $nilai_point;
            
            if ($nilai_point<0) {
                $nilai_point = 0;
            }
            $datanilaiakhir['nilai'] = $nilai_point;
            $datanilaiakhir['point'] = $totalbenar->sum('benar_salah'); 
            UPaketSoalMst::find($id)->update($datanilaiakhir);
            
        }

        $data['is_mengerjakan'] = 0;
        $updateselesai = UPaketSoalMst::find($id)->update($data);
        
        if ($updateselesai) {
            return response()->json([
                'status' => true,
                'message' => 'Jawaban telah tersimpan. Ujian selesai!'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Gagal simpan, harap coba lagi'
            ]);
        }
    }

    public function selesaiujiankecermatan(Request $request)
    {
        $id = Crypt::decrypt($request->idsoalmst);
        $data['is_mengerjakan'] = 2;
        $updateselesai = UPaketSoalKecermatanSoalMst::find($id)->update($data);
        $cekdata = UPaketSoalKecermatanSoalMst::find($id);
        $idpaketmst = $cekdata->fk_u_paket_soal_kecermatan_mst;
        $cekdataterakhir = UPaketSoalKecermatanSoalMst::where('fk_u_paket_soal_kecermatan_mst',$idpaketmst)->where('is_mengerjakan',0)->get();
        $jumlah = count($cekdataterakhir);
        if($jumlah>0){
            $isterakhir = 'tidak';
        }else{
            $isterakhir = 'ya';
            $data['is_mengerjakan'] = 2;
            $data['selesai'] = Carbon::now()->toDateTimeString();

            $cekdataterakhir = UPaketSoalKecermatanMst::find($idpaketmst)->update($data);
        }
        if ($updateselesai) {
            return response()->json([
                'status' => true,
                'isterakhir'=>$isterakhir,
                'message' => 'Jawaban telah tersimpan. Ujian selesai!'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Gagal memuat soal, harap coba lagi!'
            ]);
        }
    }

    public function selesaiujiankecermatanfix(Request $request)
    {
        $id = Crypt::decrypt($request->idpaketmst);
        $datamst['is_mengerjakan'] = 2;
        $datamst['selesai'] = Carbon::now()->toDateTimeString();
        $datasoal['is_mengerjakan'] = 2;
        $upaketsoalmst = UPaketSoalKecermatanMst::find($id)->update($datamst);
        $upaketsoalmstsoal = UPaketSoalKecermatanSoalMst::where('fk_u_paket_soal_kecermatan_mst',$id)->update($datasoal);

        if ($upaketsoalmst) {
            return response()->json([
                'status' => true,
                'message' => 'Jawaban telah tersimpan. Ujian selesai!'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Gagal, harap coba lagi!'
            ]);
        }
    }

    public function detailhasil($id)
    {
        $id = Crypt::decrypt($id);
        $menu = "hasilujian";
        $submenu="";
        $upaketsoalmst = UPaketSoalMst::find($id);

        $cekbenar = UPaketSoalDtl::where('fk_u_paket_soal_mst',$upaketsoalmst->id)->where('cek_benar',1)->get();
        $ceksalah = UPaketSoalDtl::where('fk_u_paket_soal_mst',$upaketsoalmst->id)->where('cek_benar',0)->get();

        if(Auth::user()->user_level==1){
            $extend = "layouts.SkydashAdmin";
        }else{
            $extend = "layouts.Skydash";
        }

        if ($upaketsoalmst->is_mengerjakan==1) {
            return Redirect::to(url('hasilujian')); 
        }else{
            $data_param = [
                'submenu','menu','upaketsoalmst','cekbenar','ceksalah','extend'
            ];
            return view('user/detailhasil')->with(compact($data_param)); 
        }
    }

    public function detailhasilkecermatan($id)
    {
        $id = Crypt::decrypt($id);
        $menu = "hasilujian";
        $submenu="";
        $upaketsoalmst = UPaketSoalKecermatanMst::find($id);
        $soalmst = UPaketSoalKecermatanSoalMst::where('fk_u_paket_soal_kecermatan_mst',$id)->get();
        
        $cekbenar = UPaketSoalKecermatanSoalDtl::where('fk_u_paket_soal_kecermatan_mst',$upaketsoalmst->id)->where('benar_salah',">=",1)->get();
        $ceksalah = UPaketSoalKecermatanSoalDtl::where('fk_u_paket_soal_kecermatan_mst',$upaketsoalmst->id)->where('benar_salah',0)->get();
        $hitungsoaldtl = UPaketSoalKecermatanSoalDtl::where('fk_u_paket_soal_kecermatan_mst',$upaketsoalmst->id)->get();

        if ($upaketsoalmst->is_mengerjakan==1) {
            return Redirect::to(url('hasilujian')); 
        }else{
            $data_param = [
                'submenu','menu','upaketsoalmst','soalmst','cekbenar','ceksalah','hitungsoaldtl'
            ];
            return view('user/detailhasilkecermatan')->with(compact($data_param)); 
        }
    }
}
