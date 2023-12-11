<template>
    <adminLayout>
        <Head title="Admin" />
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight page_title">
                <i class="fa-solid fa-comment"></i>
                /التعليقات
            </h2>
        </template>
        <div v-if="dont_have_chanel" class="alert alert-danger alert-dismissible fade show need_account" role="alert">
            <div>
                <i class="fa-solid fa-triangle-exclamation"></i>
                المستخدم " {{ user_name }} " لا يمتلك قنات 
            </div>
            <button @click="dont_have_chanel_function" type="button" data-bs-dismiss="alert" aria-label="Close">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="contain_admin">
            <div class="historique_statistique frame_original">
                <p class="title">
                    <span>قائمة القنوات</span>
                </p>
                <DataTable class="display">
                    <thead>
                        <tr class="text-center font-bold bg-gray-600">
                            <th class="pb-4 pt-6 px-6 text-end">الحساب/القنات </th>
                            <th class="pb-4 pt-6 px-6 text-end">التعليق</th>
                            <th class="pb-4 pt-6 px-6 text-end">الاعجابات</th>
                            <th class="pb-4 pt-6 px-6 text-end">تاريخ</th>
                            <th class="pb-4 pt-6 px-6 text-end">حذف</th>
                        </tr>
                    </thead>
                    <tbody class="text-right video_table">
                        <tr v-for="comment in comments" class="hover:bg-gray-900">
                            <td class="pb-4 pt-6 px-6 border-t text-end text-white max-w-xs">
                                <div v-if="$page.props.auth.chanel[0]">
                                    <div v-if="$page.props.auth.chanel[0].id == comment.coments_chanels_id">
                                        <Link class="subchanel_icon float-right mt-3 mt-md-4" :href="route('my_chanel_AUTH')" v-if="comment.coments_chanels_name">
                                            <img :src="'/'+comment.coments_chanels_logo_path"  class="rounded-circle my-2 ml-3" width="30">
                                            <span>{{ comment.coments_chanels_name }}</span>
                                        </Link>
                                    </div>
                                    <div v-else>
                                        <Link class="subchanel_icon float-right mt-3 mt-md-4" :href="`/chanel_AUTH/${comment.coments_chanels_id}`" v-if="comment.coments_chanels_name">
                                            <img :src="'/'+comment.coments_chanels_logo_path"  class="rounded-circle my-2 ml-3" width="30">
                                            <span>{{ comment.coments_chanels_name }}</span>
                                        </Link>
                                        <p  @click="dont_have_chanel_function(comment.coments_user_name)" class="subchanel_icon float-right mt-3 mt-md-4 cursor-pointer" v-else>
                                            <img :src="'/'+comment.coments_chanels_logo_path"  class="rounded-circle my-2 ml-3" width="30">
                                            <span>{{ comment.coments_user_name }}</span>
                                        </p>
                                    </div>
                                </div>
                                <div v-else>
                                    <Link class="subchanel_icon float-right mt-3 mt-md-4" :href="`/chanel_AUTH/${comment.coments_chanels_id}`" v-if="comment.coments_chanels_name">
                                        <img :src="'/'+comment.coments_chanels_logo_path"  class="rounded-circle my-2 ml-3" width="30">
                                        <span>{{ comment.coments_chanels_name }}</span>
                                    </Link>
                                    <p  @click="dont_have_chanel_function(comment.coments_user_name)" class="subchanel_icon float-right mt-3 mt-md-4 cursor-pointer" v-else>
                                        <img :src="'/'+comment.coments_chanels_logo_path"  class="rounded-circle my-2 ml-3" width="30">
                                        <span>{{ comment.coments_user_name }}</span>
                                    </p>
                                </div>
                            </td>
                            <td class="pb-4 pt-6 px-6 border-t text-end text-white max-w-xs">
                                {{ comment.the_coment }}
                            </td>
                            <td class="pb-4 pt-6 px-6 border-t text-end text-white max-w-xs">
                                {{ comment.count }}
                            </td>
                            <td class="pb-4 pt-6 px-6 border-t text-end text-white max-w-xs">
                                منذ {{ comment.date_count }}  
                            </td>
                            <td class="pb-4 pt-6 px-6 border-t text-end text-white max-w-xs">
                                <Link :href="`/admin_taleb/comments/${comment.id}/comments_delete`" class="text-white">
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
        comments: Object,
    },

    data() {
        return {
            dont_have_chanel:false,
        }
    },
    methods: {
        dont_have_chanel_function(user_name_target){
            this.dont_have_chanel?
            this.dont_have_chanel = false:
            [
                this.user_name = user_name_target,
                this.dont_have_chanel = true,
            ];
        },
    },
}
</script>
<style>
@import 'datatables.net-dt';
</style>