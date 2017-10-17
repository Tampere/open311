<template>
    <div>
        <pie-chart :data="chart" :options="options"></pie-chart>
    </div>
</template>

<script>
import PieChart from './PieChart'
export default {
    props: ['data', 'options'],
    components: {
        PieChart
    },

    data() {
        return {
            values: this.data,
            chart: {
                datasets: [{
                    data: [this.data.pending, this.data.open, this.data.closed],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }],
                labels: [
                    'Pending',
                    'Open',
                    'Closed'
                ]
            }
        }
    }
}
</script>