<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Belanjathlalu extends Model
{
    use SoftDeletes;
    protected $fillable = ['ta','triwulan','program_id','pembiayaan_id','rekening_id','nama','nilai','tanggal_belanja'];
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

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

    public function sekolah()
    {
        return $this->belongsTo('App\Models\Sekolah', 'npsn', 'npsn')->select(array('id_sekolah', 'npsn', 'nama_sekolah'));
    }

    public function scopeNamaSekolah($query, $sekolah)
    {
        if (!empty($sekolah)) {
            return $query->whereHas('sekolah', function ($q) use ($sekolah) {
                $q->where('nama_sekolah', 'like', '%' . $sekolah . '%');
            });
        }
    }

    public function scopeNpsn($query, $npsn)
    {
        if (!empty($npsn)) {
        	return $query->where('npsn', $npsn);
        }
    }

    public function scopeTriwulan($query, $tw)
    {
        if (!empty($tw)) {
            return $query->where('triwulan', $tw);
        }
    }

    public function scopeSampaiTriwulan($query, $tw)
    {
        if (!empty($tw)) {
            return $query->where('triwulan','<=', $tw);
        }
    }

    public function scopeTa($query, $ta)
    {
        if (!empty($ta)) {
            return $query->where('ta', $ta);
        }
    }

    protected $appends = ['jenis_belanja','keterangan'];

    public function getJenisBelanjaAttribute()
    {
        // return "{$this->first_name} {$this->last_name}";
        if($this->rekening->jenis){
            return $this->rekening->jenis;
        }
        // ;
    }

    public function getKeteranganAttribute()
    {
        switch ($this->jenis_belanja) {
            case 1:
                // Modal...
                if ($this->nilai==$this->belanja_modal()->sum('total')) {
                    # code...
                    return 1;
                }
                else{
                    return -1;
                }
                break;
            case 2:
                // Persediaan
                if ($this->nilai==$this->belanja_persediaan()->sum('total')) {
                    # code...
                    return 1;
                }
                else{
                    return -1;
                }
                break;
            default:
                // Something else
                # code...
                break;
        }
    }

    public function scopePersediaan($query)
    {
        return $query->whereHas('rekening', function ($q) {
                $q->where('jenis', 2);
        });
        
    }

    public function belanja_persediaan()
    {
        return $this->hasMany('App\Models\BelanjathlaluPersediaan');
    }

    public function scopeModal($query)
    {
        return $query->whereHas('rekening', function ($q) {
            $q->where('jenis', 1);
        });
        
    }

    public function belanja_modal()
    {
        return $this->hasMany('App\Models\BelanjaModal');
    }

}