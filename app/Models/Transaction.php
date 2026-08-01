<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['user_id', 'category_id', 'jumlah', 'tipe', 'deskripsi', 'tanggal'];

public function category()
{
    return $this->belongsTo(Category::class);
}

public function user()
{
    return $this->belongsTo(\App\Models\User::class);
}
}
