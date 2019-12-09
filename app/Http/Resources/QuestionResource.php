<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
            'title' => $this->title,
            'path' => $this->path,
            'body' => $this->body,
            'created_at' => $this->created_at->diffForHumans(),
            'user' => $this->user->name,
            'id' => $this->id,
            'user_id' => $this->user_id,
            'slug' => $this->slug,
            'replies' =>  ReplyResource::collection($this->replies),
            'replies_count' => $this->replies()->count(),
            'reply_count_string' => $this->countReply($this->replies()->count()),
            'category' => new CategoryResource($this->category)
        ];
    }

    public function countReply($count)
    {
        return $count === 0  ? 'Reply' : 'Replies';
    }
}
