<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rka extends Model
{
    use SoftDeletes;
    // protected $table = 'rka';
    protected $fillable = ['ta', 'npsn', 'triwulan','uraian', 'program_id','pembiayaan_id','rekening_id','nilai','jenis_rka'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    
    public function sisa(){
        return $this->hasOne('App\Models\RkaSisa');
    }

    public function belanja(){
        return $this->hasMany('App\Models\Belanja');
    }

    public function sekolah()
    {
        return $this->belongsTo('App\Models\Sekolah', 'npsn', 'npsn')->select(array('id_sekolah', 'npsn', 'nama_sekolah'));
    }

    public function program()
    {
        return $this->belongsTo('App\Models\KodeProgram','program_id')->select(array('id', 'kode_program', 'nama_program'));
    }

    public function kp()
    {
        return $this->belongsTo('App\Models\KodePembiayaan','pembiayaan_id')->select(array('id', 'kode_pembiayaan', 'nama_pembiayaan'));
    }

    public function rekening()
    {
        return $this->belongsTo('App\Models\KodeRekening','rekening_id')->select(array('id', 'kode_rekening', 'nama_rekening', 'parent_id','jenis'));
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

    public function scopeUraian($query, $uraian)
    {
        return $query->where('uraian', 'like', '%' . $uraian . '%');
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
}