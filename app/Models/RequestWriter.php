<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RequestWriter extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'note',
        'status',
        'role_id',
        'user_id',
    ];

    public function author()
    {
        return $this->beLongsTo(User::class, 'user_id', 'id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
}
