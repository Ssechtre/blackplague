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
                                @change="getPayouts()" placeholder="Select Month" value="current_month"></date-picker> 
                                <date-picker v-model="dates.m.year" valueType="format" type="year"
                                @change="getPayouts()" placeholder="Select Year" value="current_year" class='mt-3'></date-picker> 
                            </div>
                        </div>

                        <div class="row mt-5" v-if="is_loading == true">
                            <div class="col-sm-12">
                                <center><i class="fa fa-gear fa-spin fa-lg"></i><br><label>Getting Data...</label></center>
                            </div>                            
                        </div>
                        <div class="row mt-3" v-if="payouts.length == 0 && !is_loading">
                            <div class="col-sm-12">
                                <center><p class="text-primary">No payouts found</p></center>
                            </div>
                        </div>
                        <div class="row mt-3" v-if="payouts.length > 0 && !is_loading">
                            <div class="col-md-12 col-sm-12">
                                <h4>Payouts : {{ payout_date }}</h4>
                                
                                <table class="table table-bordered table-hover table-striped table-responsive-sm table-sm">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Referrals</th>
                                            <th>Bonus</th>
                                            <th>Payment status</th>
                                            <th>Options</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="payout in payouts"  v-bind:key="payout.id" v-bind:class="(!payout.status) ? 'table-danger' : ''">
                                            <td>{{ payout.member_name }}</td>
                                            <td>{{ payout.email }}</td>
                                            <td>{{ payout.phone }}</td>
                                            <td>{{ payout.connected_customers }}</td>
                                            <td>{{ payout.connected_customers * 500 | currency }}</td>
                                            <td>{{ (!payout.status) ? 'Pending' : payout.status }}</td>
                                            <td><button class="btn btn-primary btn-sm" 
                                                data-toggle="modal" data-target="#payoutModal"
                                                v-on:click="getPayoutDetails(payout)">View more details</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payout Modal -->
        <div class="modal" id="payoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Payout Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-5" v-if="is_loading == true">
                            <div class="col-sm-12">
                                <center><i class="fa fa-gear fa-spin fa-lg"></i><br><label>Getting Data...</label></center>
                            </div>
                        </div>
                        <div class="row" v-if="!is_loading">
                            <div class="col-md-12 col-sm-12">
                                <h4>Direct Referrals</h4>
                                <p v-if="referrals.users.length == 0" class="text-primary">No referrals found</p>
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

                            <div class="col-md-12 col-sm-12">
                                <hr>
                                <h4>Incentives</h4>
                                <p v-if="commissions.data.length == 0" class="text-primary">No incentives found</p>
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

                            <div class="col-md-12 col-sm-12 mt-3">
                                <hr>
                                <h4>Payout Date : {{ payout_date }}</h4>
                                <div class="form-group mt-4">                                                                   
                                    <label class="control-label">Transaction Number</label>
                                    <input type="text" class="form-control" placeholder="Ex. Cebuana, Palawan Reference Number(Required)" 
                                    v-model="commission_status.transaction_number" 
                                    :disabled="commission_status.status == 'Paid'">
                                </div>
                                <div class="form-group mt-4">                                                                   
                                    <label class="control-label">Remarks</label>
                                    <textarea class="form-control" placeholder="Write remarks here(Optional)" 
                                    v-model="commission_status.remarks"
                                    :disabled="commission_status.status == 'Paid'"></textarea>
                                </div>
                                <i v-if="commission_status.approved_by">Approved By: {{ commission_status.approved_by }}</i>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" v-on:click="approvePayment()" v-if="!commission_status.status">Make Payment</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Payout Modal -->
    </div>

</template>

<script>
    export default {
        props: ['currentYear', 'currentMonth', 'userId', 'userType'],
        mounted() {
            console.log('Component mounted.')            
        },
        created() {
            this.dates.m.month = this.current_month;
            this.dates.m.year = this.current_year;
            this.getPayouts();
        },
        data : function(){
            return {
                user_type : this.userType,
                user_id : this.userId,
                current_year : this.currentYear,
                current_month : this.currentMonth,
                dates : {
                    daily : null,
                    m : {
                        month : null,
                        year : null
                    },
                    year : null
                },
                payouts : [],
                is_loading: false,
                payout_date : null,
                referrals : {
                    users : [],
                    amount : 0,
                },
                commissions : {
                    data : [],
                    total : 0,
                },
                commission_status : {
                    status : null,
                    transaction_number : null,
                    remarks: null,
                    approved_by : null,

                },
                member : [],
            }
        },
        methods: {
            getPayouts() {
                
                if (this.dates.m.year && this.dates.m.month) {
                    this.is_loading = true;
                    axios
                    .post('api/reports/get_payouts', {
                        date: this.dates.m,
                    })
                    .then(response => {
                        let r = response.data
                        if (r.success) {
                            this.payouts = r.data.payouts;
                            this.payout_date = r.data.payout_date;
                        }else{
                            toastr.error(r.message);
                        }
                        this.is_loading = false;
                    })
                    .catch(error => console.log(error))
                }

            },
            getPayoutDetails(data) {
                this.is_loading = true;
                axios
                .post('api/reports/get_customer_commissions', {
                    date: this.dates.m,
                    user_id : data.member_id
                })
                .then(response => {
                    let r = response.data
                    console.log(r.success);
                    this.is_loading = false;
                    if (r.success) {
                        this.referrals = r.data.referrals;
                        this.commissions = r.data.commissions;
                        this.member = r.data.user;
                        this.commission_status = r.data.commission_status;
                    }else{
                        toastr.error(r.message);
                    }                
                })
                .catch(error => console.log(error))
            },
            approvePayment() {

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes!'
                }).then((result) => {
                    if (result.value) {
                        toastr.info("Saving details...");
                        axios
                        .post('api/commission/save_commission', {
                            date: this.dates.m,
                            user_id : this.user_id,
                            member : this.member,
                            referrals : this.referrals,
                            commissions : this.commissions,
                            transaction_number : this.commission_status.transaction_number,
                            remarks : this.commission_status.remarks
                        })
                        .then(response => {
                            let r = response.data
                            console.log(r);
                            if (r.success) {
                                $('#payoutModal').modal('hide');
                                $('.modal-backdrop').hide();
                                Swal.fire(
                                    'Great Job!',
                                    r.message,
                                    'success'
                                )
                                this.getPayouts();
                            }else{
                                toastr.error(r.message);
                            }
                        })
                        .catch(error => console.log(error))
                    }
                })

                
            }
        }
    }
</script>
