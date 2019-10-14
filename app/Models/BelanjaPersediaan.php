<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BelanjaPersediaan extends Model
{
    use SoftDeletes;
    protected $fillable = ['nama_persediaan','qty','satuan','harga_satuan','total'];
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function belanja()
    {
        return $this->belongsTo('App\Models\Belanja');
    }

    public function scopeNpsn($query, $npsn)
    {
        return $query->whereHas('belanja', function ($qbelanja) use ($npsn) {
            $qbelanja->whereHas('rka', function ($q) use ($npsn) {
            	$q->where('npsn', $npsn);
        	});

        });
    }

    public function scopeTriwulan($query, $triwulan)
    {
        return $query->whereHas('belanja', function ($qbelanja) use ($triwulan) {
            $qbelanja->where('triwulan', $triwulan);
        });
    }

}