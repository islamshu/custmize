<?php

namespace App\Http\Resources;

use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Ramsey\Uuid\Type\Decimal;

class SizeProductResourse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'size_id'=>$this->id,
            'size_name'=>$this->name,
        ];
    }
}
