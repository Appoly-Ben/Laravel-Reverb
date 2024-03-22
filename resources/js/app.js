import './bootstrap';
import { createApp } from "vue";

import PodcastsIndex from './components/Podcasts/Index.vue';

const app = createApp({});

app.component('podcasts-index', PodcastsIndex);

app.mount('#app');