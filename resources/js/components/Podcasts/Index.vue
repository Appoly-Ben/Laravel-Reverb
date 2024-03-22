<template>
    <div class="grid">
        <div
            class="flex flex-col items-start gap-6 overflow-hidden rounded-lg bg-white p-6 shadow-[0px_14px_34px_0px_rgba(0,0,0,0.08)] ring-1 ring-white/[0.05] transition duration-300 hover:text-black/70 hover:ring-black/20 focus:outline-none focus-visible:ring-[#FF2D20] md:row-span-3 lg:p-10 lg:pb-10 dark:bg-zinc-900 dark:ring-zinc-800 dark:hover:text-white/70 dark:hover:ring-zinc-700 dark:focus-visible:ring-[#FF2D20]">
            <div class="w-full bg-zinc-700 rounded-md p-6 text-zinc-400 font-bold text-lg flex justify-between items-center"
                v-for="podcast in podcastsData">
                {{ podcast.title }}
                <div class="d-flex items-center">
                    <span
                        :class="{ 'bg-green-500': podcast.is_published, 'bg-red-500': !podcast.is_published, 'bg-yellow-500': podcast.is_publishing }"
                        class="h-4 w-4 rounded-full inline-block mr-2" :ref="'podcast' + podcast.id + 'status'"></span>


                    <button class="..." id="publishPodcast{{ podcast.id }}" v-on:click="publishPodcast(podcast)">
                        <span>{{ getButtonText(podcast) }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios'
export default {
    props: ['podcasts'],
    data() {
        return {
            podcastsData: this.podcasts,
        };
    },
    methods: {
        publishPodcast(podcast) {
            podcast.is_publishing = true;
            axios.post('/publish-podcast', { 'podcastId': podcast.id })
        },
        setupEchoListeners() {
            this.podcasts.forEach(podcast => {
                Echo.channel('podcasts-published.' + podcast.id).listen('PodcastPublished', (e) => {
                    let podcastData = e.podcast
                    if (podcastData.is_published) {
                        let foundPodcast = this.podcastsData.find(podcast => podcast.id === podcastData.id);
                        if (foundPodcast) {
                            foundPodcast.is_publishing = false;
                            foundPodcast.is_published = true;
                        }
                    }
                })
            })
        },

        getButtonText(podcast) {
            if (podcast.is_publishing) {
                return 'Publishing'
            }
            if (podcast.is_published) {
                return 'Published'
            }
            return 'Publish'
        }
    },
    mounted() {
        this.setupEchoListeners()
    }
}
</script>