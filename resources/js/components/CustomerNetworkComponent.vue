<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Customer Networks</h4>
                        <p class="card-category"> Here you can view the customer network level and create networks.</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <button class="btn btn-info pull-right" data-toggle="modal" data-target="#networkModal">Create Network</button>
                            </div>
                        </div>
                        <div class="row mt-5" v-if="is_loading == true">
                            <div class="col-sm-12">
                                <center><i class="fa fa-gear fa-spin fa-lg"></i><br><label>Getting Data...</label></center>
                            </div>
                        </div>
                        <div class="row" v-if="customers.length > 0 && !is_loading">
                            <div class="col-sm-12">
                                <table class="table table-bordered table-hover table-striped table-sm table-responsive-sm">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Referrals</th>
                                            <th>Options</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="customer in customers"  v-bind:key="customer.id">
                                            <td>{{ customer.member_name }}</td>
                                            <td>{{ customer.email }}</td>
                                            <td>{{ customer.phone }}</td>
                                            <td>{{ customer.connected_customers }}</td>
                                            <td><button class="btn btn-primary btn-sm" 
                                                data-toggle="modal" data-target="#userNetworksModal"
                                                v-on:click="getNetworks(customer)">View more details</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal" id="networkModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create Network</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mt-4">                               
                            <label class="control-label">Code Number</label>                            
                            <input type="text" class="form-control" v-model="code_number">
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <center><h5 class="font-weight-bold">Connected to</h5></center> 
                            </div>     
                        </div>
                        <div class="form-group mt-1">
                            <v-select v-model="user_selected" 
                            :options="users"
                            label="name"
                            ></v-select>                             
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" v-on:click="connectUsers()">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!--  -->

        <!-- User Networks -->
        <div class="modal" id="userNetworksModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-if="network_selected">{{ network_selected.member_name }}'s Referrals</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-5" v-if="networks.length == 0">
                            <div class="col-sm-12">
                                <center><i class="fa fa-gear fa-spin fa-lg"></i><br><label>Getting Data...</label></center>
                            </div>
                        </div>
                        <div class="row" v-if="networks.length > 0">
                            <div class="col-sm-12">
                                
                                <table class="table table-bordered table-hover table-striped table-responsive-sm">
                                    <thead>
                                        <tr>
                                            <td>Name</td>
                                            <td>Email</td>
                                            <td>Phone</td>
                                            <td>Date Approved</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="network in networks" v-bind:key="network.id">
                                            <td>{{ network.name }}</td>
                                            <td>{{ network.email }}</td>
                                            <td>{{ network.phone }}</td>
                                            <td>{{ network.created_at }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!--  -->
    </div>

</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')            
        },
        created() {
            this.getUsers();
            this.getCustomerNetworks();
        },
        data : function(){
            return {
                users: [],
                search_name : null,
                user_selected : null,
                code_number : null,
                customers: [],
                is_loading : false,
                networks : [],
                network_selected : null,
            }
        },
        methods: {
            getUsers: function() {
                axios
                .post('api/customer_networks/get_users', {
                    user_type: 'customer',
                    name : this.search_name
                })
                .then(response => {
                    this.users = response.data
                })
                .catch(error => console.log(error))
            },
            getCustomerNetworks: function() {
                this.is_loading = true;
                axios
                .get('api/customer_networks/get_customer_networks')
                .then(response => {
                    let r =response.data;
                    this.customers = r.data
                    this.is_loading = false;
                })
                .catch(error => console.log(error))
            },
            connectUsers: function() {
                axios
                .post('api/customer_networks/connect_users', {
                    code_number: this.code_number,
                    user_id : this.user_selected.id
                })
                .then(response => {
                    let r = response.data;
                    if (r.success) {
                        toastr.success(r.message);
                        $('#networkModal').modal('hide');
                        $('.modal-backdrop').hide();
                        this.getCustomerNetworks();
                        this.code_number = null;
                    }else{
                        toastr.error(r.message);
                    }                    
                })
                .catch(error => console.log(error))
            },
            getNetworks: function(data) {
                this.network_selected = data;
                this.networks = [];
                axios
                .post('api/customer_networks/get_user_networks', {
                    user_id : data.member_id
                })
                .then(response => {
                    let r = response.data;
                    if (r.success) {
                        this.networks = r.data;
                    }else{
                        toastr.error(r.message);
                    }                    
                })
                .catch(error => console.log(error))
            }
        }
    }
</script>
