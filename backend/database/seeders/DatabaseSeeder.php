<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create default admin user
        DB::table('users')->insertOrIgnore([
            'name'       => 'VT Admin',
            'email'      => 'admin@vtkindergarten.com',
            'password'   => Hash::make('admin123'),
            'is_admin'   => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->command->info('✅ Admin user created: admin@vtkindergarten.com / admin123');

        DB::table('users')->updateOrInsert(
            ['email' => 'admin2@vtkindergarten.com'],
            [
                'name'       => 'VT Admin 2',
                'password'   => Hash::make('admin123'),
                'is_admin'   => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $this->command->info('Admin 2 ready: admin2@vtkindergarten.com / admin123');

        // Sample admissions
        $programs = [
            'Play Group (1.5-2.5 yrs)',
            'Nursery (2.5-3.5 yrs)',
            'LKG (3.5-4.5 yrs)',
            'UKG (4.5-5.5 yrs)',
        ];

        for ($i = 1; $i <= 5; $i++) {
            DB::table('admissions')->insertOrIgnore([
                'child_name'      => "Sample Child $i",
                'dob'             => now()->subYears(rand(2, 5))->format('Y-m-d'),
                'gender'          => $i % 2 === 0 ? 'Male' : 'Female',
                'program'         => $programs[($i - 1) % 4],
                'parent_name'     => "Parent Name $i",
                'relation'        => 'Father',
                'phone'           => '9' . str_pad($i, 9, '0', STR_PAD_LEFT),
                'email'           => "parent$i@example.com",
                'address'         => "$i Main Street, Karaikudi",
                'previous_school' => null,
                'message'         => null,
                'status'          => 'pending',
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);
        }

        // Sample enquiries
        for ($i = 1; $i <= 5; $i++) {
            DB::table('enquiries')->insertOrIgnore([
                'name'       => "Enquiry Person $i",
                'phone'      => '8' . str_pad($i, 9, '0', STR_PAD_LEFT),
                'email'      => "enquiry$i@example.com",
                'program'    => $programs[($i - 1) % 4],
                'message'    => "I want to know more about admission for my child.",
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('✅ Sample data seeded successfully.');
    }
}
