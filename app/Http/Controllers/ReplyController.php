<?php

namespace App\Http\Controllers;

use App\Events\DeleteReplyEvent;
use App\Model\Reply;
use App\Model\Question;
use Illuminate\Http\Request;
use App\Notifications\NewReply;
use App\Http\Resources\ReplyResource;
use Symfony\Component\HttpFoundation\Response;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('JWT', ['except' => 'index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Question $question)
    {
        return ReplyResource::collection($question->replies);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Question $question, Request $request)
    {
        $reply = $question->replies()->create([
            'body' => request('body'),
            'user_id' => auth()->user()->id
        ]);
        $user = $question->user;
        if ($reply->user_id !== $question->user_id) {
            $user->notify(new NewReply($reply));
        }
        return response(['reply' => new ReplyResource($reply)], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question, Reply $reply)
    {
        return new ReplyResource($reply);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function update(Question $question, Reply $reply)
    {
        //implement authorization here 

        $reply->update([
            'user_id' => auth()->id(),
            'body' => request('body')
        ]);
        return response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question, Reply $reply)
    {
        //implement authorization

        $replyExist = Reply::where([
            ['user_id', auth()->id()],
            ['id', $reply->id]
        ])->exists();

        if (!$replyExist) {
            return response()->json(['error' => 'reply not found'], Response::HTTP_NOT_FOUND);
        }
        broadcast(new DeleteReplyEvent($reply->id))->toOthers();
        $reply->delete();
        return response('', Response::HTTP_NO_CONTENT);
    }
}
