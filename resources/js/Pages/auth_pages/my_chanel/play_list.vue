<!-- ////////////////// temlate///////////// -->
<template>
    <ChanelLayout>
        <Head title="Log in" />
        <div class="latest-download" v-if="$page.props.auth.chanel[0]">
                        <div class="container">
                            <div class="header_new_videos">
                                <h4 >  قوائم التشغيل</h4>
                                <button class="button_add m-0" @click="add_videos_function">
                                انشاء قائمة
                                    <i class="fa-solid fa-folder-plus"></i>
                                </button>
                            </div>
                            <div class="row" v-if="play_list[0]">
                                <div class="col-sm-6 col-md-4 col-lg-3 video_panel" v-for="(video,index) in play_list">
                                    <div class="card mp-4 p-1">
                                        <div class="card-icon">
                                            <a class="img_panel_video" @click="open_video_show(video.id,video.video_path)">
                                                <img :src="video.img_path" class="card-img-top" alt="card image">
                                                <div v-for="playlist in number_playlist" >
                                                    <div v-if="parseInt(playlist.id_playlist, 10) == video.id"> 
                                                        <p>
                                                            {{ playlist.count }} فيديو <i class="fa-solid fa-list"></i>
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="card-body p-0">
                                            <p class="card-title">{{ video.name }}</p>
                                        </div>
                                        <div class="edite_delete playlist_adite_delete">
                                            <div>
                                                <button class="button button_add"  @click="add_videos_playlist_function(video.id)">
                                                    <i class="fa-solid fa-plus"></i>
                                                </button>
                                                <button class="button"  @click="remove_videos_playlist_function(video.id)">
                                                    <i class="fa-solid fa-minus"></i>
                                                </button>
                                            </div>
                                            <div>
                                                <button class="button button_add"  @click="edite_playlist_function(video.id,video.name,video.img_path)">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>
                                                <Link class="button" 
                                                    :href="`playlist_AUTH/${video.id}/delete`">
                                                    <i class="fa-solid fa-trash"></i>
                                                </Link>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='paragraph' v-else>يمكنك الان انشاء قوائم تشغيل</div>
                        </div> 
        </div>
            <!-- popup add playlist -->
            <div class="upload_videos_frame play_list_add" id="loginModal" v-if="add_videos">
                    <div class="panel_chanel">
                        <div class="modal-header">
                            <h5 class="modal-title " style="color: #b2dfdb;" id="exampleModalLabel">
                                انشاء قائمة تشغيل
                            </h5>
                            <button type="button" class="close" @click="add_videos_function" >
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                                <form @submit.prevent="add_playlist_db">
                                        <div class="small_panel_playlist">
                                            <div class="form-group">
                                                <label for="dis" class="col-form-label text-white">  عنوان قائمة تشغيل</label>
                                                <input type="text" class="form-control" id="name" v-model="add_videos_values.name" required :error="add_videos_values.errors.name">
                                            </div>
                                            <div class="form-group">
                                                <label for="dis" class="col-form-label text-white"> صورة قائمة تشغيل  </label>
                                                <div class="img_body">
                                                    <div class="image_panel1">
                                                        <img src="img/chanels/add_img_tovideo.png" alt="">
                                                    </div>
                                                    <file-input
                                                        v-model="add_videos_values.img_path"
                                                        :error="add_videos_values.errors.img_path"
                                                        class="file_shoser"
                                                        type="file"
                                                        accept="image/*"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-center border-solid border-t border-white h-16">
                                            <button type="submit" class=" btn btn-outline-warning" > انشاء</button>
                                        </div>
                                </form>
                        </div>
                    </div>
            </div>
            <!-- popup edite playlist -->
            <div class="upload_videos_frame play_list_add" id="loginModal" v-if="edite_playlist">
                    <div class="panel_chanel">
                        <div class="modal-header">
                            <h5 class="modal-title " style="color: #b2dfdb;" id="exampleModalLabel">
                                تعديل  
                            </h5>
                            <button type="button" class="close" @click="edite_playlist_function" >
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                                <form @submit.prevent="edite_playlist_db">
                                        <div class="small_panel_playlist">
                                            <div class="form-group">
                                                <label for="name" class="col-form-label text-white">عنوان المقطع</label>
                                                <input type="text" class="form-control" id="name" v-model="edite_playlist_values.name" required :error="edite_playlist_values.errors.name">
                                            </div>
                                            <div class="form-group">
                                                <label for="dis" class="col-form-label text-white"> صورة مصغرة للفيديو </label>
                                                <div class="img_body">
                                                    <div class="image_panel2">
                                                        <img :src="edite_playlist_values.TEMPimg_path" alt="">
                                                    </div>
                                                    <file-input
                                                        v-model="edite_playlist_values.img_path"
                                                        :error="edite_playlist_values.errors.img_path"
                                                        class="file_shoser"
                                                        type="file"
                                                        accept="image/*"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-center border-solid border-t border-white h-16">
                                            <button type="submit" class=" btn btn-outline-warning" > تعديل</button>
                                        </div>
                                </form>
                        </div>
                    </div>
            </div>
            <!-- popup add videos playlist -->
            <div class="upload_videos_frame play_list_add" id="loginModal" v-if="add_videos_playlist">
                    <div class="panel_chanel">
                        <div class="modal-header">
                            <h5 class="modal-title " style="color: #b2dfdb;" id="exampleModalLabel">
                                اضافة فيديو 
                            </h5>
                            <button type="button" class="close" @click="add_videos_playlist_function" >
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                                <form @submit.prevent="add_videos_playlist_db">
                                        <div class="small_panel_playlist_videos">
                                            <div class="list_video">
                                                <div v-for="(item) in  videos_without_playlist" class="form-group">
                                                    <label class="item" :for="item.id">
                                                        <img id="item_path"  :src="item.img_path" class=" bg-white">
                                                    </label>
                                                    <input 
                                                        :id="item.id"
                                                        class="item_chek" 
                                                        type="radio" 
                                                        :value="item.id" 
                                                        :name='"items"'
                                                        v-model="add_videos_playlist_values.id_videos"
                                                        :error="add_videos_playlist_values.errors.id_videos"
                                                        :required="isRequired(item)"
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-center border-solid border-t border-white h-16">
                                            <button type="submit" class=" btn btn-outline-warning" >اضافة الفيديو</button>
                                        </div>
                                </form>
                        </div>
                    </div>
            </div>
            <!-- popup remove videos playlist -->
            <div class="upload_videos_frame play_list_add" id="loginModal" v-if="remove_videos_playlist">
                    <div class="panel_chanel">
                        <div class="modal-header">
                            <h5 class="modal-title " style="color: #b2dfdb;" id="exampleModalLabel">
                                ازالة فيديو من قائمة التشغيل
                            </h5>
                            <button type="button" class="close" @click="remove_videos_playlist_function" >
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="small_panel_playlist_videos">
                                <div class="list_video">
                                    <div v-for="(item) in  videos_with_playlist">
                                        <div class="form-group" v-if="parseInt(item.id_playlist, 10)  == remove_videos_playlist_values.id_playlist">
                                            <label class="item">
                                                <img id="item_path"  :src="item.img_path" class=" bg-white">
                                            </label>
                                            <Link class="button" 
                                                :href="`playlist_AUTH/${item.id_video}/delete_videos`">
                                                <i class="fa-solid fa-trash"></i> 
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>

    </ChanelLayout>
</template>
<script setup>
import ChanelLayout from '@/Pages/auth_pages/my_chanel/index.vue';
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
        play_list: Object,
        videos_without_playlist: Object,
        videos_with_playlist: Object,
        number_playlist: Object,
    },

    data() {
        return {
            add_videos:false,
            add_videos_values: this.$inertia.form({
                name: null,
                img_path: null,
            }),
            edite_playlist:false,
            edite_playlist_values: this.$inertia.form({
                id_playlist: null,
                name: null,
                img_path: null,
                TEMPimg_path: null,
            }),
            //videos playlist
            add_videos_playlist:false,
            add_videos_playlist_values: this.$inertia.form({
                id_videos: null,
                id_playlist: null,
            }),
            remove_videos_playlist:false,
            remove_videos_playlist_values: this.$inertia.form({
                id_playlist: null,
            }),
        }
    },
    methods: {
        //add playlist
        add_videos_function(){
            this.add_videos?
                this.add_videos=false:
                this.add_videos=true;
        },
        add_playlist_db(){
            this.add_videos_values.post(`playlist_AUTH/${this.$page.props.auth.chanel[0].id}/create`, {
                onSuccess: () => {
                    this.add_videos = false;
                    this.add_videos_values.reset();
                },
            });
        },
        //edite play list
        edite_playlist_function(id,name,img_path){
            this.edite_playlist?
                this.edite_playlist=false:
                [
                    this.edite_playlist=true,
                    this.edite_playlist_values.id_playlist=id,
                    this.edite_playlist_values.name=name,
                    this.edite_playlist_values.TEMPimg_path=img_path,
                ];
        },
        edite_playlist_db(){
            this.edite_playlist_values.post(`playlist_AUTH/${this.edite_playlist_values.id_playlist}/edit`, {
                onSuccess: () => {
                    this.edite_playlist = false;
                    this.edite_playlist_values.reset();
                },
            });
        },
        //add videos playlist
        isRequired(optionValue) {
            return this.requiredValue === optionValue;
        },
        add_videos_playlist_function(id_playlist){
            this.add_videos_playlist?
                this.add_videos_playlist=false:
                [
                    this.add_videos_playlist=true,
                    this.add_videos_playlist_values.id_playlist=id_playlist,
                ];
        },
        add_videos_playlist_db(){
            this.add_videos_playlist_values.post(`playlist_AUTH/${this.add_videos_playlist_values.id_playlist}/add_videos`, {
                onSuccess: () => {
                    this.add_videos_playlist = false;
                    this.add_videos_playlist_values.reset();
                },
            });
        },
        //remove videos play list
        remove_videos_playlist_function(id_playlist){
            this.remove_videos_playlist?
                this.remove_videos_playlist=false:
                [
                    this.remove_videos_playlist=true,
                    this.remove_videos_playlist_values.id_playlist=id_playlist,
                ];
        },
    },
}
</script>
