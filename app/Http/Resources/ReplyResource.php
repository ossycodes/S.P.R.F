<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReplyResource extends JsonResource
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
            'reply' => $this->body,
            'user' => $this->user->name,
            'created_at' => $this->created_at->diffForHumans(),
            'user_id' => $this->user_id,
            'likes_count' => $this->likes->count(),
            'liked' => $this->likes()->where('user_id', auth()->id())->exists(),
        ];
    }
}
