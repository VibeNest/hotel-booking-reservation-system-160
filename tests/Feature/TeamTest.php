<?php

namespace Tests\Feature;

use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeamTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_team()
    {

        $this->withoutMiddleware();

        // 1. Tạo dữ liệu giả
        $team = Team::factory()->create();

        // 2. Gửi request delete (route is GET)
        $response = $this->get(route('delete.team', $team->id));

        // 3. Check không lỗi
        $response->assertStatus(302);

        // 4. Check DB đã xóa
        $this->assertDatabaseMissing('teams', [
            'id' => $team->id,
        ]);
    }
}
