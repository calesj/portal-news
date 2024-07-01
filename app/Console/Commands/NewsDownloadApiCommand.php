<?php

namespace App\Console\Commands;

use App\Http\Service\NewsApiService;
use App\Jobs\DownloadNewsJob;
use Illuminate\Console\Command;

class NewsDownloadApiCommand extends Command
{
    private NewsApiService $newsApiService;

    public function __construct(
        NewsApiService $newsApiService
    )
    {
        $this->newsApiService = $newsApiService;
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news-save';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $urlApi = 'https://servicodados.ibge.gov.br/api/v3/noticias';

        $this->info("Pegando todas as noticias");
        $news = $this->newsApiService->getNews($urlApi)['items'];
        $progressBar = $this->output->createProgressBar(count($news));
        $this->info("Salvando uma a uma no banco de dados");
        $progressBar->start();
        foreach ($news as $new) {
            DownloadNewsJob::dispatch($new);
            $progressBar->advance();
        }

        $progressBar->finish();

        $this->info("Fim");
    }
}
