<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use App\Models\User;
use App\Models\Friend;

class FriendTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_can_create_a_friend()
    {
        $u1 = User::factory()->create();
        $u2 = User::factory()->create();

        $response = $this->post(route('users.friends.store', $u1->id), [
            "user1" => $u1->id,
            "user2" => $u2->id
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('friends', [
            "user1" => $u1->id,
            "user2" => $u2->id
        ]);
    }

    public function test_can_get_paginated_list_of_all_friends()
    {
        for ($i = 0; $i < 25; $i++) {
            $u1 = User::factory()->create();
            $u2 = User::factory()->create();

            $response = $this->post(route('users.friends.store', $u1->id), [
                "user1" => $u1->id,
                "user2" => $u2->id
            ]);

            $response->assertSuccessful();

            $this->assertDatabaseHas('friends', [
                "user1" => $u1->id,
                "user2" => $u2->id
            ]);
        }
        $response = $this->get(route('users.friends.index', $u1->id));
        $response->assertSuccessful();

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    "user1",
                    "user2"
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

    public function test_can_get_a_single_friend()
    {
        $u1 = User::factory()->create();
        $u2 = User::factory()->create();

        $friend = $this->post(route('users.friends.store', $u1->id), [
            "user1" => $u1->id,
            "user2" => $u2->id
        ]);

        $friend->assertSuccessful();

        $response = $this->get(route('users.friends.show', ['user' => $u1->id, 'friend' => $u2->id]));
        $response->assertSuccessful();
        $response->assertJson([
            'data' => [
                "user1" => $u1->id,
                "user2" => $u2->id
            ],
            'meta' => [
                'success' => true,
                'message' => "friend found"
            ]
        ]);
    }

    public function test_can_delete_an_friend()
    {
        $u1 = User::factory()->create();
        $u2 = User::factory()->create();

        $friend = $this->post(route('users.friends.store', $u1->id), [
            "user1" => $u1->id,
            "user2" => $u2->id
        ]);
        
        $response = $this->delete(route('users.friends.destroy', ['user' => $u1->id, 'friend' => $u2->id]));
        $response->assertSuccessful();
        $this->assertSoftDeleted('friends', [
            'id' => $friend['data']['id']
        ]);
    }
}
