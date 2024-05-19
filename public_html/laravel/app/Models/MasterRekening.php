<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterRekening extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "rekening_mst";
    protected $guarded = ["id"];
}
