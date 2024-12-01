<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'otp'=>$this->otp,
            'name'=>$this->name,
            'first_name'=>$this->first_name,
            'last_name'=>$this->last_name,
            'email'=>$this->email,
            'is_verify'=>$this->email_verified_at == null ? 0 : 1,
            'DOB'=>$this->DOB,
            'phone'=>$this->phone,
            'gender'=>$this->gender,
            'state'=>$this->state,
            'country'=>$this->country,

            // 'token' => $this->createToken('Personal Access Token')->accessToken,
        ];
    }
}
