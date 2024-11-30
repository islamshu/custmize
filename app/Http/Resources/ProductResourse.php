<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResourse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->name,
            'image' => asset('uploads/' . $this->image),
            'slug' => $this->slug,
            'url' => route('get_single_product', $this->slug),
            'description' => $this->description,
            'main_price' => $this->price,
            'delivery_date' => $this->delivery_date,
            'have_color' => $this->have_color($this),
            'colors' => ColorProductResourse::collection($this->colors),
            'have_size' => $this->have_size($this),
            'sizes' => SizeProductResourse::collection($this->sizes),
            'category'=>new CategoryResourse($this->category),
            'sub_category'=>new CategoryResourse($this->subcategory),
            'min_sale'=>$this->min_sale,
            'guidness_image'=>$this->guidness_image($this)


        ];
    }
    public function have_color($data)
    {
        if ($data->colors != null) {
            return true;
        } else {
            return false;
        }
    }
    public function have_size($data)
    {
        if ($data->sizes != null) {
            return true;
        } else {
            return false;
        }
    }
    public function guidness_image($data){
        $images =[];
        foreach (json_decode($data->guidness_pic) as $image){
            array_push( $images, asset('uploads/'.$image));
        }
        return ($images);
    }
}
