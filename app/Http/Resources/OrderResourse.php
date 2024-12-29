<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResourse extends JsonResource
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
            'code'=>$this->code,
            'name'=>$this->name,
            'email'=>$this->email,
            'phone'=>$this->phone,
            'order_status'=>$this->OrderStatus->name,
            'order_status_info'=>new StatusResourse($this->order_status),
            'total_amount'=>$this->total_amount,
            'subtotal'=>$this->subtotal,
            'discount_amount'=>$this->discount_amount,
            'promo_code'=>$this->promo_code,
            'shipping'=>$this->shipping,
            'shipping_info'=>new ShippingResourse($this->shipping_info),
            'order_detiles'=>OrderDetilesResourse::collection($this->details)
        ];
    }
}
