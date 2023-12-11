<!-- ////////////////// temlate///////////// -->
<template>
        <ChanelLayout>
        <div class="latest-download">
                        <div class="container">
                            <div class="header_new_videos">
                                <h4 > الفديوهات المرفوعة</h4>
                            </div>
                            <div class="latest-download" v-if="videos">
                                        <div class="container">
                                            <div class="row" v-if="videos[0]">
                                                <div class="col-sm-6 col-md-4 col-lg-3 video_panel mt-2" v-for="(video,index) in videos">
                                                    <div class="card mp-4 p-1">
                                                        <div class="card-icon">
                                                            <Link class="img_panel_video" :href="`/show_video_Gest/${video.id}`">
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
        videos: Object,
        chanel: Object,
    },

    data() {
        return {
            add_videos:false,
            add_videos_values: this.$inertia.form({
                name: '',
                discription: '',
                video_path: null,
                img_path: null,
            }),
            edite_videos:false,
            edite_videos_values: this.$inertia.form({
                id_video: null,
                name: '',
                discription: '',
                video_path: null,
                img_path: null,
                TEMPimg_path: null,
                TEMPvideo_path: null,
            }),
            upload_animation: false,
            fileSizeError: true,
        }
    },
    methods: {
        //upload videos
        add_videos_function(){
            this.add_videos?
                this.add_videos=false:
                this.add_videos=true;
        },
        add_videos_db(){
            if(this.fileSizeError){
            this.add_videos_values.post(`my_videos_AUTH/${this.$page.props.auth.chanel[0].id}/upload`, {
                onProgress: () => {
                    this.upload_animation=true;
                },
                onSuccess: () => {
                    this.upload_animation=false;
                    this.add_videos = false;
                    this.add_videos_values.reset();
                },
            });}
        },
        //edite
        edite_videos_function(id,name,disc,video_path,img_path){
            this.edite_videos?
                this.edite_videos=false:
                [
                    this.edite_videos=true,
                    this.edite_videos_values.id = id,
                    this.edite_videos_values.name =name,
                    this.edite_videos_values.discription =disc,
                    this.edite_videos_values.TEMPvideo_path =video_path,
                    this.edite_videos_values.TEMPimg_path = img_path,
                ];
        },
        edite_videos_db(){
            if(this.fileSizeError){
            this.edite_videos_values.post(`my_videos_AUTH/${this.edite_videos_values.id}/edit`, {
                onProgress: () => {
                    this.upload_animation=true;
                    this.uploadProgress = Math.round((progressEvent.loaded / progressEvent.total) * 100);
                },
                onSuccess: () => {
                    this.upload_animation=false;
                    this.edite_videos = false;
                    this.edite_videos_values.reset();
                },
            });}
        },

        handleFileChange(event) {
            const file = event.target.files[0];
            const maxSize = 100 * 1024 * 1024; // 5 MB (in bytes)

            if (file && file.size > maxSize) {
                this.fileSizeError = false;
            } else {
                this.fileSizeError = true;
            }
        },
    },
}
</script>
