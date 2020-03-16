<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-warning">
                        <h4 class="card-title ">Health Patrol Life Center</h4>
                        <p class="card-category">Point of Sale System</p>
                    </div>
                    <div class="card-body">
                        <div class="row d-none">
                            <div class="col-sm-12">                                
                                <button class="btn btn-success"><i class="material-icons">search</i> View Reports</button>
                                <a v-bind:href="pos_routes.products"><button class="btn btn-info"><i class="material-icons">content_paste</i> Go to Product Management</button></a>
                                <a v-bind:href="pos_routes.users"><button class="btn btn-default"><i class="material-icons">person</i> Go to Customer Management</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="row">  
                    <div class="col-lg-3 col-sm-6" v-for="product in products" v-bind:key="product.id" v-bind:title="product.description">
                        <summary class="card bg-primary" v-on:click="addProduct(product)">
                            <div class="card-body">
                                <label class="font-weight-bold text-white">{{ product.name }}</label>
                                <p>{{ product.description.substring(0,20)+".." }}</p>
                                <h4 class="text-white">P{{ product.price }}</h4>
                            </div>
                        </summary>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12" v-if="!purchases.length">
                                 <center>No purchases at the moment</center>
                            </div>
                            <div class="col-sm-12" v-if="purchases.length > 0">
                                <button class="btn btn-info btn-sm mb-2" data-toggle="modal" data-target="#discountModal" v-if="user_type != 'customer'">Appy Discount</button>
                                <button class="btn btn-danger btn-sm mb-2" v-if="discount.discount_applied" v-on:click="removeDiscount()">Remove Discount</button>
                                <button class="btn btn-danger btn-sm mb-2 pull-right" v-on:click="clearPurchase()">Clear All</button>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Price</th>
                                            <th>Qty</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="purchase in purchases">
                                            <td>{{ purchase.name }}</td>
                                            <td>{{ purchase.price | currency }}</td>
                                            <td>{{ purchase.purchased_qty }}</td>
                                            <td>{{ purchase.subtotal | currency }}</td>
                                        </tr>

                                        <tr>
                                            <td></td>                                         
                                            <td colspan="2">Total</td>
                                            <td>{{ getTotal | currency }}</td>
                                        </tr>

                                        <tr v-if="discount.discount_applied">
                                            <td></td>                                          
                                            <td colspan="2">Discount</td>
                                            <td>-{{ (discount.discount_type) ? "P" : "" }}{{ discount.discount_amount }}{{ (!discount.discount_type) ? "%" : "" }}</td>
                                        </tr>

                                        <tr>
                                            <td></td>                                           
                                            <td colspan="2">Grand Total</td>
                                            <td class="font-weight-bold">{{ getFinalTotal | currency }}</td>
                                        </tr>
                                    </tbody>
                                </table>                               

                                <div class="check-out-container">                                    
                                    <button class="btn btn-success btn-lg col-sm-12" v-on:click="finishOrder()">Save and Finish Order <i class="material-icons">check</i></button>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal" id="discountModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" v-if="user_type != 'customer'">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Apply Discount</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mt-1">
                            <v-select v-model="selected_user" 
                            :options="users"
                            label="name"
                            ></v-select>                              
                        </div>

                        <div class="form-group mt-2">
                            <!-- Rounded switch -->
                            <label class="switch">
                                <input type="checkbox" v-model="discount.discount_type">
                                <span class="slider round"></span>
                            </label>
                            <label class="switch-text">{{ (!discount.discount_type) ? "By Percentage" : "By Fixed Amount" }}</label>                         
                        </div>

                        <div class="form-group">
                            <input type="text" 
                            class="form-control" 
                            v-model="discount.discount_amount" 
                            v-bind:placeholder="(!discount.discount_type) ? 'Enter amount in percentage' : 'Enter fixed amount'">                         
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" v-bind:disabled="!discount.discount_amount || !selected_user" v-on:click="applyDiscount()">Apply Discount</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        props: ['usersRoute', 'productsRoute', 'userId', 'userType'],
        mounted() {
            console.log('Component mounted.')            
        },
        created() {
            this.getProducts();
            this.getUsers();
        },
        data : function(){
            return {
                users: [],
                user_id : this.userId,
                user_type : this.userType,
                products: [],
                purchases : [],
                search_name : null,
                total : 0,
                pos_routes : {
                    users : this.usersRoute,
                    products : this.productsRoute
                },
                selected_user : null,
                discount : {
                    discount_applied : false,
                    discount_type : false,
                    discount_amount : "",
                },
                final_total : 0,
            }
        },
        computed : {
            getTotal: function(){
                return this.computeTotal();
            },
            getFinalTotal : function() {

                let total = this.computeTotal();

                if (this.discount.discount_applied) {

                    if (!this.discount.discount_type) {
                        let discount = (total/100)*this.discount.discount_amount;

                        let total_discount = (total-discount).toFixed(2);

                        this.final_total = total_discount;
                        return total_discount;
                    }

                    let total_discount =(total-this.discount.discount_amount).toFixed(2)

                    this.final_total = total_discount;
                    return total_discount;
                }

                this.final_total = total;
                
                return total;
            }
        },
        methods: {
            getProducts: function() {
                axios
                .post('api/products/get_products', {
                    name: this.search_name,
                })
                .then(response => {
                    let r = response.data
                    this.products = r.data
                })
                .catch(error => console.log(error))
            },
            addProduct: function(product) {

                const { value: quantity } = Swal.fire({
                    title: 'Please enter quanity',
                    input: 'number',
                    inputPlaceholder: 'Quantity',
                    showCancelButton: true,
                    inputValidator: (value) => {
                        return new Promise((resolve) => {
                            if (value != '') {
                                product.purchased_qty = value;
                                product.subtotal = (value*product.price).toFixed(2);
                                this.purchases.push(product);
                                swal.close();
                            } else {
                                resolve('Quantity is required :)')
                            }
                        });
                    }
                });
            },
            finishOrder: function() {

                Swal.fire({
                    title: 'Finish this order? <br> Total : P'+this.final_total,
                    input: 'text',
                    inputPlaceholder: 'Enter remarks here(Optional)',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, complete this order',
                    showLoaderOnConfirm: true,
                    preConfirm: (remarks) => {

                        return axios.post(`/api/orders/create_order`, {
                            discount_applications : this.discount,
                            line_items : this.purchases,
                            user_cid : this.selected_user.id,
                            subtotal_price : this.computeTotal(),
                            total_price : this.final_total,
                            remarks : remarks,
                            user_id : this.user_id
                        })
                        .then(response => {
                            var r = response.data;
                            if (!r.success) {
                                throw new Error(r.message)
                            }
                            return r;
                        })
                        .catch(error => {
                            Swal.showValidationMessage(
                                `Request failed: ${error}`
                                )
                        })
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.value) {
                        Swal.fire(
                            'Great Job!',
                            result.value.message,
                            'success'
                        )
                        this.clearOrder();
                    }
                })    
            },
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
            computeTotal : function() {

                let total = [];

                Object.entries(this.purchases).forEach(([key, val]) => {
                    total.push(val.price*val.purchased_qty)
                });

                return total.reduce(function(total, num){ return total + num }, 0).toFixed(2);
            },
            applyDiscount : function() {

                this.discount.discount_applied = true;
                $('#discountModal').modal('hide');
                $('.modal-backdrop').hide();

            },
            removeDiscount : function() {
                this.discount = {
                    discount_applied : false,
                    discount_type : false,
                    discount_amount : 0,
                }
            },
            clearOrder : function() {
                this.purchases = [];
                this.selected_user = null;
                this.discount = {
                    discount_applied : false,
                    discount_type : false,
                    discount_amount : "",
                }
            },
            clearPurchase : function() {
                Swal.fire({
                    title: 'Are you sure to clear orders?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, clear everything!'
                  }).then((result) => {
                      if (result.value) {
                        this.clearOrder();
                        Swal.fire(
                          'Order Cleared!',
                          'All orders removed',
                          'success'
                        )
                    }
                })
            }
        }
    }
</script>
