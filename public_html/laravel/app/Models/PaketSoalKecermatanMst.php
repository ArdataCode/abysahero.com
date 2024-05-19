<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaketSoalKecermatanMst extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "paket_soal_kecermatan_mst";
    protected $guarded = ["id"];
}
