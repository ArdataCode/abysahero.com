<?php

namespace App\Exports;

use App\Models\PaketSoalMst;
use App\Models\UPaketSoalMst;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
class DataNilaiExport implements FromView
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

        $datapaket = PaketSoalMst::find($id);
        
        $udatapaket =UPaketSoalMst::where('fk_paket_soal_mst',$id)->where('is_mengerjakan',0)->orderBy('id','desc')->get();

        return view('excel.datanilai', [
            'datapaket' => $datapaket,
            'udatapaket' => $udatapaket
        ]);
    }

}
