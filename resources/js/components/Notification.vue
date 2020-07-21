<template>
    <li class="nav-item dropdown" v-show="!$gate.isDoctor()">
        <a class="nav-link" data-toggle="dropdown" href="#" role="button">
          Notification
          <span class="badge badge-danger">{{unreadCount}}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item" @click="markAllRead">
            <!-- Message Start -->
            <div class="media">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  <span class="float-right text-sm text-success"><i class="fas fa-check"></i></span>
                </h3>
                <p class="text-sm">Mark All As Read</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <router-link :to="{name:'PatientShow', params:{slug:item.path}}" class="dropdown-item" v-for="item in unread" :key="item.id">
            <!-- Message Start -->
            <div class="media">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm" @click="readit(item)">{{item.patientName}}</p>
              </div>
            </div>
            <!-- Message End -->
          </router-link>  
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
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
</template>

<script>
export default {
    props:['userid'],
    data(){
      return {
         read: {},
         unread: {},
         unreadCount: 0,

      }
    },
    created(){
      this.getNotifications()
        Echo.private('App.User.'+ this.userid)
        .notification((notification) => {
                this.unread.push(notification)
                this.unreadCount++
                document.getElementById("noti_sound").play()
     
         });
    },
    methods:{
      markAllRead(){
        axios.post('/api/markAllRead')
      },
      getNotifications(){
        axios.post('/api/notification')
        .then(res => {
           this.read = res.data.read
           this.unread = res.data.unread
           this.unreadCount = res.data.unread.length
        })
      },
      readit(notification){   
        axios.post('/api/markAsRead', {id:notification.id})
        .then(res =>{
           this.unread.splice(notification,1)
           this.read.push(notification)
           this.unreadCount--
        })
      }
    }
}
</script>