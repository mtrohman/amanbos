<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Kecamatan extends Model
{
    // use SoftDeletes;
    protected $table = 'kecamatan';

    // protected $fillable = [''];
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    // protected $dates = ['deleted_at'];
    public $timestamps = false;

}