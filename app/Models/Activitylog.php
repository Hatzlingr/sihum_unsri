<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $table = 'activity_log';
    protected $primaryKey = 'id_log';
    
    public $timestamps = false;
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'aksi',
        'modul',
        'target_id',
        'detail',
        'ip_address',
    ];

    protected function casts(): array
    {
        return [
            'detail' => 'array',
            'created_at' => 'datetime',
        ];
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper methods
    public static function log($aksi, $modul, $targetId = null, $detail = null)
    {
        return self::create([
            'user_id' => auth()->id(),
            'aksi' => $aksi,
            'modul' => $modul,
            'target_id' => $targetId,
            'detail' => $detail,
            'ip_address' => request()->ip(),
        ]);
    }
}