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
                        <div class="row">
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
                            <div class="col-sm-12">
                                <table class="table" v-if="purchases.length > 0">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Price</th>
                                            <th>Qty</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="purchase in purchases">
                                            <td>{{ purchase.name }}</td>
                                            <td>P{{ purchase.price }}</td>
                                            <td>{{ purchase.purchased_qty }}</td>
                                            <td>P{{ purchase.subtotal }}</td>
                                        </tr>

                                        <tr>
                                            <td></td>
                                            <td>Total</td>
                                            <td></td>
                                            <td>P{{ getTotal }}</td>
                                        </tr>

                                        <tr v-if="discount.discount_applied">
                                            <td></td>
                                            <td>Discount</td>
                                            <td></td>
                                            <td>-{{ (discount.discount_type) ? "P" : "" }}{{ discount.discount_amount }}{{ (!discount.discount_type) ? "%" : "" }}</td>
                                        </tr>

                                        <tr>
                                            <td></td>
                                            <td>Grand Total</td>
                                            <td></td>
                                            <td class="font-weight-bold">P{{ getFinalTotal }}</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <center v-if="!purchases.length">No purchases at the moment</center>

                                <div class="check-out-container" v-if="purchases.length > 0">
                                    <button class="btn btn-info btn-sm mb-2" data-toggle="modal" data-target="#discountModal">Appy Discount</button>
                                    <button class="btn btn-danger btn-sm mb-2" v-if="discount.discount_applied" v-on:click="removeDiscount()">Remove Discount</button>
                                    <button class="btn btn-success btn-lg col-sm-12" v-on:click="finishOrder()">Save and Finish Order <i class="material-icons">check</i></button>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal" id="discountModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <input type="text" class="form-control" v-on:keyup="getUsers()" v-model="search_name" placeholder="Search customer here">
                            <select class="form-control" v-model="selected_user">
                                <option value="">- Select customer to apply discount -</option>
                                <option v-for="user in users"  v-bind:key="user.id" v-bind:value="user.id">{{ user.name }}</option>
                            </select>                               
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
        props: ['usersRoute', 'productsRoute'],
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
                products: [],
                purchases : [],
                search_name : null,
                total : 0,
                pos_routes : {
                    users : this.usersRoute,
                    products : this.productsRoute
                },
                selected_user : "",
                discount : {
                    discount_applied : false,
                    discount_type : false,
                    discount_amount : "",
                }
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

                        return (total-discount).toFixed(2);
                    }

                    return (total-this.discount.discount_amount).toFixed(2);
                }

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
                                console.log(this.purchases);
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
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, completed the order!'
                }).then((result) => {
                    if (result.value) {
                        Swal.fire(
                            'Great Job!',
                            'Order successfully completed!',
                            'success'
                        )
                        this.purchases = {};
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
            }
        }
    }
</script>
