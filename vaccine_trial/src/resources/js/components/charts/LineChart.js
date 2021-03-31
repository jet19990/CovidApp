import { Line } from 'vue-chartjs'

export default {
    extends: Line,

    data() {
        return {
            options: {
                title: {
                    display: true,
                    text: 'A line graph displaying how the positive cases were distributed across different age groups'
                },
                scales: {
                  yAxes: [{
                    ticks: {
                      beginAtZero: true
                    },
                    gridLines: {
                      display: true
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Total positive cases recorded in each age group'
                    }
                  }],
                  xAxes: [ {
                    gridLines: {
                      display: false
                    },
                    scaleLabel: {
                        display: true,
                        labelString: 'Volunteers\' age in groups'
                    }
                  }]
                },
                legend: {
                  display: true
                },
                responsive: true,
                maintainAspectRatio: false
              }
        }
    },

    props: {
        chartdata : {
            type: Object,
            default: null
        },
    },

    mounted() {
        this.renderChart(this.chartdata, this.options)
    },
}