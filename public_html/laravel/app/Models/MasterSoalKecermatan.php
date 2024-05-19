<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterSoalKecermatan extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "master_soal_kecermatan";
    protected $guarded = ["id"];

    public function kategori_soal_kecermatan_r()
    {
        return $this->belongsTo(KategoriSoalKecermatan::class, 'fk_kategori_soal_kecermatan', 'id');
    }
}
