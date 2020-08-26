<template>
    <div class="container-fluid row pr-0">
        <div class="col-md-10 px-0">
            <!-- SEARCH FORM -->
        <form @submit.prevent="editmode ? updatePatient(): addPatient()">
           <div class="row">
                <div class="form-group col-md-3 pr-0">
                    <input v-model="form.name" @keyup="searchit" type="text" name="name" placeholder="Patient Name"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                    <has-error :form="form" field="name"></has-error>
                </div>
                <div class="form-group col-md-1 pr-0">
                    <input v-model="form.age" type="text" name="age" placeholder="Age"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('age') }">
                    <has-error :form="form" field="age"></has-error>
                    </div>
                <div class="form-group col-md-1 pr-0">
                    <input v-model="form.gender" type="text" name="gender" placeholder="M / F"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('gender') }">
                    <has-error :form="form" field="gender"></has-error>
                    </div>
                <div class="form-group col-md-3 pr-0">
                    <input v-model="form.address" type="text" name="address" placeholder="Address"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('address') }">
                    <has-error :form="form" field="address"></has-error>
                </div>
                <div class="form-group col-md-3">
                    <input v-model="form.phone" type="text" name="phone" placeholder="Phone"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('phone') }">
                    <has-error :form="form" field="phone"></has-error>
                </div>
                <div class="form-group">
                    <button v-show="!editmode" type="submit" class="btn btn-primary"><i class="fa fa-user-plus"></i></button>
                    <button v-show="editmode" type="submit" class="btn btn-success"><i class="fa fa-user-edit"></i></button>
                    <a href="#" @click="newModal" v-show="editmode" class="btn btn-secondary"><i class="fa fa-window-close"></i></a>
                </div>
            </div>
        </form>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Patient Records</h3>

                <div class="card-tools">
                    <datepicker  type="text" typeable="true" v-model="searchByFollowUp" @input="searchFollowUp" name="follow_up" placeholder="Search By Follow Up"
                    >
                    </datepicker>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Age</th>
                      <th>Gender</th>
                      <th>Follow Up</th>
                      <th>Address</th>
                      <th>Phone Number</th>
                      <!-- <th>Registered</th> -->
                      <th>Booking</th>
                      <th v-if="$gate.isDoctor()">Modify</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="patient in patients.data" :key="patient.id">
                      <td>{{ patient.id }}</td>
                      <td>
                          <router-link :to="patient.path">{{ patient.name }}</router-link>
                      </td>
                      <td>{{ patient.age }}</td>
                      <td>{{ patient.gender }}</td>
                      <td>{{ patient.followUp | myDate }}</td>
                      <td>{{ patient.address }}</td>
                      <td>{{ patient.phone }}</td>
                      <!-- <td>{{ patient.created_at | myDate }}</td> -->
                      <td>
                        <a href="#" @click="addBook(patient.id)" v-if="!patient.booked">
                        <i class="fa fa-book-medical fa-lg text-success"></i></a>
                        <p v-else>Booked</p>
                      </td>
                      <td v-if="$gate.isDoctor()">
                          <a href="#"  @click="editModal(patient)">
                              <i class="fa fa-edit fa-lg"></i>
                          </a>
                          <a href="#" class="iconspace" @click="deletePatient(patient.id)">
                              <i class="fa fa-trash fa-lg red"></i>
                          </a>
                      </td>
    </tr>
                    
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                  <pagination :data="patients" @pagination-change-page="getResults">
                    <span slot="prev-nav"><i class="fas fa-backward"></i></span>
                    <span slot="next-nav"><i class="fas fa-forward"></i></span>
                 </pagination>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>

            <!-- Modal -->
    <!-- <div class="modal fade" id="newPatient" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 v-show="!editmode" class="modal-title" id="exampleModalLabel">New Patient</h5>
            <h5 v-show="editmode" class="modal-title" id="exampleModalLabel">Update Patient Info</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form @submit.prevent="editmode ? updatePatient(): addPatient()">
            <div class="modal-body">
            <div class="form-group">
            <input v-model="form.name" type="text" name="name" placeholder="Patient Name"
                class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                <has-error :form="form" field="name"></has-error>
                </div>
            <div class="form-group">
                <input v-model="form.age" type="text" name="age" placeholder="Age"
                class="form-control" :class="{ 'is-invalid': form.errors.has('age') }">
                <has-error :form="form" field="age"></has-error>
                </div>
            <div class="form-group">
                <input v-model="form.gender" type="text" name="gender" placeholder="Gender"
                class="form-control" :class="{ 'is-invalid': form.errors.has('gender') }">
                <has-error :form="form" field="gender"></has-error>
                </div>
            <div class="form-group">
                <input v-model="form.address" type="text" name="address" placeholder="Address"
                class="form-control" :class="{ 'is-invalid': form.errors.has('address') }">
                <has-error :form="form" field="address"></has-error>
            </div>
            <div class="form-group">
                <input v-model="form.phone" type="text" name="phone" placeholder="Phone"
                class="form-control" :class="{ 'is-invalid': form.errors.has('phone') }">
                <has-error :form="form" field="phone"></has-error>
            </div>
            <div class="form-group">
                <input v-model="form.fatherName" type="text" name="fatherName" placeholder="Father Name"
                class="form-control" :class="{ 'is-invalid': form.errors.has('fatherName') }">
                <has-error :form="form" field="fatherName"></has-error>
            </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button v-show="!editmode" type="submit" class="btn btn-primary">Add Patient</button>
                <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
            </div>
        </form>
        </div>
    </div>
</div> -->
</div>
    <div class="col-md-2 pr-0">
        <booking-list></booking-list>
    </div>
    </div>
</template>


<script>
import Datepicker from 'vuejs-datepicker';
import BookingList from './BookingList'
import Booked from './Booked'
    export default {
        components:{Booked,BookingList,Datepicker},
        data (){
            return {
                searchByFollowUp:'',
                booked:'',
                editmode: '',
                patients:{},
                form: new Form({
                    id: '',
                    name: '',
                    age: '',
                    gender: '',
                    address: '',
                    phone:''
                })
            }
        },
        methods:{
            addBook(id){ 
            axios.post('/api/booking/'+id)
            .then(res => {
                this.booked = true
                toast.fire({
                    icon: 'success',
                    title: 'Booking Added'
                })
            })
            },
            searchFollowUp:_.debounce(function(){
                let query= this.searchByFollowUp;
                axios.post('api/findByFollowUp', {q:query})
                .then((data) => {
                    this.patients = data.data
                })
            },500),
            searchit:_.debounce(function(){
                let query= this.form.name;
                axios.get('api/findPatient?q='+query)
                .then((data) => {
                    this.patients = data.data
                })
            },500),
            getResults(page = 1) {
			axios.get('api/patient?page=' + page)
				.then(response => {
					this.patients = response.data;
				});
		    },
            updatePatient(){
               this.form.put('api/patient/'+this.form.id)
               .then(() => {
                   $('#newPatient').modal('hide')
                   Fire.$emit('RecordChange')
                   this.form.reset()
                   toast.fire({
                        icon: 'success',
                        title: 'Record Updated'
                        })
                   this.editmode = false
               })
               .catch(() => {this.$Progress.fail()})
            },
            editModal(patient){   
                this.editmode = true;            
                $('#newPatient').modal('show')
                this.form.fill(patient)
            },
            newModal(){
                this.editmode = false;
                this.form.reset()
                $('#newPatient').modal('show')
            },
            deletePatient(id){
                swal.fire({
                title: 'Are you sure?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.value) {
                    //Delete Patient
                    this.form.delete('api/patient/'+ id)
                    .then(() => {
                        Fire.$emit('RecordChange')
                        toast.fire({
                        icon: 'success',
                        title: 'Patient Deleted'
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
            loadPatients(){
                axios.get('/api/patient')
                .then(({data}) => (this.patients = data))
                .catch()
            },
            addPatient(){
                this.$Progress.start()
                this.form.post('/api/patient')
                .then((data)=>{             
                    Fire.$emit('RecordChange')
                    // Fire.$emit('NewPatientBooking',data.data.data.id)
                    toast.fire({
                    icon: 'success',
                    title: 'New Patient Added'
                })
                $('#newPatient').modal('hide')
                this.$Progress.finish()
                this.form.reset()
                // this.$router.push({path:`/patient/${data.data.id}`})
                })
                
                .catch()
                
            }
        },
        created(){
            
            this.loadPatients();
            Fire.$on('RecordChange', () => {this.loadPatients()});

            Echo.channel('PatientChannel')
            .listen('PatientEvent', (e) => {
              this.addBook(e.id)
            });
    },
        
         
    }
</script>
