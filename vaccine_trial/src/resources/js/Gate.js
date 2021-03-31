export default class Gate {

    constructor(user) {
        this.user = user
    }

    isVaccineMaker(){
        return this.user.role === 3;
    }

    isRegulator () {
        return $this.user.role === 2;
    }

    isVolunteer () {
        return this.user.role === 1;
    }

}