<template>
    <div class="container-fluid row">       
      <div :class="$gate.isPharmacy() ? 'col-md-12' : 'col-md-5'">
          <div class="card">
            <div class="card-header" >
                <h3 class="card-title" v-show="$gate.isCounterOrDoctor()">Previous Treatments</h3>
                <table class="table table-bordered col-md-12" v-show="$gate.isPharmacy()">
                    <tr>
                        <td>{{patient.name}}</td>
                        <td>{{patient.age}}</td>
                        <td>{{patient.gender}}</td>
                        <td>{{patient.fatherName}}</td>
                        <td>{{patient.address}}</td>
                        <td>{{patient.phone}}</td>
                        <td><a href="#"><i class="fas fa-user-edit fa-lg"></i></a></td>
                    </tr>
                </table>
                <div class="card-tools" v-show="$gate.isDoctor()">
                    <button class="btn btn-secondary">
                        {{visitCount}} Visits
                    </button>
                </div>
            </div>
            <div id="treatmentBox">
            <div  class="card-body" v-for="treatment in treatments.data" :key="treatment.id">
                <div class="mb-2">
                    {{treatment.created_at | myDate}}
                    <div class="float-right">
                        {{treatment.created_at | myTime}}
                    </div>
                </div>
                {{treatment.prescription}} <br>
                <div class="mt-3">
                    <button class="btn btn-warning">{{treatment.fees}} Kyats</button>
                    <div class="float-right" v-show="$gate.isCounterOrDoctor()">
                        <a href="#" @click="copyTreatment(treatment)"><i class="fas fa-copyright fa-lg green"></i></a>
                        <a href="#" class="iconspace" @click="editTreatment(treatment)"><i class="fas fa-pen-square fa-lg text-primary"></i></a>
                        <a href="#" class="iconspace" @click="deleteTreatment(treatment.id)"><i class="fas fa-trash fa-lg red"></i></a>
                    </div>
                </div>
                 <hr>
            </div>
            </div>
           
        </div>
        <!-- <div class="card-footer">
                  <pagination :data="treatments" @pagination-change-page="getResults">
                    <span slot="prev-nav"><i class="fas fa-backward"></i></span>
                    <span slot="next-nav"><i class="fas fa-forward"></i></span>
                 </pagination>
              </div> -->
      </div>
      <div class="col-md-7" v-if="!$gate.isPharmacy()">
        <div class="card">
            <div class="card-header">
                <table class="table table-bordered">
                    <tr>
                        <td>{{patient.name}}</td>
                        <td>{{patient.age}}</td>
                        <td>{{patient.gender}}</td>
                        <td>{{patient.fatherName}}</td>
                        <td>{{patient.address}}</td>
                        <td>{{patient.phone}}</td>
                        <td><a href="#"><i class="fas fa-user-edit fa-lg"></i></a></td>
                    </tr>
                </table>
            </div>
            <div class="card-body">
                <form @submit.prevent="editmode ? updateTreatment() : addTreatment()">
                    <div class="form-group">
                        <textarea v-model="form.prescription" name="prescription" placeholder="Prescription" class="form-control" :class="{ 'is-invalid': form.errors.has('prescription') }"
                         rows="15"></textarea>
                        <has-error :form="form" field="prescription"></has-error>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-10">
                            <input v-model="form.fees" type="text" name="fees" placeholder="Total Fees"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('fees') }">
                            <has-error :form="form" field="fees"></has-error>
                        </div>
                        <div class="form-group col-md-2">
                            <button v-show="!editmode" type="submit" class="btn btn-success">Add Record</button>
                            <button v-show="editmode" type="submit" class="btn btn-success">Update Record</button>
                            <a v-show="editmode" class="btn btn-success" @click="cancel">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
      </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            editmode: false,
            patient:{},
            treatments:{},
            visitCount: '',
            form: new Form({
                id: '',
                prescription :'',
                fees: ''
            })
        }
    },
    watch:{
        '$route'(to,from) {
        this.loadTreatments()
        this.loadPatient();
        }
    },
    methods:{
        updateTreatment(){          
            this.form.put(`/api/patient/${this.$route.params.slug}/treatment/`+this.form.id)
            .then(()=> {
                Fire.$emit('TreatmentChange')
                this.form.reset()
                 toast.fire({
                    icon: 'success',
                    title: 'Treatment Updated'
                })
                this.editmode= false
            })
        },
        editTreatment(treatment){
            this.editmode = true
            this.form.fill(treatment)
        },
        cancel(){
            this.editmode = false
            this.form.reset()
        },
        copyTreatment(treatment){
            this.form.fill(treatment)
        },
        deleteTreatment(id){
            swal.fire({
                title: 'Are you sure?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.value) {
                    //Delete Treatment
                    this.form.delete(`/api/patient/${this.$route.params.slug}/treatment/`+ id)
                    .then(() => {
                        Fire.$emit('TreatmentChange')
                        toast.fire({
                        icon: 'success',
                        title: 'Treatment Deleted'
                        })})
                    .catch(() => {
                        toast.fire({
                            icon:'warning',
                            title: 'Cannot Delete'
                        })
                    })     
                  }
               })
        },
        getResults(page = 1) {
			axios.get(`/api/patient/${this.$route.params.slug}/treatment?page=` + page, this.patient.id)
				.then(response => {
					this.treatments = response.data;
				});
		},
        loadTreatments(){
            axios.get(`/api/patient/${this.$route.params.slug}/treatment`)
            .then(({data}) => (this.treatments = data))
        },
        addTreatment(){
            this.editmode = false
            this.form.post(`/api/patient/${this.$route.params.slug}/treatment`,this.patient.id)
            .then(() => {
                Fire.$emit('TreatmentChange')
                this.form.reset()
                 toast.fire({
                    icon: 'success',
                    title: 'Treatment Added'
                })
              this.$router.push('/')
            })
        },
       loadPatient(){
           axios.get(`/api/patient/${this.$route.params.slug}`,this.patient.id)
         .then((res) => {
             this.patient = res.data.data
             this.visitCount = this.patient.visitCount
         })
       }
    },
     created(){
         this.loadPatient();
         this.loadTreatments();
         Fire.$on('TreatmentChange', () => {
             this.loadTreatments()
             this.loadPatient();
         })
         
     }
}
</script>