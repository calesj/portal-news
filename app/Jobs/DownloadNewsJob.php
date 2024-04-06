<?php

namespace App\Jobs;

use App\Http\Service\NewsApiService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DownloadNewsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    private NewsApiService $newsApiService;
    private array $new;

    public function __construct(array $new)
    {
        $this->newsApiService = app(NewsApiService::class);
        $this->new = $new;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->newsApiService->downloadNews($this->new);
    }
}
