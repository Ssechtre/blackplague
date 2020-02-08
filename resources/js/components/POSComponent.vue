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
                    <div class="col-sm-3" v-for="product in products" v-bind:key="product.id" v-bind:title="product.description">
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
                                    </tbody>
                                </table>

                                <center v-if="!purchases.length">No purchases at the moment</center>

                                <button class="btn btn-success btn-lg col-sm-12" v-if="purchases.length > 0" v-on:click="finishOrder()">Save and Finish Order <i class="material-icons">check</i></button>
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

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" v-on:click="">Save changes</button>
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
        },
        data : function(){
            return {
                products: [],
                purchases : [],
                search_name : null,
                total : 0,
                pos_routes : {
                    users : this.usersRoute,
                    products : this.productsRoute
                }
            }
        },
        computed : {
            getTotal: function(){

                let total = [];

                Object.entries(this.purchases).forEach(([key, val]) => {
                    total.push(val.price*val.purchased_qty)
                });

                return total.reduce(function(total, num){ return total + num }, 0).toFixed(2);
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
                
            }
        }
    }
</script>
