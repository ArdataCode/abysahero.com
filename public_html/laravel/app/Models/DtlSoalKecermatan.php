<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DtlSoalKecermatan extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "dtl_soal_kecermatan";
    protected $guarded = ["id"];
}
