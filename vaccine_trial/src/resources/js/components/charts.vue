<template>
  <div class="container">
    <div v-if="$gate.isVaccineMaker()">
     <div class="row mt-2">
      <div class="col-md-12 px-5 py-2">
          <h4 class="header-text blue">
             <span><i class="fas fa-th-list    "></i></span>
             Vaccine Administaration Visualizations Reports
          </h4>
      </div>
    <div class="col-md-6  mb-2 col-lg-4">
      <div class="chart-container">
           <bar-chart
            v-if="loaded"
            :chartdata="chartdata"
            yLabelString="No. of people"
            title="A Bar Graph showing the gender distribution in the total volunteers"
            />
      </div>
       
    </div>
     <div class="col-md-6  mb-2 col-lg-4">
       <div class="chart-container">
            <bar-chart
            v-if="loaded"
            :chartdata="chartdata2"
            yLabelString="Total vaccine administration (Both dosage)"
            title="Total Administarations per each vaccine"
            />
       </div>
    </div>
     <div class="col-md-6  mb-2 col-lg-4">
     <div class="chart-container">
        <pie-chart
      v-if="loaded"
      :chartdata="piechartdata"
      title="Total dose adminisration per vaccine"
      />
     </div>
    </div>

     <div class="col-md-12 px-5 py-2 mt-5">
          <h4 v-if="showresult" class="header-text green">
             <span><i class="fas fa-clipboard-list    "></i></span>
             Vaccine Test Results Visualizations Reports
          </h4>
           <h4 v-else class="header-text text-danger">
             <span><i class="fas fa-clipboard-list    "></i></span>
             Vaccine Test Results Visualizations Reports will be displayed here after the threshold is met.
          </h4>
      </div>
     <div v-if="showresult" class="col-md-6  mb-2 col-lg-4">
      <div class="chart-container">
           <bar-chart
            v-if="loaded"
            :chartdata="genderTestResultsData"
            yLabelString="No. of test results per gender"
            title="Total positive and negative cases recorded in each gender"
            />
      </div>
       
    </div>

    <div v-if="showresult" class="col-md-6  mb-2 col-lg-4">
      <div class="chart-container">
           <pie-chart
            v-if="loaded"
            :chartdata="positiveCasesData"
            title="Total positive cases per dose in each vaccine"
            />
      </div>
       
    </div>

    <!-- <div class="col-md-6  mb-2 col-lg-4">
      <div class="chart-container">
           <bar-chart
            v-if="loaded"
            :chartdata="chartdata"
            yLabelString="No. of people"
            />
      </div>
       
    </div>
 -->
    <div v-if="showresult" class="col-md-12">
      <div class="chart-container">
        <line-chart
          v-if="loaded"
          :chartdata ="lineChartData"
         />
      </div>
    </div>

  </div>
  </div>
  </div>
</template>

<script>
  import BarChart from './charts/BarChart.js'
  import PieChart from './charts/PieChart.js'
  import LineChart from './charts/LineChart.js'

  export default {
    components: {
      BarChart,
      PieChart,
      LineChart
    },
    data () {
      return {
        showresult: false,
        loaded: false,
        chartdata: null,
        chartdata2: null,
        piechartdata: null,
        genderTestResultsData: null,
        positiveCasesData: null,
        lineChartData: null,
        
        colors: ['#2980b9','#9b59b6','#27ae60', '#2c3e50','#f39c12', '#e74c3c', '#7f8c8d',
        '#2980b9','#9b59b6','#27ae60', '#2c3e50','#f39c12', '#e74c3c', '#7f8c8d']
      }
    },
    
  async mounted () {
    this.loaded = false
    this.getThreshHold()
   if(this.$gate.isVaccineMaker()){
      try {
      await this.fillVolunteersData()
      await this.fillVaccinationData()
      await this.fillVaccinesData()
      await this.fillGenderTestResults()
      await this.fillPositiveCasesData()
      await this.fillLineChartData()
      this.loaded = true
    } catch (e) {
      console.error(e)
    }
   }else {
      this.$router.push('/test')
   }
  },

  methods: {
    getRandomColorIndex () {
          return Math.floor(Math.random() * (this.colors.length + 1))
    },

    async fillVolunteersData() {
    const userlist  = await axios.get('/api/userlist')
    this.chartdata = {
      labels: ['Female', 'Male', 'Others'],
      datasets:[{
        label: 'Volunteers gender distribution',
         data :userlist.data.map((gender) => {
                  return gender.total
              }),
          borderWidth: 1,
          pointBorderColor: '#2554FF',
          borderColor: [
              'rgba(255, 206, 86, 1)',
              'rgba(75, 192, 192, 1)',
               'rgba(255,99,132,1)',
                          
              ],
          backgroundColor: [
              'rgba(255, 206, 86, 0.2)',
              'rgba(75, 192, 192, 0.2)',   
              'rgba(255,99,132,0.2)',             
              ],
            }
          ]
        }
    },

    async fillVaccinationData() {
    const vaccinations  = await axios.get('/api/vaccine/taken')
    this.chartdata2 = {
      labels: ['A', 'B'],
      datasets:[
       {
          label: 'Vaccines Administaration data',
          data: vaccinations.data.map((vaccine) => {
            return vaccine.total
          }),
          borderWidth: 1,
          pointBorderColor: '#2554FF',
          borderColor: [
              'rgba(255,99,132,1)',
              'rgba(54, 162, 235, 1)',
              'rgba(255, 206, 86, 1)',
              'rgba(75, 192, 192, 1)'            
              ],
          backgroundColor: [
              'rgba(255, 99, 132, 0.2)',
              'rgba(54, 162, 235, 0.2)',
              'rgba(255, 206, 86, 0.2)',
              'rgba(75, 192, 192, 0.2)',                
              ],
        }
      ]
              }
  },

  async fillVaccinesData() {

   const doses = await axios.get('/api/vaccine/dose/taken')
     this.piechartdata = {
       labels: doses.data.map((dose) => {
         return `${dose.dose} vaccine ${dose.vaccine}`
       }),
          datasets: [{
              label: "Total dosage administration",
              borderWidth: 1,
              borderColor: [
              'rgba(255,99,132,1)',
              'rgba(54, 162, 235, 1)',
              'rgba(255, 206, 86, 1)',
              'rgba(75, 192, 192, 1)'            
              ],
              backgroundColor: [
              'rgba(255, 99, 132, 0.2)',
              'rgba(54, 162, 235, 0.2)',
              'rgba(255, 206, 86, 0.2)',
              'rgba(75, 192, 192, 0.2)',                
              ],
              data: doses.data.map(dose => dose.total)
            }]
     }
  },

  async fillGenderTestResults() {
    const response = await axios.get('/api/vaccine/reported/result')

    const data1  = response.data.filter(test => !test.test)
    const data2  = response.data.filter(test => test.test)

    this.genderTestResultsData = {
       labels: this.getUniqueElements(response.data),
       datasets: [
         {
           label: 'Negative',
           borderWidth: 1,
           data: data1.map(test =>  test.total),
            borderColor: 'rgba(106, 255, 86, 1)',      
          backgroundColor: 'rgba(106, 255, 86, 0.2)',            
         },
          {
          label: 'Positive',
          borderWidth: 1,
           data: data2.map((test) =>test.total),
          borderColor: 'rgba(255,99,132,1)',
          backgroundColor: 'rgba(255,99,132,0.2)',              
         }
       ]
    }

  },

  async fillPositiveCasesData() {

   const doses = await axios.get('/api/vaccine/positivecases')
     this.positiveCasesData = {
       labels: doses.data.map((dose) => {
         return `${dose.dose} vaccine ${dose.vaccine}`
       }),
          datasets: [{
              label: "Total positive cases per vaccine dosage",
              borderWidth: 1,
              borderColor: [
              'rgba(255,99,132,1)',
              'rgba(54, 162, 235, 1)',
              'rgba(255, 206, 86, 1)',
              'rgba(75, 192, 192, 1)'            
              ],
              backgroundColor: [
              'rgba(255, 99, 132, 0.2)',
              'rgba(54, 162, 235, 0.2)',
              'rgba(255, 206, 86, 0.2)',
              'rgba(75, 192, 192, 0.2)',                
              ],
              data: doses.data.map(dose => dose.total)
            }]
     }
  },

  async fillLineChartData() {

   const response = await axios.get('/api/vaccine/agepositivecases')

    this.lineChartData = {
      labels: Object.keys(response.data),
          datasets: [
            {
              label: 'Line Chart',
              data: Object.values(response.data),
              fill: false,
              borderColor: '#2554FF',
              backgroundColor: '#2554FF',
              borderWidth: 1
            }
          ]
    }
  },

  getUniqueElements(array){
    var flags = [], output = [], l = array.length, i;
    for( i=0; i<l; i++) {
        if( flags[array[i].gender]) continue;
        flags[array[i].gender] = true;
        output.push(array[i].gender);
    }
   
    return output;
  },

  getThreshHold() {
    axios.get('api/get/threshold').then(response => {
       this.showresult = response.data.positive_cases >= response.data.thresh_hold
    })
  }

  }
}
</script>

<style scoped>
.chart-container{
  padding: 10px;
  border: 1px solid #d1d1d1;
  border-radius: 8px;
  height: 430px;
}
</style>