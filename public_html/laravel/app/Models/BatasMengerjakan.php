<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BatasMengerjakan extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "batas_mengerjakan";
    protected $guarded = ["id"];
}
