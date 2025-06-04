<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExternalSizeResource extends JsonResource
{
    /**
     * تحويل البيانات إلى مصفوفة
     */
    public function toArray(Request $request): array
    {
        return [
            'size_id' => $this->id,
            'size_name' => $this->name,
            'external_id' => $this->external_id,
            'default_code' => $this->default_code,
        ];
    }
}