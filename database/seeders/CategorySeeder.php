<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = new Category();
        $category->updateOrCreate(
            ['id' => 1], [
            'language' => 'pt',
            'name' => 'Economicas',
            'slug' => Str::slug('Economicas'),
            'show_at_nav' => 1,
            'status' => 1,
        ]);

        $category = new Category();
        $category->updateOrCreate(
            ['id' => 2], [
            'language' => 'pt',
            'name' => 'Ibge',
            'slug' => Str::slug('Ibge'),
            'show_at_nav' => 1,
            'status' => 1,
        ]);

        $category = new Category();
        $category->updateOrCreate(
            ['id' => 3], [
            'language' => 'pt',
            'name' => 'Global',
            'slug' => Str::slug('Global'),
            'show_at_nav' => 1,
            'status' => 1,
        ]);

        $category = new Category();
        $category->updateOrCreate(
            ['id' => 1], [
            'language' => 'en',
            'name' => 'Global',
            'slug' => Str::slug('Global'),
            'show_at_nav' => 1,
            'status' => 1,
        ]);
    }
}
