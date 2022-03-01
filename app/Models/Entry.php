<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use RyanChandler\Uuid\Concerns\HasUuid;

class Entry extends Model
{
    use HasFactory;
    use HasUuid;

    protected $guarded = [];

    protected $casts = [
        'read' => 'boolean',
        'updated' => 'datetime'
    ];

    public function feed()
    {
        return $this->belongsTo(Feed::class);
    }
}
