<!-- ////////////////// temlate///////////// -->
<template>
    <ChanelLayout>
        <div>
                        <div class="video-section bg-white p-2 mt-3">
                            <div class="card1 border-0" v-if="main_video">
                                            <div class="row">
                                            <div class="col-md-6 main_video_panel">
                                                <video  controls :poster="'/'+main_video.img_path" autoplay muted loop class="w-100">
                                                    <track kind="captions" :src="'/'+main_video.video_path" srclang="ar" label="عربي" default>
                                                    <source :src="'/'+main_video.video_path" type="video/webm">
                                                    <source :src="'/'+main_video.video_path" type="video/mp4">
                                                    <source :src="'/'+main_video.video_path" type="video/webm">
                                                    <source :src="'/'+main_video.video_path" type="video/ogg">
                                                    لا يدعم متصفحك العنصر <code>video</code>.
                                                </video>
                                            </div>
                                            <div class="pt-10 col-md-6 main_details_panel">
                                                <div class="card-block">
                                                    <a href="watch.html">
                                                        <h4 class="card-title">{{main_video.name }}</h4>
                                                    </a>
                                                    <p class="card-text">{{ main_video.discription }}</p>
                                                    <small class="text-muted">
                                                        <i class="fa-solid fa-eye"></i> <span>{{main_video.vuews_video}} مشاهدة</span>
                                                        <i class="fa-solid fa-calendar-days ml-2"></i> <span>منذ {{ time_test }} </span>
                                                    </small>
                                                </div>
                                            </div>
                                            </div>
                            </div>
                        </div> 
                        <div class="latest-download" v-if="videos">
                                        <div class="container">
                                            <div class="header_new_videos">
                                                <h4 >آخر الفديوهات المرفوعة</h4>
                                            </div>
                                            <div class="row" v-if="videos[0]">
                                                <div class="col-sm-6 col-md-4 col-lg-3 video_panel  mt-2" v-for="(video,index) in videos">
                                                    <div class="card mp-4 p-1">
                                                        <div class="card-icon">
                                                            <Link class="img_panel_video" :href="`/show_video/${video.id}`">
                                                                <img :src="'/'+video.img_path" class="card-img-top" alt="card image">
                                                                <time>{{video.video_duration}}</time>
                                                                <i class="fas fa-play fa-2x"></i>
                                                            </Link>
                                                        </div>
                                                        <div class="card-body p-0">
                                                            <p class="card-title">{{ video.name }}</p>
                                                        </div>
                                                        <div class="card-footer">
                                                            <small class="text-muted">
                                                                <span class="d-block"><i class="fa-solid fa-eye"></i> <span>{{video.vuews_video}} مشاهدة</span></span>
                                                                <i class="fa-solid fa-calendar-days"></i> <span>منذ {{ video.date_count }} </span>
                                                            </small>
                                                        </div>
                                                        <Link class="channel-img" :href="route('my_chanel_AUTH')">
                                                            <img class="rounded-circle my-2 ml-3" width="30">
                                                            <span class="card-text"></span>
                                                        </Link>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class='paragraph' v-else>لا يوجد محتوى</div>
                                        </div> 
                        </div>
                        <div v-else class="dont_have_chanel">
                                <p>لا يوجد محتوى</p>
                        </div>
        </div>
    </ChanelLayout>
</template>
<script setup>
import ChanelLayout from '@/Pages/auth_pages/my_chanel_gest/index.vue';
import FileInput from "@/Components/FileInput.vue";
import { Head, Link} from '@inertiajs/vue3';
import Cookies from 'js-cookie';
</script>

<script>
export default {
    components: {
        Head,
        Link,
        FileInput,
    },
    props: {
        videos: Object,
        main_video: Object,
        time_test: Object,
    },

    data() {
        return {
            myCookieArray: [],
            get_cookie: '',
        }
    },
    methods: {

    },
    mounted() {
        this.get_cookie = Cookies.get('my_chanel');
        this.myCookieArray = this.get_cookie ? JSON.parse(this.get_cookie) : [];
    },
}
</script>