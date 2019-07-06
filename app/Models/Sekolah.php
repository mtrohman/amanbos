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

    public function rka(){
        return $this->hasMany('App\Models\Rka','npsn','npsn');
    }

    public function pagu(){
        return $this->hasMany('App\Models\Pagu','npsn','npsn');
    }

}