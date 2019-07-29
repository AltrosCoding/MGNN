<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'userName' => $this->user_name,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'birthDate' => (string) $this->birth_date,
            'email' => $this->email,
            'isConfirmed' => $this->is_confirmed,
            'role' => $this->role,
            'exp' => $this->exp,
            'level' => $this->level,
            'adSenseSnippet' => $this->ad_sense_snippet,
            'posts' => $this->posts,
            'roles' => $this->roles,
        ];
    }
}
