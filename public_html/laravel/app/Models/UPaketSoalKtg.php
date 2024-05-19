<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UPaketSoalKtg extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "u_paket_soal_ktg";
    protected $guarded = ["id"];
}
