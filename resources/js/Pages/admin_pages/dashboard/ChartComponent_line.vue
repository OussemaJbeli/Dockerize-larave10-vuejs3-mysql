<!-- resources/js/Pages/admin_pages/dashboard/ChartComponent.vue -->

<template>
    <div>
      <canvas ref="myChart"></canvas>
    </div>
  </template>
  
  <script>
  import Chart from 'chart.js/auto';
  
  export default {
    props: ['chartData', 'chartOptions'],
    mounted() {
      this.renderChart();
    },
    methods: {
      renderChart() {
        const ctx = this.$refs.myChart.getContext('2d');
        new Chart(ctx, {
          type: 'line', // You can change the chart type here
          data: this.chartData,
          options: this.chartOptions,
        });
      },
    },
  };
  </script>
  
  <style scoped>
  /* Add any custom styles for your chart component here */
  </style>
  