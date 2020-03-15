<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Commissions</h4>
                        <p class="card-category"> View commissions here per year.</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2 col-sm-12">
                                <date-picker v-model="dates.year" valueType="date" type="year" @change="getCommissions()"></date-picker>  
                            </div>
                            <div class="col-md-3 col-sm-12" v-if="user_type == 'admin'">
                                <v-select v-model="user_selected" 
                                :options="customers"
                                label="name"
                                ></v-select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <h3>Direct Referrals</h3>
                                <p v-if="referrals.users.length == 0">No referrals found</p>
                                <div class="alert alert-warning pb-1" v-if="referrals.users.length > 0">
                                    <span>Referral Bonus</span> 
                                    <h2>{{ referrals.amount | currency }}</h2>
                                </div>
                                <table class="table table-bordered table-striped table-sm mt-2 table-responsive-sm" 
                                v-if="referrals.users.length > 0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Created At</th>
                                            <th>Bonus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="user in referrals.users">
                                            <td>{{ user.name }}</td>
                                            <td>{{ user.created_at }}</td>
                                            <td>P 500.00</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <h3>Profit Sharing</h3>
                                <p v-if="referrals.users.length == 0">No profit sharing found</p>
                                <div class="alert alert-success pb-1" v-if="commissions.data.length > 0">
                                    <span>Profit Sharing Total</span> <h2>{{ commissions.total | currency }}</h2>
                                </div>
                                <table class="table table-bordered table-striped table-sm mt-2 table-responsive-sm" 
                                v-if="commissions.data.length > 0">
                                    <thead>
                                        <tr>
                                            <th>From</th>
                                            <th>Commission</th>
                                            <th>Order Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="commission in commissions.data">
                                            <td>{{ commission.customer_name }}</td>
                                            <td>{{ commission.commission | currency }}</td>
                                            <td>{{ commission.created_at }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        props: ['currentYear', 'userId', 'userType'],
        mounted() {
            console.log('Component mounted.')            
        },
        created() {
            let url = window.location.protocol + '//' + window.location.host;
            axios.defaults.baseURL = url;
            this.getUsers();
        },
        data : function(){
            return {
                user_type : this.userType,
                user_id : this.userId,
                current_year : this.currentYear,
                dates : {
                    year : this.currentYear
                },
                referrals : {
                    users : [],
                    amount : 0,
                },
                commissions : {
                    data : [],
                    total : 0,
                },
                user_selected : null,
                customers : [],
            }
        },
        methods: {
            getCommissions() {
                console.log(this.user_selected);
                axios
                .post('api/reports/get_customer_commissions', {
                    year : this.dates.year,
                    user_id : this.user_id,
                })
                .then(response => {
                    let r = response.data
                    if (r.success) {
                        this.referrals = r.data.referrals;
                        this.commissions = r.data.commissions;
                    }
                })
                .catch(error => console.log(error))
            },
            getUsers: function() {
                axios
                .post('api/customer_networks/get_users', {
                    user_type: 'customer',
                })
                .then(response => {
                    this.customers = response.data;
                })
                .catch(error => console.log(error))

            },
        }
    }
</script>
