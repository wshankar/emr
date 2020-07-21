<template>
          <table class="table">
                    <thead>
                    <tr>
                      <td>Patient</td>
                      <td>Time</td>
                      <td> 
                          <span class="badge badge-danger">{{booked_patients.length}}</span></td>
                    </tr>
                    </thead>
           
              <tbody>
                  <tr v-for="(item,index) in booked_patients" :key="item.book_id">
                      <td>{{item.patientName}}</td>
                      <td>{{item.created_at | myDate}}</td>
                      <td>
                        <a href="#" @click="startConsult(item.id,index)">
                        <i class="fa fa-person-booth fa-lg text-primary"></i>
                        </a>
                      </td>
                  </tr>
              </tbody>
          </table>


</template>

<script>
export default {
    data(){
        return{
            booked_patients:[]
        }
    },
    methods:{
        bookedPatients(){
            axios.post('/api/bookedpatient')
            .then(res => {
                this.booked_patients = res.data.data
            })
        },
        startConsult(id,index){
            axios.delete('/api/booking/'+id)
            .then(res => {
                this.booked_patients.splice(index,1)
                Fire.$emit('ConsultationStart')
                this.booked = false
                toast.fire({
                    icon: 'success',
                    title: 'Consultation Started'
                })
            })
        },
    },
    created(){
        this.bookedPatients()

        Echo.channel('BookingChannel')
          .listen('BookingEvent', (e) => {
            this.booked_patients.push(e)
    });
    }
}
</script>

<style>

</style>