<template>
    <adminLayout>
        <Head title="Admin" />
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight page_title">
                <i class="fa-solid fa-user"></i>
                /المستخدمون
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
                            <th class="pb-4 pt-6 px-6 text-end">الإسم</th>
                            <th class="pb-4 pt-6 px-6 text-end">البريد الالكتروني</th>
                            <th class="pb-4 pt-6 px-6 text-end">حالة المستخدم</th>
                            <th class="pb-4 pt-6 px-6 text-end">ترقية</th>
                            <th class="pb-4 pt-6 px-6 text-end">حذف</th>
                        </tr>
                    </thead>
                    <tbody class="text-right">
                        <tr v-for="user in users" class="hover:bg-gray-900">
                            <td class="pb-4 pt-6 px-6 border-t text-start text-white">
                                {{ user.name }}
                            </td>
                            <td class="pb-4 pt-6 px-6 border-t text-start text-white">
                                {{ user.email }}
                            </td>
                            <td class="pb-4 pt-6 px-6 border-t text-start text-white">
                                <span v-if="user.admin">مسؤول</span>
                                <span v-else-if="user.super_user">نائب مسؤول</span>
                                <span v-else>مستخدم</span>
                            </td>
                            <td class="pb-4 pt-6 px-6 border-t text-start text-white">
                                <button @click="change_user_frame_fun(user.id,user.dashboard_control,user.chanels_control,user.support_control,user.videos_control,user.comments_control)">
                                    <i class="fa-solid fa-pen-to-square text-green-500"></i> تعديل
                                </button>
                            </td>
                            <td class="pb-4 pt-6 px-6 border-t text-start text-white ">
                                <Link :href="`/admin_taleb/users/${user.id}/destroy`" class="text-white">
                                    <i class="fa-solid fa-trash text-red-500"></i> حذف
                                </Link>
                            </td>
                        </tr>
                    </tbody>
                </DataTable>
            </div>
            <!-- popup incame -->
            <div class="limit_frame" v-if="change_user_frame">
                <div class="limit_panel">
                    <div class="header">
                        <div class="logo"></div>
                        <div class="exite" id="exit_popup" @click="change_user_frame_fun"><i class="fa-sharp fa-solid fa-circle-xmark"></i></div>
                    </div>
                    <form @submit.prevent="change_user_db" class="body_fram">
                        <div class="limit_type">
                            <label for="r3">
                                <p class="pb-2">حدد الالمهام المسموح بها</p>
                                <ToggleCheckbox
                                    :id="'ventilation'"
                                    :active_value="'نعم'"
                                    :inactive_value="'لا'"
                                    :label="'لوحة التحكم'"
                                    :isChecked="change_user_vars.dashboard_control"
                                    @toggle="dashboard_control_togle"
                                />
                                <ToggleCheckbox
                                    :id="'ventilation'"
                                    :active_value="'نعم'"
                                    :inactive_value="'لا'"
                                    :label="'القنوات '"
                                    :isChecked="change_user_vars.chanels_control"
                                    @toggle="chanels_control_togle"
                                />
                                <ToggleCheckbox
                                    :id="'ventilation'"
                                    :active_value="'نعم'"
                                    :inactive_value="'لا'"
                                    :label="'الدعم والابلاغات '"
                                    :isChecked="change_user_vars.support_control"
                                    @toggle="support_control_togle"
                                />
                                <ToggleCheckbox
                                    :id="'ventilation'"
                                    :active_value="'نعم'"
                                    :inactive_value="'لا'"
                                    :label="'الفيديوهات '"
                                    :isChecked="change_user_vars.videos_control"
                                    @toggle="videos_control_togle"
                                />
                                <ToggleCheckbox
                                    :id="'ventilation'"
                                    :active_value="'نعم'"
                                    :inactive_value="'لا'"
                                    :label="'التعليقات '"
                                    :isChecked="change_user_vars.comments_control"
                                    @toggle="comments_control_togle"
                                />
                            </label>
                        </div>
                        <div class="save">
                            <button type="submit">
                                save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </adminLayout>
</template>
<script setup>

import adminLayout from '@/Layouts/Admin.vue';
import { Head, Link} from '@inertiajs/vue3';
import ToggleCheckbox from "@/Components/ToggleCheckbox.vue";
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
        ToggleCheckbox,
    },
    props: {
        users: Object,
    },
    data() {
        return {
            change_user_frame: false,
            change_user_vars: this.$inertia.form({
                id_user: null,
                dashboard_control: this.$page.props.auth.user.dashboard_control,
                chanels_control: this.$page.props.auth.user.chanels_control,
                support_control: this.$page.props.auth.user.support_control,
                videos_control: this.$page.props.auth.user.comments_control,
                comments_control: this.$page.props.auth.user.videos_control,
        }),
        }
    },
    methods: {
        change_user_frame_fun(id_user,dashboard_control,chanels_control,support_control,videos_control,comments_control){
            this.change_user_frame?
                this.change_user_frame=false:
                [
                    this.change_user_vars.id_user=id_user,
                    this.change_user_vars.dashboard_control=dashboard_control,
                    this.change_user_vars.chanels_control=chanels_control,
                    this.change_user_vars.support_control=support_control,
                    this.change_user_vars.videos_control=videos_control,
                    this.change_user_vars.comments_control=comments_control,
                    this.change_user_frame=true
                ]
        },
        //togle
        comments_control_togle() {
        this.change_user_vars.comments_control = !this.change_user_vars.comments_control;
        },
        videos_control_togle() {
        this.change_user_vars.videos_control = !this.change_user_vars.videos_control;
        },
        support_control_togle() {
        this.change_user_vars.support_control = !this.change_user_vars.support_control;
        },
        chanels_control_togle() {
        this.change_user_vars.chanels_control = !this.change_user_vars.chanels_control;
        },
        dashboard_control_togle() {
        this.change_user_vars.dashboard_control = !this.change_user_vars.dashboard_control;
        },
        change_user_db() {
            this.change_user_vars.post(`/admin_taleb/users/${this.change_user_vars.id_user}/chaneg_state_users`, {
                onSuccess: () => {
                this.change_user_frame = false;
                this.change_user_vars.reset();
                },
            });
        },
    },
}
</script>
<style>
@import 'datatables.net-dt';
</style>