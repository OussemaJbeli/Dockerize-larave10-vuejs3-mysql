<!-- ////////////////// temlate///////////// -->
<template>
    <AuthenticatedLayout>
        <Head title="Log in" />
        <div class="big_frame">
            <div class="first_part">
                <div class="img">
                    <img src="/img/support3.png" alt="">
                </div>
                <p>كيف يمكننا مساعدتك ؟</p>
            </div>
            <div class="second_part">
                <div class="conversation" v-for="support in supports">
                    <div class="underconverstation" v-if="support.id_user == $page.props.auth.user.id">
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
                <form @submit.prevent="add_coments_db">
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="8" placeholder="صف مشكلتك ..." v-model="add_coment_values.the_message" required :error="add_coment_values.errors.the_message"></textarea>
                    <button type="submit" class="btn btn-warning mt-3">إرسال</button>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
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
    },

    data() {
        return {
            add_coment_values: this.$inertia.form({
                the_message: null,
                the_side: 'user',
            }),
        }
    },
    methods: {
        add_coments_db(){
            this.add_coment_values.get(`support_AUTH/create`, {
                onSuccess: () => {
                    this.add_coment_values.reset();
                },
            });
        },
    },
}
</script>
