<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRoles extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'role',
    ];

    public $incrementing = false;
    protected $primaryKey = 'user_id';

    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }
}
