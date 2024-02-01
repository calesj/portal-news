<?php

namespace App\Http\Controllers\Frontend\Traits;

use App\Models\Tag;
use Illuminate\Support\Facades\DB;

trait HomeTrait
{
    /**
     * INCREMENTANDO 1 NA QUANTIDADE DE VIEWS
     * @param $news
     * @return void
     */
    public function countView($news): void
    {
        if (session()->has('viewed_posts')) {
            $postIds = session('viewed_posts');

            if (!in_array($news->id, $postIds)) {
                $postIds[] = $news->id;
                $news->increment('views');
            }
            session(['viewed_posts' => $postIds]);

        } else {
            session(['viewed_posts' => [$news->id]]);

            $news->increment('views');
        }
    }

    /**
     * Retornando as tags mais utilizadas
     * @return mixed
     */
    public function mostCommonTags(): mixed
    {
        return Tag::select('name', DB::raw('COUNT(*) as count'))
            ->where('language', getLanguage())
            ->groupBy('name')
            ->orderByDesc('count')
            ->take(15)
            ->get();
    }
}
