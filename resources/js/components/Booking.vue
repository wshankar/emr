<template>
    <div class="container-fluid">
            <!-- SEARCH FORM -->
        <form>
           <div class="row">
                <div class="form-group col-md-3">
                    <input v-model="form.name" type="text" name="name" placeholder="Patient Name"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                    <has-error :form="form" field="name"></has-error>
                </div>
                <div class="form-group col-md-1">
                    <input v-model="form.age" type="text" name="age" placeholder="Age"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('age') }">
                    <has-error :form="form" field="age"></has-error>
                    </div>
                <div class="form-group col-md-2">
                    <input v-model="form.gender" type="text" name="gender" placeholder="Gender"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('gender') }">
                    <has-error :form="form" field="gender"></has-error>
                    </div>
                    <div class="form-group col-md-3">
                    <input v-model="form.fatherName" type="text" name="fatherName" placeholder="Father Name"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('fatherName') }">
                    <has-error :form="form" field="fatherName"></has-error>
                </div>
                <div class="form-group col-md-3">
                    <input v-model="form.address" type="text" name="address" placeholder="Address"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('address') }">
                    <has-error :form="form" field="address"></has-error>
                </div>
                <div class="form-group col-md-3">
                    <input v-model="form.phone" type="text" name="phone" placeholder="Phone"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('phone') }">
                    <has-error :form="form" field="phone"></has-error>
                </div>
                <div class="form-group col-md-9">
                    <button  type="submit" class="btn btn-primary btn-block">Add Patient</button>
                    <button  type="submit" class="btn btn-success">Update</button>
                    <a href="#" class="btn btn-primary">Add New</a>
                </div>
            </div>
        </form>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Patient Records</h3>

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
                      <th>Age</th>
                      <th>Gender</th>
                      <th>Father Name</th>
                      <th>Address</th>
                      <th>Phone Number</th>
                      <th>Registered</th>
                      <th >Modify</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td>
                          Name
                      </td>
                      <td>Age</td>
                      <td>Sex</td>
                      <td>Father Name</td>
                      <td>Address</td>
                      <td>Phone Number</td>
                      <td>Date</td>
                      <td>
                          <a href="#">
                              <i class="fa fa-edit fa-lg"></i>
                          </a>
                          <a href="#" class="iconspace">
                              <i class="fa fa-trash fa-lg red"></i>
                          </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                  <pagination>
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
                patients:{},
                form: new Form({
                    id: '',
                    name: '',
                    age: '',
                    gender: '',
                    address: '',
                    phone:'',
                    fatherName:''
                })
            }
        },
        created(){

        }
    }
</script>
