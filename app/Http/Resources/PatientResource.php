<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
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
            'fatherName' => $this->fatherName,
            'phone' => $this->phone,
            'path' => $this->path,
            'treatments' => $this->treatments,
            'visitCount' => $this->treatments->count(),
            'booked' => !!$this->booking->count()
        ];
    }
}
