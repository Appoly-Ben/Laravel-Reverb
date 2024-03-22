<?php

use App\Models\Podcast;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('podcasts-published.{podcastId}', function (User $user, $podcastId) {
    return $user->id === Podcast::find($podcastId)->user_id;
});
