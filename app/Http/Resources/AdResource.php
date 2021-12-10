<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
      return [
          'id' => $this->id,
          'title' => $this->title,
          'type' => $this->type,
          'description' => $this->description,
          'start_date' => $this->start_date,
          'advertiser_id' => $this->advertiser_id,
          'category_id' => $this->category_id,
          'category' => $this->category,
          'tags' => $this->tags,
      ];
    }
}
