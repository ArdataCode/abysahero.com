<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterSoal extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "master_soal";
    protected $guarded = ["id"];
}
