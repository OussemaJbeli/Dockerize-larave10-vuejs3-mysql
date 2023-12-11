<template>
        <div>
            <div id="top-menu">
                <div class="container-fluid overflow-visible">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light px-3  flexjustify-between ">
                        <div>
                            <i class="fa-solid fa-bars fa-xl" @click="open_side_bar"></i>
                            <b>
                                <Link class="navbar-brand" :href="route('home.gest')">
                                    طلاب
                                    <span class="tolab-icon"><i class="fa-solid fa-graduation-cap fa-lg"></i></span>
                                </Link>
                            </b>
                        </div>
                        <div class="navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav mx-lg-auto">
                                <li class="nav-item active">
                                    <Link class="nav-link4 pl-0 px-3 ml-1 mr-3" :href="route('home.gest')">
                                        الصفحة الرئيسية
                                    </Link>
                                </li>
                                <li class="nav-item">
                                    <Link class="nav-link4 pl-0 px-3 ml-1 mr-3" :href="route('news.gest')">
                                        المرفوعة حديثآ
                                    </Link>
                                </li>
                                <li class="nav-item">
                                    <Link class="nav-link4 pl-0 px-3 ml-1 mr-3" :href="route('hot.gest')">
                                        الفديوهات الرائجة
                                    </Link>
                                </li>
                            </ul>
                        </div>
                        <div class="flex flex-row ">
                            <div class="form-inline m-0 p-0">
                                <label :style="{ width: search_run? '100%' : '20%' }" class="label_for_search">
                                    <i class="fa-solid fa-circle-xmark" v-if="search_run" @click="start_searsh()" ></i>
                                    <i class="fa-solid fa-magnifying-glass" v-else @click="start_searsh()" ></i>
                                    <input 
                                        class="search" type="search" 
                                        v-model="searchQuery" 
                                        placeholder="إبحث ..." 
                                        :style="{ display: search_run? 'flex' : 'none' }"
                                    />
                                </label>
                            </div>
                            <button class="nav-link1 login pl-3" v-if="!search_run"  @click="open_login_frame_function">تسجيل الدخول</button>
                        </div>
                    </nav>
                    <!-- Modal -->
                    <div class="login_frame" id="loginModal" :style="{ display: open_login_frame? '' : 'none' }">
                            <div class="panel_login" v-if="register">
                                <div class="modal-header">
                                <h5 class="modal-title " style="color: #b2dfdb;" id="exampleModalLabel">
                                    تسجيل الدخول
                                    <i class="fa-solid fa-user-pen" style="color: bisque;"></i>
                                </h5>
                                <button type="button" class="close" @click="open_login_frame_function" >
                                    <span>&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                    <form @submit.prevent="submitregister">
                                        <div class="form-group">
                                            <label for="name" class="col-form-label text-white">الاسم :</label>
                                            <TextInput type="text" class="form-control" id="name" v-model="formregister.name" required />
                                            <InputError class="mt-2" :message="formregister.errors.name" />
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="col-form-label text-white">البريد الإلكتروني:</label>
                                            <TextInput type="email" class="form-control" id="email" v-model="formregister.email" required />
                                            <p class='text-red-500 pt-2' v-if="formregister.errors.email">البريد الإلكتروني تم أخذه بالفعل  </p>
                                        </div>
                                        <div class="form-group">
                                            <label for="password" class="col-form-label text-white">كلمة المرور:</label>
                                            <TextInput type="password" class="form-control" id="password" v-model="formregister.password" required placeholder="الرجاء ادخال كلمة اطول من 8 احرف" />
                                        </div>
                                        <div class="form-group">
                                            <label for="password_confirmation" class="col-form-label text-white"> اعد كتابة كلمة المرور:</label>
                                            <TextInput  type="password" class="form-control" id="password_confirmation" v-model="formregister.password_confirmation" required placeholder="الرجاء ادخال كلمة اطول من 8 احرف" />
                                        </div>
                                        <div class="flex items-center justify-between text-amber-500">
                                            <p class="sinup cursor-pointer" @click="change_page">لديك حساب؟</p>
                                            <button type="submit" class=" btn btn-outline-warning">تسجيل</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="panel_login"  v-else>
                                <div class="modal-header">
                                <h5 class="modal-title " style="color: #b2dfdb;" id="exampleModalLabel">
                                    تسجيل الدخول
                                    <i class="fa-solid fa-user-pen" style="color: bisque;"></i>
                                </h5>
                                <button type="button" class="close"  @click="open_login_frame_function" >
                                    <span>&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                    <form @submit.prevent="submitlogin">
                                        <div class="form-group">
                                            <label for="email" class="col-form-label text-white">البريد الإلكتروني:</label>
                                            <TextInput 
                                                type="email" 
                                                class="form-control" 
                                                id="email" 
                                                v-model="formlogin.email" 
                                                required 
                                                autofocus
                                            />
                                            <p class='text-red-500 pt-2' v-if="formlogin.errors.email">المستخدم غير موجود الرجاء التثبة من المعلومات</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="password" class="col-form-label text-white">كلمة المرور:</label>
                                            <TextInput 
                                                type="password" 
                                                class="form-control" 
                                                id="password" 
                                                v-model="formlogin.password" 
                                                required 
                                            />
                                            <InputError class="mt-2" :message="formlogin.errors.password" />
                                        </div>
                                        <div class="flex items-center justify-between text-amber-500">
                                            <p class="sinup cursor-pointer" @click="change_page">إنشاء حساب</p>
                                            <button type="submit" class=" btn btn-outline-warning">دخول</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            <main  class="main_over_all">
                <div class="row side_bare_copy">
                        <div id="wrap">
                            <div class="sidebar" :style="{ right: open_side_frame? '0px' : '-17rem' }">
                                <ul class="list-group list-group-flush pl-0">
                                    <Link class="list-group-item list-group-item-action" :href="route('home.gest')">
                                        <i class="fas fa-home mr-2 purple"></i> الصفحة الرئيسية
                                    </Link> 
                                    <Link class="list-group-item list-group-item-action" :href="route('news.gest')">
                                        <i class="fas fa-plus-square mr-2 purple"></i> المرفوعة حديثآ
                                    </Link> 
                                    <Link class="list-group-item list-group-item-action" :href="route('hot.gest')">
                                        <i class="fas fa-fire-alt mr-2 purple"></i> الفديوهات الرائجة
                                    </Link>
                                    <div class="copy_right">
                                        &copy; 2023 - طلاب <br>
                                        جميع الحقوق محفوظة. المحتوى التعليمي مخصص للاستخدام الشخصي فقط. ويحظر الاستخدام أو التوزيع غير المصرح له. اتصل بـالدعم الفني للاستفسارات.
                                    </div>
                                </ul>
                            </div>
                        </div>
                    </div>
                <div class="layer_dark" @click="open_side_bar" :style="{ display: open_side_frame? 'block' : 'none' }"></div>
            <!-- search items -->
                <div v-if="search_run" data-bs-spy="scroll" data-bs-target="#list-example" data-bs-offset="0" class="home_content_frame home_content_frame_serach" tabindex="0">
                    <div class="row">
                        <div class="video_card col-sm-6 col-md-4 col-lg-3" v-for="video_serach in filteredItems">
                            <div class="card p-1 mp-4">
                                <div class="card-icon">
                                    <Link class="image_video" :href="`/show_video_Gest/${video_serach.id}`">
                                        <img :src="'/'+video_serach.img_path" class="card-img-top" alt="card image">
                                        <time>{{video_serach.video_duration}}</time>
                                        <i class="fas fa-play fa-2x"></i>
                                    </Link>
                                </div>
                                <Link :href="`/show_video_Gest/${video_serach.id}`">
                                    <div class="card-body p-0">
                                        <p class="card-title">{{video_serach.name}}</p>
                                    </div>
                                </Link>
                                <div class="card-footer">
                                    <small class="text-muted">
                                        <span class="d-block"><i class="fa-solid fa-eye"></i> <span>{{video_serach.vuews_video}} مشاهدة</span></span>
                                        <i class="fa-solid fa-calendar-days"></i> <span>منذ {{ video_serach.date_count }} </span>
                                    </small>
                                </div>
                                <Link :href="`/chanel_gest/${video_serach.id}`" class="channel-img flex items-center flex-row">
                                    <img :src="'/'+video_serach.video_chanel_logo_path"  class="rounded-circle my-2 ml-3 h-8 w-8">
                                    <span class="card-text  pl-2">{{video_serach.video_chanel_name}}</span>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-else>
                    <slot />
                </div>
            </main>
        </div>
</template>
<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const formlogin = useForm({
    email: null,
    password: null,
});
const formregister = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submitlogin = () => {
    formlogin.post(route('login'), {
        onFinish: () => {
            formlogin.reset('password');
        },
    });
};

const submitregister = () => {
    formregister.post(route('register'), {
        onFinish: () => formregister.reset('password', 'password_confirmation'),
    });
};
</script>
<script>
export default {
    components: {
        Head,
        Link,
    },
    props: {
        items_list: Object,
    },
    data() {
        return {
            open_login_frame: false,
            register: false,
            open_side_frame: false,
            search_run: false,
            searchQuery: '',
        }
    },
    methods: {
        open_side_bar(){
            this.open_side_frame ? 
                this.open_side_frame=false : 
                this.open_side_frame=true;
        },
        change_page(){
            this.register ? 
                this.register=false : 
                this.register=true;
        },
        open_login_frame_function(){
            this.open_login_frame ? 
                this.open_login_frame=false : 
                this.open_login_frame=true;
        },
        start_searsh(){
            this.search_run?
                this.search_run=false:
                this.search_run=true;
        },
    },
    computed: {
        filteredItems() {
            const query = this.searchQuery.toLowerCase();
            return this.$page.props.videos_chanel_target.filter(video_serach => video_serach.name.toLowerCase().includes(query));
        }
    }
}
</script>
