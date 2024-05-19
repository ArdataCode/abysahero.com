<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MasterMember;
use App\Models\MemberDtl;
use App\Models\PaketSoalMst;
use App\Models\PaketSoalKecermatanMst;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Crypt;

class MasterMemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $menu = 'master';
        $submenu='mastermember';
        $data = MasterMember::all();
        $data_param = [
            'menu','submenu','data'
        ];

        return view('master/mastermember')->with(compact($data_param));
    }

    public function store(Request $request)
    {
        $data['judul'] = $request->judul_add;
        $data['bg_color'] = $request->bg_color_add;
        $data['harga'] = $request->harga_add;
        $data['batas_mengerjakan'] = $request->batas_mengerjakan_add;
        $data['ket'] = $request->ket_add;
        $data['status'] = 1;
        $data['created_by'] = Auth::id();
        $data['created_at'] = Carbon::now()->toDateTimeString();
        $data['updated_by'] = Auth::id();
        $data['updated_at'] = Carbon::now()->toDateTimeString();
        $createdata = MasterMember::create($data);
        if($createdata){
            return response()->json([
                'status' => true,
                'message' => 'Berhasil menambahkan data'
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
        $data['judul'] = $request->judul[0];
        $data['bg_color'] = $request->bg_color[0];
        $data['harga'] = $request->harga[0];
        $data['batas_mengerjakan'] = $request->batas_mengerjakan[0];
        $data['ket'] = $request->ket[0];
        $data['status'] = $request->status[0];
        $data['updated_by'] = Auth::id();
        $data['updated_at'] = Carbon::now()->toDateTimeString();

        $updatedata = MasterMember::find($id)->update($data);

        if($updatedata){
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diubah'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Gagal. Mohon coba kembali!'
            ]);
        }
    }

    public function destroy($id)
    {
        $data['deleted_by'] = Auth::id();
        $data['deleted_at'] = Carbon::now()->toDateTimeString();
        $updateData = MemberDtl::where('fk_master_member',$id)->update($data);
        $updateData = MasterMember::find($id)->update($data);
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }

    public function indexdtl($idmst)
    {
        $menu = 'master';
        $submenu='mastermember';
        $datamst = MasterMember::find($idmst);
        // $arr = MemberDtl::where('fk_master_member',$idmst)->pluck('fk_paket_soal_mst')->all(); 
        // $paketsoal = PaketSoalMst::whereNotIn('id',$arr)->get();
        $data = MemberDtl::where('fk_master_member',$idmst)->orderBy('jenis','asc')->get();
        $data_param = [
            'menu','submenu','data','idmst','datamst'
        ];
        return view('master/memberdtl')->with(compact($data_param));
    }

    public function storedtl(Request $request)
    {
        $data['fk_paket_soal_mst'] = $request->fk_paket_soal_mst_add;
        $data['fk_master_member'] = $request->fk_master_member;
        $data['jenis'] = $request->jenis_soal_add;
        $data['created_by'] = Auth::id();
        $data['created_at'] = Carbon::now()->toDateTimeString();
        $data['updated_by'] = Auth::id();
        $data['updated_at'] = Carbon::now()->toDateTimeString();
        $createdata = MemberDtl::create($data);
        if($createdata){
            return response()->json([
                'status' => true,
                'message' => 'Berhasil menambahkan data'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Gagal. Mohon coba kembali!'
            ]);
        }
    }
    public function updatedtl(Request $request, $id)
    {
 
        $data['updated_by'] = Auth::id();
        $data['updated_at'] = Carbon::now()->toDateTimeString();

        $updatedata = MemberDtl::find($id)->update($data);

        if($updatedata){
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil diubah'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Gagal. Mohon coba kembali!'
            ]);
        }
    }
    public function destroydtl($id)
    {
        $data['deleted_by'] = Auth::id();
        $data['deleted_at'] = Carbon::now()->toDateTimeString();
        $updateData = MemberDtl::find($id)->update($data);
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }

    public function getPaketSoal(Request $request , $idmst)
    {
        $datamst = MasterMember::find($idmst);
        $arr = MemberDtl::where('fk_master_member',$idmst)->where('jenis',$request->val)->pluck('fk_paket_soal_mst')->all(); 
        if($request->val==1){
            $datapaket = PaketSoalMst::whereNotIn('id',$arr)->get(['id AS id', 'judul as text'])->toArray();
        }elseif($request->val==2){
            $datapaket = PaketSoalKecermatanMst::whereNotIn('id',$arr)->get(['id AS id', 'judul as text'])->toArray();
        }

        return response()->json([
            'status' => true,
            'datapaket' => $datapaket
        ]);
    }
}
