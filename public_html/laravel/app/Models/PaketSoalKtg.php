<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaketSoalKtg extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "paket_soal_ktg";
    protected $guarded = ["id"];

    public function kategori_soal_r()
    {
        return $this->belongsTo(KategoriSoal::class, 'fk_kategori_soal', 'id');
    }
}
