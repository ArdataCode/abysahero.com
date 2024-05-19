<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KategoriSoalKecermatan extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "kategori_soal_kecermatan";
    protected $guarded = ["id"];
}
