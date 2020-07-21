export default class Gate {

    constructor(user){
        this.user = user;
    }

    isDoctor(){
        return this.user.type === 'Doctor';
    }

    isPharmacy(){
        return this.user.type === 'Pharmacy';
    }

    isCounterOrDoctor(){
        return this.user.type === 'Counter' || this.user.type === 'Doctor'
    }

}