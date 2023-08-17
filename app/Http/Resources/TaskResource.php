<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'name' => $this->name,
            'due_date' => Carbon::parse($this->due_date)->format('d-m-Y'),
            'priority' => $this->priority,
            'status' => $this->status,
            'type' => $this->type,
            'description' => $this->description,
            'completed_at' => Carbon::parse($this->completed_at)->format('d-m-Y'),
        ];
    }
}
