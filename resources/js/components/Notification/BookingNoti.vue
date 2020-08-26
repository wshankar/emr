<template>
    <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" role="button">
          Booking
          <span class="badge badge-danger">{{bookCount}}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" v-if="bookCount">
          <a href="#" class="dropdown-item" v-for="item in booking" :key="item.id">

            <div class="media">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">{{item.patientName}}</p>
              </div>
            </div>

          </a>  
        </div> 
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" v-else>
          <a href="#" class="dropdown-item" v-for="item in booking" :key="item.id">

            <div class="media">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  No Booking
                </h3>
              </div>
            </div>

          </a>  
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
         booking:[],
         bookCount: 0
      }
    },
    created(){
        this.getBookings()
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
        Fire.$on('ConsultationStart',()=>{
          this.bookCount--
            document.getElementById("noti_sound").play()
          })
         Echo.channel('BookingChannel')
          .listen('BookingEvent', (e) => {
            this.bookCount++
            document.getElementById("noti_sound").play()
    });
    },
    methods:{
      getBookings(){
        axios.post('/api/booking')
        .then(res =>{
          //  this.booking = res.data.unreadBooking

           this.bookCount = res.data
        })
      }
    }
    
}
</script>