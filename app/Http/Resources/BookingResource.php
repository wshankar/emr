<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
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
            'book_id' => $this->id,
            'bookCount' => $this->count(),
            'id' => $this->patient->id,
            'patientName' => $this->patient->name,
            'created_at' => $this->created_at
        ];
    }
}
