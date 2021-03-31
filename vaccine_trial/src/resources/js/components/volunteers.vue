<template>
    <div class="container">
        <div class="card" v-if="$gate.isVaccineMaker()">
            <div class="card-header">Volunteers <br>
               <div class="float-right">
                    <i class="fas fa-filter   purple "></i> 
                    <a href="" @click.prevent="getAllVolunteers" class="btn btn-info btn-sm mt-2 mx-2">
                         {{!loading && volunteers.length > 0 ? volunteers.length : ''}} All cases</a>
                    <a href="" @click.prevent="getVolunteersWithTest('positive')" class="btn btn-danger btn-sm mt-2 mx-2 " :class="{'disabled' : loading}">
                        {{!loading && positiveVolunteers.length > 0 ? positiveVolunteers.length : ''}} Positive cases</a>
                    <a href="" @click.prevent="getVolunteersWithTest('negative')" class="btn btn-success btn-sm mt-2 mx-2 " :class="{'disabled' : loading}">
                         {{!loading && negativeVolunteers.length > 0 ? negativeVolunteers.length : ''}} Negative cases</a>
               </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped selectable table-hover">
                    <thead>
                        <th>#</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Adress</th>
                        <th>Health condation</th>
                        <th>Vaccine</th>
                        <th>Dosage</th>
                        <th>Test</th>
                    </thead>
                    <tbody>
                        <tr v-for="(volunteer, index) in getVolunteers" :key="index">
                            <td>{{index + 1}}</td>
                            <td>{{volunteer.name}}</td>
                            <td>{{volunteer.age}}</td>
                            <td>{{volunteer.gender}}</td>
                            <td>{{volunteer.address}}</td>
                            <td>{{volunteer.health_condition}}</td>
                            <td>
                                <a v-if="volunteer.vaccine === 'A'" href="#" class="badge badge-info p-2">{{volunteer.vaccine}}</a>
                                <a v-else href="#" class="badge badge-primary p-2">{{volunteer.vaccine}}</a>
                            </td>
                            <td>
                                <a v-if="volunteer.dose === 1" href="#" class="badge badge-info p-2">{{volunteer.dose}}</a>
                                <a v-else href="#" class="badge badge-primary p-2">{{volunteer.dose}}</a>
                            </td>

                            <td>
                                <a v-if="volunteer.test" href="#" class="badge badge-danger">Positive</a>
                                <a v-else href="#" class="badge badge-success">Negative</a>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <th>#</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Adress</th>
                        <th>Health condation</th>
                        <th>Vaccine</th>
                        <th>Dosage</th>
                        <th>Test</th>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {

    data() {
        return {
            loading: true,
            volunteers: [],
            positiveVolunteers : [],
            negativeVolunteers : [],
            isPositive : false,
            isNegative : false,
        }
    },
    computed: {
        getVolunteers(){
           if(this.isPositive){
               return this.positiveVolunteers;
           } else if(this.isNegative){
               return this.negativeVolunteers
           }else{
               return this.volunteers
           }
        }
    },
    created(){
      if(this.$gate.isVaccineMaker()){
          this.getAllVolunteers()
          }else{
             
            this.$router.push('/test')
          }
    },
    methods: {
        getAllVolunteers(){
            this.$Progress.start()
            this.loading = true;
            this.isPositive = false
            this.isNegative = false
            axios.get('api/volunteers').then((response)=> {
                this.volunteers = response.data.data
                this.loading = false;
                this.$Progress.finish()
                console.log(response.data.data)
            }).catch((error) => {
                console.log(error.message)
                this.$Progress.fail()
            })
        },

        getVolunteersWithTest (type){
            if(type === 'positive'){
                this.isPositive = true
                this.isNegative = false
                this.positiveVolunteers = this.volunteers.filter((volunteer) => volunteer.test)
            }else{
                this.isPositive = false
                this.isNegative = true
                this.negativeVolunteers = this.volunteers.filter((volunteer) => !volunteer.test)
            }
        }
    },
}
</script>