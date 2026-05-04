<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengelola extends Model
{
    use HasFactory;

    protected $table = 'pengelola';
    protected $primaryKey = 'id_pengelola';

    protected $fillable = [
        'user_id',
        'nama',
        'email',
        'no_hp',
        'hunian_id',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hunian()
    {
        return $this->belongsTo(Hunian::class, 'hunian_id', 'id_hunian');
    }
}