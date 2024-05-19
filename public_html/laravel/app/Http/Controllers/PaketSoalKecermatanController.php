<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\KategoriSoalKecermatan;
use App\Models\PaketSoalKecermatanMst;
use App\Models\PaketSoalKecermatanDtl;
use App\Models\MasterSoalKecermatan;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Crypt;

class PaketSoalKecermatanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $menu = 'master';
        $submenu='paketsoalkecermatan';
        $data = PaketSoalKecermatanMst::all();
        $data_param = [
            'menu','submenu','data'
        ];

        return view('master/paketsoalkecermatan')->with(compact($data_param));
    }

    public function store(Request $request)
    {
        $data['judul'] = $request->judul_add;
        $data['waktu'] = 0;
        $data['kkm'] = $request->kkm_add;
        $data['ket'] = $request->ket_add;
        $data['created_by'] = Auth::id();
        $data['created_at'] = Carbon::now()->toDateTimeString();
        $data['updated_by'] = Auth::id();
        $data['updated_at'] = Carbon::now()->toDateTimeString();
        $createdata = PaketSoalKecermatanMst::create($data);
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
        $data['kkm'] = $request->kkm[0];
        $data['ket'] = $request->ket[0];
        $data['updated_by'] = Auth::id();
        $data['updated_at'] = Carbon::now()->toDateTimeString();

        $updatedata = PaketSoalKecermatanMst::find($id)->update($data);

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
        $updateData = PaketSoalKecermatanMst::find($id)->update($data);
        $updateData = PaketSoalKecermatanDtl::where('fk_paket_soal_kecermatan_mst',$id)->update($data);
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }

    public function indexdtl($idpaketsoal)
    {
        $menu = 'master';
        $submenu='paketsoalkecermatan';
        $data = PaketSoalKecermatanMst::find($idpaketsoal); 
        $mastersoal = MasterSoalKecermatan::orderBy('fk_kategori_soal_kecermatan','asc')->get();
        $data_param = [
            'menu','submenu','data','mastersoal'
        ];
        return view('master/paketsoalkecermatandtl')->with(compact($data_param));
    }

    public function storedtl(Request $request ,$idmst)
    {
        PaketSoalKecermatanDtl::where('fk_paket_soal_kecermatan_mst',$idmst)->forceDelete();
        if($request->id_master_soal){
            foreach ($request->id_master_soal as $key) {
                $data['fk_master_soal_kecermatan'] = $key;
                $cekktg = MasterSoalKecermatan::find($key);
                $data['fk_kategori_soal_kecermatan'] = $cekktg->fk_kategori_soal_kecermatan;
                $data['fk_paket_soal_kecermatan_mst'] = $idmst;
                $data['created_by'] = Auth::id();
                $data['created_at'] = Carbon::now()->toDateTimeString();
                $data['updated_by'] = Auth::id();
                $data['updated_at'] = Carbon::now()->toDateTimeString();
                PaketSoalKecermatanDtl::create($data);
            }

            $updatedatamst['total_soal'] = count(PaketSoalKecermatanDtl::where('fk_paket_soal_kecermatan_mst', $idmst)->get());
            PaketSoalKecermatanMst::find($idmst)->update($updatedatamst);

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil disimpan'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Soal belum dipilih'
            ]);
        }
    }
}
