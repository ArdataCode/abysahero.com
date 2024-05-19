<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\KategoriSoal;
use App\Models\PaketSoalMst;
use App\Models\PaketSoalDtl;
use App\Models\UPaketSoalDtl;
use App\Models\UPaketSoalMst;
use App\Models\PaketSoalKtg;
use App\Models\MasterSoal;
use App\Exports\NilaiExport;
use App\Exports\DataNilaiExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Crypt;

class PaketSoalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $menu = 'master';
        $submenu='paketsoal';
        $data = PaketSoalMst::all();
        $data_param = [
            'menu','submenu','data'
        ];

        return view('master/paketsoal')->with(compact($data_param));
    }

    public function store(Request $request)
    {
        $data['judul'] = $request->judul_add;
        $data['waktu'] = $request->waktu_add;
        $data['jenis_penilaian'] = $request->jenis_penilaian_add;
        $data['kkm'] = $request->kkm_add;
        $data['ket'] = $request->ket_add;
        $data['created_by'] = Auth::id();
        $data['created_at'] = Carbon::now()->toDateTimeString();
        $data['updated_by'] = Auth::id();
        $data['updated_at'] = Carbon::now()->toDateTimeString();
        $createdata = PaketSoalMst::create($data);
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
        $data['waktu'] = $request->waktu[0];
        $data['jenis_penilaian'] = $request->jenis_penilaian[0];
        $data['kkm'] = $request->kkm[0];
        $data['ket'] = $request->ket[0];
        $data['updated_by'] = Auth::id();
        $data['updated_at'] = Carbon::now()->toDateTimeString();

        $updatedata = PaketSoalMst::find($id)->update($data);

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
        $updateData = PaketSoalMst::find($id)->update($data);
        $updateData = PaketSoalKtg::where('fk_paket_soal_mst',$id)->update($data);
        $updateData = PaketSoalDtl::where('fk_paket_soal_mst',$id)->update($data);
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }

    public function indexktg($idpaketmst)
    {
        $menu = 'master';
        $submenu='paketsoal';
        $datamst = PaketSoalMst::find($idpaketmst);
        $arr = PaketSoalKtg::where('fk_paket_soal_mst',$idpaketmst)->pluck('fk_kategori_soal')->all(); 
        $ktgsoal = KategoriSoal::whereNotIn('id',$arr)->get();
        $data = PaketSoalKtg::where('fk_paket_soal_mst',$idpaketmst)->get();
        $data_param = [
            'menu','submenu','data','ktgsoal','idpaketmst','datamst'
        ];
        return view('master/paketsoalktg')->with(compact($data_param));
    }

    public function storektg(Request $request)
    {
        $data['fk_paket_soal_mst'] = $request->fk_paket_soal_mst;
        $data['fk_kategori_soal'] = $request->fk_kategori_soal_add;

        $cekdata = PaketSoalKtg::where('fk_paket_soal_mst',$request->fk_paket_soal_mst)->where('fk_kategori_soal',$request->fk_kategori_soal_add)->first();
        if($cekdata){
            return response()->json([
                'status' => false,
                'message' => 'Kategori soal sudah ada pada paket ini, silahkan isi kategori lainnya!'
            ]);
            dd('Error');
        }
        $data['kkm'] = $request->kkm_add;
        $data['created_by'] = Auth::id();
        $data['created_at'] = Carbon::now()->toDateTimeString();
        $data['updated_by'] = Auth::id();
        $data['updated_at'] = Carbon::now()->toDateTimeString();

        $createdata = PaketSoalKtg::create($data);
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
    public function updatektg(Request $request, $id)
    {
        $data['kkm'] = $request->kkm[0];
        $data['updated_by'] = Auth::id();
        $data['updated_at'] = Carbon::now()->toDateTimeString();

        $updatedata = PaketSoalKtg::find($id)->update($data);

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
    public function destroyktg($id)
    {
        $data['deleted_by'] = Auth::id();
        $data['deleted_at'] = Carbon::now()->toDateTimeString();
        $updateData = PaketSoalKtg::find($id)->update($data);
        $updateData = PaketSoalDtl::where('fk_paket_soal_ktg',$id)->update($data);
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }

    public function indexdtl($idpaketsoalktg)
    {
        $menu = 'master';
        $submenu='paketsoal';
        $data = PaketSoalKtg::find($idpaketsoalktg); 
        $mastersoal = MasterSoal::where('fk_kategori_soal',$data->fk_kategori_soal)->get();
        $data_param = [
            'menu','submenu','data','mastersoal','idpaketsoalktg'
        ];
        return view('master/paketsoaldtl')->with(compact($data_param));
    }

    public function storedtl(Request $request ,$idmst, $idktg)
    {
       
        PaketSoalDtl::where('fk_paket_soal_mst',$idmst)->where('fk_paket_soal_ktg', $idktg)->forceDelete();
        if($request->id_master_soal){
            foreach ($request->id_master_soal as $key) {
                $data['fk_master_soal'] = $key;
                $data['fk_paket_soal_mst'] = $idmst;
                $data['fk_paket_soal_ktg'] = $idktg;
                $data['created_by'] = Auth::id();
                $data['created_at'] = Carbon::now()->toDateTimeString();
                $data['updated_by'] = Auth::id();
                $data['updated_at'] = Carbon::now()->toDateTimeString();
                PaketSoalDtl::create($data);
            } 
            $updatedataktg['jumlah_soal'] = count(PaketSoalDtl::where('fk_paket_soal_ktg', $idktg)->get());
            PaketSoalKtg::find($idktg)->update($updatedataktg);

            $updatedatamst['total_soal'] = count(PaketSoalDtl::where('fk_paket_soal_mst', $idmst)->get());
            PaketSoalMst::find($idmst)->update($updatedatamst);

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

    public function nilaipeserta($id){
        $id = Crypt::decrypt($id);

        $menu = "master";
        $submenu="paketsoal";
        $datapaket = PaketSoalMst::find($id);
        
        $udatapaket =UPaketSoalMst::where('fk_paket_soal_mst',$id)->where('is_mengerjakan',0)->orderBy('id','desc')->get();
                 
        // $udatapaket = UMapelMst::where('fk_paket_soal_mst',$id)->get();
        $data_param = [
            'submenu','menu','datapaket','udatapaket'
        ];
        return view('master/nilaipeserta')->with(compact($data_param)); 
    }

    public function downloadnilai($id)
    {
        $id = Crypt::decrypt($id);
        $data = [
            'id' => $id
        ];
        return Excel::download(new NilaiExport($data), 'Nilai_Peserta.xlsx');
    }
    public function lihatnilai($id)
    {
        $id = Crypt::decrypt($id);
        $menu = "master";
        $submenu="paketsoal";
        $ujian = UPaketSoalMst::find($id);
        $datanilai = UPaketSoalDtl::where('fk_u_paket_soal_mst',$id)->get();
        return view('master.nilai', [
            'ujian' => $ujian,
            'datanilai' => $datanilai,
            'menu' => $menu,
            'submenu'=> $submenu
        ]);
    }
    public function downloaddatanilai($id)
    {
        $id = Crypt::decrypt($id);
        $data = [
            'id' => $id
        ];
        return Excel::download(new DataNilaiExport($data), 'Data_Nilai_Peserta.xlsx');
    }
}
