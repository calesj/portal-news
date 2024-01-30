<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminNewsCreateRequest;
use App\Http\Requests\AdminNewsUpdateRequest;
use App\Models\Category;
use App\Models\Language;
use App\Models\News;
use App\Models\Tag;
use App\Traits\FileUploadTrait;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Throwable;

class NewsController extends Controller
{
    use FileUploadTrait;

    /**
     * @return View
     */
    public function index(): View
    {
        $languages = Language::all();
        return view('admin.news.index', compact('languages'));
    }

    /**
     * Fetch category depending on language
     * @param Request $request
     * @return mixed
     */
    public function fetchCategory(Request $request): mixed
    {
        return Category::where('language', $request->lang)->get();
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $languages = Language::all();
        return view('admin.news.create', compact('languages'));
    }

    public function store(AdminNewsCreateRequest $request): RedirectResponse
    {
        /** Handle Image */
        $imagePath = $this->handleFileUpload($request, 'image');

        $news = new News();
        $news->language = $request->language;
        $news->category_id = $request->category;
        $news->auther_id = Auth::guard('admin')->id();
        $news->image = $imagePath;
        $news->title = $request->title;
        $news->slug = Str::slug($request->title);
        $news->content = $request->input('content');
        $news->meta_title = $request->meta_title;
        $news->meta_description = $request->meta_description;
        $news->is_breaking_news = $request->is_breaking_news == 1 ? 1 : 0;
        $news->show_at_slider = $request->show_at_slider == 1 ? 1 : 0;
        $news->show_at_popular = $request->show_at_popular == 1 ? 1 : 0;
        $news->status = $request->status == 1 ? 1 : 0;
        $news->save();

        /** transformando as tags em itens de um array */
        $tags = explode(',', $request->tags);
        $tagIds = [];

        foreach ($tags as $tag) {
            $item = Tag::firstOrCreate(['name' => $tag]);
            $tagIds[] = $item->id;
        }

        $news->tags()->attach($tagIds);

        toast(__('Created SuccessFully!'), 'success')->width('350');

        return redirect()->route('admin.news.index');
    }


    /**
     * Change toggle status of news
     * @param Request $request
     * @return Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     * @throws Throwable
     */
    public function toggleNewsStatus(Request $request)
    {
        try {
            $news = News::findOrFail($request->id);
            $news->{$request->name} = $request->status;
            $news->save();

            return response(['status' => 'success', 'message' => __('Updated successfully!')]);
        } catch (Throwable $th) {
            throw $th;
        }
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $languages = Language::all();
        $news = News::findOrFail($id);
        $categories = Category::where('language', $news->language)->get();

        return view('admin.news.edit', compact('languages', 'news', 'categories'));
    }

    /**
     * @param AdminNewsUpdateRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(AdminNewsUpdateRequest $request, int $id)
    {
        $news = News::findOrFail($id);

        /** Handle Image */
        $imagePath = $this->handleFileUpload($request, 'image', $news->image);

        $news->language = $request->language;
        $news->category_id = $request->category;
        $news->image = !empty($imagePath) ? $imagePath : $news->image;
        $news->title = $request->title;
        $news->slug = Str::slug($request->title);
        $news->content = $request->input('content');
        $news->meta_title = $request->meta_title;
        $news->meta_description = $request->meta_description;
        $news->is_breaking_news = $request->is_breaking_news == 1 ? 1 : 0;
        $news->show_at_slider = $request->show_at_slider == 1 ? 1 : 0;
        $news->show_at_popular = $request->show_at_popular == 1 ? 1 : 0;
        $news->status = $request->status == 1 ? 1 : 0;
        $news->save();

        /** transformando as tags em itens de um array */
        $tags = explode(',', $request->tags);
        $tagIds = [];

        // removendo o vinculo de todas as tags da noticia
        $news->tags()->detach($news->tags);
        foreach ($tags as $tag) {
            $item = Tag::firstOrCreate(['name' => $tag]);
            $tagIds[] = $item->id;
        }

        // adicionando o vinculo de tag por tag na noticia
        $news->tags()->attach($tagIds);

        toast(__('Updated SuccessFully!'), 'success')->width('350');

        return redirect()->route('admin.news.index');
    }
}
