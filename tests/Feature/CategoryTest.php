<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authenticated_user_ask_question()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $this->actingAs($user, 'api');

        $title = "Sss";
        $this->json('POST', '/categories', [
            'name' => $title,
            'slug' => str_slug($title)
        ])->assertStatus(201);
    }
}
