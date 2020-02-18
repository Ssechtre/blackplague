<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Inventory Reports</h4>
                        <p class="card-category"> View sales report and inventory.</p>
                    </div>
                    <div class="card-body">

                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Daily Sales</h4>
                        <p class="card-category"> View sales reports per day.</p>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <date-picker v-model="dates.daily" valueType="format" @change="getDailySales()"></date-picker> 

                            <table class="table table-bordered mt-2">
                                <thead>
                                    <tr>
                                        <th>Order Number</th>
                                        <th>Sold To</th>
                                        <th>Total</th>
                                        <th>Applied Discount</th>
                                        <th>Grand Total</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="order in daily_orders">
                                        <td>{{ order.order_number }}</td>
                                        <td>{{ order.name }}</td>
                                        <td>{{ order.subtotal_price | currency }}</td>
                                        <td>{{ order.discount }}</td>
                                        <td><b>{{ order.total_price | currency }}</b></td>
                                        <td><button class="btn btn-sm btn-primary">View details</button></td>
                                    </tr>
                                </tbody>
                            </table>                   
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header card-header-warning">
                        <h4 class="card-title ">Monthly Sales</h4>
                        <p class="card-category"> View sales reports per month.</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <date-picker v-model="dates.m.month" type="month"></date-picker>   
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <date-picker v-model="dates.m.year" type="year"></date-picker>   
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header card-header-success">
                        <h4 class="card-title ">Annaul Sales</h4>
                        <p class="card-category"> View sales reports per year.</p>
                    </div>
                    <div class="card-body">
                        <date-picker v-model="dates.annual" type="year"></date-picker>   
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import DatePicker from 'vue2-datepicker';
    import 'vue2-datepicker/index.css';

    export default {
        components: { DatePicker },
        props: ['currentYear'],
        mounted() {
            console.log('Report Component mounted.')            
        },
        created() {

        },
        data : function(){
            return {
                current_year : this.currentYear,
                dates : {
                    daily : null,
                    m : {
                        month : null,
                        year : null
                    },
                    annual : null
                },
                daily_orders : [],
                daily_orders_total : 0
            }
        },
        methods: {
            getDailySales : function() {
                axios
                .post('api/reports/get_dailysales', {
                    date:this.dates.daily,
                })
                .then(response => {
                    let r = response.data
                    if (r.success) {
                        this.daily_orders = r.data.orders;
                        this.daily_orders_total = r.data.total;
                    }
                })
                .catch(error => console.log(error))
            },
            getMonthlySales: function() {

            },
            getYearlySales : function() {

            }
        },
    }
</script>
