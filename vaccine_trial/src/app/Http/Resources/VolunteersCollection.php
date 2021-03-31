<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use App\Vaccination;

class VolunteersCollection extends Resource
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
            'name' => $this->name,
            'age'  => $this->age,
            'gender' => $this->gender,
            'address' => $this->address,
            'health_condition'=> $this->health_condition,
            'vaccine' => Vaccination::where('uid', $this->id)->value('vaccine'),
            'dose' => Vaccination::where('uid', $this->id)->value('dose'),
            'test' => Vaccination::where('uid', $this->id)->value('test'),
        ];
    }

   
}
