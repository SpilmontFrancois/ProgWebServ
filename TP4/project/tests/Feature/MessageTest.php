<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use App\Models\Message;
use App\Models\User;

class MessageTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_can_create_a_message()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $message = Message::factory()->make([
            'user1' => $user1->login,
            'user2' => $user2->login
        ]);

        $response = $this->post(route('messages.store'), [
            "user1" => $message->user1,
            "user2" => $message->user2,
            "content" => $message->content
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('messages', [
            "user1" => $message->user1,
            "user2" => $message->user2,
            "content" => $message->content
        ]);
    }

    public function test_can_get_paginated_list_of_all_messages()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        Message::factory()->count(25)->create([
            'user1' => $user1->login,
            'user2' => $user2->login
        ]);

        $response = $this->get(route('messages.index'));
        $response->assertSuccessful();

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    "user1",
                    "user2",
                    "content"
                ]
            ],
            'links' => [
                'first',
                'last',
                'prev',
                'next'
            ],
            'meta' => [
                "current_page",
                "from",
                "path",
                "per_page",
                "to"
            ]
        ]);
    }

    public function test_can_get_a_single_message()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $message = Message::factory()->create([
            'user1' => $user1->login,
            'user2' => $user2->login
        ]);

        $response = $this->get(route('messages.show', $message->id));
        $response->assertSuccessful();
        $response->assertJson([
            'data' => [
                "user1" => $message->user1,
                "user2" => $message->user2,
                "content" => $message->content
            ],
            'meta' => [

                'success' => true,
                'message' => "Message found"
            ]
        ]);
    }

    public function test_can_update_a_message()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $message = Message::factory()->create([
            'user1' => $user1->login,
            'user2' => $user2->login
        ]);

        $response = $this->patch(route('messages.update', $message->id), [
            'content' => $content = $this->faker->text()
        ]);

        $response->assertSuccessful();
        $this->assertDatabaseHas('messages', [
            'id' => $message->id,
            'content' => $content
        ]);
    }

    public function test_can_delete_a_message()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $message = Message::factory()->create([
            'user1' => $user1->login,
            'user2' => $user2->login
        ]);
        $response = $this->delete(route('messages.destroy', $message->id));
        $response->assertSuccessful();
        $this->assertSoftDeleted('messages', [
            'id' => $message->id
        ]);
    }
}
