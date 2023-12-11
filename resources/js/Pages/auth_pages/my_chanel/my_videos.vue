<!-- ////////////////// temlate///////////// -->
<template>
        <ChanelLayout>
        <div class="latest-download" v-if="$page.props.auth.chanel[0]">
                        <div class="container">
                            <div class="header_new_videos">
                                <h4 > الفديوهات المرفوعة</h4>
                                <button class="button_add m-0" @click="add_videos_function">
                                    رفع فيديو
                                    <i class="fa-solid fa-arrow-up-from-bracket"></i>
                                </button>
                            </div>
                            <div class="row" v-if="videos[0]">
                                <div class="col-sm-6 col-md-4 col-lg-3 video_panel mt-10" v-for="(video,index) in videos">
                                    <div class="card mp-4 p-1">
                                        <div class="card-icon">
                                            <Link class="img_panel_video" :href="`show_video/${video.id}`">
                                                <img :src="video.img_path" class="card-img-top" alt="card image">
                                                <time>{{video.video_duration}}</time>
                                                <i class="fas fa-play fa-2x"></i>
                                            </Link>
                                        </div>
                                        <div class="card-body p-0">
                                            <p class="card-title">{{ video.name }}</p>
                                        </div>
                                        <div class="card-footer">
                                            <small class="text-muted">
                                                <span class="d-block"><i class="fa-solid fa-eye"></i> <span>{{video.vuews_video}} مشاهدة</span></span>
                                                <i class="fa-solid fa-calendar-days"></i> <span>منذ {{ video.date_count }} </span>
                                            </small>
                                        </div>
                                        <div class="edite_delete">
                                            <button class="button button_add"  @click="edite_videos_function(video.id,video.name,video.discription,video.public,video.video_path,video.img_path)">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                            <Link class="button" 
                                                :href="`my_videos_AUTH/${video.id}/delete`">
                                                <i class="fa-solid fa-trash"></i>
                                            </Link>
                                            <div class="video_visibility mr-28">
                                                <div v-if="video.public == 'عامة'" class="text-green-500">
                                                    <i class="fa-solid fa-people-group mr-2" ></i>
                                                    <span>عام</span>
                                                </div>
                                                <div v-if="video.public == 'خاصة'" class="text-red-500">
                                                    <i class="fa-solid fa-lock mr-2 " ></i>
                                                    <span>خاص</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class='paragraph' v-else>يمكمك الان رفع الفيديوهات علي القنات</div>
                        </div> 
        </div>
        <div v-else class="dont_have_chanel">
                <p>قم بإنشاء قنات لتتمكن من رفع الفيديوهات عليها</p>
                <button class="button_add" @click="add_chanel_function">
                    إنشاء قنات
                    <i class="fa-solid fa-plus"></i>
                </button>
        </div>
            <!-- popup edite video -->
                <div class="upload_videos_frame" id="loginModal" v-if="edite_videos">
                    <div class="panel_chanel">
                        <div class="modal-header">
                            <h5 class="modal-title " style="color: #b2dfdb;" id="exampleModalLabel">
                                تعديل فيديو 
                            </h5>
                            <button type="button" class="close" @click="edite_videos_function" >
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                                <form @submit.prevent="edite_videos_db">
                                        <div class="small_panel">
                                            <div class="info_video frames">
                                                <div class="form-group">
                                                    <label for="name" class="col-form-label text-white">عنوان المقطع</label>
                                                    <input type="text" class="form-control" id="name" v-model="edite_videos_values.name" required :error="edite_videos_values.errors.name">
                                                </div>
                                                <div class="form-group">
                                                    <label for="dis" class="col-form-label text-white">وصف للقنات</label>
                                                    <textarea name="discription" class="form-control form-control-text" id="dis" v-model="edite_videos_values.discription" required :error="edite_videos_values.errors.discription"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="name" class="col-form-label text-white"> حالات مقاطع الفيديو</label>
                                                    <select 
                                                        class="form-control" 
                                                        required
                                                        v-model="edite_videos_values.public_states" 
                                                        :error="edite_videos_values.errors.public_states"
                                                        >
                                                        <option class="list-group-item list-group-item-action" value= 'خاصة' selected>
                                                            خاصة
                                                        </option>
                                                        <option class="list-group-item list-group-item-action" value= 'عامة'>
                                                            عامة
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="meadia_upload frames">
                                                <div class="form-group">
                                                    <label for="dis" class="col-form-label text-white"> الفيديو :اقصى حد مسموح به هو 100MB</label>
                                                    <div class="img_body">
                                                        <div class="image_panel1">
                                                            <video width="320" height="240" controls>
                                                                <source :src="edite_videos_values.TEMPvideo_path" type="video/mp4">
                                                                <source :src="edite_videos_values.TEMPvideo_path" type="video/webm">
                                                                <source :src="edite_videos_values.TEMPvideo_path" type="video/ogg">
                                                            </video>
                                                        </div>
                                                        <file-input
                                                        required
                                                            v-model="edite_videos_values.video_path"
                                                            :error="edite_videos_values.errors.video_path"
                                                            class="file_shoser"
                                                            type="file"
                                                            accept="video/*"
                                                            @change="handleFileChange"
                                                        />
                                                        <p class="text-red-700" v-if="fileSizeError == false">اقصى حد مسموح به هو 100MB</p>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="dis" class="col-form-label text-white"> صورة مصغرة للفيديو </label>
                                                    <div class="img_body">
                                                        <div class="image_panel2">
                                                            <img :src="edite_videos_values.TEMPimg_path" alt="">
                                                        </div>
                                                        <file-input
                                                        required
                                                            v-model="edite_videos_values.img_path"
                                                            :error="edite_videos_values.errors.img_path"
                                                            class="file_shoser"
                                                            type="file"
                                                            accept="image/*"
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-center border-solid border-t border-white h-16">
                                            <button type="submit" class=" btn btn-outline-warning" >رفع الفيديو</button>
                                        </div>
                                </form>
                        </div>
                    </div>
            </div>
            <!-- popup upload video -->
            <div class="upload_videos_frame" id="loginModal" v-if="add_videos">
                    <div class="panel_chanel">
                        <div class="modal-header">
                            <h5 class="modal-title " style="color: #b2dfdb;" id="exampleModalLabel">
                                رفع فيديو
                            </h5>
                            <button type="button" class="close" @click="add_videos_function" >
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                                <form @submit.prevent="add_videos_db">
                                        <div class="small_panel">
                                            <div class="info_video frames">
                                                <div class="form-group">
                                                    <label for="dis" class="col-form-label text-white">  عنوان المقطع</label>
                                                    <input type="text" class="form-control" id="name" v-model="add_videos_values.name" required :error="add_videos_values.errors.name">
                                                </div>
                                                <div class="form-group">
                                                    <label for="dis" class="col-form-label text-white">وصف المقطع</label>
                                                    <textarea name="discription" class="form-control form-control-text" id="dis" v-model="add_videos_values.discription" required :error="add_videos_values.errors.discription"></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="name" class="col-form-label text-white"> حالات مقاطع الفيديو</label>
                                                    <select 
                                                        class="form-control" 
                                                        required
                                                        v-model="add_videos_values.public_states" 
                                                        :error="add_videos_values.errors.public_states"
                                                        >
                                                        <option class="list-group-item list-group-item-action" value= 'خاصة' selected>
                                                            خاصة
                                                        </option>
                                                        <option class="list-group-item list-group-item-action" value= 'عامة'>
                                                            عامة
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="meadia_upload frames">
                                                <div class="form-group">
                                                    <label for="dis" class="col-form-label text-white">  الفيديو :اقصى حد مسموح به هو 100MB  </label>
                                                    <div class="img_body">
                                                        <div class="image_panel1">
                                                            <img src="img/chanels/upload_video.png" alt="">
                                                        </div>
                                                        <file-input
                                                        required
                                                            v-model="add_videos_values.video_path"
                                                            :error="add_videos_values.errors.video_path"
                                                            class="file_shoser"
                                                            type="file"
                                                            accept="video/*"
                                                            @change="handleFileChange"
                                                        />
                                                        <p class="text-red-700" v-if="fileSizeError == false">اقصى حد مسموح به هو 100MB</p>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="dis" class="col-form-label text-white"> صورة مصغرة للفيديو </label>
                                                    <div class="img_body">
                                                        <div class="image_panel2">
                                                            <img src="img/chanels/add_img_tovideo.png" alt="">
                                                        </div>
                                                        <file-input
                                                        required
                                                            v-model="add_videos_values.img_path"
                                                            :error="add_videos_values.errors.img_path"
                                                            class="file_shoser"
                                                            type="file"
                                                            accept="image/*"
                                                        />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center justify-center border-solid border-t border-white h-16">
                                            <button type="submit" class=" btn btn-outline-warning" >رفع الفيديو</button>
                                        </div>
                                </form>
                        </div>
                    </div>
                </div>
            <!-- upload animation -->
            <div class="upload_animation_frame" v-if="upload_animation">
                <div class="upload-container">
                    <div class="img">
                        <img src="img/chanels/upload_animation2.gif" alt="">
                    </div>
                    <p>
                        <span>جاري رفع الفيديو!</span>
                        <span>الرجاء عدم غلق هذه النافذة</span>
                        <span> قد تطول المدة علي حسب <span class="importent">سرعة الانترنات</span> و <span class="importent">حجم الفيديو</span></span>
                    </p>
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
        videos: Object,
    },

    data() {
        return {
            add_videos:false,
            add_videos_values: this.$inertia.form({
                name: '',
                discription: '',
                public_states: '',
                video_path: null,
                img_path: null,
            }),
            edite_videos:false,
            edite_videos_values: this.$inertia.form({
                id_video: null,
                name: '',
                discription: '',
                public_states: '',
                video_path: null,
                img_path: null,
                TEMPimg_path: null,
                TEMPvideo_path: null,
            }),
            upload_animation: false,
            fileSizeError: true,
        }
    },
    methods: {
        //upload videos
        add_videos_function(){
            this.add_videos?
                this.add_videos=false:
                this.add_videos=true;
        },
        add_videos_db(){
            if(this.fileSizeError){
            this.add_videos_values.post(`my_videos_AUTH/${this.$page.props.auth.chanel[0].id}/upload`, {
                onProgress: () => {
                    this.upload_animation=true;
                },
                onSuccess: () => {
                    this.upload_animation=false;
                    this.add_videos = false;
                    this.add_videos_values.reset();
                },
            });}
        },
        //edite
        edite_videos_function(id,name,disc,public_state,video_path,img_path){
            this.edite_videos?
                this.edite_videos=false:
                [
                    this.edite_videos=true,
                    this.edite_videos_values.id = id,
                    this.edite_videos_values.name =name,
                    this.edite_videos_values.discription =disc,
                    this.edite_videos_values.public_states =public_state,
                    this.edite_videos_values.TEMPvideo_path =video_path,
                    this.edite_videos_values.TEMPimg_path = img_path,
                ];
        },
        edite_videos_db(){
            if(this.fileSizeError){
            this.edite_videos_values.post(`my_videos_AUTH/${this.edite_videos_values.id}/edit`, {
                onProgress: () => {
                    this.upload_animation=true;
                    this.uploadProgress = Math.round((progressEvent.loaded / progressEvent.total) * 100);
                },
                onSuccess: () => {
                    this.upload_animation=false;
                    this.edite_videos = false;
                    this.edite_videos_values.reset();
                },
            });}
        },

        handleFileChange(event) {
            const file = event.target.files[0];
            const maxSize = 100 * 1024 * 1024; // 5 MB (in bytes)

            if (file && file.size > maxSize) {
                this.fileSizeError = false;
            } else {
                this.fileSizeError = true;
            }
        },
    },
}
</script>
