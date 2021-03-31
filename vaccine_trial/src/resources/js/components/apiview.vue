<template>
    <div class="container">
        <div class="row justify-content-center">
            <div v-if="newKey" class="col-md-9">
                <div class="card mt-3">
                    <div class="card-body">
                       <div class="header-top">
                            <i class="fas fa-key  blue icon  "></i>
                          <h4 class="head-text">Request Usage for the Api</h4>
                       </div>
                        <p class="card-txt my-4 text-center">
                            <b>Need to use our API.</b> <br>
                            Click the button below  to send a request to use the api. You will be notified upon
                             the request approval.
                        </p>

                        <div class="header-top">
                            <a href="" @click.prevent="setApiKey" class="btn btn-info">Send Request</a>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="pending" class="col-md-9">
                <div class="card mt-3">
                    <div class="card-body">
                       <div class="header-top">
                            <i class="fas fa-key  blue icon  "></i>
                          <h4 class="head-text">Pending Api Usage Request</h4>
                       </div>
                        <p class="card-txt my-4 text-center">
                           Your request to use the api is pending. <br>
                           Please wait for the approval.
                        </p>
                    </div>
                </div>
            </div>

            <div v-if="key" class="col-md-9">
                <div class="card mt-3">
                    <div class="card-body">
                       <div class="header-top">
                            <i class="fas fa-key  blue icon  "></i>
                          <h4 class="head-text"> Your Secret Key </h4>
                       </div>
                        <p class="card-txt my-4 text-center">
                            {{ key }}
                        </p>

                        <div class="header-top">
                            <a  href="" @click.prevent="resetKey" class="btn btn-info">RESET KEY</a>
                            <a href="https://documenter.getpostman.com/view/6602490/TVsydjc1" target="blank" class="btn btn-primary ml-5">Read docs</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {

    data() {
        return {
            newKey: true,
            pending: false,
            key: false,
        }
    },

    created() {
        this.getApiKey()
    },

    methods: {
        setApiKey(){
            this.$Progress.start()
             axios.post('/api/requesttoken/store').then((response) => {
               if(response.data.id){
                   this.newKey = false;
                   this.pending = true;

                   if(response.data.status){
                       this.pending =  false;
                       this.key = response.data.key
                   }

                Toast.fire({
                           icon: 'success',
                           title: "Request submitted successfully"
                       })
                       
               }else{
                       Toast.fire({
                           icon: 'error',
                           title: 'An error occured'
                       })
                   }
               this.$Progress.finish()
            }).catch((error) => {
                Toast.fire({
                           icon: 'error',
                           title: error.message
                       })

                this.$Progress.fail()
            })
        },
        getApiKey(){
            axios.get('/api/requesttoken/show').then((response) => {
               if(response.data.id){
                   this.newKey = false;
                   this.pending = true;

                   if(response.data.status){
                       this.pending =  false;
                       this.key = response.data.key

                   }
               }
            })
        },

        resetKey() {
            axios.put('/api/requesttoken/reset').then((response) => {
               if(response.data.id){
                   this.newKey = false;
                   this.pending = true;

                   if(response.data.status){
                       this.pending =  false;
                       this.key = response.data.key

                   }
               }
            })
        }
    },
    
}
</script>

<style scoped>
 .header-top {
     text-align: center;
 }
 .icon {
     font-size: 40px;
 }
 .head-text {
     color: #235698;
     margin-top: 10px;
 }

 .card-txt{
     color: #555;
     font-size: 22px;
 }
</style>