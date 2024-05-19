<?php

namespace App\Imports;

use App\Models\MasterSoal;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\User;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Auth;
use Carbon\Carbon;

class SoalImport implements ToModel ,WithStartRow, SkipsOnError
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    use Importable;

    private $data; 

    public function __construct(array $data = [])
    {
        $this->data = $data; 
    }

    public function model(array $row)
    {
        $fk_kategori_soal = $this->data['fk_kategori_soal'];
        
            return new MasterSoal([
                'fk_kategori_soal'     => $fk_kategori_soal,
                'soal'     => $row[0],
                'a'     => $row[1],
                'point_a'    => $row[2], 
                'b'    => $row[3], 
                'point_b'    => $row[4], 
                'c'    => $row[5], 
                'point_c'    => $row[6], 
                'd'    => $row[7], 
                'point_d'    => $row[8], 
                'e'    => $row[9], 
                'point_e'    => $row[10], 
                'jawaban'    => strtolower($row[11]), 
                'pembahasan'    => $row[12], 
                'created_by'    => Auth::id(), 
                'created_at'    => Carbon::now()->toDateTimeString(),
                'updated_by'    => Auth::id(), 
                'updated_at'    => Carbon::now()->toDateTimeString(),  
            ]);
        // }
    }
    public function startRow(): int
    {
        return 2;
    }

    public function onError(\Throwable $error)
    {
        // Handle the exception how you'd like.
    }
}
