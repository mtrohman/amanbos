<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pagu extends Model
{
    use SoftDeletes;
    // protected $table = 'rka';
    protected $fillable = ['ta', 'npsn', 'pagu', 'tw1', 'tw2', 'tw3', 'tw4'];
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function sisa()
    {
        return $this->hasOne('App\Models\PaguSisa');
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
}
