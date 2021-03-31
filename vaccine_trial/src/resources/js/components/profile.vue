<template>
    <div class="container">
        <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Update profile</div>

                <div class="card-body">
                    <form  class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="text-md-right">Full Name</label>

                                <div class="">
                                    <input v-model="form.name" id="name" type="text" 
                                    :class="{
                              'is-invalid': form.errors.has('name'),
                            }"
                                    class="form-control" name="name" required autocomplete="name" autofocus>
                                         <span
                            class="invalid-feedback col-md-9 offset-3"
                            v-if="form.errors.has('name')"
                            v-text="form.errors.first('name')"
                          ></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email" class="text-md-right">E-Mail Address</label>

                                <div class="">
                                    <input v-model="form.email" id="email" type="email" 
                                    :class="{
                              'is-invalid': form.errors.has('email'),
                            }"
                                    class="form-control" name="email" required autocomplete="email">

                                         <span
                            class="invalid-feedback col-md-9 offset-3"
                            v-if="form.errors.has('email')"
                            v-text="form.errors.first('email')"
                          ></span>
                    
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="age" class="text-md-right">Age</label>

                                <div class="">
                                    <input v-model="form.age" id="age" type="integer" 
                                    :class="{
                              'is-invalid': form.errors.has('age'),
                            }"
                                    class="form-control " name="age"  required autocomplete="age">

                                  
                                         <span
                            class="invalid-feedback col-md-9 offset-3"
                            v-if="form.errors.has('age')"
                            v-text="form.errors.first('age')"
                          ></span>
                                   
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="gender" class="text-md-right">Gender</label>

                                <div class="">
                                     <select v-model="form.gender" id="gender" 
                                     :class="{
                              'is-invalid': form.errors.has('gender'),
                            }"
                                     class="form-control " name="gender"  required autocomplete="gender">
                                        <option selected disabled>Select your gender</option>
                                        <option  value="male">Male</option>
                                        <option  value="female">Female</option>
                                        <option  value="other">Other</option>
                                     </select>
                
                                         <span
                            class="invalid-feedback col-md-9 offset-3"
                            v-if="form.errors.has('gender')"
                            v-text="form.errors.first('gender')"
                          ></span>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">

                        <div class="form-group">
                                <label for="address" class="text-md-right">Address</label>

                                <div class="">
                                    <input v-model="form.address" id="address" type="text" 
                                    :class="{
                              'is-invalid': form.errors.has('address'),
                            }"
                                    class="form-control " name="address"  required autocomplete="address">

                            
                                         <span
                            class="invalid-feedback col-md-9 offset-3"
                            v-if="form.errors.has('address')"
                            v-text="form.errors.first('address')"
                          ></span>
                                  
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="health_condition" class="text-md-right">'Health Condition'</label>

                                <div class="">
                                     <select v-model="form.health_condition" 
                                     :class="{
                              'is-invalid': form.errors.has('health_condition'),
                            }"
                                     id="health_condition" class="form-control" name="health_condition"  required autocomplete="health_condition">
                                        <option selected disabled>Select your health condition</option>
                                        <option  value="healthy">Healthy</option>
                                        <option  value="sick">Sick</option>
                                     </select>
                        

                                    
                                        <span
                            class="invalid-feedback col-md-9 offset-3"
                            v-if="form.errors.has('health_condition')"
                            v-text="form.errors.first('health_condition')"
                          ></span>
                                    
                                </div>
                            </div>

                        <div class="form-group">
                            <label for="password" class="text-md-right">New Password(optional)</label>

                            <div class="">
                                <input v-model="form.password" id="password" type="password" 
                                :class="{
                              'is-invalid': form.errors.has('password'),
                            }"
                                class="form-control" name="password" autocomplete="new-password">

                                
                                    <span
                            class="invalid-feedback col-md-9 offset-3"
                            v-if="form.errors.has('password')"
                            v-text="form.errors.first('password')"
                          ></span>
                               
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="text-md-right">Confirm new Password</label>

                            <div class="">
                                <input v-model="form.password_confirmation" id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group mb-0 float-right">
                            <div class="">
                                <button @click.prevent="updateProfile" class="btn btn-primary">
                                    Update
                                </button>
                            </div>
                        </div>
                        
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</template>

<script>
import Form from "@imritesh/form";
export default {
    data() {
        return {
            form: new Form({
                name: '',
                email: '',
                age: '',
                address: '',
                health_condition: '',
                gender: '',
                password: '',
                password_confirmation: ''
            })
        }
    },

    mounted() {
        this.getAuthUser()
    },

    methods: {
        getAuthUser () {
           axios.get('/api/user').then((response) => {
               console.log(response.data)
               this.form.name = response.data.name
               this.form.email = response.data.email
               this.form.age = response.data.age
               this.form.address= response.data.address
               this.form.health_condition = response.data.health_condition
               this.form.gender = response.data.gender
           })
        },

        updateProfile(){
            this.form.post('api/update/profile').then(response => {
                if(response.status){
                    this.getAuthUser()
                     Toast.fire(
                        {
                        icon: 'success',
                        title: 'Profile was updated',
                        }
                    )
                }
            })
        }
    },
}
</script>