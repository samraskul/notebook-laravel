<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NavbarMenuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // dd($this);
        // return parent::toArray($request);
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'parentId'  => ($this->parent_id) ? (int)$this->parent_id : null,
            'icon'      => $this->icon,
            'link'      => $this->link,
            'order'     => $this->order,
        ];
    }
}