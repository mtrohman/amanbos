<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Belanja extends Model
{
    use SoftDeletes;
    protected $fillable = ['triwulan','nama','nilai','tanggal_belanja'];
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function rka()
    {
        return $this->belongsTo('App\Models\Rka')->select(array('id', 'ta', 'npsn', 'program_id','pembiayaan_id','rekening_id'));;
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

    public function scopeTriwulan($query, $tw)
    {
        if (!empty($tw)) {
            return $query->where('triwulan', $tw);
        }
    }

    public function scopeTa($query, $ta)
    {
        if (!empty($ta)) {
        	return $query->whereHas('rka', function ($q) use ($ta) {
            	$q->where('ta', $ta);
        	});
        }
    }

}