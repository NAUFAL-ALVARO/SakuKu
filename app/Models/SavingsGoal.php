<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavingsGoal extends Model
{
    protected $fillable = ['user_id', 'nama_target', 'jumlah_target', 'jumlah_terkumpul', 'tenggat_waktu', 'status'];

public function user()
{
    return $this->belongsTo(\App\Models\User::class);
}
}
