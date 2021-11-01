<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use App\Models\User;
use App\Models\Friend;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class FriendTest extends TestCase
{
    use RefreshDatabase, WithFaker, WithoutMiddleware;

    public function test_can_create_a_friend()
    {
        $u1 = User::factory()->create();
        $u2 = User::factory()->create();

        $response = $this->post(route('users.friends.store', $u1->id), [
            "user1" => $u1->login,
            "user2" => $u2->login
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('friends', [
            "user1" => $u1->login,
            "user2" => $u2->login
        ]);
    }

    public function test_can_get_paginated_list_of_all_friends()
    {
        for ($i = 0; $i < 25; $i++) {
            $u1 = User::factory()->create();
            $u2 = User::factory()->create();

            $response = $this->post(route('users.friends.store', $u1->id), [
                "user1" => $u1->login,
                "user2" => $u2->login
            ]);

            $response->assertSuccessful();

            $this->assertDatabaseHas('friends', [
                "user1" => $u1->login,
                "user2" => $u2->login
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
}
