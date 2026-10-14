<?php

namespace Database\Factories;

use App\Models\MedicalCase;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MedicalCase>
 */
class MedicalCaseFactory extends Factory
{
    protected $model = MedicalCase::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $implantTypes = [
            'PEEK Patient-Specific Cranial Implant',
            '3D-Printed Titanium Mandibular Reconstruction Plate',
            'Trabecular Titanium Acetabular Revision Cup',
            'Patient-Specific Maxillofacial Mesh',
            'Custom Porous Hip Stem',
            'Custom Spinal Interbody Fusion Cage',
            'Patient-Specific Knee Surgical Guide & Plate',
            'Custom Sternum Reconstruction Plate',
            'Subperiosteal Dental Implant Framework',
            'Temporomandibular Joint (TMJ) Prosthesis',
            'Titanium Orbital Floor Mesh',
            'Custom Pediatric Femoral Lengthening Implant',
        ];

        $surgeons = [
            'Dr. Sarah Jenkins, MD, FACS',
            'Dr. Michael Patel, MS, MCh (Orth)',
            'Dr. Elena Rostova, MD, PhD',
            'Dr. Marcus Vance, MD, DDS',
            'Dr. Rajeshwar Sharma, MS (Orth)',
            'Dr. Emily Chen, MD, MPH',
            'Dr. David Alverez, MD, FICS',
            'Dr. Fatima Al-Mansoor, MD, FRCS',
            'Dr. Jonathan Hayes, MD',
            'Dr. Christine Weber, MD, PhD',
        ];

        return [
            'case_number' => 'CAS-' . fake()->unique()->numerify('2026-#####'),
            'patient_reference' => 'PT-' . strtoupper(fake()->bothify('?#?###')),
            'surgeon_name' => fake()->randomElement($surgeons),
            'implant_type' => fake()->randomElement($implantTypes),
            'status' => fake()->randomElement(MedicalCase::STATUSES),
            'priority' => fake()->randomElement(MedicalCase::PRIORITIES),
            'surgery_date' => fake()->boolean(80) ? fake()->dateTimeBetween('-1 month', '+3 months')->format('Y-m-d') : null,
            'created_by' => User::factory(),
        ];
    }
}
