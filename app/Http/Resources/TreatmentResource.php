<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TreatmentResource extends JsonResource
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
            'prescription' => $this->prescription,
            'fees' => $this->fees,
            'follow_up' => $this->follow_up,
            'patientName' => $this->patient->name,
            'created_at' => $this->created_at
        ];
    }
}
