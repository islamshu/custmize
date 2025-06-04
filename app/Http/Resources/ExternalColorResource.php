<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExternalColorResource extends JsonResource
{
    /**
     * تحويل البيانات إلى مصفوفة
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "sizes" => ExternalSizeResource::collection($this->sizes),
            'front_image' => $this->front_image ? asset('storage/' . $this->front_image) : null,
            'back_image' => $this->back_image ? asset('storage/' . $this->back_image) : null,
            'right_side_image' => $this->right_side_image ? asset('storage/' . $this->right_side_image) : null,
            'left_side_image' => $this->left_side_image ? asset('storage/' . $this->left_side_image) : null,

            // Image availability
            'has_front_image' => !empty($this->front_image),
            'has_back_image' => !empty($this->back_image),
            'has_right_side_image' => !empty($this->right_side_image),
            'has_left_side_image' => !empty($this->left_side_image),

        ];
    }
}
