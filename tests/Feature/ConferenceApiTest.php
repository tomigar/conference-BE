<?php

namespace Tests\Feature;

use App\Models\Conference;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConferenceApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Create a test user
        $this->user = User::factory()->create([
            'role' => 'admin'
        ]);

        // Create a token for the user
        $this->token = $this->user->createToken('test-token')->plainTextToken;
    }

    /**
     * Test conference listing.
     *
     * @return void
     */
    public function test_can_list_conferences()
    {
        // Create some test conferences
        Conference::factory()->count(3)->create();

        // Make the API request with authentication
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/conferences');

        // Assert the response is correct
        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => [
                        'id',
                        'year',
                        'name',
                        'start_date',
                        'end_date',
                        'location',
                        'is_active'
                    ]
                ]
            ])
            ->assertJson([
                'success' => true
            ]);
    }

    /**
     * Test conference creation.
     *
     * @return void
     */
    public function test_can_create_conference()
    {
        $conferenceData = [
            'year' => 2025,
            'name' => 'Test Conference 2025',
            'start_date' => '2025-06-15',
            'end_date' => '2025-06-18',
            'location' => 'Test Location',
            'description' => 'Test Description',
            'is_active' => true
        ];

        // Make the API request with authentication
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/conferences', $conferenceData);

        // Assert the response is correct
        $response->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'year',
                    'name',
                    'start_date',
                    'end_date',
                    'location',
                    'description',
                    'is_active'
                ]
            ])
            ->assertJson([
                'success' => true,
                'message' => 'Conference created successfully'
            ]);

        // Assert the data was saved to the database
        $this->assertDatabaseHas('conferences', [
            'year' => 2025,
            'name' => 'Test Conference 2025'
        ]);
    }

    /**
     * Test conference retrieval.
     *
     * @return void
     */
    public function test_can_get_conference()
    {
        // Create a test conference
        $conference = Conference::factory()->create();

        // Make the API request with authentication
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/conferences/' . $conference->id);

        // Assert the response is correct
        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'id',
                    'year',
                    'name',
                    'start_date',
                    'end_date',
                    'location',
                    'is_active'
                ]
            ])
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => $conference->id
                ]
            ]);
    }

    /**
     * Test conference update.
     *
     * @return void
     */
    public function test_can_update_conference()
    {
        // Create a test conference
        $conference = Conference::factory()->create();

        $updatedData = [
            'year' => 2026,
            'name' => 'Updated Conference',
            'start_date' => '2026-07-15',
            'end_date' => '2026-07-18',
            'location' => 'Updated Location',
            'description' => 'Updated Description',
            'is_active' => false
        ];

        // Make the API request with authentication
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->putJson('/api/conferences/' . $conference->id, $updatedData);

        // Assert the response is correct
        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'year',
                    'name',
                    'start_date',
                    'end_date',
                    'location',
                    'description',
                    'is_active'
                ]
            ])
            ->assertJson([
                'success' => true,
                'message' => 'Conference updated successfully'
            ]);

        // Assert the data was updated in the database
        $this->assertDatabaseHas('conferences', [
            'id' => $conference->id,
            'year' => 2026,
            'name' => 'Updated Conference'
        ]);
    }

    /**
     * Test conference deletion.
     *
     * @return void
     */
    public function test_can_delete_conference()
    {
        // Create a test conference
        $conference = Conference::factory()->create();

        // Make the API request with authentication
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->deleteJson('/api/conferences/' . $conference->id);

        // Assert the response is correct
        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message'
            ])
            ->assertJson([
                'success' => true,
                'message' => 'Conference deleted successfully'
            ]);

        // Assert the data was deleted from the database
        $this->assertDatabaseMissing('conferences', [
            'id' => $conference->id
        ]);
    }
}
