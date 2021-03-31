<template>
    <div v-if="$gate.isVaccineMaker()" class="container">
         <div class="row mt-3">
          <div class="col-lg-3 col-6">
            <!-- small box -->
           
            <div class="small-box bg-info" >
              <div class="inner">
                <h3>{{ volunteers }}</h3>

                <p class="phome">Volunteers</p>
              </div>
              <div class="icon">
                  <i class="fas fa-users    "></i>
              </div>
              <router-link to="/volunteers" href="volunteers" class="small-box-footer">More Info<i class="fas fa-arrow-circle-right mx-2"></i></router-link>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{negativeCases}}<sup style="font-size: 20px"></sup></h3>

                <p class="phome">Negative Cases</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-minus    "></i>
              </div>
              <router-link to="/volunteers" href="volunteers" class="small-box-footer">More Info<i class="fas fa-arrow-circle-right mx-2"></i></router-link>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{positiveCases}}</h3>

                <p class="text-dark">Positive cases</p>
              </div>
              <div class="icon">
                 <i class="fas fa-user-plus    "></i>
              </div>
              <router-link to="/volunteers" href="volunteers" class="small-box-footer">More Info<i class="fas fa-arrow-circle-right mx-2"></i></router-link>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{percentagePositive}} %</h3>

                <p class="phome">Positive result rate</p>
              </div>
              <div class="icon">
                 <i class="fas fa-exclamation-triangle    "></i>
              </div>
              <router-link to="/volunteers" href="volunteers" class="small-box-footer">More Info<i class="fas fa-arrow-circle-right mx-2"></i></router-link>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->

    <div class="row mt-2">
      <div class="col-md-12 px-5 py-2">
          <h4 class="header-text blue">
             <span><i class="fas fa-th-list    "></i></span>
             Vaccine Administration Visualizations Reports
          </h4>
      </div>
    <div class="col-md-6  mb-2 col-lg-4">
      <div class="chart-container">
           <bar-chart
            v-if="loaded"
            :chartdata="chartdata"
            yLabelString="No. of people"
            title="A bar graph showing the gender distribution in the total volunteers"
            />
      </div>
       
    </div>
     <div class="col-md-6  mb-2 col-lg-4">
       <div class="chart-container">
            <bar-chart
            v-if="loaded"
            :chartdata="chartdata2"
            yLabelString="Total vaccine administration (Both dosage)"
            title="Total administrations per each vaccine"
            />
       </div>
    </div>

    <div class="col-md-6  mb-2 col-lg-4">
     <div class="chart-container">
        <pie-chart
      v-if="loaded"
      :chartdata="piechartdata"
      title="Total dose administration per vaccine"
      />
     </div>
    </div>

</div>
    </div>
</template>

<script>
  import BarChart from './charts/BarChart.js'
  import PieChart from './charts/PieChart.js'
 
  export default {
    components: {
      BarChart,
      PieChart,
    },

    data() {
        return {
            volunteers: 0,
            positiveCases: 0,
            negativeCases: 0,
            percentagePositive: 0,
            loaded: false,
            chartdata: null,
            chartdata2: null,
            piechartdata: null,
        }
    },


    async mounted() {
        try{
            this.loaded = false
            await this.fillVolunteersData()
            await this.fillVaccinationData()
            await this.fillVaccinesData()
            this.loaded = true
        }catch(error){
            console.log(error)
        }
    },


    methods: {
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
          label: 'Vaccines Administration data',
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

  getDashData(){
      axios.get('api/dashboardReport').then((response) => {
          console.log(response.data)
          this.volunteers = response.data.volunteers
          this.positiveCases = response.data.positive_cases
          this.negativeCases = response.data.negative_cases
          this.percentagePositive = response.data.percentage_positive.toFixed(2)
      })
  }
    },
    
    created() {
        if(!this.$gate.isVaccineMaker()){
            this.$router.push('/test')
        }else{
            this.getDashData()
        }
    },
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