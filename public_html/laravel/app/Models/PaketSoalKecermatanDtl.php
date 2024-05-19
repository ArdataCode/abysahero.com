<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaketSoalKecermatanDtl extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "paket_soal_kecermatan_dtl";
    protected $guarded = ["id"];

    public function master_soal_kecermatan_r()
    {
        return $this->belongsTo(MasterSoalKecermatan::class, 'fk_master_soal_kecermatan', 'id');
    }
}
