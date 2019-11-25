<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BarangPersediaan extends Model
{
    use SoftDeletes;
    // protected $table = 'rka';
    protected $fillable = ['npsn', 'nama_persediaan', 'satuan','harga_satuan', 'stok'];
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

}
