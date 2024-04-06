<?php

namespace App\Http\Service;

use App\Http\Service\Traits\FileDownloadTrait;
use App\Models\News;
use App\Models\Tag;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class NewsApiService
{
    use FileDownloadTrait;

    private News $news;

    public function __construct(News $news)
    {
        $this->news = $news;
    }

    public function getNews(string $url)
    {
        return Http::withoutVerifying()->get($url)->json();
    }

    public function downloadNews($request): void
    {
        $imagemPath = json_decode($request['imagens'])->image_fulltext;

        $link = "https://agenciadenoticias.ibge.gov.br/";

        $imagemDownloadPath = $link . $imagemPath;

        $imagePath = $this->downloadImage($imagemDownloadPath);
        $news = $this->news;
        $news = $news->find($request['id']);
        if (!$news) {
            $news = new News();
            $news->id = $request['id'];
        }

        $news->language = 'pt';
        $news->category_id = $request['editorias'] === 'ibge' ? 2 : ($request['editorias'] === 'economicas' ? 1 : 3);
        $news->author_id = 1;
        $news->image = $imagePath;
        $news->title = $request['titulo'];
        $news->slug = Str::slug($request['titulo']);
        $news->content = $request['introducao'];

        $news->is_breaking_news = 0;
        $news->show_at_slider = 0;
        $news->show_at_popular = 0;
        $news->is_approved = 1;
        $news->status = 1;
        $news->save();

        /** transformando as tags em itens de um array */
        $tag = $request['editorias'];

        $item = new Tag();
        $item->name = $tag;
        $item->language = 'pt';
        $item->save();

        $news->tags()->attach($item->id);
    }
}
