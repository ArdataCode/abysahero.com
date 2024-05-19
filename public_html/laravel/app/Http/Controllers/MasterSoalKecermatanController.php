<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterSoalKecermatan;
use App\Models\KategoriSoalKecermatan;
use App\Models\User;
// use App\Imports\SoalImport;
// use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Crypt;

class MasterSoalKecermatanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($idkategori)
    {
        $menu = 'master';
        $submenu='kategorisoalkecermatan';
        $data = MasterSoalKecermatan::where('fk_kategori_soal_kecermatan',$idkategori)->get();
        $datakategori = KategoriSoalKecermatan::find($idkategori);
        $data_param = [
            'menu','submenu','data','idkategori','datakategori'
        ];

        return view('master/mastersoalkecermatan')->with(compact($data_param));
    }

    public function store(Request $request)
    {
        $data['fk_kategori_soal_kecermatan'] = $request->fk_kategori_soal_kecermatan_add;
        $data['karakter'] = json_encode($request->karakter_add);
        $data['kiasan'] = json_encode($request->kiasan_add);
        $data['created_by'] = Auth::id();
        $data['created_at'] = Carbon::now()->toDateTimeString();
        $data['updated_by'] = Auth::id();
        $data['updated_at'] = Carbon::now()->toDateTimeString();
        $createdata = MasterSoalKecermatan::create($data);
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
        $data['karakter'] = json_encode($request->karakter);
        $data['kiasan'] = json_encode($request->kiasan);
        
        $data['updated_by'] = Auth::id();
        $data['updated_at'] = Carbon::now()->toDateTimeString();

        $updatedata = MasterSoalKecermatan::find($id)->update($data);

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
        $updateData = MasterSoalKecermatan::find($id)->update($data);
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
