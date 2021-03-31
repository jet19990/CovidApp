<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-11 main-container">
        <div v-if="!oldUser" class="card card-steps">
          <div class="card-head">
            <ul class="steps">
              <li>
                <div class="line active-tab"></div>
                <div class="step active-tab">1</div>
              </li>
              <li>
                <div class="line step-1"></div>
                <div class="step step-1">2</div>
              </li>
              <li>
                <div class="line step-2"></div>
                <div class="step step-2">3</div>
              </li>
            </ul>
          </div>

          <div class="card-bod">
            <div class="tab-content" id="myTabContent">
              <div
                class="tab-pane fade show active text-center"
                id="home"
                role="tabpanel"
                aria-labelledby="home-tab"
              >
                <div class="w-100 center-icon mt-2">
                  <div class="circle-img center">
                    <i class="fas fa-thumbs-up header-text blue icon"></i>
                  </div>
                </div>
                <div class="col-md-12 container text-center mt-4">
                  <h4 class="text-center title">Welcome</h4>
                </div>

                <h3 class="text-center white mt-4">
                  Thanks for volunteering for the test. To get started click the
                  button below and scan the QR Code in your nasal spray with
                  your camera.
                </h3>
              </div>
              <div
                class="tab-pane fade"
                id="profile"
                role="tabpanel"
                aria-labelledby="profile-tab"
              >
                <div class="row">
                  <div class="col-md-5 scanner-container">
                    <qrcode-stream
                      @decode="onDecode"
                      class="scanner"
                    ></qrcode-stream>
                  </div>
                  <div class="col-md-6">
                    <h3 class="white">
                      <div class="alert alert-info mb-2 py-2">
                        Incase you are unable to scan, use this form.
                      </div>
                      <form action="">
                        <div class="form-group">
                          <label for="vaccine">Vaccine Type</label>
                          <select
                            name="vaccine"
                            id="vaccine"
                            v-model="form.vaccine"
                            class="form-control"
                            :class="{
                              'is-invalid': form.errors.has('vaccine'),
                            }"
                          >
                            <option selected disabled>
                              Select vaccine type here
                            </option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                          </select>
                          <span
                            class="invalid-feedback col-md-9 offset-3"
                            v-if="form.errors.has('vaccine')"
                            v-text="form.errors.first('vaccine')"
                          ></span>
                        </div>
                        <div class="form-group">
                          <label for="dosage">Dosage</label>
                          <select
                            name="dosage"
                            id="dosage"
                            v-model="form.dose"
                            class="form-control"
                            :class="{ 'is-invalid': form.errors.has('dose') }"
                          >
                            <option selected disabled>
                              Select vaccine type here
                            </option>
                            <option value="1">1</option>
                            <option value="0.5">0.5</option>
                          </select>
                          <span
                            class="invalid-feedback col-md-9 offset-3"
                            v-if="form.errors.has('dose')"
                            v-text="form.errors.first('dose')"
                          ></span>
                        </div>
                      </form>
                    </h3>
                  </div>
                </div>
              </div>
              <div
                class="tab-pane fade"
                id="contact"
                role="tabpanel"
                aria-labelledby="contact-tab"
              >
                <div class="w-100 center-icon">
                  <div class="circle-img center">
                    <i class="fas fa-check text-success"></i>
                  </div>
                </div>
                <h3 class="white text-center">
                  Congraturations <br />
                  Your Vaccine details was recieved. In a few weeks, you will be
                  asked to take a test to see if you are infected. Your are
                  required to inform the vaccine maker if you tested positive, by
                  clicking the "Report Positive" button in the dashboard.
                </h3>
              </div>
            </div>
          </div>
          <div class="btn-container">
            <button
              class="btn btn-info float-right mt-5 btn-continue"
              @click.stop="changeTabs(1)"
            >
              Continue To Scan the QR Code
              <i class="fa fa-arrow-circle-right mr-2" aria-hidden="true"></i>
            </button>
          </div>
        </div>

        <div v-else class="card">
          <div class="card-body">
            <div class="col-md-12 container text-center">
              <i class="fab fa-readme indigo icon"></i>
              <h4 class="text-center title">Testing Report</h4>
            </div>
            <p v-if="!testedPositive" class="card-text white text-center mt-3">
              Congraturations <br />
              <br />
              Your Vaccine details was recieved. In a few weeks, you will be
              asked to take a test to see if you are infected. Your are required
              inform the vaccine maker if you tested positive, by clicking a
              "Report Positive" button below.
            </p>

            <p v-else class="white text-center">
              Congraturations <br />

              Thanks for taking part in the test. Your final result was
              received. We will notify you upon the final vaccine test results.
            </p>

            <div v-if="!testedPositive" class="col-md-12 text-center">
              <a
                href=""
                @click.prevent="reportPositive"
                class="btn-success btn mt-3"
                >Report Positive</a
              >
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { QrcodeStream, QrcodeDropZone, QrcodeCapture } from "vue-qrcode-reader";
import Form from "@imritesh/form";

export default {
  data() {
    return {
      tabIndex: 0,
      oldUser: false,
      testedPositive: false,
      form: new Form({
        vaccine: "",
        dose: "",
      }),
    };
  },
  components: {
    QrcodeStream,
    QrcodeDropZone,
    QrcodeCapture,
  },
  methods: {
    async postForm() {
      return this.form
        .post("api/submit/vaccination")
        .then((response) => {
          console.log(response.data);
          this.hasUserAddedTheVaccine()
          return true;
    
        })
        .catch((error) => {
          console.log(error.message);
          Toast.fire(
            {
              icon: 'error',
              title: error.message,
            }
          )
          return false;
        });
    },

    onDecode(decodeString) {
      this.play()
      try {
        const jsonData = JSON.parse(decodeString);
        console.log(jsonData);
        if (jsonData.vaccine) {
          axios
            .post("api/submit/vaccination", jsonData)
            .then((response) => {
              if (response.data.status) {
                this.hasUserAddedTheVaccine();
              }
              Toast.fire({
                icon: 'success',
                title: 'Vaccine deatails submitted'
              })
            })
            .catch((error) => {
             Toast.fire({
                icon: 'error',
                title: error.message
              })
            });
        }
      } catch (error) {
        Toast.fire({
                icon: 'error',
                title: error.message
              })
      }
    },

    setBtn(btn){
        // Set btn text dynamicaly
        if (this.tabIndex === 0) {
            btn.innerText = "Submit form and continue";
        } else if (this.tabIndex === 1) {
            btn.innerText = "Continue to Dashboard";
        } else {
            btn.innerText = "Continue To Scan the QR Code";
        }
      
    },

    async changeTabs(index) {
      var tabs = document.querySelectorAll(".tab-pane");
      var btn = document.querySelector(".btn-continue");

      if (this.tabIndex === tabs.length - 2) {
          this.hasUserAddedTheVaccine();
        }
      
       
      if (this.tabIndex === 1) {
        this.postForm().then((res)=> {
            console.log(res)
            if(res){
            this.changeActiveTab(tabs)
            this.setBtn(btn);
            this.tabIndex ++;
            }
           
        });
      }
       else {
        this.changeActiveTab(tabs)
        this.setBtn(btn)
        this.tabIndex += 1;
      }

    },

    changeActiveTab(tabs){
         // Remove active classes

         tabs.forEach((element) => {
            element.classList.remove("show", "active");
        });
        
        //   Change active tab
        tabs[this.tabIndex + 1].classList.add("show", "active");
        var tabClass = `.step-${this.tabIndex + 1}`;
        var activeTab = document.querySelectorAll(tabClass);

        activeTab.forEach((element) => {
            element.classList.add("active-tab");
        });
    },

    hasUserAddedTheVaccine() {
      axios.get("api/checkuservaccine").then((response) => {
        this.oldUser = response.data.status;
        this.testedPositive = response.data.testedPositive;
        console.log(response.data);
      });
    },

    reportPositive() {
      Swal.fire({
      title: 'Are you sure you are positive?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, confirm positive!'
    }).then((result) => {
      if (result.isConfirmed) {
        this.$Progress.start()
        axios
            .post("api/reportpositive")
            .then((response) => {
              console.log(response.data);
              this.hasUserAddedTheVaccine();
              this.$Progress.finish()
              Swal.fire(
                'Submited!',
                'Your test result was submited successfully.',
                'success'
              )
            })
            .catch((error) => {
              console.log(error.message)
              this.$Progress.fail()
              Swal.fire(
                'Oops',
                error.message,
                'error'
              )
              });
        
      }
    })
    },

  play() {
    var audio = new Audio('audio/audio.mp3');
    audio.play();
  }
  },

  created() {
    this.hasUserAddedTheVaccine();
  },
};
</script>

<style scoped>
* {
  box-sizing: border-box;
}
.card {
  margin-top: 20px;
}
.card-steps {
  height: 100%;
  position: relative;
}

.card-head {
  background: #f3f3f3;
  padding: 10px 0;
  display: flex;
  align-content: center;
}

.steps {
  width: 100%;
  list-style: none;
  display: flex;
  justify-content: center;
  align-items: center;
}

.active-tab {
  background: #5bc0de !important;
}
.line {
  height: 10px;
  background: #d7d7d8;
  width: 90%;
  border-radius: 3px;
  margin: 0;
}

.steps li {
  width: 32%;
  display: flex;
  align-items: center;
}

li .step {
  height: 40px;
  width: 40px;
  background: #d7d7d8;
  border-radius: 50%;
  text-align: center;
  padding: 7px;
  color: #f3f3f3;
}
.circle-img {
  margin-top: 20px;
  display: flex;
  border: 1px solid #5bc0de;
  border-radius: 50px;
  height: 80px;
  width: 80px;
  justify-content: center;
  align-items: center;
}
.center-icon {
  display: flex;
  justify-content: center;
}
.white {
  width: 80%;
  margin-left: 10%;
  color: #555;
  font-size: 20px;
  font-weight: 100;
  line-height: 140%;
}
.btn-container {
  width: 100%;
  display: flex;
  justify-content: center;
}
.btn-continue {
  padding: 12px 7px;
  background: #5bc0de;
  color: white;
}
.scanner {
  border-radius: 20px;
  margin-left: 10px;
  margin-top: 10px;
}
.tab-pane,
.tab-content {
  height: 100%;
}

.icon {
  font-size: 50px;
}

.title {
  font-size: 28px;
  width: 100%;
  font-weight: 100;
}

.title:after {
  content: "";
  display: block;
  height: 2px;
  width: 100px;
  background: #5bc0de;
  margin: 15px auto;
}

@media only screen and (max-width: 760px) {
  video {
    width: 80% !important;
  }
  .white {
  width: 80%;
  margin-left: 10%;
  color: #555;
  font-size: 16px;
  font-weight: 100;
  line-height: 140%;
}
.title{
  font-size: 20px;
}
}
</style>
