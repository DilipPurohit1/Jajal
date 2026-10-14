<?php

namespace Tests\Feature;

use App\Models\MedicalCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CaseManagementApiTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $viewer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'name' => 'API Admin',
            'email' => 'admin.api@jajalmedical.com',
            'password' => Hash::make('Password123!'),
            'role' => 'Admin',
        ]);

        $this->viewer = User::factory()->create([
            'name' => 'API Viewer',
            'email' => 'viewer.api@jajalmedical.com',
            'password' => Hash::make('Password123!'),
            'role' => 'Viewer',
        ]);
    }

    public function test_api_login_returns_token_and_user_profile(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => 'admin.api@jajalmedical.com',
            'password' => 'Password123!',
        ]);

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Authentication successful.',
            ])
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'user' => ['id', 'name', 'email', 'role'],
                    'token',
                    'token_type',
                ],
            ]);
    }

    public function test_api_login_fails_with_invalid_credentials(): void
    {
        $response = $this->postJson('/api/login', [
            'email' => 'admin.api@jajalmedical.com',
            'password' => 'WrongPassword',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'success' => false,
            ]);
    }

    public function test_api_logout_revokes_token(): void
    {
        $token = $this->admin->createToken('test_token')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/logout');

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Operation successful. Token revoked.',
            ]);

        $this->assertCount(0, $this->admin->fresh()->tokens);
    }

    public function test_unauthenticated_api_request_returns_401(): void
    {
        $response = $this->getJson('/api/cases');

        $response->assertStatus(401)
            ->assertJson([
                'success' => false,
                'message' => 'Unauthenticated.',
            ]);
    }

    public function test_both_admin_and_viewer_can_list_cases_via_api(): void
    {
        MedicalCase::factory()->count(5)->create(['created_by' => $this->admin->id]);

        $adminToken = $this->admin->createToken('admin_token')->plainTextToken;
        $viewerToken = $this->viewer->createToken('viewer_token')->plainTextToken;

        $adminResponse = $this->withHeader('Authorization', "Bearer {$adminToken}")
            ->getJson('/api/cases');

        $adminResponse->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Operation successful',
            ])
            ->assertJsonStructure([
                'data' => ['data', 'current_page', 'total'],
            ]);

        $viewerResponse = $this->withHeader('Authorization', "Bearer {$viewerToken}")
            ->getJson('/api/cases');

        $viewerResponse->assertOk()
            ->assertJson(['success' => true]);
    }

    public function test_api_search_and_filter_parameters(): void
    {
        MedicalCase::factory()->create([
            'case_number' => 'CAS-FILTER-101',
            'status' => 'Planning',
            'created_by' => $this->admin->id,
        ]);

        MedicalCase::factory()->create([
            'case_number' => 'CAS-FILTER-202',
            'status' => 'Completed',
            'created_by' => $this->admin->id,
        ]);

        $token = $this->admin->createToken('token')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->getJson('/api/cases?status=Planning');

        $response->assertOk();
        $this->assertStringContainsString('CAS-FILTER-101', $response->getContent());
        $this->assertStringNotContainsString('CAS-FILTER-202', $response->getContent());
    }

    public function test_admin_can_create_case_via_api(): void
    {
        $token = $this->admin->createToken('admin_token')->plainTextToken;

        $payload = [
            'case_number' => 'CAS-API-CREATE-01',
            'patient_reference' => 'PT-API-001',
            'surgeon_name' => 'Dr. Api Surgeon',
            'implant_type' => 'Custom Titanium Hip Stem',
            'status' => 'Planning',
            'priority' => 'High',
            'surgery_date' => '2026-11-20',
        ];

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/cases', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'data' => [
                    'case_number' => 'CAS-API-CREATE-01',
                    'surgeon_name' => 'Dr. Api Surgeon',
                    'status' => 'Planning',
                ],
            ]);

        $this->assertDatabaseHas('cases', [
            'case_number' => 'CAS-API-CREATE-01',
            'created_by' => $this->admin->id,
        ]);
    }

    public function test_viewer_is_forbidden_from_creating_case_via_api(): void
    {
        $token = $this->viewer->createToken('viewer_token')->plainTextToken;

        $payload = [
            'case_number' => 'CAS-API-ILLEGAL-01',
            'patient_reference' => 'PT-ILLEGAL',
            'surgeon_name' => 'Dr. Unauthorized',
            'implant_type' => 'Custom Mesh',
            'status' => 'Draft',
            'priority' => 'Low',
        ];

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/cases', $payload);

        $response->assertStatus(403)
            ->assertJson([
                'success' => false,
            ]);

        $this->assertDatabaseMissing('cases', [
            'case_number' => 'CAS-API-ILLEGAL-01',
        ]);
    }

    public function test_api_case_creation_validation_errors(): void
    {
        $token = $this->admin->createToken('admin_token')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/cases', [
                'case_number' => '',
                'surgeon_name' => '',
                'status' => 'InvalidStatusValue',
            ]);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
            ])
            ->assertJsonStructure([
                'success',
                'message',
                'errors' => ['case_number', 'patient_reference', 'surgeon_name', 'implant_type', 'status', 'priority'],
            ]);
    }

    public function test_get_single_case_details_via_api(): void
    {
        $case = MedicalCase::factory()->create([
            'case_number' => 'CAS-API-SHOW',
            'created_by' => $this->admin->id,
        ]);

        $token = $this->viewer->createToken('viewer_token')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->getJson("/api/cases/{$case->id}");

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'data' => [
                    'id' => $case->id,
                    'case_number' => 'CAS-API-SHOW',
                ],
            ]);
    }

    public function test_get_non_existent_case_returns_404(): void
    {
        $token = $this->viewer->createToken('viewer_token')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->getJson('/api/cases/999999');

        $response->assertStatus(404)
            ->assertJson([
                'success' => false,
            ]);
    }

    public function test_admin_can_update_case_via_api(): void
    {
        $case = MedicalCase::factory()->create([
            'case_number' => 'CAS-API-UPDATE',
            'status' => 'Planning',
            'created_by' => $this->admin->id,
        ]);

        $token = $this->admin->createToken('admin_token')->plainTextToken;

        $payload = [
            'case_number' => 'CAS-API-UPDATE',
            'patient_reference' => $case->patient_reference,
            'surgeon_name' => 'Dr. Updated API Surgeon',
            'implant_type' => $case->implant_type,
            'status' => 'Completed',
            'priority' => 'High',
            'surgery_date' => '2026-12-05',
        ];

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->putJson("/api/cases/{$case->id}", $payload);

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'data' => [
                    'surgeon_name' => 'Dr. Updated API Surgeon',
                    'status' => 'Completed',
                ],
            ]);

        $this->assertDatabaseHas('cases', [
            'id' => $case->id,
            'status' => 'Completed',
            'surgeon_name' => 'Dr. Updated API Surgeon',
        ]);
    }

    public function test_viewer_is_forbidden_from_updating_case_via_api(): void
    {
        $case = MedicalCase::factory()->create([
            'case_number' => 'CAS-API-NOUPDATE',
            'created_by' => $this->admin->id,
        ]);

        $token = $this->viewer->createToken('viewer_token')->plainTextToken;

        $payload = [
            'case_number' => 'CAS-API-NOUPDATE',
            'patient_reference' => $case->patient_reference,
            'surgeon_name' => 'Hacker Name',
            'implant_type' => $case->implant_type,
            'status' => 'Approved',
            'priority' => 'High',
        ];

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->putJson("/api/cases/{$case->id}", $payload);

        $response->assertStatus(403)
            ->assertJson([
                'success' => false,
            ]);
    }

    public function test_admin_can_delete_case_via_api(): void
    {
        $case = MedicalCase::factory()->create([
            'case_number' => 'CAS-API-DELETE',
            'created_by' => $this->admin->id,
        ]);

        $token = $this->admin->createToken('admin_token')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->deleteJson("/api/cases/{$case->id}");

        $response->assertOk()
            ->assertJson([
                'success' => true,
                'message' => 'Operation successful',
            ]);

        $this->assertDatabaseMissing('cases', ['id' => $case->id]);
    }

    public function test_viewer_is_forbidden_from_deleting_case_via_api(): void
    {
        $case = MedicalCase::factory()->create([
            'case_number' => 'CAS-API-NODELETE',
            'created_by' => $this->admin->id,
        ]);

        $token = $this->viewer->createToken('viewer_token')->plainTextToken;

        $response = $this->withHeader('Authorization', "Bearer {$token}")
            ->deleteJson("/api/cases/{$case->id}");

        $response->assertStatus(403)
            ->assertJson([
                'success' => false,
            ]);

        $this->assertDatabaseHas('cases', ['id' => $case->id]);
    }
}
