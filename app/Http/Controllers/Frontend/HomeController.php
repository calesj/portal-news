<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\Traits\HomeTrait;
use App\Mail\ContactMail;
use App\Models\About;
use App\Models\Ad;
use App\Models\Category;
use App\Models\Contact;
use App\Models\HomeSectionSetting;
use App\Models\News;
use App\Models\RecivedMail;
use App\Models\SocialCount;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Mail;

class HomeController extends Controller
{
    use HomeTrait;

    /**
     * @return View
     */
    public function index(): View
    {
        // noticias que aparecerao no carrossel
        $breakingNews = News::where(['is_breaking_news' => 1])
            ->activeEntries()
            ->withLocalize()
            ->orderBy('id', 'DESC')
            ->take(10)->get();

        // noticias que aparecerao no carrossel
        $heroSlider = News::with(['category', 'author'])
            ->where(['show_at_slider' => 1])->activeEntries()
            ->withLocalize()
            ->orderBy('id', 'DESC')
            ->take(7)->get();

        // noticias recentes
        $recentNews = News::with(['category', 'author'])
            ->activeEntries()
            ->withLocalize()
            ->orderBy('id', 'DESC')
            ->take(6)->get();

        // noticias popular
        $popularNews = News::with('category')
            ->where('show_at_popular', 1)
            ->activeEntries()
            ->withLocalize()
            ->orderBy('updated_at', 'DESC')
            ->take(4)->get();

        // Primeira categoria que mostra na pagina inicial
        $homeSectionSetting = HomeSectionSetting::query()->where([
            'language' => getLanguage()
        ])->first();

        // registros da primeira categoria
        $categorySectionOne = News::query()->with(['category', 'author'])->where('category_id', $homeSectionSetting->category_section_one)
            ->activeEntries()
            ->withLocalize()
            ->orderBy('id', 'DESC')
            ->take(8)
            ->get();

        $categorySectionTwo = News::query()->with(['category', 'author'])->where('category_id', $homeSectionSetting->category_section_two)
            ->activeEntries()
            ->withLocalize()
            ->orderBy('id', 'DESC')
            ->take(5)
            ->get();

        $categorySectionThree = News::query()->with(['category', 'author'])->where('category_id', $homeSectionSetting->category_section_three)
            ->activeEntries()
            ->withLocalize()
            ->orderBy('id', 'DESC')
            ->take(6)
            ->get();

        $categorySectionFour = News::query()->with(['category', 'author'])->where('category_id', $homeSectionSetting->category_section_four)
            ->activeEntries()
            ->withLocalize()
            ->orderBy('id', 'DESC')
            ->take(4)
            ->get();

        //Mais vistos
        $mostViewedNews = News::query()->with(['category', 'author'])
            ->activeEntries()
            ->withLocalize()
            ->orderBy('views', 'DESC')
            ->take(3)
            ->get();

        // Mostrando todas as tags
        $mostCommonTags = $this->mostCommonTags();

        $socialCounts = SocialCount::where(['status' => 1, 'language' => getLanguage()])->get();

        $ad = Ad::first();

        return view('frontend.home', compact(
            'breakingNews',
            'heroSlider',
            'recentNews',
            'popularNews',
            'categorySectionOne',
            'categorySectionTwo',
            'categorySectionThree',
            'categorySectionFour',
            'mostViewedNews',
            'socialCounts',
            'mostCommonTags',
            'ad'
        ));
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

        $socialCounts = SocialCount::where(['status' => 1, 'language' => getLanguage()])->get();

        $ad = Ad::first();

        return view(
            'frontend.news-detail',
            compact('news', 'recentNews', 'mostCommonTags', 'nextPost', 'previousPost', 'relatedPosts', 'socialCounts', 'ad')
        );
    }

    public function news(Request $request)
    {
        $news = News::query();

        $news->when($request->has('tag'), function ($query) use ($request) {
            $query->whereHas('tags', function ($query) use ($request) {
                $query->where('name', $request->tag);
            });
        });

        $news->when($request->has('category') && !empty($request->category), function ($query) use ($request) {
            $query->whereHas('category', function ($query) use ($request) {
                $query->where('slug', $request->category);
            });
        });

        $news->when($request->has('search'), function ($query) use ($request) {
            $query->where(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('content', 'like', '%' . $request->search . '%');
            })->orWhereHas('category', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            });
        });

        $news = $news->activeEntries()->withLocalize()->paginate(8);

        /** noticias criadas recentementes */
        $recentNews = News::with(['category', 'author'])
            ->activeEntries()
            ->withLocalize()
            ->orderBy('id', 'DESC')
            ->take(4)->get();

        /** tags mais comuns utilizadas */
        $mostCommonTags = $this->mostCommonTags();

        $categories = Category::where(['status' => 1, 'language' => getLanguage()])->get();

        $ad = Ad::first();

        return view('frontend.news', compact('news', 'recentNews', 'mostCommonTags', 'categories', 'ad'));
    }

    /** Subscriber Newsletter register */
    public function subscriberNewsLetter(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:subscribers,email'],
        ], [
            'email.unique' => __('frontend.Email is already subscribed!')
        ]);

        $subscriber = new Subscriber();
        $subscriber->email = $request->email;
        $subscriber->save();

        return response(['status' => 'success', 'message' => __('frontend.Subscribed Success')]);
    }

    public function about()
    {
        $about = About::where('language', getLanguage())->first();
        return view('frontend.about', compact('about'));
    }

    public function contact()
    {
        $contact = Contact::where('language', getLanguage())->first();
        return view('frontend.contact', compact('contact'));
    }

    public function handleContactForm(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'max:255'],
            'message' => ['required', 'max:500'],
        ]);

        try {
            $toMail = Contact::where('language', getLanguage())->first();

            Mail::to($toMail->email)->send(new ContactMail($request->subject, $request->message, $request->email));

            /** store the mail */
            $mail = new RecivedMail();
            $mail->email = $request->email;
            $mail->subject = $request->subject;
            $mail->message = $request->message;
            $mail->save();

            toast(__('frontend.Message sent succesfully!'), 'success');
        } catch (\Exception $e) {
            toast(__($e->getMessage()), 'error');
        }

        return redirect()->back();
    }
}
