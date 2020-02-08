<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <button class="btn btn-info pull-right" data-toggle="modal" data-target="#networkModal">Create Network</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="row">  
                    <div class="col-sm-3" v-for="product in products" v-bind:key="product.id" v-bind:title="product.description">
                        <summary class="card bg-primary" v:on:click="addProduct(product)">
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
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Price</th>
                                            <th>Qty</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
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
            this.getProducts();
            this.getCustomerNetworks();
        },
        data : function(){
            return {
                products: [],
                purchases : [],
                search_name : null,
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
                const { value: quanity } = await Swal.fire({
                  title: 'Quanity',
                  input: 'number',
                  inputPlaceholder: 'Enter quanity'
                });

                if (quanity) {
                  Swal.fire(`Entered email: ${email}`)
                }
            },
        }
    }
</script>
