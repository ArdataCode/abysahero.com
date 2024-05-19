<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterSoal;
use App\Models\KategoriSoal;
use App\Models\User;
use App\Imports\SoalImport;
use App\Models\PaketSoalDtl;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Crypt;

class MasterSoalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($idkategori)
    {
        $menu = 'master';
        $submenu='kategorisoal';
        $data = MasterSoal::where('fk_kategori_soal',$idkategori)->get();
        $datakategori = KategoriSoal::find($idkategori);
        $data_param = [
            'menu','submenu','data','idkategori','datakategori'
        ];

        return view('master/mastersoal')->with(compact($data_param));
    }

    public function store(Request $request)
    {
        $data['fk_kategori_soal'] = $request->fk_kategori_soal_add;
        $data['soal'] = $request->soal_add;
        $data['a'] = $request->a_add;
        $data['b'] = $request->b_add;
        $data['c'] = $request->c_add;
        $data['d'] = $request->d_add;
        $data['e'] = $request->e_add;
        $data['point_a'] = $request->point_a_add;
        $data['point_b'] = $request->point_b_add;
        $data['point_c'] = $request->point_c_add;
        $data['point_d'] = $request->point_d_add;
        $data['point_e'] = $request->point_e_add;
        $jawaban = $request->jawaban_add;
        $jawaban = implode(",",$jawaban);
        $data['jawaban'] = $jawaban;
        $data['pembahasan'] = $request->pembahasan_add;

        // if ($data['soal']=='' || $data['a']=='' || $data['b']=='' || $data['c']=='' || $data['d']=='' || $data['e']=='' || $data['jawaban']=='' || $data['pembahasan']=='') {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'Semua kolom harus diisi!'
        //     ]);
        //     exit();
        // }

        $data['created_by'] = Auth::id();
        $data['created_at'] = Carbon::now()->toDateTimeString();
        $data['updated_by'] = Auth::id();
        $data['updated_at'] = Carbon::now()->toDateTimeString();
        $createdata = MasterSoal::create($data);
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

    public function edit($idkategori,$idsoal)
    {
        $menu = 'master';
        $submenu='kategorisoal';
        $data = MasterSoal::find($idsoal);
        $datakategori = KategoriSoal::find($idkategori);
        $data_param = [
            'menu','submenu','data','idkategori','datakategori'
        ];

        return view('master/editsoal')->with(compact($data_param));
    }

    public function update(Request $request, $id)
    {
        $data['soal'] = $request->soal[0];
        $data['a'] = $request->a[0];
        $data['b'] = $request->b[0];
        $data['c'] = $request->c[0];
        $data['d'] = $request->d[0];
        $data['e'] = $request->e[0];
        $data['point_a'] = $request->point_a[0];
        $data['point_b'] = $request->point_b[0];
        $data['point_c'] = $request->point_c[0];
        $data['point_d'] = $request->point_d[0];
        $data['point_e'] = $request->point_e[0];
        
        $jawaban = $request->jawaban;
        $jawaban = implode(",",$jawaban);
        $data['jawaban'] = $jawaban;
        $data['pembahasan'] = $request->pembahasan[0];

        // if ($data['soal']=='' || $data['a']=='' || $data['b']=='' || $data['c']=='' || $data['d']=='' || $data['e']=='' || $data['jawaban']=='' || $data['pembahasan']=='') {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'Semua kolom harus diisi!'
        //     ]);
        //     exit();
        // }
        
        $data['updated_by'] = Auth::id();
        $data['updated_at'] = Carbon::now()->toDateTimeString();

        $updatedata = MasterSoal::find($id)->update($data);

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
        $updateData = MasterSoal::find($id)->update($data);
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }

    public function destroyall(Request $request)
    {
        foreach($request->idsoal as $key){
            $cekdata = PaketSoalDtl::where('fk_master_soal',$key)->first();
            if(!$cekdata){
                $data['deleted_by'] = Auth::id();
                $data['deleted_at'] = Carbon::now()->toDateTimeString();
                $updateData = MasterSoal::find($key)->update($data);
            }
        }
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }

    public function importsoal(Request $request)
    {
        $idkategori = $request->idkategori;
        $data = [
            'fk_kategori_soal' => $idkategori, 
        ]; 
        Excel::import(new SoalImport($data), request()->file('fileexcel'));
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diimport'
        ]);
    }
}
