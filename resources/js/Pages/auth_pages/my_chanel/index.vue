<!-- ////////////////// temlate///////////// -->
<template>
    <AuthenticatedLayout>
        <Head title="طلاب" />
        <div class="channel-page">
            <div class="container-fluid">
                <div class="row">
                    <div class="banner position-relative p-0 m-0">
                        <div class="img-fluid">
                            <div class="separateur1">
                                <img :src="'/'+$page.props.auth.chanel[0].img_path_chanel" alt="" v-if="$page.props.auth.chanel[0]">
                                <img src="img/chanels/base_back.webp" alt="" v-else>
                            </div>
                            <div class="separateur2">
                                <div class="img_container">
                                    <div class="discription">
                                        <div  class="image_panel">
                                            <img :src="'/'+$page.props.auth.chanel[0].logo_path_chanel" alt="" v-if="$page.props.auth.chanel[0]">
                                            <img src="img/chanels/base_logo.png" alt="" v-else>
                                        </div>
                                        <div class="chanel_name_subs">
                                            <div class="chanel_under_name">
                                                <p class='name' v-if="$page.props.auth.chanel[0]">{{$page.props.auth.chanel[0].name_chanel}}</p>
                                                <p class='name' v-else>{{$page.props.auth.user.name}}</p>
                                                <p  v-if="$page.props.auth.chanel[0]">الاشتراكات : {{$page.props.auth.chanel[0].count_subscribe}} </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="buttons_chanel_controll">
                                        <button class="button_add mr-2 mb-2"  v-if="$page.props.auth.chanel[0]" @click="edite_chanel_function($page.props.auth.chanel[0].name_chanel,$page.props.auth.chanel[0].discription_chanel,$page.props.auth.chanel[0].logo_path_chanel,$page.props.auth.chanel[0].img_path_chanel)">
                                            تعديل القنات
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button class="button_add mr-2  mb-2"  v-if="$page.props.auth.chanel[0]" @click="add_links_function">
                                            اضف رابط
                                            <i class="fa-solid fa-plus"></i>
                                        </button>
                                        <button class="button_add button_delete"  v-if="$page.props.auth.chanel[0] && $page.props.auth.links[0]" @click="remove_links_function">
                                            حذف رابط
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                    <div class="chanel_links">
                                        <div v-for="(link_path,index) in $page.props.auth.links[0]">
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
                    <div class="row" v-if="$page.props.auth.chanel[0]">
                        <nav class="navbar navbar-expand-lg navbar-light bg-light4 mx-auto w-100 px-0 py-2">                 
                            <ul class="navbar-nav mx-auto d-block pl-0 ul_of_chanel_links">
                                <li class="nav-item nav-item1">
                                    <Link class="list-group-item list-group-item-action border-0" :href="route('my_chanel_AUTH')">
                                        الصفحة الرئيسية
                                    </Link>
                                </li>
                                <li class="nav-item">
                                    <Link class="list-group-item list-group-item-action border-0" :href="route('my_videos_AUTH')">
                                        فديوهاتي
                                    </Link>
                                </li>
                                <li class="nav-item">
                                    <Link class="list-group-item list-group-item-action border-0" :href="route('playlist_AUTH')">
                                        قوائم التشغيل
                                    </Link>
                                </li>
                                <li class="nav-item">
                                    <Link class="list-group-item list-group-item-action border-0" :href="route('my_subscribs_AUTH')">
                                        القنوات
                                    </Link>
                                </li>
                                <li class="nav-item">
                                    <Link class="list-group-item list-group-item-action border-0" :href="`my_about_AUTH/${$page.props.auth.chanel[0].id}`">
                                        حول
                                    </Link>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <slot/>
            </div>
                <!-- popup edite chanel -->
                <div class="chanel_frame" id="loginModal" v-if="edite_chanel">
                    <div class="panel_chanel">
                        <div class="modal-header">
                            <h5 class="modal-title " style="color: #b2dfdb;" id="exampleModalLabel">
                                تعديل القنات
                            </h5>
                            <button type="button" class="close" @click="edite_chanel_function($page.props.auth.chanel[0].name,$page.props.auth.chanel[0].discription,$page.props.auth.chanel[0].logo_path,$page.props.auth.chanel[0].img_path)">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                                <form @submit.prevent="edite_chanel_db" >
                                        <div class="small_panel">
                                            <div class="form-group">
                                                <label for="name" class="col-form-label text-white">إسم القنات</label>
                                                <input type="text" class="form-control" id="name" v-model="edite_chanel_values.name" required :error="edite_chanel_values.errors.name">
                                            </div>
                                            <div class="form-group">
                                                <label for="dis" class="col-form-label text-white">وصف للقنات</label>
                                                <textarea name="discription" class="form-control form-control-text" id="dis" v-model="edite_chanel_values.discription" required :error="edite_chanel_values.errors.discription">
                                                </textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="dis" class="col-form-label text-white">خلفية القنات </label>
                                                <div class="img_body">
                                                    <div class="image_panel1">
                                                        <img :src="$page.props.auth.chanel[0].img_path_chanel" alt="">
                                                    </div>
                                                    <file-input
                                                        v-model="edite_chanel_values.img_path"
                                                        :error="edite_chanel_values.errors.img_path"
                                                        class="file_shoser"
                                                        type="file"
                                                        accept="image/*"
                                                    />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="dis" class="col-form-label text-white"> شعار القنات</label>
                                                <div class="img_body">
                                                    <div class="image_panel2">
                                                        <img :src="$page.props.auth.chanel[0].logo_path_chanel" alt="">
                                                    </div>
                                                    <file-input
                                                        v-model="edite_chanel_values.logo_path"
                                                        :error="edite_chanel_values.errors.logo_path"
                                                        class="file_shoser"
                                                        type="file"
                                                        accept="image/*"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-center border-solid border-t border-white h-16">
                                            <button type="submit" class=" btn btn-outline-warning">تعديل</button>
                                        </div>
                                </form>
                        </div>
                    </div>
                </div>
                <!-- add links -->
                <div class="chanel_frame" id="loginModal" v-if="add_links">
                    <div class="links_frame">
                        <div class="modal-header">
                            <h5 class="modal-title " style="color: #b2dfdb;" id="exampleModalLabel">
                                اضافة رابط
                            </h5>
                            <button type="button" class="close" @click="add_links_function">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                                <form @submit.prevent="add_links_db" >
                                        <div class="small_panel">
                                            <div class="form-group">
                                                <label for="name" class="col-form-label text-white">نوع الرابط</label>
                                                <select 
                                                    class="form-control" 
                                                    required
                                                    v-model="add_links_values.link_type"
                                                    :error="add_links_values.errors.link_type"
                                                    >
                                                    <option class="list-group-item list-group-item-action" value= 'twitter' selected>
                                                        تويتر
                                                    </option>
                                                    <option class="list-group-item list-group-item-action" value= 'facebook'>
                                                        فيس بوك
                                                    </option>
                                                    <option class="list-group-item list-group-item-action" value= 'snapchat'>
                                                        سناب شات
                                                    </option>
                                                    <option class="list-group-item list-group-item-action" value= 'instagram'>
                                                        انستاغرام
                                                    </option>
                                                    <option class="list-group-item list-group-item-action" value= 'other'>
                                                        رابط آخر
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="name" class="col-form-label text-white">الرابط </label>
                                                <input type="url" class="form-control" id="name" v-model="add_links_values.link_name" required :error="add_links_values.errors.link">
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-center border-solid border-t border-white h-16">
                                            <button type="submit" class=" btn btn-outline-warning">انشاء</button>
                                        </div>
                                </form>
                        </div>
                    </div>
                </div>
                <!-- remove links -->
                <div class="chanel_frame" id="loginModal" v-if="remove_links">
                    <div class="links_frame">
                        <div class="modal-header">
                            <h5 class="modal-title " style="color: #b2dfdb;" id="exampleModalLabel">
                                حذف رابط
                            </h5>
                            <button type="button" class="close" @click="remove_links_function">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="small_panel">
                                <div class="form-group"  v-for="(link_path,index) in $page.props.auth.links[0]">
                                    <div :href="link_path.link" class="remove_frame">
                                        <i class="fa-brands fa-square-facebook" v-if="link_path.name == 'facebook'"></i>
                                        <i class="fa-brands fa-square-twitter" v-if="link_path.name == 'twitter'"></i>
                                        <i class="fa-brands fa-square-snapchat" v-if="link_path.name == 'snapchat'"></i>
                                        <i class="fa-brands fa-square-instagram" v-if="link_path.name == 'instagram'"></i>
                                        <i class="fa-solid fa-link" v-if="link_path.name == 'other'"></i>
                                        <p>{{link_path.link}}</p>
                                        <button @click="remove_links_db(link_path.id)"><i class="fa-solid fa-trash"></i></button>
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
        chanel: Object,
        links: Object,
    },

    data() {
        return {
            add_links:false,
            edite_chanel:false,
            remove_links:false,

            edite_chanel_values: this.$inertia.form({
                name: '',
                discription: '',
                logo_path: '',
                img_path: '',
            }),
            add_links_values: this.$inertia.form({
                link_type: '',
                link_name: '',
            }),
        }
    },
    methods: {
        //edite chanel
        edite_chanel_function(name,discription,logo_path,img_path){
            this.edite_chanel?
                this.edite_chanel=false:
                [
                    this.edite_chanel=true,
                    this.edite_chanel_values.name = name, 
                    this.edite_chanel_values.discription = discription, 
                ];
        },
        edite_chanel_db(){
            this.edite_chanel_values.post(`/my_chanel_AUTH/${this.$page.props.auth.chanel[0].id}/edit`, {
                onSuccess: () => {
                this.edite_chanel = false;
                this.edite_chanel_values.reset();
                },
            });
        },
        //add links
        add_links_function(){
            this.add_links?
                this.add_links=false:
                this.add_links=true;
        },
        add_links_db(){
            this.add_links_values.put(`my_chanel_AUTH/${this.$page.props.auth.chanel[0].id}/links`, {
                preserveScroll: true,
                onSuccess: () => {
                this.add_links = false;
                this.add_links_values.reset();
                },
            });
        },
        //add links
        remove_links_function(){
            this.remove_links?
                this.remove_links=false:
                this.remove_links=true;
        },
        remove_links_db(id_link){
            this.add_links_values.put(`my_chanel_AUTH/${id_link}/remove`);
        },
    },
}
</script>
