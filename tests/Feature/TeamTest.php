<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeamTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_team()
    {
        // 1. Tạo dữ liệu giả
        $team = Team::factory()->create();

        // 2. Gửi request delete
        $response = $this->delete(route('delete.team', $team->id));

        // 3. Check không lỗi
        $response->assertStatus(302);

        // 4. Check DB đã xóa
        $this->assertDatabaseMissing('teams', [
            'id' => $team->id
        ]);
    }
}