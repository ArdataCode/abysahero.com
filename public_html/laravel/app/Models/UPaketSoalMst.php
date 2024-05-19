<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UPaketSoalMst extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "u_paket_soal_mst";
    protected $guarded = ["id"];

    public function u_paket_soal_ktg_r()
    {
        return $this->hasMany(UPaketSoalKtg::class, 'fk_u_paket_soal_mst', 'id');
    }
    public function u_paket_soal_dtl_r()
    {
        return $this->hasMany(UPaketSoalDtl::class, 'fk_u_paket_soal_mst', 'id')->orderBy('no_soal','asc');
    }

    public function user_r()
    {
        return $this->belongsTo(User::class, 'fk_user_id', 'id');
    }

    public function getNamaJenisPenilaianAttribute() {
        if ($this->jenis_penilaian==1) {
            return "Rata-rata";
        }else if($this->jenis_penilaian==2){
            return "Point";
        }
    }
}
