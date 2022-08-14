<template>
	<canvas
		ref="chart"
	/>
</template>

<script>
import Chart from 'chart.js/auto'

export default {
    props: ['type', 'labels', 'datasets'],

    data() {
        return {
            config: {
                type: this.type,
                data: {
                    labels: this.labels,
                    datasets: this.datasets
                },
                options: {
                    spanGaps: true,
                    responsive: true,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        legend: {
                            display: false,
                        },
                        tooltip: {
                            usePointStyle: true,
                            callbacks: {
                                // use arrow function to use prop inside callback
                                label: (context) => {
                                    if (context.dataset.saleData) {
                                        return [
                                            context.formattedValue + ' order(s)',
                                            (context.dataset.saleData[context.dataIndex] / 100).toLocaleString(
                                                'en-US', {style: 'currency', currency: 'USD'}
                                            ),
                                        ]
                                    }

                                    return context.formattedValue + ' user(s)'
                                },
                                labelPointStyle: function() {
                                    return {
                                        pointStyle: 'circle',
                                    }
                                },
                            }
                        }
                    },
                }
            }
        }
    },

    mounted() {
        new Chart(this.$refs.chart, this.config)
    },
}
</script>

<style scoped>

</style>
