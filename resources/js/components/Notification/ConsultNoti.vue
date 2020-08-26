<template>
    <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" role="button">
          New Patient
          <span class="badge badge-danger">{{newPatient}}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <div v-for="(item,index) in patients" :key="item.id" >
          

            <div class="media">
              <div class="media-body">
                <h3 class="dropdown-item-title" @click="deletePatient(index)">       
                <router-link  :to="{name:'PatientShow', params:{slug:item.path}}" class="dropdown-item">
                  {{item.patientName}}
                </router-link> 
                </h3>
                
                
                        
              </div>
            </div>

 
          <div class="dropdown-divider"></div> 
          </div>
        </div> 
          <!-- <div class="dropdown-divider"></div> -->
          <!-- <router-link :to="item.path" class="dropdown-item" v-for="item in read" :key="item.id">
            <div class="media">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  <span class="float-right text-sm text-danger"></span>
                </h3>
                <p class="text-sm">{{item.patientName}}</p>
              </div>
            </div>
          </router-link>  -->
          <!-- <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div> -->
      </li>
</template>

<script>
export default {
    props:['userid'],
    data(){
      return {
         patients:[],
         newPatient: 0
      }
    },
    created(){
    
        //  Echo.channel('BookingChannel')
        //      .notification((notification) => {
        //         this.booking.push(notification)
        //         this.bookCount++
        //         document.getElementById("noti_sound").play()
        //      });
        // Echo.channel('BookingChannel')
        // .notification((notification) => {
        //         // this.booking.push(notification)
        //         this.bookCount++
        //         document.getElementById("noti_sound").play()
     
        //  });

         Echo.channel('ConsultChannel')
          .listen('ConsultEvent', (e) => {
            this.patients.push(e)
            this.newPatient++
            document.getElementById("noti_sound").play()
    });
    },
    methods:{
        deletePatient(index){
            this.patients.splice(index,1)
            this.newPatient--
        }
    }
    
}
</script>