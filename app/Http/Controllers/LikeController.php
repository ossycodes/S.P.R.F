<?php

namespace App\Http\Controllers;

use App\Events\LikeReplyEvent;
use App\Model\Like;
use App\Model\Reply;
use App\Model\Question;
use Illuminate\Http\Request;
use App\Notifications\NewReply;
use Symfony\Component\HttpFoundation\Response;

class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('JWT');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Reply $reply)
    {
        // $question = Question::where('slug', request('question_slug'))->first();
        $reply->likes()->create(['user_id' => auth()->id()]);
        broadcast(new LikeReplyEvent($reply->id, 1))->toOthers();
        // $user = $question->user;
        // if ($reply->user_id !== $question->user_id) {
        //     $user->notify(new NewReply($reply));
        // }
        return response('liked', Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Like  $like
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reply $reply)
    {
        $reply->likes()->where('user_id', auth()->id())->first()->delete();
        broadcast(new LikeReplyEvent($reply->id, 0))->toOthers();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
