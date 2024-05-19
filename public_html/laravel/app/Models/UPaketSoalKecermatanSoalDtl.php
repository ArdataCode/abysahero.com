<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UPaketSoalKecermatanSoalDtl extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "u_paket_soal_kecermatan_soal_dtl";
    protected $guarded = ["id"];
    
}
