<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
       // return parent::toArray($request);

       return[
           'id'                           => (string)$this->id,
           'title'                        => $this->title ? $this->title : '',
           'description'                        =>$this->description ? $this->description : '',
           'price'                        => $this->price ? (string)$this->price : '0',
           'description'                  => $this->description ? (string)strip_tags($this->description) : '',
           'status'                       =>$this->status,
       ];
    }
}
