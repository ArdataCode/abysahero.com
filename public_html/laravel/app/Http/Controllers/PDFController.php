<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use PDF;
use Carbon\Carbon;
use App\Models\PaketSoalMst;
use App\Models\PaketSoalDtl;
use App\Models\PaketSoalKtg;
use App\Models\PaketSoalKecermatanMst;
use App\Models\PaketSoalKecermatanDtl;
use App\Models\DtlSoalKecermatan;
use Auth;

class PDFController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function exportsoal($jns , $id){
        $id = Crypt::decrypt($id);
        
        if ($jns=="pilgan") {
            $paketsoalmst = PaketSoalMst::find($id);
            $paketsoalktg = PaketSoalKtg::where('fk_paket_soal_mst',$id)->inRandomOrder()->get();
            $paketsoaldtl = PaketSoalDtl::where('fk_paket_soal_mst',$id)->get();

            $data = [
                'paketsoalktg'=> $paketsoalktg,
                'paketsoalmst'=>$paketsoalmst,
                'paketsoaldtl'=>$paketsoaldtl
            ];
            $pdf = PDF::loadView('pdf/SoalPilGan', $data);
            $pdf->setPaper('A4','potrait');
            return $pdf->stream('Soal_Pilihan_Ganda.pdf'); 
        }elseif($jns=="kec"){
            $paketsoalmst = PaketSoalKecermatanMst::find($id);
            $paketsoaldtl = PaketSoalKecermatanDtl::where('fk_paket_soal_kecermatan_mst',$id)->inRandomOrder()->get();
            $arr = PaketSoalKecermatanDtl::where('fk_paket_soal_kecermatan_mst',$id)->pluck('fk_master_soal_kecermatan')->all(); 
            $dtlsoal = DtlSoalKecermatan::whereIn('fk_master_soal_kecermatan',$arr)->get();
            $data = [
                'paketsoaldtl'=> $paketsoaldtl,
                'paketsoalmst'=>$paketsoalmst,
                'dtlsoal'=>$dtlsoal
            ];
            $pdf = PDF::loadView('pdf/SoalKecermatan', $data);
            $pdf->setPaper('A4','potrait');
            return $pdf->stream('Soal_Kecermatan.pdf'); 
        }
    }
}
