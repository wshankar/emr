<template>
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                Income
            </div>
            <div class="card-tools">
                    <button type="button" class="btn btn-success" @click="getDaily">
                         <i class="fas fa-dollar-sign"></i> Daily
                    </button>
                    <button type="button" class="btn btn-success" @click="getMonthly">
                        Monthly <i class="fas fa-calendar-alt"></i>
                    </button>
                    <button type="button" class="btn btn-success" @click="getYearly">
                        Yearly <i class="fas fa-wallet"></i>
                    </button>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover" v-show="monthly">
                <thead>
                    <tr>
                        <th>Year</th>
                        <th>Month</th>
                        <th>Income</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="month in monthlyIncomes" :key="month.sum">
                        <td>{{month.year}}</td>
                        <td>{{month.month}}</td>
                        <td><strong>{{month.sum}}</strong> Kyats</td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-hover" v-show="yearly">
                <thead>
                    <tr>
                        <th>Year</th>
                        <th>Income</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="year in yearlyIncomes" :key="year.sum">
                        <td>{{year.year}}</td>
                        <td><strong>{{year.sum}}</strong> Kyats</td>
                    </tr>
                </tbody>
            </table>
            <table class="table table-hover" v-show="daily">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Month</th>
                        <th>Income</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="day in dailyIncomes" :key="day.sum">
                        <td>{{day.day}}</td>
                        <td>{{day.month}}</td>
                        <td><strong>{{day.sum}}</strong> Kyats</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            daily:true,
            monthly:true,
            yearly:true,
            monthlyIncomes:{},
            dailyIncomes:{},
            yearlyIncomes:{}
        }
    },
    methods:{
        getMonthly(){
            this.monthly=true
            this.daily=false
            this.yearly = false
            axios.get('/api/monthlyincome')
            .then(res => {
                this.monthlyIncomes  = res.data
            })
        },
        getDaily(){
            this.daily=true
            this.monthly = false
            this.yearly = false
            axios.get('/api/dailyincome')
            .then(res => {
                this.dailyIncomes  = res.data
            })
        },
        getYearly(){
            this.daily=false
            this.monthly = false
            this.yearly = true
            axios.get('/api/yearlyincome')
            .then(res => {
                this.yearlyIncomes  = res.data
            })
        }
    },
    created(){
        this.getDaily()
    }
}
</script>

<style>

</style>