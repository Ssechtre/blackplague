<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Commissions</h4>
                        <p class="card-category"> View all your commissions here per year.</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <date-picker v-model="dates.year" valueType="date" type="year"></date-picker>  
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
        props: ['currentYear'],
        mounted() {
            console.log('Component mounted.')            
        },
        created() {
            console.log(this.dates.year);
        },
        data : function(){
            return {
                current_year : this.currentYear,
                dates : {
                    year : this.currentYear
                },
            }
        },
        methods: {
            getReferrals() {
                axios
                .post('api/reports/get_dailysales', {
                    date: this.dates.year,
                })
                .then(response => {
                    let r = response.data
                    if (r.success) {
                    }
                })
                .catch(error => console.log(error))
            }
        }
    }
</script>
