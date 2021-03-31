<template>
    <div v-if="$gate.isVaccineMaker()" class="container-fluid">
        <div class="card">
            <div class="card-header">Api Key requests</div>
            <div class="card-body table-responsive">
                <table class="table table-striped">
            <thead>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Address</th>
                <th>Status</th>
                <th>Action</th>
            </thead>
            <tbody>
                <tr v-for="(request, index) in requests" :key="index">
                    <td>{{index + 1}}</td>
                    <td>{{request.name}}</td>
                    <td>{{request.email}}</td>
                    <td>{{request.address}}</td>
                    <td>
                        <a href="#" v-if="request.status" class="badge badge-success badge-sm">Active</a>
                         <a href="#" v-else class="badge badge-danger badge-sm">pending</a>
                    </td>
                    <td>
                        <a href="#" v-if="request.status" @click.prevent="closeApiKey(request.id)" class="btn btn-warning">Cancel</a>
                         <a href="#" v-else @click.prevent="aproveApiKey (request.id)" class="btn btn-info">Approve</a>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Address</th>
                <th>Status</th>
                <th>Action</th>
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
            requests: []
        }
    },
    
    methods: {
        getAllApiKeysRequests(){
            this.$Progress.start()
            axios.get('api/apikeys/requests').then((response) => {
                console.log(response.data.data)
                this.requests = response.data.data
                this.$Progress.finish()
            }).catch((error)=> {
                console.log(error.message)
                this.$Progress.fail()
            })
        },

        aproveApiKey (id) {

            Swal.fire({
                title: 'Are you sure?',
                text: "You want to approve this api request!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Aprove it!'
                }).then((result) => {
                if (result.isConfirmed) {

                    this.$Progress.start()
                    axios.post(`/api/apikeys/requests/aprove/${id}`)
                    .then((response) => {
                        if(response.data.status){
                            this.getAllApiKeysRequests()
                            Swal.fire(
                                'Approved!',
                                response.data.message,
                                'success'
                                )
                            this.$Progress.finish()
                        }else{
                            Swal.fire(
                                'Failed!',
                                response.data.message,
                                'error'
                                )
                            this.$Progress.fail()

                        }
                    }).catch((error) => {
                        Swal.fire(
                                'Failed!',
                                error.message,
                                'error'
                                )
                        this.$Progress.fail()

                    })
                    
                }
                })
        },

        closeApiKey (id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, close it!'
                }).then((result) => {
                if (result.isConfirmed) {

                    this.$Progress.start()
                    axios.delete(`/api/apikeys/requests/delete/${id}`)
                    .then((response) => {
                        console.log(response.data)
                        if(response.data.status){
                            this.getAllApiKeysRequests()
                            Swal.fire(
                                'Closed!',
                                response.data.message,
                                'success'
                                )
                            this.$Progress.finish()
                        }else{
                             Swal.fire(
                                'An error occured!',
                                response.data.message,
                                'error'
                                )
                            this.$Progress.fail()

                        }
                    }).catch((error) => {
                        Swal.fire(
                                    'An error occured!',
                                    error.message,
                                    'error'
                                    )
                        this.$Progress.fail()

                    })
                    
                }
                })
            
            
        }
    },

    created() {
        if(!this.$gate.isVaccineMaker()){
            this.$router.push('/test')
        }else{
            this.getAllApiKeysRequests()
        }
    },
}
</script>