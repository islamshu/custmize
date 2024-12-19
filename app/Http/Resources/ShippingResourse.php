<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShippingResourse extends JsonResource
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
            'receiver_name'=>$this->receiver_name,
            'address'=>$this->address,
            'city'=>$this->city,
            'postal_code'=>$this->postal_code,
            'country'=>$this->country,
            'status'=>$this->status,
        ];
    }
}
