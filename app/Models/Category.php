<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['user_id', 'nama_kategori', 'tipe'];

    public function transactions()
{
    return $this->hasMany(Transaction::class);
}

public function user()
{
    return $this->belongsTo(\App\Models\User::class);
}
}
