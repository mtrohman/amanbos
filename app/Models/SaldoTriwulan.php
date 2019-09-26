<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaldoTriwulan extends Model
{
    use SoftDeletes;
    protected $fillable = ['ta','triwulan','npsn','sisa'];
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

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

    public function scopeTriwulan($query, $triwulan)
    {
        return $query->where('ta', $triwulan);
    }

}