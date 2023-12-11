<!-- ////////////////// temlate///////////// -->
<template>
    <AuthenticatedLayout>
        <Head title="طلاب" />
        <div class="history-page pt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 history-right-column">
                    <div class="form-inline my-2 my-lg-0">
                        <label :style="{ width: search_run? '100%' : '100%' }" class="label_for_search">
                            <i class="fa-solid fa-circle-xmark" v-if="search_run" @click="start_searsh()" ></i>
                            <div v-else @click="start_searsh()" class="flex flex-row items-center">
                                <i class="fa-solid fa-magnifying-glass mr-2" ></i> 
                                <span class="text-black">ابحث في سجل المشاهدة</span>                           
                            </div>
                            <input 
                                class="search text-black" type="search" 
                                v-model="searchQuery" 
                                placeholder="إبحث ..." 
                                :style="{ display: search_run? 'flex' : 'none' }"
                            />
                        </label>
                    </div>
                    <hr>
                    <div class="list-group list-group-flush pr-0" id="list-tab">
                        <Link :href="route('historique_AUTH.delete')">
                            حذف سجل المشاهدة <i class="fa-solid fa-trash ml-4"></i>
                        </Link>
                    </div>
                    <label class="mt-4">التاريخ:</label>
                    <div class="list-group list-group-flush pr-0" id="list-tab">
                        <a @click="pagination('all')" class="list-group-item list-group-item-action active" id="list-home-list" data-toggle="list" href="#list-home"> الكل</a>
                        <a @click="pagination('day')" class="list-group-item list-group-item-action" id="list-home-list" data-toggle="list" href="#list-home">منذ 24 ساعة</a>
                        <a @click="pagination('three_day')" class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#list-profile">منذ 3 ايام</a>
                        <a @click="pagination('week')" class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list" href="#list-messages">منذ اسبوع</a>
                        <a @click="pagination('month')" class="list-group-item list-group-item-action" id="list-settings-list" data-toggle="list" href="#list-settings">منذ شهر</a>
                    </div>
                </div>
                <div class="col-lg-9 videos_frame">
                    <div v-if="search_run" data-bs-spy="scroll" data-bs-target="#list-example" data-bs-offset="0" class="container" tabindex="0">
                        <div class="row">
                            <div class="col-12" v-for="history_video in filteredItems">
                                <div class="card mb-3">
                                    <div class="card-horizontal d-md-flex d-block">
                                        <div class="img-square-wrapper card-icon">
                                            <Link class="image_video" :href="`show_video/${history_video.id}`">
                                                <img :src="'/'+history_video.img_path" class="card-img-top" alt="card image">
                                                <time>{{history_video.video_duration}}</time>
                                                <i class="fas fa-play fa-2x"></i>
                                            </Link>
                                            <Link :href="`historique_AUTH/${history_video.id}/delete`">
                                                <i class="fas fa-times remove" ></i> 
                                            </Link>
                                        </div>
                                        <div class="card-body p-2">
                                            <a href="watch.html">
                                                <h4 class="card-title">{{ history_video.name }}</h4>
                                            </a>
                                            <p class="card-text">{{ history_video.discription }}</p>
                                            <small class="text-muted">
                                                <i class="fa-solid fa-eye mr-2"></i> <span> {{history_video.vuews_video}} مشاهدة</span>
                                                <i class="fa-solid fa-calendar-days mr-2 ml-2"></i> <span>منذ {{ history_video.date_count }} </span>
                                            </small>
                                            <div v-if="$page.props.auth.chanel[0]">
                                                <div v-if="$page.props.auth.chanel[0].id == history_video.id_chanel">
                                                    <Link :href="route('my_chanel_AUTH')" class="channel-img mt-2">
                                                        <img :src="'/'+history_video.video_chanels_logo_path"  class="rounded-circle mr-2" width="30">
                                                        <span class="card-text">{{history_video.video_chanels_name}}</span>
                                                    </Link>
                                                </div>
                                                <div v-else>
                                                    <Link :href="`/chanel_AUTH/${history_video.id_chanel}`" class="channel-img mt-2">
                                                        <img :src="'/'+history_video.video_chanels_logo_path"  class="rounded-circle mr-2" width="30">
                                                        <span class="card-text">{{history_video.video_chanels_name}}</span>
                                                    </Link>
                                                </div>
                                            </div>
                                            <div v-else>
                                                <Link :href="`/chanel_AUTH/${history_video.id_chanel}`" class="channel-img mt-2">
                                                    <img :src="'/'+history_video.video_chanels_logo_path"  class="rounded-circle mr-2" width="30">
                                                    <span class="card-text">{{history_video.video_chanels_name}}</span>
                                                </Link>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container" v-else>
                        <div class="row">
                            <h4 class="mt-2 mb-10">{{ title_page }}</h4>
                            <div class="card_video_historique" v-for="history_video in table_big">
                                <div class="card mb-3">
                                    <div class="card-horizontal d-md-flex d-block">
                                        <div class="img-square-wrapper card-icon">
                                            <Link class="image_video" :href="`show_video/${history_video.id}`">
                                                <img :src="'/'+history_video.img_path" class="card-img-top" alt="card image">
                                                <time>{{history_video.video_duration}}</time>
                                                <i class="fas fa-play fa-2x"></i>
                                            </Link>
                                            <Link :href="`historique_AUTH/${history_video.id}/delete`">
                                                <i class="fas fa-times remove" ></i> 
                                            </Link>
                                        </div>
                                        <div class="card-body p-2">
                                            <a href="watch.html">
                                                <h4 class="card-title">{{ history_video.name }}</h4>
                                            </a>
                                            <p class="card-text">{{ history_video.discription }}</p>
                                            <small class="text-muted">
                                                <i class="fa-solid fa-eye mr-2"></i> <span> {{history_video.vuews_video}} مشاهدة</span>
                                                <i class="fa-solid fa-calendar-days mr-2 ml-2"></i> <span>منذ {{ history_video.date_count }} </span>
                                            </small>
                                            <div v-if="$page.props.auth.chanel[0]">
                                                <div v-if="$page.props.auth.chanel[0].id == history_video.id_chanel">
                                                    <Link :href="route('my_chanel_AUTH')" class="channel-img mt-2">
                                                        <img :src="'/'+history_video.video_chanels_logo_path"  class="rounded-circle mr-2" width="30">
                                                        <span class="card-text">{{history_video.video_chanels_name}}</span>
                                                    </Link>
                                                </div>
                                                <div v-else>
                                                    <Link :href="`/chanel_AUTH/${history_video.id_chanel}`" class="channel-img mt-2">
                                                        <img :src="'/'+history_video.video_chanels_logo_path"  class="rounded-circle mr-2" width="30">
                                                        <span class="card-text">{{history_video.video_chanels_name}}</span>
                                                    </Link>
                                                </div>
                                            </div>
                                            <div v-else>
                                                <Link :href="`/chanel_AUTH/${history_video.id_chanel}`" class="channel-img mt-2">
                                                    <img :src="'/'+history_video.video_chanels_logo_path"  class="rounded-circle mr-2" width="30">
                                                    <span class="card-text">{{history_video.video_chanels_name}}</span>
                                                </Link>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link} from '@inertiajs/vue3';
</script>

<script>
export default {
    components: {
        Head,
        Link,
    },
    props: {
        historique: Object,
        last_day: Object,
        last_three_day: Object,
        last_week: Object,
        last_month: Object,
    },

    data() {
        return {
            search_run: false,
            searchQuery: '',
            page_name: 'all',
            table_big: this.historique,
            title_page:  'كل السجل',
        }
    },
    methods: {
        start_searsh(){
            this.search_run?
                this.search_run=false:
                this.search_run=true;
        },
        pagination(page_name_type){
            this.page_name = page_name_type;
            switch (page_name_type) {
                case 'all':
                    this.table_big = this.historique;this.title_page = 'كل السجل';break;
                case 'day':
                    this.table_big = this.last_day;this.title_page = 'آخر يوم';break;
                case 'three_day':
                    this.table_big = this.last_three_day;this.title_page = 'آخر ثلاث ايام';break;
                case 'week':
                    this.table_big = this.last_week;this.title_page = 'آخر أسبوع';break;
                case 'month':
                    this.table_big = this.last_month;this.title_page = 'آخر سنة';break;
            }
        }
    },
    computed: {
        filteredItems() {
            const query = this.searchQuery.toLowerCase();
            return this.historique.filter(history_video => history_video.name.toLowerCase().includes(query));
        }
    }
}
</script>
