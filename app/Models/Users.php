<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Ramsey\Uuid\Uuid;

class Users extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'state',
    ];

    public $incrementing = false;
    protected $primaryKey = 'user_id';

    public function roles(): HasMany
    {
        return $this->hasMany(UserRoles::class, 'user_id');
    }

    public static function boot(): void
    {
        parent::boot();

        self::creating(
            function ($model) {
                if (!$model->user_id) {
                    $model->user_id = Uuid::uuid4()->toString();
                }
            }
        );
    }
}
