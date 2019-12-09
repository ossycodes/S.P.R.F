<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Model\Question;

class QuestionsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        factory('App\User')->create();

        factory('App\Model\Category')->create();
    }

    /** @test */
    public function a_user_read_see_all_questions()
    {
        $questions = factory(Question::class, 3)->create();

        $response = $this->get('/api/questions');

        
        $response->assertStatus(200);

        foreach ($questions as $question) {
            $response = $this->get('/api/questions');

            $response->assertJsonFragment([
                'title' => $question->title,
                'body' => $question->body,
                'created_at' => $question->created_at->diffForHumans()
            ]);
        }
    }

    /** @test */
    public function a_user_can_read_a_single_question()
    {
        $question =  factory('App\Model\Question')->create();

        $response = $this->get("/api/questions/{$question->slug}");

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'title' => $question->title,
            'body' => $question->body,
            'created_at' => $question->created_at->diffForHumans()
        ]);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_create_a_question()
    {
        $questionAttributes = factory('App\Model\Question')->raw();
     
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->post('/api/questions', $questionAttributes);

        $response->assertStatus(400);
    }

    /** @test */
    public function an_unauthenticated_user_cannot_update_a_question()
    {
        $question = factory('App\Model\Question')->create();
     
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->patch("/api/questions/{$question->slug}");

        $response->assertStatus(400);
    }
    /** @test */
    public function an_unauthenticated_user_cannot_delete_a_question()
    {
        $question = factory('App\Model\Question')->create();
     
        $response = $this->withHeaders([
            'Accept' => 'application/json'
        ])->delete("/api/questions/{$question->slug}");

        $response->assertStatus(400);
    }

    /** @test */
    // public function an_authenticated_user_can_create_a_question()
    // {
    //     $user = factory('App\User')->create();

    //     $this->actingAs($user);

    //     $question = factory('App\Model\Question')->raw();

    //     $response = $this->post('/api/questions', $question);

    //     dd($response);

    //     $response->assertStatus(201);
    // }
}
