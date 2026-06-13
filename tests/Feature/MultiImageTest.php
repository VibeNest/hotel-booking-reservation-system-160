<?php

namespace Tests\Feature;

use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class MultiImageTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_update_room_and_store_multiple_images()
    {
        $this->withoutMiddleware();
        $room = Room::factory()->create();

        // ✅ dùng image() (cần GD)
        $files = [
            UploadedFile::fake()->image('img1.jpg'),
            UploadedFile::fake()->image('img2.jpg'),
        ];

        $response = $this->post(route('update.room', $room->id), [
            'roomtype_id' => 1,
            'total_adult' => 2,
            'total_child' => 1,
            'room_capacity' => 3,
            'price' => 100,
            'size' => 50,
            'view' => 'Sea',
            'bed_style' => 'King',
            'discount' => 0,
            'short_desc' => 'Test',
            'description' => 'Test desc',
            'facility_name' => ['Wifi', 'TV'],
            'multi_img' => $files,
        ]);

        $response->assertRedirect();

        $this->assertDatabaseCount('multi_images', 2);

        $this->assertDatabaseHas('multi_images', [
            'rooms_id' => $room->id,
        ]);
    }

    public function test_it_returns_error_if_no_facility_selected()
    {
        $this->withoutMiddleware();
        $room = Room::factory()->create();

        $response = $this->post(route('update.room', $room->id), [
            'roomtype_id' => 1,
            'total_adult' => 2,
            'total_child' => 1,
            'room_capacity' => 3,
            'price' => 100,
            'size' => 50,
            'view' => 'Sea',
            'bed_style' => 'King',
            'discount' => 0, // 🔥 QUAN TRỌNG
            'short_desc' => 'Test',
            'description' => 'Test desc',
        ]);

        $response->assertSessionHas('message', 'Sorry! Not Any Basic Facility Select');
    }

    public function test_it_replaces_old_multi_images_when_updating()
    {
        $this->withoutMiddleware();
        $room = Room::factory()->create();

        // lần 1
        $this->post(route('update.room', $room->id), [
            'roomtype_id' => 1,
            'total_adult' => 2,
            'total_child' => 1,
            'room_capacity' => 3,
            'price' => 100,
            'size' => 50,
            'view' => 'Sea',
            'bed_style' => 'King',
            'discount' => 0, // 🔥 QUAN TRỌNG
            'short_desc' => 'Test',
            'description' => 'Test desc',
            'facility_name' => ['Wifi'],
            'multi_img' => [
                UploadedFile::fake()->image('old.jpg'),
            ],
        ]);

        $this->assertDatabaseCount('multi_images', 1);

        // lần 2
        $this->post(route('update.room', $room->id), [
            'roomtype_id' => 1,
            'facility_name' => ['Wifi'],
            'multi_img' => [
                UploadedFile::fake()->image('new1.jpg'),
                UploadedFile::fake()->image('new2.jpg'),
            ],
        ]);

        $this->assertDatabaseCount('multi_images', 2);
    }
}
