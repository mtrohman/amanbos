<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BelanjaModal extends Model
{
    use SoftDeletes;
    protected $fillable = ['nama_barang','merek','tipe','bahan','bukti_tanggal','bukti_bulan','bukti_nomor','qty','satuan','harga_satuan','total'];
    
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

}