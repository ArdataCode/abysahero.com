<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DtlSoalKecermatan;
use App\Models\MasterSoalKecermatan;
use App\Models\User;
// use App\Imports\SoalImport;
// use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Crypt;

class DtlSoalKecermatanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($idmaster)
    {
        $menu = 'master';
        $submenu='kategorisoalkecermatan';
        $data = DtlSoalKecermatan::where('fk_master_soal_kecermatan',$idmaster)->get();
        $datamaster = MasterSoalKecermatan::find($idmaster);
        $data_param = [
            'menu','submenu','data','idmaster','datamaster'
        ];

        return view('master/dtlsoalkecermatan')->with(compact($data_param));
    }

    public function store(Request $request)
    {
        $data['fk_master_soal_kecermatan'] = $request->fk_master_soal_kecermatan_add;
        $data['soal'] = json_encode($request->soal_add);
        $data['jawaban'] = $request->jawaban_add;
        $data['waktu'] = $request->waktu_add;
        $data['created_by'] = Auth::id();
        $data['created_at'] = Carbon::now()->toDateTimeString();
        $data['updated_by'] = Auth::id();
        $data['updated_at'] = Carbon::now()->toDateTimeString();
        $createdata = DtlSoalKecermatan::create($data);
        $datamstupdate['waktu'] = DtlSoalKecermatan::where('fk_master_soal_kecermatan',$request->fk_master_soal_kecermatan_add)->sum('waktu');
        MasterSoalKecermatan::find($request->fk_master_soal_kecermatan_add)->update($datamstupdate);

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
        $data['soal'] = json_encode($request->soal);
        $data['jawaban'] = $request->jawaban[0];
        $data['waktu'] = $request->waktu[0];
        $data['updated_by'] = Auth::id();
        $data['updated_at'] = Carbon::now()->toDateTimeString();

        $updatedata = DtlSoalKecermatan::find($id)->update($data);
        $datadtl = DtlSoalKecermatan::find($id);
        $datamstupdate['waktu'] = DtlSoalKecermatan::where('fk_master_soal_kecermatan',$datadtl->fk_master_soal_kecermatan)->sum('waktu');
        MasterSoalKecermatan::find($datadtl->fk_master_soal_kecermatan)->update($datamstupdate);

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
        $datadtl = DtlSoalKecermatan::find($id);
        $updateData = DtlSoalKecermatan::find($id)->update($data);
        $datamstupdate['waktu'] = DtlSoalKecermatan::where('fk_master_soal_kecermatan',$datadtl->fk_master_soal_kecermatan)->sum('waktu');
        MasterSoalKecermatan::find($datadtl->fk_master_soal_kecermatan)->update($datamstupdate);

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }

    // public function importsoal(Request $request)
    // {
    //     $idkategori = $request->idkategori;
    //     $data = [
    //         'fk_kategori_soal' => $idkategori, 
    //     ]; 
    //     Excel::import(new SoalImport($data), request()->file('fileexcel'));
    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Data berhasil diimport'
    //     ]);
    // }
}
