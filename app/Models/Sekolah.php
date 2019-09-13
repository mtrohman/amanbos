<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sekolah extends Model
{
    use SoftDeletes;
    protected $table = 'sekolah';
    protected $fillable = ['npsn','nama_sekolah','jenjang','status','kecamatan','role','alamat','telepon','foto','nama_kepsek','nip_kepsek','nama_bendahara','nip_bendahara','password'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $hidden = ['password'];

    protected $primaryKey = 'id_sekolah';

    public function rkas(){
        return $this->hasMany('App\Models\Rka','npsn','npsn');
    }

    public function pagus(){
        return $this->hasMany('App\Models\Pagu','npsn','npsn');
    }

    public function pencairans(){
        return $this->hasMany('App\Models\Pencairan','npsn','npsn');
    }

    public function saldos(){
        return $this->hasMany('App\Models\Saldo','npsn','npsn');
    }

    public function belanjas(){
        return $this->hasMany('App\Models\Belanja','npsn','npsn');
    }

    public function belanjathlalus(){
        return $this->hasMany('App\Models\Belanjathlalu','npsn','npsn');
    }

    public function kecamatannya(){
        return $this->belongsTo('App\Models\Kecamatan','kecamatan');
    }

    public function scopeNpsn($query, $npsn)
    {
        return $query->where('npsn', 'like', '%' . $npsn . '%');
    }

    public function scopeNamaSekolah($query, $sekolah)
    {
        return $query->where('nama_sekolah', 'like', '%' . $sekolah . '%');
    }

}