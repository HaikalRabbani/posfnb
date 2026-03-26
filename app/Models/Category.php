<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    // 1. MATIKAN TIMESTAMPS (Kunci utama agar error 'updated_at' hilang)
    public $timestamps = false;

    // 2. DAFTARKAN KOLOM YANG BOLEH DIISI
    // Sesuaikan dengan yang diminta Controller (name dan description)
    protected $fillable = [
        'name', 
        'description'
    ];
}