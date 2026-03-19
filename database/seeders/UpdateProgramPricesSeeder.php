<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Program;

class UpdateProgramPricesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = Program::all();
        
        foreach ($programs as $program) {
            $program->price = 120000;
            $program->save();
            
            $this->command->info("Updated program '{$program->title}' price to MWK 120,000");
        }
        
        $this->command->info("Successfully updated {$programs->count()} programs to MWK 120,000");
    }
}
