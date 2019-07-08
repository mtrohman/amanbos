<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sekolah extends Model
{
    use SoftDeletes;
    protected $table = 'sekolah';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $primaryKey = 'id_sekolah';

    public function rkas(){
        return $this->hasMany('App\Models\Rka','npsn','npsn');
    }

    public function pagus(){
        return $this->hasMany('App\Models\Pagu','npsn','npsn');
    }

    public function scopeNpsn($query, $npsn)
    {
        return $query->where('npsn', 'like', '%' . $npsn . '%');
    }

}