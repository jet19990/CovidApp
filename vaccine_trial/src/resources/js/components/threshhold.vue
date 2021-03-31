<template>
    <form action="" method="post">
        <div class="modal-body">
           <div class="form-group">
             <label for="threshhold">What is the new threshhold ?</label>
             <input type="number"
               v-model="form.threshhold"
               :class="{
                              'is-invalid': form.errors.has('threshhold'),
                            }"
               class="form-control" name="threshhold" id="threshhold" aria-describedby="helpId" placeholder="">
           <span
                class="invalid-feedback col-md-9 offset-3"
                v-if="form.errors.has('threshhold')"
                v-text="form.errors.first('threshhold')"
              ></span>
           </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          <button type="button" @click="updateThresh" class="btn btn-primary">Update</button>
        </div>
    </form>
</template>

<script>
import Form from "@imritesh/form";
export default {
  data() {
    return {
      form: new Form({
        threshhold: ''
      })
    }
  },

  methods: {
   updateThresh(){
      this.form.post('/api/update/threshold').then((response) => {
      if(response.status){
        window.location.reload()
      }
    })
   }
  },
}
</script>