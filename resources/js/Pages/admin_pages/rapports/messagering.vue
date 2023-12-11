<!-- ////////////////// temlate///////////// -->
<template>
    <adminLayout>
        <Head title="Log in" />
        <div class="big_frame flex-row">
            <div class="second_part">
                <!-- <p class="text-white">{{ supports[0].id_user }}</p> -->
                <div class="conversation conversation_respensive" v-for="support in supports">
                    <div class="underconverstation">
                        <div class="message_user" v-if="support.the_side == 'user'">
                            <div class="message">
                                <div class="sender">{{ support.name }}</div>
                                <div class="text">{{ support.the_message }}</div>
                                <div class="timestamp">{{ support.date_count }}</div>
                            </div>
                        </div>
                        <div class="message_admin" v-else>
                            <div class="message">
                                <div class="sender ltr">الدعم</div>
                                <div class="text">{{ support.the_message }}</div>
                                <div class="timestamp">{{ support.date_count }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <form @submit.prevent="add_coments_db" class="form_respensive">
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="8" placeholder="صف مشكلتك ..." v-model="add_coment_values.the_message" required :error="add_coment_values.errors.the_message"></textarea>
                    <button type="submit" class="btn btn-warning mt-3">إرسال</button>
                </form>
            </div>
            <div class="user_info">
                <!-- <p class="text-white">{{ userMessage }}</p> -->
                <div class="user_img">
                    <div v-if="$page.props.auth.chanel[0]">
                        <div v-if="$page.props.auth.chanel[0].id == userMessage.coments_chanels_id">
                            <Link class="user_img" :href="route('my_chanel_AUTH')" v-if="userMessage.coments_chanels_name">
                                <img :src="'/'+userMessage.coments_chanels_logo_path" >
                                <span>{{ userMessage.coments_chanels_name }}</span>
                            </Link>
                        </div>
                        <div v-else>
                            <Link class="user_img" :href="`/chanel_AUTH/${userMessage.coments_chanels_id}`" v-if="userMessage.coments_chanels_name">
                                <img :src="'/'+userMessage.coments_chanels_logo_path" >
                                <span>{{ userMessage.coments_chanels_name }}</span>
                            </Link>
                            <p  @click="dont_have_chanel_function(userMessage.coments_user_name)" class="user_img cursor-pointer" v-else>
                                <img src="/img/chanels/base_logo.png" >
                                <span class="name">{{ userMessage.name }}</span>
                            </p>
                        </div>
                    </div>
                    <div v-else>
                        <Link class="user_img" :href="`/chanel_AUTH/${userMessage.coments_chanels_id}`" v-if="userMessage.coments_chanels_name">
                            <img :src="'/'+userMessage.coments_chanels_logo_path"  >
                            <span>{{ userMessage.coments_chanels_name }}</span>
                        </Link>
                        <p  @click="dont_have_chanel_function(userMessage.coments_user_name)" class="user_img cursor-pointer" v-else>
                            <img src="/img/chanels/base_logo.png" >
                            <span class="name">{{ userMessage.name }}</span>
                        </p>
                    </div>
                </div>
                <div class="email">{{userMessage.email}}</div>
                <div class="channel" v-if="userMessage.coments_chanels_name">{{userMessage.coments_chanels_name}}</div>
                <div class="channel" v-else>هذا المستخدم لا يمتاك قنات</div>
            </div>
        </div>
    </adminLayout>
</template>
<script setup>
import adminLayout from '@/Layouts/Admin.vue';
import { Head, Link} from '@inertiajs/vue3';
</script>

<script>
export default {
    components: {
        Head,
        Link,
    },
    props: {
        supports: Object,
        userMessage: Object,
    },

    data() {
        return {
            add_coment_values: this.$inertia.form({
                the_message: null,
                the_side: 'admin',
            }),
        }
    },
    methods: {
        add_coments_db(){
            this.add_coment_values.get(`/admin_taleb/rapports/${this.supports[0].id_user}/create`, {
                onSuccess: () => {
                    this.add_coment_values.reset();
                },
            });
        },
    },
}
</script>
