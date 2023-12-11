<template>
    <adminLayout>
        <Head title="Admin" />
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight page_title">
                <i class="fa-solid fa-envelope-open-text"></i>
                /الدعم و الابلاغات
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
                            <th class="pb-4 pt-6 px-6 text-end">الحساب </th>
                            <th class="pb-4 pt-6 px-6 text-end">الرسالة</th>
                            <th class="pb-4 pt-6 px-6 text-end">الحالة</th>
                            <th class="pb-4 pt-6 px-6 text-end">تاريخ</th>
                            <th class="pb-4 pt-6 px-6 text-end">حذف</th>
                            <th class="pb-4 pt-6 px-6 text-end">الرد</th>
                        </tr>
                    </thead>
                    <tbody class="text-right video_table">
                        <tr v-for="rapports in rapport" class="hover:bg-gray-900">
                            <td class="pb-4 pt-6 px-6 border-t text-end text-white max-w-xs">
                                <span>{{ rapports.username }}</span>
                            </td>
                            <td class="pb-4 pt-6 px-6 border-t text-end text-white max-w-xs">
                                <span class="max-w-56">
                                    {{ rapports.the_message }}  
                                </span>
                            </td>
                            <td class="pb-4 pt-6 px-6 border-t text-end text-white max-w-xs">
                                {{ rapports.the_coment }}
                                <span v-if="rapports.the_side == 'user'" class="text-red-500">
                                    <i class="fa-solid fa-flag"></i> لم يتم الرد
                                </span>
                                <span v-else  class="text-green-500">
                                    <i class="fa-solid fa-check"></i> تم الرد
                                </span>
                            </td>
                            <td class="pb-4 pt-6 px-6 border-t text-end text-white max-w-xs">
                                منذ {{ rapports.date_count }}  
                            </td>
                            <td class="pb-4 pt-6 px-6 border-t text-end text-white max-w-xs">
                                <Link :href="`/admin_taleb/rapports/${rapports.id_user}/delete`" class="text-white">
                                    <i class="fa-solid fa-trash text-red-500"></i> حذف
                                </Link>
                            </td>
                            <td class="pb-4 pt-6 px-6 border-t text-end text-white max-w-xs">
                                <Link :href="`/admin_taleb/rapports/${rapports.id_user}/message`" class="text-white">
                                    <i class="fa-solid fa-chevron-left text-yellow-500"></i> رد
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
        rapport: Object,
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