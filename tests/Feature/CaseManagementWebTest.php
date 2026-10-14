<?php

namespace Tests\Feature;

use App\Models\MedicalCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CaseManagementWebTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $viewer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'name' => 'Admin Tester',
            'email' => 'admin.test@jajalmedical.com',
            'role' => 'Admin',
        ]);

        $this->viewer = User::factory()->create([
            'name' => 'Viewer Tester',
            'email' => 'viewer.test@jajalmedical.com',
            'role' => 'Viewer',
        ]);
    }

    public function test_guest_is_redirected_to_login_when_accessing_dashboard(): void
    {
        $response = $this->get(route('dashboard'));
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_admin_can_access_dashboard_with_stats(): void
    {
        MedicalCase::factory()->create(['status' => 'Planning', 'created_by' => $this->admin->id]);
        MedicalCase::factory()->create(['status' => 'Approved', 'created_by' => $this->admin->id]);

        $response = $this->actingAs($this->admin)->get(route('dashboard'));

        $response->assertOk();
        $response->assertSee('Clinical Dashboard');
        $response->assertSee('Planning');
        $response->assertSee('Approved');
    }

    public function test_authenticated_viewer_can_access_dashboard(): void
    {
        $response = $this->actingAs($this->viewer)->get(route('dashboard'));

        $response->assertOk();
        $response->assertSee('Clinical Dashboard');
    }

    public function test_both_admin_and_viewer_can_view_cases_index(): void
    {
        $case = MedicalCase::factory()->create([
            'case_number' => 'CAS-2026-TEST',
            'surgeon_name' => 'Dr. Test Surgeon',
            'created_by' => $this->admin->id,
        ]);

        $adminResponse = $this->actingAs($this->admin)->get(route('cases.index'));
        $adminResponse->assertOk();
        $adminResponse->assertSee('CAS-2026-TEST');
        $adminResponse->assertSee('Dr. Test Surgeon');

        $viewerResponse = $this->actingAs($this->viewer)->get(route('cases.index'));
        $viewerResponse->assertOk();
        $viewerResponse->assertSee('CAS-2026-TEST');
    }

    public function test_case_search_and_filters_work_on_index(): void
    {
        MedicalCase::factory()->create([
            'case_number' => 'CAS-ALPHA-1',
            'surgeon_name' => 'Dr. Smith',
            'status' => 'Planning',
            'created_by' => $this->admin->id,
        ]);

        MedicalCase::factory()->create([
            'case_number' => 'CAS-BETA-2',
            'surgeon_name' => 'Dr. Johnson',
            'status' => 'Completed',
            'created_by' => $this->admin->id,
        ]);

        $response = $this->actingAs($this->admin)->get(route('cases.index', ['status' => 'Planning']));
        $response->assertOk();
        $response->assertSee('CAS-ALPHA-1');
        $response->assertDontSee('CAS-BETA-2');

        $searchResponse = $this->actingAs($this->admin)->get(route('cases.index', ['surgeon_name' => 'Johnson']));
        $searchResponse->assertOk();
        $searchResponse->assertSee('CAS-BETA-2');
        $searchResponse->assertDontSee('CAS-ALPHA-1');
    }

    public function test_admin_can_view_create_case_page(): void
    {
        $response = $this->actingAs($this->admin)->get(route('cases.create'));
        $response->assertOk();
        $response->assertSee('Create New Medical Case');
    }

    public function test_viewer_is_forbidden_from_create_case_page(): void
    {
        $response = $this->actingAs($this->viewer)->get(route('cases.create'));
        $response->assertForbidden();
    }

    public function test_admin_can_create_a_case(): void
    {
        $payload = [
            'case_number' => 'CAS-2026-NEW01',
            'patient_reference' => 'PT-REF-01',
            'surgeon_name' => 'Dr. Leading Surgeon',
            'implant_type' => 'PEEK Patient-Specific Cranial Implant',
            'status' => 'Planning',
            'priority' => 'High',
            'surgery_date' => '2026-11-15',
        ];

        $response = $this->actingAs($this->admin)->post(route('cases.store'), $payload);

        $this->assertDatabaseHas('cases', [
            'case_number' => 'CAS-2026-NEW01',
            'patient_reference' => 'PT-REF-01',
            'surgeon_name' => 'Dr. Leading Surgeon',
            'status' => 'Planning',
            'priority' => 'High',
            'created_by' => $this->admin->id,
        ]);

        $createdCase = MedicalCase::where('case_number', 'CAS-2026-NEW01')->first();
        $response->assertRedirect(route('cases.show', $createdCase));
    }

    public function test_viewer_cannot_create_a_case(): void
    {
        $payload = [
            'case_number' => 'CAS-2026-FORBIDDEN',
            'patient_reference' => 'PT-REF-FORBIDDEN',
            'surgeon_name' => 'Dr. Unauthorized',
            'implant_type' => 'Custom Mesh',
            'status' => 'Planning',
            'priority' => 'Low',
        ];

        $response = $this->actingAs($this->viewer)->post(route('cases.store'), $payload);
        $response->assertForbidden();

        $this->assertDatabaseMissing('cases', [
            'case_number' => 'CAS-2026-FORBIDDEN',
        ]);
    }

    public function test_both_admin_and_viewer_can_view_case_details(): void
    {
        $case = MedicalCase::factory()->create([
            'case_number' => 'CAS-2026-DETAIL',
            'created_by' => $this->admin->id,
        ]);

        $adminResponse = $this->actingAs($this->admin)->get(route('cases.show', $case));
        $adminResponse->assertOk();
        $adminResponse->assertSee('CAS-2026-DETAIL');

        $viewerResponse = $this->actingAs($this->viewer)->get(route('cases.show', $case));
        $viewerResponse->assertOk();
        $viewerResponse->assertSee('CAS-2026-DETAIL');
    }

    public function test_admin_can_update_a_case(): void
    {
        $case = MedicalCase::factory()->create([
            'case_number' => 'CAS-2026-TOUPDATE',
            'surgeon_name' => 'Original Surgeon',
            'created_by' => $this->admin->id,
        ]);

        $payload = [
            'case_number' => 'CAS-2026-TOUPDATE',
            'patient_reference' => $case->patient_reference,
            'surgeon_name' => 'Updated Surgeon Name',
            'implant_type' => $case->implant_type,
            'status' => 'Approved',
            'priority' => 'High',
            'surgery_date' => '2026-12-01',
        ];

        $response = $this->actingAs($this->admin)->put(route('cases.update', $case), $payload);
        $response->assertRedirect(route('cases.show', $case));

        $this->assertDatabaseHas('cases', [
            'id' => $case->id,
            'surgeon_name' => 'Updated Surgeon Name',
            'status' => 'Approved',
        ]);
    }

    public function test_viewer_cannot_update_a_case(): void
    {
        $case = MedicalCase::factory()->create([
            'case_number' => 'CAS-2026-NOUPDATE',
            'created_by' => $this->admin->id,
        ]);

        $payload = [
            'case_number' => 'CAS-2026-NOUPDATE',
            'patient_reference' => $case->patient_reference,
            'surgeon_name' => 'Hacker Name',
            'implant_type' => $case->implant_type,
            'status' => 'Approved',
            'priority' => 'High',
        ];

        $response = $this->actingAs($this->viewer)->put(route('cases.update', $case), $payload);
        $response->assertForbidden();
    }

    public function test_admin_can_delete_a_case(): void
    {
        $case = MedicalCase::factory()->create([
            'case_number' => 'CAS-2026-DELETE',
            'created_by' => $this->admin->id,
        ]);

        $response = $this->actingAs($this->admin)->delete(route('cases.destroy', $case));
        $response->assertRedirect(route('cases.index'));

        $this->assertDatabaseMissing('cases', [
            'id' => $case->id,
        ]);
    }

    public function test_viewer_cannot_delete_a_case(): void
    {
        $case = MedicalCase::factory()->create([
            'case_number' => 'CAS-2026-NODELETE',
            'created_by' => $this->admin->id,
        ]);

        $response = $this->actingAs($this->viewer)->delete(route('cases.destroy', $case));
        $response->assertForbidden();

        $this->assertDatabaseHas('cases', [
            'id' => $case->id,
        ]);
    }
}
