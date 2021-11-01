<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use App\Models\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker, WithoutMiddleware;

    public function test_can_get_paginated_list_of_all_users()
    {
        User::factory()->count(25)->create();

        $response = $this->get(route('users.index'));
        $response->assertSuccessful();

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    "lastname",
                    "firstname",
                    "login",
                    "coordinates",
                    "contaminated"
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

    public function test_can_get_a_single_user()
    {
        $user = User::factory()->create();
        $response = $this->get(route('users.show', $user->id));
        $response->assertSuccessful();
        $response->assertJson([
            'data' => [
                "lastname" => $user->lastname,
                "firstname" => $user->firstname,
                "login" => $user->login,
                "coordinates" => $user->coordinates,
                "contaminated" => $user->contaminated
            ],
            'meta' => [
                'success' => true,
                'message' => "User found"
            ]
        ]);
    }

    public function test_can_update_an_user()
    {
        $user = User::factory()->create();

        $response = $this->patch(route('users.update', $user->id), [
            'password' => $pass = $this->faker->password()
        ]);

        $response->assertSuccessful();
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'password' => $pass
        ]);
    }

    public function test_can_delete_an_user()
    {
        $user = User::factory()->create();
        $response = $this->delete(route('users.destroy', $user->id));
        $response->assertSuccessful();
        $this->assertSoftDeleted('users', [
            'id' => $user->id
        ]);
    }
}
