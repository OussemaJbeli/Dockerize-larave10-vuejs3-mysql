<template>
  <div>
    <line-chart :data="chartData" :options="chartOptions"></line-chart>
  </div>
</template>

<script>
import { Line, mixins } from 'vue-chartjs';

export default {
  data(){
    return{
      chartData: {
        labels: ['January', 'February', 'March', 'April', 'May'],
        datasets: [
            {
                label: 'Dataset 1',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                data: [10, 20, 15, 25, 30],
            },
            {
                label: 'Dataset 2',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
                data: [5, 10, 8, 15, 20],
            },
            ],
      },
      chartOptions: {
            scales: {
            yAxes: [{
                ticks: {
                beginAtZero: true,
                },
            }],
            },
            legend: {
            display: true,
            position: 'top',
            },
      },
    }
  },
  extends: Line,
  mixins: [mixins.reactiveProp],
  props: {
    chartData: {
      type: Object,
      required: true,
    },
    chartOptions: {
      type: Object,
      required: true,
    },
  },
  mounted() {
    this.renderChart(this.chartData, this.chartOptions);
  },
};
</script>
