<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaguSisa extends Model
{
    use SoftDeletes;
    // protected $table = 'rka';
    protected $fillable = ['tw1', 'tw2', 'tw3', 'tw4'];
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

}