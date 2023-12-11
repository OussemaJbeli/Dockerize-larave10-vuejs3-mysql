<!-- ////////////////// temlate///////////// -->
<template>
    <ChanelLayout>
        <div class="apropo_chaine">
            <div class="apropo_chaine">
                <div class="big pl-2">
                    <div class="header_new_videos">
                        <h4>تفاصيل القنات</h4>
                    </div>
                    <span>اسم صاحب القنات</span>
                    <p>{{chanel.user_name}}</p>
                    <span>اسم القنات</span>
                    <p>{{chanel.name_chanel}}</p>
                    <span>الوصف</span>
                    <p class="discription">{{chanel.discription_chanel}}</p>
                </div>
                <div class="small">
                    <div class="header_new_videos">
                        <h4>معلومات حول القنات</h4>
                    </div>
                    <p>تاريخ الانشاء {{ date_created }}</p>
                    <p>عدد المشتركين {{ subscribesNum }}</p>
                    <p>عدد المشاهدات {{ vuewsNum }}</p>
                    <p>عدد الفيديوهات {{ chanel.count_subscribe }}</p>
                </div>
            </div>
        </div>
    </ChanelLayout>
</template>
<script setup>
import ChanelLayout from '@/Pages/auth_pages/my_chanel_gest/index.vue';
import { Head, Link} from '@inertiajs/vue3';
</script>

<script>
export default {
    components: {
        Head,
        Link,
    },
    props: {
        videosNum: Object,
        subscribesNum: Object,
        vuewsNum: Object,
        date_created:Object,
        chanel: Object,
    },

    data() {
        return {

        }
    },
    methods: {

    }

}
</script>
