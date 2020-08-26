<template>
    <div class="container-fluid">
        <form @submit.prevent="editmode ? updatePharmacy() : addPharmacy()">
           <div class="row">
                <div class="form-group col-md-3">
                    <input v-model="form.name" type="text" name="name" placeholder="Medicine"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                    <has-error :form="form" field="name"></has-error>
                </div>
                <div class="form-group col-md-1">
                    <input v-model="form.price" type="text" name="price" placeholder="Price"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('price') }">
                    <has-error :form="form" field="price"></has-error>
                    </div>
                <div class="form-group col-md-2">
                    <input v-model="form.quantity" type="text" name="quantity" placeholder="Quantity"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('quantity') }">
                    <has-error :form="form" field="quantity"></has-error>
                    </div>
                    <div class="form-group col-md-3">
                    <input v-model="form.expire_date" type="text" name="expire_date" placeholder="Expire Date"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('expire_date') }">
                    <has-error :form="form" field="expire_date"></has-error>
                </div>
                <div class="form-group col-md-9">
                    <button v-show="!editmode" type="submit" class="btn btn-primary">Add Medicine</button>
                    <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                    <a href="#" v-show="editmode" @click="cancel" class="btn btn-primary">Cancel</a>
                </div>
            </div>
        </form>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Pharmacy</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-success">
                        Add New <i class="fas fa-hospital-user"></i>
                    </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Quantity</th>
                      <th>Price</th>
                      <th>Expire Date</th>
                      <th >Modify</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in pharmacy.data" :key="item.id">
                      <td>{{ item.id }}</td>
                      <td>{{ item.name }}</td>
                      <td>{{ item.price }}</td>
                      <td>{{ item.quantity }}</td>
                      <td>{{ item.expire_date }}</td>
                      <td>
                          <a href="#" @click="editForm(item)">
                              <i class="fa fa-edit fa-lg"></i>
                          </a>
                          <a href="#" class="iconspace" @click="deletePharmacy(item.id)">
                              <i class="fa fa-trash fa-lg red"></i>
                          </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                  <pagination :data="pharmacy" @pagination-change-page="getResults">
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
</template>

<script>
    export default {
        data (){
            return {
                editmode: '',
                pharmacy:{},
                form: new Form({
                    id: '',
                    name: '',
                    price: '',
                    quantity: '',
                    expire_date: '',
                })
            }
        },
        methods:{
            deletePharmacy(id){
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
                    this.form.delete('api/pharmacy/'+ id)
                    .then(() => {
                        Fire.$emit('NewMedicine')
                        toast.fire({
                        icon: 'success',
                        title: 'Record Deleted'
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
            cancel(){
                this.editmode= false
                this.form.reset()
            },
            editForm(item){   
                this.editmode = true;            
                this.form.fill(item)
            },
            updatePharmacy(){
               this.form.put('api/pharmacy/'+this.form.id)
               .then(() => {
                   Fire.$emit('NewMedicine')
                   this.form.reset()
                   toast.fire({
                        icon: 'success',
                        title: 'Record Updated'
                        })
                   this.editmode = false
               })
               .catch(() => {this.$Progress.fail()})
            },
            loadPharmacy(){
                axios.get('/api/pharmacy')
                .then(({data}) => {this.pharmacy = data})
            },
            addPharmacy(){
                this.$Progress.start()
                this.form.post('/api/pharmacy')
                .then((data)=>{             
                    Fire.$emit('NewMedicine')
                    // Fire.$emit('NewPatientBooking',data.data.data.id)
                    toast.fire({
                    icon: 'success',
                    title: 'New Medicine Added'
                })
                this.$Progress.finish()
                this.form.reset()
                // this.$router.push({path:`/patient/${data.data.id}`})
                })
                
                .catch()
                
            },
            getResults(page = 1) {
			axios.get('api/pharmacy?page=' + page)
				.then(response => {
					this.pharmacy = response.data;
				});
		    }
        },
        created(){
            this.loadPharmacy()
            Fire.$on('NewMedicine', () => {this.loadPharmacy()});
        }
    }
</script>
