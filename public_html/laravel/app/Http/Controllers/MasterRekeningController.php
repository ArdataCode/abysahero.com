<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterRekening;
use App\Models\User;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Crypt;

class MasterRekeningController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $menu = 'master';
        $submenu='masterrekening';
        $data = MasterRekening::all();
        $data_param = [
            'menu','submenu','data'
        ];

        return view('master/masterrekening')->with(compact($data_param));
    }
    public function store(Request $request)
    {
        $data['nama'] = $request->nama_add;
        $data['no'] = $request->no_add;
        $data['kategori'] = $request->kategori_add;
        $data['partner'] = $request->partner_add;
        $data['created_by'] = Auth::id();
        $data['created_at'] = Carbon::now()->toDateTimeString();
        $data['updated_by'] = Auth::id();
        $data['updated_at'] = Carbon::now()->toDateTimeString();
        $createdata = MasterRekening::create($data);
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
        $data['nama'] = $request->nama[0];
        $data['no'] = $request->no[0];
        $data['kategori'] = $request->kategori[0];
        $data['partner'] = $request->partner[0];
        $data['updated_by'] = Auth::id();
        $data['updated_at'] = Carbon::now()->toDateTimeString();

        $updatedata = MasterRekening::find($id)->update($data);

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
        $updateData = MasterRekening::find($id)->update($data);
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
