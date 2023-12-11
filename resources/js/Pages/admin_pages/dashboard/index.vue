<template>
    <adminLayout>
        <Head title="Admin" />
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight page_title">
                <i class="fa-solid fa-chart-line"></i>
                /لوحة التحكم
            </h2>
        </template>
        <div class="contain_admin">
            <div class="cards_panel">
                <total_cards class="first_card total_card_panel">
                    <div class="logo_card">
                        <p>إجمالي المستخدمين</p>
                        <span class="value">{{countusers}} مستخدم</span>
                    </div>
                    <div class="values_card">
                        <i class="fa-regular fa-user"></i>
                    </div>
                </total_cards>
                <total_cards class="second_card total_card_panel">
                    <div class="logo_card">
                        <p>إجمالي القنوات</p>
                        <span class="value">{{countChanels}} قنات</span>
                    </div>
                    <div class="values_card">
                        <i class="fa-brands fa-youtube"></i>
                    </div>
                </total_cards>
                <total_cards class="theerd_card total_card_panel">
                    <div class="logo_card">
                        <p>إجمالي الفيديوهات</p>
                        <span class="value">{{countvideos}} فيديو</span>
                    </div>
                    <i class="fa-solid fa-video values_card"></i>
                </total_cards>
            </div>
            <div class="charts_frame">
                <!-- chart line for vues in one manth -->
                <div class="first_chart">
                    <ChartComponent_line class='barchart' :chart-data="chartData_line" :chart-options="chartOptions_line"></ChartComponent_line>
                </div>
                <!-- chart circle for users have chanels/don't have -->
                <div class="second_chart">
                    <ChartComponent_donate class="barchart2" :chart-data="chartData_donate" :chart-options="chartOptions_donate"></ChartComponent_donate>
                </div>
            </div>
        </div>
    </adminLayout>
</template>
<script setup>
import adminLayout from '@/Layouts/Admin.vue';
import { Head, Link} from '@inertiajs/vue3';
import total_cards from '@/Components/cards/total_cards.vue';
//chart
import ChartComponent_line from '@/Pages/admin_pages/dashboard/ChartComponent_line.vue';
import ChartComponent_donate from '@/Pages/admin_pages/dashboard/ChartComponent_donate.vue';


</script>

<script>
export default {
    name: 'App',
    components: {
        Head,
        Link,
        ChartComponent_line,
        ChartComponent_donate,
    },
    props: {
        countusers: Object,
        countusers_have_chanel: Object,
        countvideos: Object,
        countChanels: Object,
        dateRange: Object,
        viewsByDay: Object,
        viewsDay: Object,
        usersWithoutChannels: Object,
    },

    data() {
        return {
            chartData_line: {
                labels: this.dateRange,
                datasets: [
                    {
                    label: 'سجل المشاهداة الشهري',
                    data: this.viewsDay,
                    fill: true, 
                    borderColor: 'rgba(75, 192, 192, 1)', 
                    backgroundColor: 'rgba(75, 192, 192, 0.2)', 
                    tension: 0.4,
                    },
                ],
            },
            chartOptions_line: {
                scales: {
                    x: {
                        ticks: {
                        color: 'white', // Change the color of x-axis labels to white
                        },
                    },
                    y: {
                        ticks: {
                        color: 'white', // Change the color of y-axis labels to white
                        },
                    },
                },
                plugins: {
                    legend: {
                        labels: {
                        color: 'white', // Change the color of legend labels to white
                        },
                    },
                },
            },
            chartData_donate: {
                labels: ['المستخدمون', 'المستخدمون اصحاب القنوات',],
                datasets: [
                    {
                    label: 'المستخدمون',
                    data: [this.usersWithoutChannels, this.countusers_have_chanel],
                    },
                ],
            },
            chartOptions_donate: {
                plugins: {
                    legend: {
                        labels: {
                        color: 'white', // Change the color of legend labels to white
                        },
                    },
                },
            },
        };
    },
    methods: {
        
    },
}
</script>