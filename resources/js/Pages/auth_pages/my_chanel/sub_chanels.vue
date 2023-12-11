<!-- ////////////////// temlate///////////// -->
<template>
    <ChanelLayout>
        <Head title="طلاب" />
        <div class="list_chaine" v-if="subscrib_chanel[0]">
            <div class="list_chanel_frame" v-for="subscrib_chanels in subscrib_chanel">
                <Link class="img_panel_video" :href="`chanel_AUTH/${subscrib_chanels.id}}`">
                    <img :src="subscrib_chanels.logo_path_chanel" class="card-img-top" alt="card image">
                </Link>
                <p>{{subscrib_chanels.name_chanel}}</p>
            </div>
        </div> 
        <div class="pont_subscribe" v-else>
            انت لست مشترك في اي قنات
        </div>
    </ChanelLayout>
</template>
<script setup>
import ChanelLayout from '@/Pages/auth_pages/my_chanel/index.vue';
import { Head, Link} from '@inertiajs/vue3';
</script>

<script>
export default {
    components: {
        Head,
        Link,
    },
    props: {
        subscrib_chanel:Object,
    },

    data() {
        return {
            
        }
    },
    methods: {
        
    },
}
</script>
