<?php

namespace App\Exports;

use App\Models\UPaketSoalMst;
use App\Models\UPaketSoalDtl;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class NilaiExport implements FromView
{
    use Exportable;

    private $data; 

    public function __construct(array $data = [])
    {
        $this->data = $data; 
    }
    
    public function view(): View
    {
        $id = $this->data['id']; 
        $ujian = UPaketSoalMst::find($id);
        $datanilai = UPaketSoalDtl::where('fk_u_paket_soal_mst',$id)->get();
        return view('excel.nilai', [
            'ujian' => $ujian,
            'datanilai' => $datanilai
        ]);
    }

}
