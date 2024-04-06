<?php

namespace Database\Seeders;

use App\Models\Ad;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ad::updateOrCreate(
            ['id' => 1], [
            'home_top_bar_ad' => 'teste',
            'home_middle_ad' => 'teste',
            'view_page_ad' => 'teste',
            'news_page_ad' => 'teste',
            'side_bar_ad' => 'teste',
            'home_top_bar_ad_status' => 1,
            'home_middle_ad_status' => 1,
            'view_page_ad_status' => 1,
            'news_page_ad_status' => 1,
            'side_bar_ad_status' => 1,
            'home_top_bar_ad_url' => 'teste',
            'home_middle_ad_url' => 'teste',
            'view_page_ad_url' => 'teste',
            'news_page_ad_url' => 'teste',
            'side_bar_ad_url' => 'teste',
        ]);
    }
}
