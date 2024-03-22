<?php

namespace App\Jobs;

use App\Events\PodcastPublished;
use App\Events\PodcastPublishing;
use App\Models\Podcast;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PublishPodcast implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $podcast;

    /**
     * Create a new job instance.
     */
    public function __construct($podcastId)
    {
        $this->podcast = Podcast::find($podcastId)->withoutRelations();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        sleep(5);
        $this->podcast->update(['is_published' => true]);
        PodcastPublished::dispatch($this->podcast);
    }
}
