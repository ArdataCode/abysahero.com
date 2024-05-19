<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UPaketSoalDtl extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "u_paket_soal_dtl";
    protected $guarded = ["id"];

    public function u_paket_soal_ktg_r()
    {
        return $this->belongsTo(UPaketSoalKtg::class, 'fk_u_paket_soal_ktg', 'id');
    }
}
