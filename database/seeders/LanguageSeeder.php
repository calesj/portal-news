<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $language = new Language();
        $language->name = 'Portuguese (Brazil)';
        $language->lang = 'pt';
        $language->slug = 'pt';
        $language->default = 1;
        $language->status = 1;
        $language->save();
    }
}
