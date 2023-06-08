<?php

namespace Tests\Feature\Controller;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndexMethod()
    {
        Post::factory()->count(100)->create();
        $response = $this->get(route('home'));
        $response->assertStatus(200);
        $response->assertViewIs('welcome');
        $response->assertViewHas('posts',Post::latest()->paginate(15));
    }

    public function testSingleMethod(){
        $this->withExceptionHandling();
        $post= Post::factory()->hasComments(0,3)->create();
        $response= $this->get(route('single', $post->id));
        $response->assertOk();
        $response->assertViewIs('single');
        $response->assertViewHasAll([
           'post'=>$post,
           'comments'=>$post->comments()->latest()->paginate(15)
        ]);
    }
}
