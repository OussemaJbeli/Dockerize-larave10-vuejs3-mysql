<!-- ////////////////// temlate///////////// -->
<template>
    <GuestLayout>
        <Head title="Log in" />
        <div class="big_frame">
            <div class="first_part">
                <div class="img">
                    <img src="/img/support3.png" alt="">
                </div>
                <p>كيف يمكننا مساعدتك ؟</p>
            </div>
            <div class="second_part">
                <form @submit.prevent="add_coments_db">
                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="8" placeholder="صف مشكلتك ..." v-model="add_coment_values.the_coment" required :error="add_coment_values.errors.the_coment"></textarea>
                    <button type="submit" class="btn btn-warning mt-3">إرسال</button>
                </form>
            </div>
        </div>
    </GuestLayout>
</template>
<script setup>
import GuestLayout from '@/Layouts/gestLayoutuser.vue';
import { Head, Link} from '@inertiajs/vue3';
</script>

<script>
export default {
    components: {
        Head,
        Link,
    },
    props: {

    },

    data() {
        return {
            add_coment_values: this.$inertia.form({
                the_coment: null,
            }),
        }
    },
    methods: {
        add_coments_db(){
            this.add_coment_values.get(`Coments_AUTH/create`, {
                onSuccess: () => {
                    this.add_coment_values.reset();
                },
            });
        },
    },
}
</script>
