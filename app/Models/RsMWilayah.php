<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RsMWilayah extends Model
{
    protected $table = 'rs_m_wilayah';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'kode', 'nama', 'ibu_kota', 'type', 'kategori_wilayah', 'ket', 'kode_negara', 'update_time'
    ];
}