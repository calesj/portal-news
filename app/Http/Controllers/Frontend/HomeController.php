<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $breakingNews = News::where([
            'is_breaking_news' => 1,
        ])->activeEntries()->withLocalize()->orderBy('id', 'DESC')->take(10)->get();


        return view('frontend.home', compact('breakingNews'));
    }

    /**
     * @param string $slug
     * @return View
     */
    public function showNews(string $slug): View
    {
        $news = News::with(['auther', 'tags']) // eager loading -- carregando tudo em apenas uma consulta ao banco
        ->where('slug', $slug)
            ->activeEntries()
            ->withLocalize()
            ->first();

        $recentNews = News::with(['category', 'auther'])
            ->where('slug', '!=', $slug)
            ->activeEntries()
            ->withLocalize()
            ->orderBy('id', 'DESC')
            ->take(4)->get();

        $mostCommonTags = $this->mostCommonTags();

        $this->countView($news);

        return view('frontend.news-detail', compact('news', 'recentNews', 'mostCommonTags'));
    }

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

    public function mostCommonTags()
    {
        return Tag::select('name', DB::raw('COUNT(*) as count'))
            ->where('language', getLanguage())
            ->groupBy('name')
            ->orderByDesc('count')
            ->take(15)
            ->get();
    }
}
