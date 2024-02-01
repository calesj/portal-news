<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\Traits\HomeTrait;
use App\Models\News;
use Illuminate\View\View;

class HomeController extends Controller
{
    use HomeTrait;
    /**
     * @return View
     */
    public function index(): View
    {
        $breakingNews = News::where(['is_breaking_news' => 1])
            ->activeEntries()
            ->withLocalize()
            ->orderBy('id', 'DESC')
            ->take(10)->get();

        $heroSlider = News::with(['category', 'author'])
            ->where(['show_at_slider' => 1])->activeEntries()
            ->withLocalize()
            ->orderBy('id', 'DESC')
            ->take(7)->get();

        $recentNews = News::with(['category', 'author'])
            ->activeEntries()
            ->withLocalize()
            ->orderBy('id', 'DESC')
            ->take(6)->get();

        $popularNews = News::with('category')
            ->where('show_at_popular', 1)
            ->activeEntries()
            ->withLocalize()
            ->orderBy('updated_at', 'DESC')
            ->take(4)->get();

        return view('frontend.home', compact('breakingNews', 'heroSlider', 'recentNews', 'popularNews'));
    }

    /**
     * Mostra os detalhes de uma noticia, e informações sobre outras para a tela de detalhes de noticia
     * @param string $slug
     * @return View
     */
    public function showNews(string $slug): View
    {
        $news = News::with(['author', 'tags', 'comments']) // eager loading -- carregando tudo em apenas uma consulta ao banco
        ->where('slug', $slug)
            ->activeEntries()
            ->withLocalize()
            ->first();

        $this->countView($news);

        /** noticias criadas recentementes */
        $recentNews = News::with(['category', 'author'])
            ->where('slug', '!=', $slug)
            ->activeEntries()
            ->withLocalize()
            ->orderBy('id', 'DESC')
            ->take(4)->get();

        /** tags mais comuns utilizadas */
        $mostCommonTags = $this->mostCommonTags();

        /** proximo post, seguindo a ordem do id */
        $nextPost = News::where('id', '>', $news->id)
            ->orderBy('id', 'ASC')
            ->activeEntries()
            ->withLocalize()
            ->first();

        /** post anterior, seguindo a ordem do id */
        $previousPost = News::where('id', '<', $news->id)
            ->orderBy('id', 'DESC')
            ->activeEntries()
            ->withLocalize()
            ->first();

        /** Posts relacionados */
        $relatedPosts = News::where('slug', '!=', $news->slug)
            ->where('category_id', $news->category_id)
            ->orderBy('id', 'DESC')
            ->activeEntries()
            ->withLocalize()
            ->take(5)
            ->get();

        return view(
            'frontend.news-detail',
            compact('news', 'recentNews', 'mostCommonTags', 'nextPost', 'previousPost', 'relatedPosts')
        );
    }
}
