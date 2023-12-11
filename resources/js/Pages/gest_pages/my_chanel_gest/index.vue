<!-- ////////////////// temlate///////////// -->
<template>
    <gestLayoutuser>
        <Head title="طلاب" />
        <div class="channel-page">
            <div class="container-fluid">
                <div v-if="needt_login" class="alert alert-danger alert-dismissible fade show need_account" role="alert">
                    <div>
                        <i class="fa-solid fa-triangle-exclamation"></i>
                            تحتاج لتسجيل الدخول اولا او انشاء حساب
                    </div>
                    <button @click="needt_login_function" type="button" data-bs-dismiss="alert" aria-label="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="row">
                    <div class="banner position-relative p-0 m-0">
                        <div class="img-fluid">
                            <div class="separateur1">
                                <img :src="'/'+myCookieArray.img_path_chanel" alt="">
                            </div>
                            <div class="separateur2">
                                <div class="img_container">
                                    <div class="discription">
                                        <div  class="image_panel">
                                            <img :src="'/'+myCookieArray.logo_path_chanel" alt="">
                                        </div>
                                        <div class="chanel_name_subs">
                                            <div class="chanel_name">
                                                <p class='name'>{{ myCookieArray.name_chanel }}</p>
                                                <p>الاشتراكات :  {{ myCookieArray.count_subscribe }}</p>
                                            </div>
                                            <button @click="needt_login_function" class="float-right btn text-white btn-warning button_ictirak">
                                                إشترك
                                            </button> 
                                        </div>
                                    </div>
                                    <div class="chanel_links">
                                        <div v-for="link_path in myCookieArray_links">
                                            <a :href="link_path.link" class="mr-1" target="_blank">
                                                <i class="fa-brands fa-square-facebook" v-if="link_path.name == 'facebook'"></i>
                                                <i class="fa-brands fa-square-twitter" v-if="link_path.name == 'twitter'"></i>
                                                <i class="fa-brands fa-square-snapchat" v-if="link_path.name == 'snapchat'"></i>
                                                <i class="fa-brands fa-square-instagram" v-if="link_path.name == 'instagram'"></i>
                                                <i class="fa-solid fa-link" v-if="link_path.name == 'other'"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <!-- test -->
                    <div class="row">
                        <nav class="navbar navbar-expand-lg navbar-light bg-light4 mx-auto w-100 px-0 py-2">                 
                            <ul class="navbar-nav mx-auto d-block pl-0 ul_of_chanel_links">
                                <li class="nav-item  nav-item1">
                                    <Link class="list-group-item list-group-item-action border-0" :href="`/chanel_gest/${myCookieArray.id}`">
                                        الصفحة الرئيسية
                                    </Link>
                                </li>
                                <li class="nav-item">
                                    <Link class="list-group-item list-group-item-action border-0" :href="`/other_videos_gest/${myCookieArray.id}`">
                                        الفديوهات
                                    </Link>
                                </li>
                                <li class="nav-item">
                                    <Link class="list-group-item list-group-item-action border-0" :href="`/other_playlist_gest/${myCookieArray.id}`">
                                        قوائم التشغيل
                                    </Link>
                                </li>
                                <li class="nav-item">
                                    <Link class="list-group-item list-group-item-action border-0" :href="`/other_subscribs_gest/${myCookieArray.id}/${myCookieArray.id_user}`">
                                        القنوات
                                    </Link>
                                </li>
                                <li class="nav-item">
                                    <Link class="list-group-item list-group-item-action border-0" :href="`/other_about_gest/${myCookieArray.id}`">
                                        حول
                                    </Link>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div>
                    <slot/>
                </div>
            </div>
        </div>
    </gestLayoutuser>
</template>
<script setup>
import gestLayoutuser from '@/Layouts/gestLayoutuser.vue';
import FileInput from "@/Components/FileInput.vue";
import { Head, Link} from '@inertiajs/vue3';
import Cookies from 'js-cookie';
</script>

<script>
export default {
    components: {
        Head,
        Link,
        FileInput,
    },
    props: {

    },

    data() {
        return {
            myCookieArray: [],
            get_cookie: '',

            myCookieArray_links: [],
            get_cookie_links: '',

            needt_login: false,
        }
    },
    methods: {
        needt_login_function(){
            this.needt_login?
            this.needt_login = false:
            this.needt_login = true;
        },
    },
    mounted() {
        this.get_cookie = Cookies.get('my_chanel');
        this.myCookieArray = this.get_cookie ? JSON.parse(this.get_cookie) : [];
        
        this.get_cookie_links = Cookies.get('my_links');
        this.myCookieArray_links = this.get_cookie_links ? JSON.parse(this.get_cookie_links) : [];
    },
}
</script>
