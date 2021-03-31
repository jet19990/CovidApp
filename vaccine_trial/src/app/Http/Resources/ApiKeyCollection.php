<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use App\User;

class ApiKeyCollection extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => User::find($this->uid)->name,
            'email' => User::find($this->uid)->email,
            'address' => User::find($this->uid)->address,
            'status' => $this->status

        ];
    }
}
