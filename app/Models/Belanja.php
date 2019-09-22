<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Belanja extends Model
{
    use SoftDeletes;
    protected $fillable = ['triwulan','nama','nilai','tanggal_belanja','nomor','penerima','ppn','pph21','pph23'];
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function rka()
    {
        return $this->belongsTo('App\Models\Rka')->select(array('id', 'ta', 'npsn', 'program_id','pembiayaan_id','rekening_id'));
    }

    public function scopeNamaSekolah($query, $sekolah)
    {
        return $query->whereHas('rka', function ($qrka) use ($sekolah) {
	        $qrka->whereHas('sekolah', function ($q) use ($sekolah) {
	            $q->where('nama_sekolah', 'like', '%' . $sekolah . '%');
	        });
        });
    }

    public function scopeNpsn($query, $npsn)
    {
        if (!empty($npsn)) {
        	return $query->whereHas('rka', function ($q) use ($npsn) {
            	$q->where('npsn', $npsn);
        	});
        }
    }

    public function scopeParentRekening($query, $rekening_id)
    {
        return $query->whereHas('rka', function ($qrka) use ($rekening_id) {
            $qrka->whereHas('rekening', function ($q) use ($rekening_id) {
                $q->where('parent_id', $rekening_id);
            });
        });
    }

    public function scopeTriwulan($query, $tw)
    {
        if (!empty($tw)) {
            return $query->where('triwulan', $tw);
        }
    }

    public function scopeSampaiTriwulan($query, $tw)
    {
        // if (!empty($tw)) {
            return $query->where('triwulan','<=', $tw);
        // }
    }

    public function scopeTa($query, $ta)
    {
        if (!empty($ta)) {
            return $query->whereHas('rka', function ($q) use ($ta) {
                $q->where('ta', $ta);
            });
        }
    }



    protected $appends = ['jenis_belanja','keterangan','npsn'];

    public function getNpsnAttribute()
    {
        if($this->rka->npsn){
            return $this->rka->npsn;
        }
    }

    public function getJenisBelanjaAttribute()
    {
        // return "{$this->first_name} {$this->last_name}";
        if($this->rka->rekening->jenis){
            return $this->rka->rekening->jenis;
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
        return $query->whereHas('rka', function ($qrka) {
            $qrka->whereHas('rekening', function ($q) {
                $q->where('jenis', 2);
            });
        });
        
    }

    public function belanja_persediaan()
    {
        return $this->hasMany('App\Models\BelanjaPersediaan');
    }

    public function scopeModal($query)
    {
        return $query->whereHas('rka', function ($qrka) {
            $qrka->whereHas('rekening', function ($q) {
                $q->where('jenis', 1);
            });
        });
        
    }

    public function belanja_modal()
    {
        return $this->hasMany('App\Models\BelanjaModal');
    }

    public function scopeThBerjalan($query)
    {
        return $query->whereHas('rka', function ($qrka) {
            $qrka->where('jenis_rka', 'RKA Tahun Berjalan');
        });    
    }

    public function scopePerubahan($query)
    {
        return $query->whereHas('rka', function ($qrka) {
            $qrka->where('jenis_rka', 'RKA Perubahan');
        });    
    }

    public function scopeThLalu($query)
    {
        return $query->whereHas('rka', function ($qrka) {
            $qrka->where('jenis_rka', 'RKA Tahun Lalu');
        });    
    }

}