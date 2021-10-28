<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use App\Models\Group;
use App\Models\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class GroupTest extends TestCase
{
    use RefreshDatabase, WithFaker, WithoutMiddleware;

    public function test_can_create_a_group()
    {
        $group = Group::factory()->make();

        $response = $this->post(route('groups.store'), [
            "name" => $group->name
        ]);

        $response->assertSuccessful();

        $this->assertDatabaseHas('groups', [
            "name" => $group->name
        ]);
    }

    public function test_can_get_paginated_list_of_all_groups()
    {
        Group::factory()->count(25)->create();

        $response = $this->get(route('groups.index'));
        $response->assertSuccessful();

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    "name"
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

    public function test_can_get_a_single_group()
    {
        $group = Group::factory()->create();

        $response = $this->get(route('groups.show', $group->id));
        $response->assertSuccessful();
        $response->assertJson([
            'data' => [
                "name" => $group->name
            ],
            'meta' => [
                'success' => true,
                'message' => "Group found"
            ]
        ]);
    }

    public function test_can_update_a_group()
    {
        $group = Group::factory()->create();

        $response = $this->patch(route('groups.update', $group->id), [
            'name' => $name = $this->faker->words(5, true)
        ]);

        $response->assertSuccessful();
        $this->assertDatabaseHas('groups', [
            'id' => $group->id,
            'name' => $name
        ]);
    }

    public function test_can_delete_a_group()
    {
        $group = Group::factory()->create();
        $response = $this->delete(route('groups.destroy', $group->id));
        $response->assertSuccessful();
        $this->assertSoftDeleted('groups', [
            'id' => $group->id
        ]);
    }
}
