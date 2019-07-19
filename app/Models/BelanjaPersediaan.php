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

}