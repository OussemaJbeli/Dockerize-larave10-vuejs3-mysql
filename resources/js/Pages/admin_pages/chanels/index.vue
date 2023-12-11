<template>
    <adminLayout>
        <Head title="Admin" />
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight page_title">
                <i class="fa-brands fa-youtube"></i>
                /القنوات
            </h2>
        </template>
        <div class="contain_admin">
            <div class="historique_statistique frame_original">
                <p class="title">
                    <span>قائمة القنوات</span>
                </p>
                <DataTable class="display">
                    <thead>
                        <tr class="text-center font-bold bg-gray-600">
                            <th class="pb-4 pt-6 px-6 text-end">القنوات </th>
                            <th class="pb-4 pt-6 px-6 text-end">عدد المشتركين</th>
                            <th class="pb-4 pt-6 px-6 text-end">عدد المشاهدات</th>
                            <th class="pb-4 pt-6 px-6 text-end">عدد الفيديوهات</th>
                            <th class="pb-4 pt-6 px-6 text-end">تاريخ الانشاء</th>
                            <th class="pb-4 pt-6 px-6 text-end">حذف</th>
                        </tr>
                    </thead>
                    <tbody class="text-right video_table">
                        <tr v-for="channel in channels" class="hover:bg-gray-900">
                            <td class="pb-4 pt-6 px-6 border-t text-end text-white">
                                <div v-if="$page.props.auth.chanel[0]">
                                    <div v-if="$page.props.auth.chanel[0].id == channel.id">
                                        <Link class="subchanel_icon" :href="route('my_chanel_AUTH')" >
                                            <img :src="'/'+channel.logo_path_chanel"  class="rounded-circle my-2 ml-3" width="30">
                                            <span class="card-text">{{channel.name_chanel}}</span>
                                        </Link>
                                    </div>
                                    <div v-else>
                                        <Link class="subchanel_icon" :href="`/chanel_AUTH/${channel.id}`">
                                            <img :src="'/'+channel.logo_path_chanel"  class="rounded-circle my-2 ml-3" width="30">
                                            <span class="card-text">{{channel.name_chanel}}</span>
                                        </Link>
                                    </div>
                                </div>
                                <div v-else>
                                    <Link class="subchanel_icon" :href="`/chanel_AUTH/${channel.id}`">
                                        <img :src="'/'+channel.logo_path_chanel"  class="rounded-circle my-2 ml-3" width="30">
                                        <span class="card-text">{{channel.name_chanel}}</span>
                                    </Link>
                                </div>
                            </td>
                            <td class="pb-4 pt-6 px-6 border-t text-end text-white">
                                {{ channel.count_subscribe }}
                            </td>
                            <td class="pb-4 pt-6 px-6 border-t text-end text-white">
                                {{ channel.count_views }}
                            </td>
                            <td class="pb-4 pt-6 px-6 border-t text-end text-white">
                                {{ channel.count_videos }}
                            </td>
                            <td class="pb-4 pt-6 px-6 border-t text-end text-white">
                                منذ {{ channel.date_create }}  
                            </td>
                            <td class="pb-4 pt-6 px-6 border-t text-end text-white ">
                                <Link :href="`/admin_taleb/chanels/${channel.id}/chanels_delete`" class="text-white">
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
        channels: Object,
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