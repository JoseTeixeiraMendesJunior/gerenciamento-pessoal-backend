<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class TransactionResource extends JsonResource
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
            'description' => $this->description,
            'amount' => round(floatval($this->amount), 2),
            'type' => $this->type,
            'date' => Carbon::parse($this->date)->format('d-m-Y'),
            'category' => $this->category,
        ];
    }
}
