<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\News;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $heroSlider = News::with(['category', 'auther'])
            ->where([
            'show_at_slider' => 1,
        ])->activeEntries()->withLocalize()->orderBy('id', 'DESC')->take(7)->get();


        return view('frontend.home', compact('breakingNews', 'heroSlider'));
    }

    /**
     * @param string $slug
     * @return View
     */
    public function showNews(string $slug): View
    {
        $news = News::with(['auther', 'tags', 'comments']) // eager loading -- carregando tudo em apenas uma consulta ao banco
        ->where('slug', $slug)
            ->activeEntries()
            ->withLocalize()
            ->first();

        $this->countView($news);

        /** noticias criadas recentementes */
        $recentNews = News::with(['category', 'auther'])
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

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function handleComment(Request $request): RedirectResponse
    {
        $request->validate([
            'comment' => ['required', 'string', 'max:1000']
        ]);

        $comment = new Comment();
        $comment->news_id = $request->news_id;
        $comment->user_id = Auth::user()->id;
        $comment->parent_id = $request->parent_id;
        $comment->comment = $request->comment;
        $comment->save();

        toast(__('Comment added successfully'), 'success');
        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function handleReplay(Request $request): RedirectResponse
    {
        $request->validate([
            'reply' => ['required', 'string', 'max:1000']
        ]);

        $comment = new Comment();
        $comment->news_id = $request->news_id;
        $comment->user_id = Auth::user()->id;
        $comment->parent_id = $request->parent_id;
        $comment->comment = $request->reply;
        $comment->save();

        toast(__('Comment added successfully'), 'success');
        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function commentDestroy(Request $request): JsonResponse
    {
        $comment = Comment::findOrFail($request->id);
        if (Auth::user()->id === $comment->user_id) {
            $comment->delete();
            return response()->json(['status' => 'success', 'message' => __('Deleted Successfully!')]);
        }

        return response()->json(['status' => 'error', 'message' => __('Someting went wrong!')]);
    }
}
