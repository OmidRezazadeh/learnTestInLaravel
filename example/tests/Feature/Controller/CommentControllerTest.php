<?php

namespace Controller;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCommentWhenUserLoggedIn()
    {
        $this->withExceptionHandling();
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $data = Comment::factory()->state([
            'user_id' => $user->id,
            'commentable_id' => $post->id,
        ])->make()->toArray();

        $response =
            $this->actingAs($user)
                ->post(
                    route('single.comment', $post->id),
                    ['text' => $data['text']]
                );

        $response->assertRedirect(route('single', $post->id));
        $this->assertDatabaseHas('comments', $data);

    }


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCommentWhenUserNotLoggedIn()
    {
//        $this->withExceptionHandling();
        $post = Post::factory()->create();

        $data = Comment::factory()->state([
            'commentable_id' => $post->id,
        ])->make()->toArray();
        unset($data['user_id']);
        $response = $this->post(
            route('single.comment', $post->id),
            ['text' => $data['text']]
        );

        $response->assertRedirect(route('login'));
        $this->assertDatabaseMissing('comments', $data);

    }
}
