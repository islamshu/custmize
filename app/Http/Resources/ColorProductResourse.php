<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ColorProductResourse extends JsonResource
{
    protected $productId;

    public function __construct($resource, $productId = null)
    {
        parent::__construct($resource);
        $this->productId = $productId; // حفظ product_id لاستخدامه في فلترة الأحجام
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id, // ID اللون
            "name" => $this->name, // اسم اللون
            "color_code" => $this->code, // كود اللون
            'have_front_image' => $this->pivot->front_image ? true : false, // تحقق من وجود صورة أمامية
            'have_back_image' => $this->pivot->back_image ? true : false, // تحقق من وجود صورة خلفية
            'right_side_back_image' => $this->pivot->right_side_image ? true : false, // تحقق من وجود صورة خلفية
            'left_side_back_image' => $this->pivot->left_side_image ? true : false, // تحقق من وجود صورة خلفية

            'front_image' => $this->pivot->front_image
                ? asset('storage/' . $this->pivot->front_image)
                : null,
            'back_image' => $this->pivot->back_image
                ? asset('storage/' . $this->pivot->back_image)
                : null,
            'right_side_image' => $this->pivot->right_side_image
                ? asset('storage/' . $this->pivot->right_side_image)
                : null, 
            'left_side_image' => $this->pivot->left_side_image
                ? asset('storage/' . $this->pivot->left_side_image)
                : null,        
            'price' => (floatval($this->pivot->price)) ? floatval($this->pivot->price) : 0, // السعر من الجدول الوسيط
            'sizes' => SizeProductResourse::collection($this->sizes($this->pivot->product_id)->get()),
        ];
    }
}
