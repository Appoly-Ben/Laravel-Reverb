<?php

namespace App\Http\Controllers;

use App\Jobs\PublishPodcast;
use Illuminate\Http\Request;

class PodcastController extends Controller
{
    public function publish(Request $request)
    {
        $podcastId = $request->input('podcastId');

        PublishPodcast::dispatch($podcastId);

        return response()->json(['message' => 'Podcast publishing initiated!']);
    }
}
