<!-- ////////////////// temlate///////////// -->
<template>
    <GuestLayout>
        <Head title="طلاب" />
        <div class="content m-4 home_content_frame">
                <h4 class="py-5">الفديوهات الرائجة </h4>
                <div class="row">
                    <div class="video_card col-sm-6 col-md-4 col-lg-3" v-for="video in videos">
                        <div class="card p-1 mp-4">
                            <div class="card-icon">
                                <Link class="image_video" :href="`show_video_Gest/${video.id}`">
                                    <img :src="'/'+video.img_path" class="card-img-top" alt="card image">
                                    <time>{{video.video_duration}}</time>
                                    <i class="fas fa-play fa-2x"></i>
                                </Link>
                            </div>
                            <Link :href="`show_video_Gest/${video.id}`">
                                <div class="card-body p-0">
                                    <p class="card-title">{{video.name}}</p>
                                </div>
                            </Link>
                            <div class="card-footer">
                                <small class="text-muted">
                                    <span class="d-block"><i class="fa-solid fa-eye"></i> <span> {{video.vuews_video}} مشاهدة</span></span>
                                    <i class="fa-solid fa-calendar-days"></i> <span>منذ {{ video.date_count }} </span>
                                </small>
                            </div>
                            <Link :href="`chanel_gest/${video.chanel_id}`" class="channel-img flex items-center flex-row">
                                <img :src="'/'+video.chanel_logo_path"  class="rounded-circle my-2 ml-3 h-8 w-8">
                                <span class="card-text  pl-2">{{video.chanel_name}}</span>
                            </Link>
                        </div>
                    </div>
                </div>
        </div>
    </GuestLayout>
</template>
<script setup>
import GuestLayout from '@/Layouts/gestLayoutuser.vue';
import { Head, Link} from '@inertiajs/vue3';
</script>

<script>
export default {
    components: {
        Head,
        Link,
    },
    props: {
        videos:Object,
    },

    data() {
        return {
            
        }
    },
    methods: {
        
    },
}
</script>
