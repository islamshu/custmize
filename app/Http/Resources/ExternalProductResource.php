<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExternalProductResource extends JsonResource
{
    /**
     * تحويل البيانات إلى مصفوفة
     */
    public function toArray(Request $request): array
{
    $defaultCodes = $this->default_codes ?? [];
    $count = count($defaultCodes);

    return [
        'id' => $this->id,
        'title' => $this->name,
        'image' => asset('storage/'.$this->image),
        'description' => $this->description_sale,
        'brand' => $this->brand,
        'default_codes' => $defaultCodes,
        'count' => $count,
        'price'=>$this->price,
        'default_code' => $count  == 1 ? $defaultCodes[0] : false,
        'external_id' => $count  == 1 ? $this->external_id : false,
        'have_color' => $this->colors->isNotEmpty(),
        'colors' => ExternalColorResource::collection($this->colors),
    ];
}

}