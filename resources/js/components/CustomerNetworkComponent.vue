<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Customer Networks</h4>
                        <p class="card-category"> Here you can; View the customer network level and create networks.</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <button class="btn btn-info pull-right" data-toggle="modal" data-target="#networkModal">Create Network</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Connections</th>
                                            <th>Options</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="customer in customers"  v-bind:key="customer.id">
                                            <td>{{ customer.name }}</td>
                                            <td>{{ customer.email }}</td>
                                            <td>{{ customer.phone }}</td>
                                            <td>{{ customer.connected_customers }}</td>
                                            <td><button class="btn btn-primary btn-sm">View more details</button></td>
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
                            <input type="text" class="form-control"" v-model="code_number">
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <center><h5 class="font-weight-bold">Connected to</h5></center> 
                            </div>     
                        </div>
                        <div class="form-group mt-1">
                            <input type="text" class="form-control" v-on:keyup="getUsers()" v-model="search_name" placeholder="Search customer this person is connected to">
                            <select class="form-control" v-model="connected_user_id">
                                <option value="">- Select customer this person is connected to -</option>
                                <option v-for="user in users"  v-bind:key="user.id" v-bind:value="user.id">{{ user.name }}</option>
                            </select>                               
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" v-on:click="connectUsers()">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
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
                connected_user_id : "",
                code_number : null,
                customers: [],
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
                axios
                .get('api/customer_networks/get_customer_networks')
                .then(response => {
                    let r =response.data;
                    this.customers = r.data
                })
                .catch(error => console.log(error))
            },
            connectUsers: function() {
                axios
                .post('api/customer_networks/connect_users', {
                    code_number: this.code_number,
                    user_id : this.connected_user_id
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
            }
        }
    }
</script>
