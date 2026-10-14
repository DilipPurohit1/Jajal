<?php

namespace Database\Seeders;

use App\Models\MedicalCase;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed the Admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@jajalmedical.com'],
            [
                'name' => 'Dr. Alexander Wright (Admin)',
                'password' => Hash::make('Password123!'),
                'role' => 'Admin',
                'email_verified_at' => now(),
            ]
        );

        // 2. Seed the Viewer user
        $viewer = User::firstOrCreate(
            ['email' => 'viewer@jajalmedical.com'],
            [
                'name' => 'Clara Oswald (Clinical Viewer)',
                'password' => Hash::make('Password123!'),
                'role' => 'Viewer',
                'email_verified_at' => now(),
            ]
        );

        // 3. Clear existing cases for clean seeding
        MedicalCase::truncate();

        // 4. Seed structured realistic medical cases covering all statuses and priorities
        $curatedCases = [
            [
                'case_number' => 'CAS-2026-1001',
                'patient_reference' => 'PT-JM-4819',
                'surgeon_name' => 'Dr. Sarah Jenkins, MD, FACS',
                'implant_type' => 'PEEK Patient-Specific Cranial Implant',
                'status' => 'Planning',
                'priority' => 'High',
                'surgery_date' => now()->addDays(5)->format('Y-m-d'),
                'created_by' => $admin->id,
            ],
            [
                'case_number' => 'CAS-2026-1002',
                'patient_reference' => 'PT-JM-7721',
                'surgeon_name' => 'Dr. Michael Patel, MS, MCh (Orth)',
                'implant_type' => 'Trabecular Titanium Acetabular Revision Cup',
                'status' => 'In Review',
                'priority' => 'High',
                'surgery_date' => now()->addDays(9)->format('Y-m-d'),
                'created_by' => $admin->id,
            ],
            [
                'case_number' => 'CAS-2026-1003',
                'patient_reference' => 'PT-JM-3304',
                'surgeon_name' => 'Dr. Elena Rostova, MD, PhD',
                'implant_type' => '3D-Printed Titanium Mandibular Reconstruction Plate',
                'status' => 'Approved',
                'priority' => 'Medium',
                'surgery_date' => now()->addDays(14)->format('Y-m-d'),
                'created_by' => $admin->id,
            ],
            [
                'case_number' => 'CAS-2026-1004',
                'patient_reference' => 'PT-JM-9182',
                'surgeon_name' => 'Dr. Marcus Vance, MD, DDS',
                'implant_type' => 'Subperiosteal Dental Implant Framework',
                'status' => 'Completed',
                'priority' => 'Medium',
                'surgery_date' => now()->subDays(12)->format('Y-m-d'),
                'created_by' => $admin->id,
            ],
            [
                'case_number' => 'CAS-2026-1005',
                'patient_reference' => 'PT-JM-5529',
                'surgeon_name' => 'Dr. Rajeshwar Sharma, MS (Orth)',
                'implant_type' => 'Custom Porous Hip Stem',
                'status' => 'Completed',
                'priority' => 'Low',
                'surgery_date' => now()->subDays(20)->format('Y-m-d'),
                'created_by' => $admin->id,
            ],
            [
                'case_number' => 'CAS-2026-1006',
                'patient_reference' => 'PT-JM-6640',
                'surgeon_name' => 'Dr. Emily Chen, MD, MPH',
                'implant_type' => 'Custom Spinal Interbody Fusion Cage',
                'status' => 'Draft',
                'priority' => 'Low',
                'surgery_date' => null,
                'created_by' => $admin->id,
            ],
            [
                'case_number' => 'CAS-2026-1007',
                'patient_reference' => 'PT-JM-1208',
                'surgeon_name' => 'Dr. David Alverez, MD, FICS',
                'implant_type' => 'Temporomandibular Joint (TMJ) Prosthesis',
                'status' => 'Planning',
                'priority' => 'Medium',
                'surgery_date' => now()->addDays(22)->format('Y-m-d'),
                'created_by' => $admin->id,
            ],
            [
                'case_number' => 'CAS-2026-1008',
                'patient_reference' => 'PT-JM-8813',
                'surgeon_name' => 'Dr. Fatima Al-Mansoor, MD, FRCS',
                'implant_type' => 'Patient-Specific Knee Surgical Guide & Plate',
                'status' => 'In Review',
                'priority' => 'High',
                'surgery_date' => now()->addDays(7)->format('Y-m-d'),
                'created_by' => $admin->id,
            ],
            [
                'case_number' => 'CAS-2026-1009',
                'patient_reference' => 'PT-JM-4190',
                'surgeon_name' => 'Dr. Jonathan Hayes, MD',
                'implant_type' => 'Custom Sternum Reconstruction Plate',
                'status' => 'Approved',
                'priority' => 'High',
                'surgery_date' => now()->addDays(11)->format('Y-m-d'),
                'created_by' => $admin->id,
            ],
            [
                'case_number' => 'CAS-2026-1010',
                'patient_reference' => 'PT-JM-7341',
                'surgeon_name' => 'Dr. Christine Weber, MD, PhD',
                'implant_type' => 'Titanium Orbital Floor Mesh',
                'status' => 'Cancelled',
                'priority' => 'Low',
                'surgery_date' => null,
                'created_by' => $admin->id,
            ],
            [
                'case_number' => 'CAS-2026-1011',
                'patient_reference' => 'PT-JM-2901',
                'surgeon_name' => 'Dr. Sarah Jenkins, MD, FACS',
                'implant_type' => 'PEEK Patient-Specific Cranial Implant',
                'status' => 'Planning',
                'priority' => 'Medium',
                'surgery_date' => now()->addDays(18)->format('Y-m-d'),
                'created_by' => $admin->id,
            ],
            [
                'case_number' => 'CAS-2026-1012',
                'patient_reference' => 'PT-JM-6124',
                'surgeon_name' => 'Dr. Michael Patel, MS, MCh (Orth)',
                'implant_type' => 'Custom Pediatric Femoral Lengthening Implant',
                'status' => 'Approved',
                'priority' => 'High',
                'surgery_date' => now()->addDays(15)->format('Y-m-d'),
                'created_by' => $admin->id,
            ],
            [
                'case_number' => 'CAS-2026-1013',
                'patient_reference' => 'PT-JM-9402',
                'surgeon_name' => 'Dr. Elena Rostova, MD, PhD',
                'implant_type' => 'Patient-Specific Maxillofacial Mesh',
                'status' => 'Completed',
                'priority' => 'Medium',
                'surgery_date' => now()->subDays(5)->format('Y-m-d'),
                'created_by' => $admin->id,
            ],
            [
                'case_number' => 'CAS-2026-1014',
                'patient_reference' => 'PT-JM-3781',
                'surgeon_name' => 'Dr. Marcus Vance, MD, DDS',
                'implant_type' => 'Subperiosteal Dental Implant Framework',
                'status' => 'In Review',
                'priority' => 'Low',
                'surgery_date' => now()->addDays(28)->format('Y-m-d'),
                'created_by' => $admin->id,
            ],
            [
                'case_number' => 'CAS-2026-1015',
                'patient_reference' => 'PT-JM-8239',
                'surgeon_name' => 'Dr. Rajeshwar Sharma, MS (Orth)',
                'implant_type' => 'Trabecular Titanium Acetabular Revision Cup',
                'status' => 'Planning',
                'priority' => 'High',
                'surgery_date' => now()->addDays(4)->format('Y-m-d'),
                'created_by' => $admin->id,
            ],
            [
                'case_number' => 'CAS-2026-1016',
                'patient_reference' => 'PT-JM-5012',
                'surgeon_name' => 'Dr. Emily Chen, MD, MPH',
                'implant_type' => 'Custom Spinal Interbody Fusion Cage',
                'status' => 'Approved',
                'priority' => 'Medium',
                'surgery_date' => now()->addDays(12)->format('Y-m-d'),
                'created_by' => $admin->id,
            ],
            [
                'case_number' => 'CAS-2026-1017',
                'patient_reference' => 'PT-JM-1655',
                'surgeon_name' => 'Dr. David Alverez, MD, FICS',
                'implant_type' => '3D-Printed Titanium Mandibular Reconstruction Plate',
                'status' => 'Completed',
                'priority' => 'High',
                'surgery_date' => now()->subDays(25)->format('Y-m-d'),
                'created_by' => $admin->id,
            ],
            [
                'case_number' => 'CAS-2026-1018',
                'patient_reference' => 'PT-JM-4987',
                'surgeon_name' => 'Dr. Fatima Al-Mansoor, MD, FRCS',
                'implant_type' => 'Patient-Specific Knee Surgical Guide & Plate',
                'status' => 'Planning',
                'priority' => 'Low',
                'surgery_date' => now()->addDays(35)->format('Y-m-d'),
                'created_by' => $admin->id,
            ],
            [
                'case_number' => 'CAS-2026-1019',
                'patient_reference' => 'PT-JM-7703',
                'surgeon_name' => 'Dr. Jonathan Hayes, MD',
                'implant_type' => 'Custom Sternum Reconstruction Plate',
                'status' => 'In Review',
                'priority' => 'High',
                'surgery_date' => now()->addDays(6)->format('Y-m-d'),
                'created_by' => $admin->id,
            ],
            [
                'case_number' => 'CAS-2026-1020',
                'patient_reference' => 'PT-JM-2349',
                'surgeon_name' => 'Dr. Christine Weber, MD, PhD',
                'implant_type' => 'Titanium Orbital Floor Mesh',
                'status' => 'Draft',
                'priority' => 'Medium',
                'surgery_date' => null,
                'created_by' => $admin->id,
            ],
            [
                'case_number' => 'CAS-2026-1021',
                'patient_reference' => 'PT-JM-8910',
                'surgeon_name' => 'Dr. Sarah Jenkins, MD, FACS',
                'implant_type' => 'PEEK Patient-Specific Cranial Implant',
                'status' => 'Completed',
                'priority' => 'High',
                'surgery_date' => now()->subDays(8)->format('Y-m-d'),
                'created_by' => $admin->id,
            ],
            [
                'case_number' => 'CAS-2026-1022',
                'patient_reference' => 'PT-JM-3456',
                'surgeon_name' => 'Dr. Michael Patel, MS, MCh (Orth)',
                'implant_type' => 'Custom Porous Hip Stem',
                'status' => 'Planning',
                'priority' => 'Medium',
                'surgery_date' => now()->addDays(20)->format('Y-m-d'),
                'created_by' => $admin->id,
            ],
            [
                'case_number' => 'CAS-2026-1023',
                'patient_reference' => 'PT-JM-6789',
                'surgeon_name' => 'Dr. Elena Rostova, MD, PhD',
                'implant_type' => '3D-Printed Titanium Mandibular Reconstruction Plate',
                'status' => 'In Review',
                'priority' => 'High',
                'surgery_date' => now()->addDays(8)->format('Y-m-d'),
                'created_by' => $admin->id,
            ],
            [
                'case_number' => 'CAS-2026-1024',
                'patient_reference' => 'PT-JM-1122',
                'surgeon_name' => 'Dr. Marcus Vance, MD, DDS',
                'implant_type' => 'Subperiosteal Dental Implant Framework',
                'status' => 'Approved',
                'priority' => 'Low',
                'surgery_date' => now()->addDays(16)->format('Y-m-d'),
                'created_by' => $admin->id,
            ],
            [
                'case_number' => 'CAS-2026-1025',
                'patient_reference' => 'PT-JM-5566',
                'surgeon_name' => 'Dr. Rajeshwar Sharma, MS (Orth)',
                'implant_type' => 'Trabecular Titanium Acetabular Revision Cup',
                'status' => 'Completed',
                'priority' => 'High',
                'surgery_date' => now()->subDays(3)->format('Y-m-d'),
                'created_by' => $admin->id,
            ],
        ];

        foreach ($curatedCases as $caseData) {
            MedicalCase::create($caseData);
        }
    }
}
