<template>
    <div>
        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
            <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
            </symbol>
        </svg>
        <div v-if="successMessage " class="alert alert-success d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
            <div>
                {{ successMessage }}
            </div>
        </div>
        <div class="min-h-screen bg-gray-100 main_frame">
<!-- ////////////////////////////////////nave barre//////////////////////// -->
            <nav class=" border-b border-gray-100 side_barre"
                :style="{ width: (sid_bar || test_side)? '' : '70px' ,right:sid_bar_second?'0': ''}"
                @mouseover="hover_side_bar" @mouseout="out_side_bar"
                >
                <div class="back_block_transparent"></div>
                    <div class="flex justify-between h-16 nave_liste">
                        <!-- **************nave option*************** -->
                        <div class="flex nave_options">
                            <div class="exite_side_bar" v-if="sid_bar_second">
                                <div class="close_sid_bar" @click="min_sid_bar_second"><i class="fa-solid fa-x"></i></div>
                            </div>
                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex options_nave">
                                <NavLink :href="route('admin_taleb.dashboard')" :active="route().current('admin_taleb.dashboard')" class="NavLink pl-2" v-if="$page.props.auth.user.dashboard_control">
                                    <i class="fa-solid fa-chart-line" :style="{ right: (sid_bar || test_side)? '' : '15px' }"></i>
                                    <span :style="{ visibility: (sid_bar || test_side)? '' : 'hidden' }">لوحة التحكم</span>
                                </NavLink>
                                <NavLink :href="route('admin_taleb.videos')" :active="route().current('admin_taleb.videos')" class="NavLink pl-2" v-if="$page.props.auth.user.videos_control">
                                    <i class="fa-solid fa-video" :style="{ right: (sid_bar || test_side)? '' : '15px' }"></i>
                                    <span :style="{ visibility: (sid_bar || test_side)? 'visible' : 'hidden' }">الفيديوهات </span>
                                </NavLink>
                                <NavLink :href="route('admin_taleb.chanels')" :active="route().current('admin_taleb.chanels')" class="NavLink pl-2" v-if="$page.props.auth.user.chanels_control">
                                    <i class="fa-brands fa-youtube"  :style="{ right: (sid_bar || test_side)? '' : '15px' }"></i>
                                    <span :style="{ visibility: (sid_bar || test_side)? '' : 'hidden' }">القنوات</span>
                                </NavLink>
                                <NavLink :href="route('admin_taleb.comments')" :active="route().current('admin_taleb.comments')" class="NavLink pl-2" v-if="$page.props.auth.user.comments_control">
                                    <i class="fa-solid fa-comment"  :style="{ right: (sid_bar || test_side)? '' : '15px' }"></i>
                                    <span :style="{ visibility: (sid_bar || test_side)? '' : 'hidden' }">التعليقات</span>
                                </NavLink>
                                <NavLink :href="route('admin_taleb.rapports')" :active="route().current('admin_taleb.rapports')" class="NavLink pl-2" v-if="$page.props.auth.user.support_control">
                                    <i class="fa-solid fa-envelope-open-text"  :style="{ right: (sid_bar || test_side)? '' : '15px' }"></i>
                                    <span :style="{ visibility: (sid_bar || test_side)? '' : 'hidden' }">الدعم و الابلاغات</span>
                                </NavLink>
                                <NavLink :href="route('admin_taleb.users')" :active="route().current('admin_taleb.users')" class="NavLink pl-2" v-if="$page.props.auth.user.admin">
                                    <i class="fa-solid fa-user"  :style="{ right: (sid_bar || test_side)? '' : '15px' }"></i>
                                    <span :style="{ visibility: (sid_bar || test_side)? '' : 'hidden' }">المستخدمون</span>
                                </NavLink>
                                <NavLink :href="route('home_AUTH')" :active="route().current('home_AUTH')" class="NavLink pl-2">
                                    <i class="fa-solid fa-arrow-left ml-2" :style="{ right: (sid_bar || test_side)? '' : '15px' }"></i>
                                    <span :style="{ visibility: (sid_bar || test_side)? '' : 'hidden' }">رجوع</span>
                                </NavLink>
                            </div>
                        </div>
                    </div>
            </nav>
<!-- ////////////////////////////////////main_content//////////////////////// -->
            <div class="main_content" :style="{ width: (sid_bar || test_side )? '' : 'calc(100% - 80px)' }">
                <!-- header -->
                <header class=" shadow header">
                    <!-- **************name_page*************** -->
                    <div class="mx-2  title_session">
                        <i class="fa-solid fa-bars" id="sid_show1" @click="min_sid_bar"
                            :style="{transform: (sid_bar || test_side)? '' : 'rotateZ(90deg)' }">
                        </i>
                        <i class="fa-solid fa-bars" id="sid_show2" @click="min_sid_bar_second"
                            :style="{transform: (sid_bar || test_side)? '' : 'rotateZ(90deg)' }">
                        </i>
                        <slot name="header" />
                    </div>
                    <!-- **************profile*************** -->
                    <div class="side_but_secsion hidden sm:flex sm:items-center sm:ml-6">
                        <Link :href="route('home_AUTH')" class="return_to_app">
                            رجوع الى الصفحة الرئيسية<i class="fa-solid fa-arrow-left ml-2"></i>
                        </Link>
                    </div>
                </header>
                <!-- Page Content -->
                <main>
                    <!-- ************************ thems congig *********************** -->
                    <FlashMessages />
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>
<script setup>
import { ref } from 'vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';
import FlashMessages from "@/Components/FlashMessages.vue";

const showingNavigationDropdown = ref(false);
</script>
<script>
import axios from 'axios';
export default {
    components: {
        Link,
        FlashMessages,
    },
    props: {

    },
    data() {
        return {
            search_run: false,
            searchQuery: '',
            sid_bar : true,
            test_side: false,
            openEdite_frame : false,
            sid_bar_second: false,
            openTickets_frame : false,
            add_frame_item: false,
            img1: 'img_1.jpg',
            img2: 'img_2.jpg',
            img3: 'img_3.jpg',
            img4: 'img_4.jpg',
            img5: 'img_5.jpg',
            img6: 'img_6.jpg',
            img7: 'img_7.jpg',
            img8: 'img_8.jpg',
            img9: 'img_9.jpg',
            color1: 'ffc502',
            color2: 'ff5602',
            color3: '8b1bd2',
            color4: '02bf09',
            color5: '02ff1b',
            color6: '02e1ff',
            color7: '020aff',
            region_selectetd: '',

            ticket_form: this.$inertia.form({
                selectedOption: null,
                state: null,
                carrency: null,
                price: null,
                quentity: null,
                item_name: null,
            }),
            id_categorie: null,
            item_form_add: this.$inertia.form({
                categories: null,
                item: null,
            }),
        }
    },
    methods: {
        isRequired(optionValue) {
            return this.requiredValue === optionValue;
        },
        openEdite() {
            this.openEdite_frame ? 
                this.openEdite_frame=false : 
                this.openEdite_frame=true;
        },
        min_sid_bar(){
            if(this.sid_bar){
                this.sid_bar=false 
                this.test_side=false;
            }
            else{
                this.sid_bar=true 
                this.test_side=true;
            }
        },
        min_sid_bar_second(){
            if(this.sid_bar_second){
                this.sid_bar_second=false;
                this.sid_bar = true;
                this.test_side = false;
            }
            else{
                this.sid_bar_second=true;
                this.sid_bar = true;
                this.test_side = false;
            }
        },
        hover_side_bar(){
            this.sid_bar ? 
                this.test_side=true : 
                this.test_side=true;
        },
        out_side_bar(){
            this.sid_bar ? 
                this.test_side=true : 
                this.test_side=false;
        },
        openTickets() {
            this.openTickets_frame?
                this.openTickets_frame=false:
                this.openTickets_frame=true;
        },

        //*********************add items */
        openAdd_item(categorie) {
            if(this.add_frame_item){
                this.add_frame_item = false;
            }
            else{
                this.add_frame_item = true;
                this.item_form_add.categories = categorie;
                this.id_categorie=categorie;
            }
        },
        region_add_item(){
            this.item_form_add.put(`/Icons/create`, {
                preserveScroll: true,
                onSuccess: () => {
                this.add_frame_item = false;
                this.item_form_add.reset();
                },
            });
        },
        start_searsh(){
            this.search_run?
                this.search_run=false:
                this.search_run=true;
        },
    },
    // mounted() {
    //     const color = this.color;
    //     this.updateRootCSSVariable(color);
    // },
}
</script>
