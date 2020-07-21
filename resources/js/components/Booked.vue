<template>
    <div>
        <a href="#" @click="addBook(patient.id)" v-if="!booked">
            <i class="fa fa-book-medical fa-lg text-success"></i>
        </a>
        <a href="#" @click="startConsult(patient.id)" v-else>
            <i class="fa fa-person-booth fa-lg text-primary"></i>
        </a>
    </div>
</template>

<script>
export default {
    props:['patient'],
    data(){
        return{
            booked: this.patient.booked,
            bookCount: 0,
            id:''
        }
    },
    methods:{
        Book(){
            this.booked = false ? this.addBook : this.startConsult
        },

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

        startConsult(id){
            axios.delete('/api/booking/'+id)
            .then(res => {
                Fire.$emit('ConsultationStart')
                this.booked = false
                toast.fire({
                    icon: 'success',
                    title: 'Consultation Started'
                })
            })
        },
        listen(){
         if (this.addPatient) {
             this.addBook(this.id)
         }
    },
    created(){
        Echo.channel('PatientChannel')
          .listen('PatientEvent', (e) => {
              this.addBook(e.id)
            });
    },
    
    }}
</script>
