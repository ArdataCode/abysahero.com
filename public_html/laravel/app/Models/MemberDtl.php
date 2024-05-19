<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberDtl extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "member_dtl";
    protected $guarded = ["id"];

    public function master_member_r()
    {
        return $this->belongsTo(MasterMember::class, 'fk_master_member', 'id');
    }

    public function paket_soal_mst_r()
    {
        return $this->belongsTo(PaketSoalMst::class, 'fk_paket_soal_mst', 'id');
    }

    public function paket_soal_mst_kecermatan_r()
    {
        return $this->belongsTo(PaketSoalKecermatanMst::class, 'fk_paket_soal_mst', 'id');
    }
}
