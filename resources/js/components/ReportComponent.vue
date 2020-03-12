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

             <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header card-header-tabs card-header-info">
                        <div class="nav-tabs-navigation">
                            <div class="nav-tabs-wrapper">
                                <span class="nav-tabs-title">Sales:</span>
                                <ul class="nav nav-tabs" data-tabs="tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#daily" data-toggle="tab">
                                            <i class="material-icons">calendar_today</i> Daily Sales
                                            <div class="ripple-container"></div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#monthly" data-toggle="tab">
                                            <i class="material-icons">calendar_today</i> Monthly Sales
                                            <div class="ripple-container"></div>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#annual" data-toggle="tab">
                                            <i class="material-icons">calendar_today</i> Annual Sales
                                            <div class="ripple-container"></div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">

                            <!-- Daily Sales Tab -->
                            <div class="tab-pane active" id="daily">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-12 mb-3">
                                            <date-picker v-model="dates.daily" valueType="format" @change="getDailySales()"></date-picker> 
                                        </div>
                                        <div class="col-lg-3 offset-lg-3 col-sm-12" v-show="daily_data.orders.length > 0">
                                            <div class="alert alert-success pb-1">
                                                <span>Grand Total as of <b>{{ dates.daily }}</b>  </span> <h2>{{ daily_data.total_revenue | currency }}</h2>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12" v-show="!daily_data.orders">
                                            <center><p>No records available</p></center>
                                        </div>
                                        <div class="col-sm-12">
                                            <table class="table table-bordered table-striped table-sm mt-2 table-responsive-sm" v-show="daily_data.orders.length > 0">
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
                                                    <tr v-for="order in daily_data.orders">
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
                            <!-- End Daily Sales Tab -->

                            <!-- Monthly Sales Tab -->
                            <div class="tab-pane" id="monthly">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <date-picker v-model="dates.m.month" valueType="format" type="month" @change="getMonthlySales()"></date-picker>  
                                        <date-picker v-model="dates.m.year" valueType="date" type="year" @change="getMonthlySales()"></date-picker>    
                                    </div>
                                    <div class="col-lg-3 offset-lg-3 col-sm-12" v-show="monthly_data.orders.length > 0">
                                        <div class="alert alert-success pb-1">
                                            <span>Grand Total</span> <h2>{{ monthly_data.total_revenue | currency }}</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12" v-show="!monthly_data.orders">
                                        <center><p>No records available</p></center>
                                    </div>
                                    <div class="col-sm-12">
                                        <table class="table table-bordered table-striped table-sm mt-2 table-responsive-sm" v-show="monthly_data.orders.length > 0">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Total Orders</th>
                                                    <th>Total Revenue</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="order in monthly_data.orders">
                                                    <td>{{ order.date_beautified }}</td>
                                                    <td>{{ order.daily_orders }} order(s)</td>
                                                    <td><b>{{ order.total_daily_sales | currency }}</b></td>
                                                    <td><button class="btn btn-sm btn-primary">View details</button></td>
                                                </tr>
                                            </tbody>
                                        </table> 
                                    </div>
                                </div>  
                            </div>
                            <!-- End Monthly Sales Tab -->

                            <!-- Annual Sales Tab -->
                            <div class="tab-pane" id="annual">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <date-picker v-model="dates.year" valueType="date" type="year" @change="getAnnualSales()"></date-picker>  
                                    </div>
                                    <div class="col-lg-3 offset-lg-3 col-sm-12" v-show="annual_data.orders.length > 0">
                                        <div class="alert alert-success pb-1">
                                            <span>Annual Revenue</span> <h2>{{ annual_data.total_revenue | currency }}</h2>
                                        </div>
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="col-sm-12" v-show="!annual_data.orders">
                                        <center><p>No records available</p></center>
                                    </div>
                                    <div class="col-sm-12">
                                        <table class="table table-bordered table-striped table-sm mt-2 table-responsive-sm" v-show="annual_data.orders.length > 0">
                                            <thead>
                                                <tr>
                                                    <th>Month</th>
                                                    <th>Total Orders</th>
                                                    <th>Total Revenue</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="order in annual_data.orders">
                                                    <td>{{ order.month_name }}</td>
                                                    <td>{{ order.monthly_orders }} order(s)</td>
                                                    <td><b>{{ order.total_monthly_sales | currency }}</b></td>
                                                    <td><button class="btn btn-sm btn-primary">View details</button></td>
                                                </tr>
                                            </tbody>
                                        </table> 
                                    </div>
                                </div>                                
                            </div>
                            <!-- End Annual Sales Tab -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
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
                    year : null
                },
                daily_data : {
                    orders : []
                },
                monthly_data : {
                    orders : []
                },
                annual_data : {
                    orders : []
                },
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
                        this.daily_data = r.data;
                        console.log(this.daily_data);
                    }
                })
                .catch(error => console.log(error))
            },
            getMonthlySales: function() {
                axios
                .post('api/reports/get_monthlysales', {
                    date:this.dates.m,
                })
                .then(response => {
                    let r = response.data
                    if (r.success) {
                        this.monthly_data = r.data;
                    }
                })
                .catch(error => console.log(error))
            },
            getAnnualSales : function() {
                axios
                .post('api/reports/get_annualsales', {
                    date : this.dates.year,
                })
                .then(response => {
                    let r = response.data
                    if (r.success) {
                        this.annual_data = r.data;
                    }
                })
                .catch(error => console.log(error))
            }
        },
    }
</script>
