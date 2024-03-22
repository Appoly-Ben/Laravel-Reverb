<?php

namespace App\Http\Controllers;

use App\Jobs\PublishPodcast;
use App\Models\Podcast;
use Illuminate\Http\Request;

class PodcastController extends Controller
{
    public function publish(Request $request)
    {
        $podcastId = $request->input('podcastId');

        $podcast = Podcast::find($podcastId);

        if (!$podcast) {
            return response()->json(['message' => 'Podcast not found'], 404);
        }

        if ($podcast->is_publishing) {
            return response()->json(['message' => 'Podcast is already being published'], 422);
        }

        if ($podcast->user_id == auth()->user()->id) {
            $podcast->update(['is_publishing' => true]);
            PublishPodcast::dispatch($podcastId);
            $message = 'Podcast publishing initiated!';
        } else {
            $message = "You don't own this podcast! Publishing aborted";
        }

        return response()->json(['message' => $message, 'podcast' => $podcast]);
    }
}
