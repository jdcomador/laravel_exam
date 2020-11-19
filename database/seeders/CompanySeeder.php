<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company_data = [
            [
                "c_name" => "Company 1",
                "c_address" => "Quezon City",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "c_name" => "Company 2",
                "c_address" => "Marikina City",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "c_name" => "Company 3",
                "c_address" => "Pasig City",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "c_name" => "Company 4",
                "c_address" => "Malabon City",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "c_name" => "Company 5",
                "c_address" => "Caloocan City",
                "created_at" => now(),
                "updated_at" => now(),
            ],
        ];

        \DB::table('companies')->insert($company_data);
    }
}
