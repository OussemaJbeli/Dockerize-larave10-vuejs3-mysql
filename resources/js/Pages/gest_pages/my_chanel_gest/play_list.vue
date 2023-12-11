<!-- ////////////////// temlate///////////// -->
<template>
    <ChanelLayout>
        <Head title="Log in" />
        <div class="latest-download">
                        <div class="container">
                            <div class="header_new_videos">
                                <h4 >  قوائم التشغيل</h4>
                            </div>
                            <div class="row" v-if="play_list[0]">
                                <div class="col-sm-6 col-md-4 col-lg-3 video_panel" v-for="(video,index) in play_list">
                                    <div class="card mp-4 p-1" @click="videos_playlist_function(video.id)">
                                        <div class="card-icon">
                                            <a class="img_panel_video">
                                                <img :src="'/'+video.img_path" class="card-img-top" alt="card image">
                                                <div v-for="playlist in number_playlist" >
                                                    <div v-if="parseInt(playlist.id_playlist, 10) == video.id"> 
                                                        <p>
                                                            {{ playlist.count }} فيديو <i class="fa-solid fa-list"></i>
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="card-body p-0">
                                            <p class="card-title">{{ video.name }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='paragraph' v-else><p>لا يوجد قوائم تشغيل</p></div>
                        </div> 
        </div>
            <!-- popup remove videos playlist -->
            <div class="upload_videos_frame play_list_add" id="loginModal" v-if="videos_playlist">
                    <div class="panel_chanel">
                        <div class="modal-header">
                            <h5 class="modal-title " style="color: #b2dfdb;" id="exampleModalLabel">
                                قائمة التشغيل
                            </h5>
                            <button type="button" class="close" @click="videos_playlist_function" >
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="small_panel_playlist_videos">
                                <div class="list_video pr-0 pl-0">
                                        <div v-for="video_serach in videos_with_playlist">
                                            <div class="ml-2 card p-1 mt-2 w-40" v-if="parseInt(video_serach.id_playlist, 10)  == videos_playlist_values.id_playlist">
                                                    <div class="card-icon">
                                                        <Link class="" :href="`/show_video_Gest/${video_serach.video_id_playlist}`">
                                                            <img :src="'/'+video_serach.img_path" class="card-img-top h-24" alt="card image">
                                                            <time>{{video_serach.video_duration}}</time>
                                                            <i class="fas fa-play fa-2x"></i>
                                                        </Link>
                                                    </div>
                                                    <Link :href="`/show_video_Gest/${video_serach.video_id_playlist}`">
                                                        <div class="card-body p-0">
                                                            <p class="card-title">{{video_serach.name}}</p>
                                                        </div>
                                                    </Link>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
    </ChanelLayout>
</template>
<script setup>
import ChanelLayout from '@/Pages/gest_pages/my_chanel_gest/index.vue';
import FileInput from "@/Components/FileInput.vue";
import { Head, Link} from '@inertiajs/vue3';
</script>

<script>
export default {
    components: {
        Head,
        Link,
        FileInput,
    },
    props: {
        play_list: Object,
        videos_with_playlist: Object,
        number_playlist: Object,
        chanel: Object,
    },

    data() {
        return {
            videos_playlist:false,
            videos_playlist_values: this.$inertia.form({
                id_playlist: null,
            }),
        }
    },
    methods: {
        videos_playlist_function(id_playlist){
            this.videos_playlist?
                this.videos_playlist=false:
                [
                    this.videos_playlist=true,
                    this.videos_playlist_values.id_playlist=id_playlist,
                ];
        },
    },
}
</script>
