<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Transaksi extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "transaksi";
    protected $guarded = ["id"];

    public function master_member_r()
    {
        return $this->belongsTo(MasterMember::class, 'fk_master_member_id', 'id');
    }

    // public function getNameAtribute($value)
    // {
    //     $this->attributes['expired'] =Carbon::parse($this->attributes['value'])->translatedFormat('l, d F Y');
    // }
}
