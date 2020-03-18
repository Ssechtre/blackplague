<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Commissions</h4>
                        <p class="card-category"> View commissions here.</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <date-picker v-model="dates.m.month" valueType="format" type="month" 
                                @change="getCommissions()" placeholder="Select Month" value="current_month"></date-picker> 
                                <date-picker v-model="dates.m.year" valueType="format" type="year"
                                @change="getCommissions()" placeholder="Select Year" value="current_year" class='mt-3'></date-picker> 
                            </div>
                        </div>

                        <div class="row mt-5" v-if="is_loading == true">
                            <div class="col-sm-12">
                                <center><i class="fa fa-gear fa-spin fa-lg"></i><br><label>Getting Data...</label></center>
                            </div>
                        </div>
                        <div class="row" v-if="!is_loading">
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
                                <h3>Incentives</h3>
                                <p v-if="commissions.data.length == 0">No incentives found</p>
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
        props: ['currentYear', 'currentMonth', 'userId', 'userType'],
        mounted() {
            console.log('Component mounted.')            
        },
        created() {
            this.getUsers();
            this.dates.m.month = this.currentMonth;
            this.dates.m.year = this.currentYear;
            this.getCommissions();
        },
        data : function(){
            return {
                user_type : this.userType,
                user_id : this.userId,
                current_year : this.currentYear,
                current_year : this.currentMonth,
                dates : {
                    daily : null,
                    m : {
                        month : null,
                        year : null
                    },
                    year : null
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
                is_loading: false,
            }
        },
        methods: {
            getCommissions() {
                
                if (this.dates.m.year && this.dates.m.month) {
                    this.is_loading = true;
                    axios
                    .post('api/reports/get_customer_commissions', {
                        date: this.dates.m,
                        user_id : this.user_id
                    })
                    .then(response => {
                        let r = response.data
                        if (r.success) {
                            this.referrals = r.data.referrals;
                            this.commissions = r.data.commissions;
                        }else{
                            toastr.error(r.message);
                        }
                        this.is_loading = false;
                    })
                    .catch(error => console.log(error))
                }

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
