<?php

namespace Database\Seeders;

use App\Models\HomeSectionSetting;
use Illuminate\Database\Seeder;

class HomeSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $homeSection = new HomeSectionSetting();
        $homeSection->updateOrCreate(
            ['language' => 'pt'], //pt
            [
                'language' => 'pt',
                'category_section_one' => 1,
                'category_section_two' => 2,
                'category_section_three' => 3,
                'category_section_four' => 1,
            ]
        );

        $homeSection->updateOrCreate(
            ['language' => 'en'], //pt
            [
                'language' => 'en',
                'category_section_one' => 1,
                'category_section_two' => 1,
                'category_section_three' => 1,
                'category_section_four' => 1,
            ]
        );
    }
}
