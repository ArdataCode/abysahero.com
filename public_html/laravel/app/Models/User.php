<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ["id"];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function menu_user()
    {
        return $this->hasMany(MenuUser::class, 'fk_user_level', 'user_level');
    }

    public function kecamatan_r()
    {
        return $this->belongsTo(MasterKecamatan::class, 'kecamatan', 'id_kec');
    }

    public function kabupaten_r()
    {
        return $this->belongsTo(MasterKabupaten::class, 'kabupaten', 'id_kab');
    }

    public function provinsi_r()
    {
        return $this->belongsTo(MasterProvinsi::class, 'provinsi', 'id_prov');
    }

    public function getNamaKelaminAttribute() {
        if ($this->jenis_kelamin=='l') {
            return "Laki-laki";
        }else if($this->jenis_kelamin=='p'){
            return "Perempuan";
        }
    }
}
