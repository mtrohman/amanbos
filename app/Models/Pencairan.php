<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pencairan extends Model
{
    use SoftDeletes;
    protected $fillable = ['ta','triwulan','npsn','saldo','sumber_dana','tanggal_pencairan'];
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function sisa()
    {
        return $this->hasOne('App\Models\PencairanSisa');
    }

    public function sekolah()
    {
        return $this->belongsTo('App\Models\Sekolah', 'npsn', 'npsn')->select(array('id_sekolah', 'npsn', 'nama_sekolah'));
    }

    public function scopeNamaSekolah($query, $sekolah)
    {
        return $query->whereHas('sekolah', function ($q) use ($sekolah) {
            $q->where('nama_sekolah', 'like', '%' . $sekolah . '%');
        });
    }

    public function scopeNpsn($query, $npsn)
    {
        return $query->where('npsn', 'like', '%' . $npsn . '%');
    }

    public function scopeTa($query, $ta)
    {
        return $query->where('ta', $ta);
    }

    public function scopeTriwulan($query, $tw)
    {
        if (!empty($tw)) {
            return $query->where('triwulan', $tw);
        }
    }

    public function scopeSumberDana($query, $sumberdana)
    {
        if (!empty($sumberdana) && ($sumberdana=="BOS" || $sumberdana=="Dana Lainnya") ) {
            return $query->where('sumber_dana', $sumberdana);
        }
    }

}