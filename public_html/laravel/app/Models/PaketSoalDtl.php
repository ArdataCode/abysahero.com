<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaketSoalDtl extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "paket_soal_dtl";
    protected $guarded = ["id"];

    public function master_soal_r()
    {
        return $this->belongsTo(MasterSoal::class, 'fk_master_soal', 'id');
    }
}
