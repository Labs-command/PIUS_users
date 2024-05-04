<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserRolesResource extends JsonResource
{

    public function toArray($request): array
    {
        return [
            'user_id' => $this->user_id,
            'role' => $this->role,
        ];
    }
}
