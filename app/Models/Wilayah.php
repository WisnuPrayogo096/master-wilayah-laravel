<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wilayah extends Model
{
    // use SoftDeletes;

    protected $table = 'wilayahs';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'kode', 'nama', 'ibu_kota', 'type', 'kategori_wilayah', 'kode_negara',
        'created_by', 'updated_by', 'deleted_by', 'restored_by',
        'created_at', 'updated_at', 'deleted_at', 'restored_at'
    ];
}
