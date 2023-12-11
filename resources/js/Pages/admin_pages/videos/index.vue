<template>
    <adminLayout>
        <Head title="Admin" />
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight page_title">
                <i class="fa-solid fa-video"></i>
                /الفيديوهات
            </h2>
        </template>
        <div class="contain_admin">
            <div class="historique_statistique frame_original">
                <p class="title">
                    <span>قائمة المستخدمين</span>
                </p>
                <DataTable class="display">
                    <thead>
                        <tr class="text-center font-bold bg-gray-600">
                            <th class="pb-4 pt-6 px-6 text-end">القنوات </th>
                            <th class="pb-4 pt-6 px-6 text-end">الفيديو </th>
                            <th class="pb-4 pt-6 px-6 text-end">المشاهدات</th>
                            <th class="pb-4 pt-6 px-6 text-end">التعليقات</th>
                            <th class="pb-4 pt-6 px-6 text-end">الاعجابات</th>
                            <th class="pb-4 pt-6 px-6 text-end">التاريخ</th>
                            <th class="pb-4 pt-6 px-6 text-end">الخصوصية</th>
                            <th class="pb-4 pt-6 px-6 text-end">الابلاغات</th>
                            <th class="pb-4 pt-6 px-6 text-end">حذف</th>
                        </tr>
                    </thead>
                    <tbody class="text-right video_table">
                        <tr v-for="video in videos" class="hover:bg-gray-900">
                            <td class="pb-4 pt-6 px-6 border-t text-end text-white">
                                <div v-if="$page.props.auth.chanel[0]">
                                    <div v-if="$page.props.auth.chanel[0].id == video.video_chanel_id">
                                        <Link class="subchanel_icon" :href="route('my_chanel_AUTH')" >
                                            <img :src="'/'+video.chanel_logo_path"  class="rounded-circle my-2 ml-3" width="30">
                                            <span class="card-text">{{video.videos_name_chanel}}</span>
                                        </Link>
                                    </div>
                                    <div v-else>
                                        <Link class="subchanel_icon" :href="`/chanel_AUTH/${video.video_chanel_id}`">
                                            <img :src="'/'+video.chanel_logo_path"  class="rounded-circle my-2 ml-3" width="30">
                                            <span class="card-text">{{video.videos_name_chanel}}</span>
                                        </Link>
                                    </div>
                                </div>
                                <div v-else>
                                    <Link class="subchanel_icon" :href="`/chanel_AUTH/${video.video_chanel_id}`">
                                        <img :src="'/'+video.chanel_logo_path"  class="rounded-circle my-2 ml-3" width="30">
                                        <span class="card-text">{{video.videos_name_chanel}}</span>
                                    </Link>
                                </div>
                            </td>
                            <td class="pb-4 pt-6 px-6 border-t text-end text-white">
                                <Link class="image_logo_videos" :href="`/show_video/${video.id}`">
                                    <img :src="'/'+video.img_path" class="card-img-top" alt="card image">
                                    <span>{{ video.name }}</span>
                                </Link >
                            </td>
                            <td class="pb-4 pt-6 px-6 border-t text-end text-white">
                                {{ video.vew_video }}
                            </td>
                            <td class="pb-4 pt-6 px-6 border-t text-end text-white">
                                {{ video.count_comments_video }}
                            </td>
                            <td class="pb-4 pt-6 px-6 border-t text-end text-white">
                                {{ video.like_video }}
                            </td>
                            <td class="pb-4 pt-6 px-6 border-t text-end text-white">
                                منذ {{ video.date_count }}  
                            </td>
                            <td class="pb-4 pt-6 px-6 border-t text-end text-white">
                                <span v-if="video.public == 'عامة'">عام <i class="fa-solid fa-people-group mr-2" ></i></span>
                                <span v-if="video.public == 'خاصة'">خاص <i class="fa-solid fa-lock mr-2 " ></i></span>
                            </td>
                            <td class="pb-4 pt-6 px-6 border-t text-end text-white">
                                <span v-if="video.strik" class="text-red-500">مبلغ عنه</span>
                                <span v-else class="text-green-500">سليم</span>
                            </td>
                            <td class="pb-4 pt-6 px-6 border-t text-end text-white ">
                                <Link :href="`/my_videos_AUTH/${video.id}/delete`" class="text-white">
                                    <i class="fa-solid fa-trash text-red-500"></i> حذف
                                </Link>
                            </td>
                        </tr>
                    </tbody>
                </DataTable>
            </div>
        </div>
    </adminLayout>
</template>
<script setup>
import adminLayout from '@/Layouts/Admin.vue';
import { Head, Link} from '@inertiajs/vue3';
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net';

DataTable.use(DataTablesCore);
</script>

<script>
export default {
    components: {
        Head,
        Link,
        DataTable,
    },
    props: {
        videos: Object,
        tes1: Object,
        tes2: Object,
        tes3: Object,
    },

    data() {
        return {
            
        }
    },
    methods: {
        
    },
}
</script>
<style>
@import 'datatables.net-dt';
</style>