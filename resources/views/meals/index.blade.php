
@extends ('base')

@section ('style')

<style type="text/css">
    form.form-inline > * {padding: 5px 10px !important;}
</style>

@endsection

@section ('content')

<div id ="meals-module">
    @include('modal')
    
    <div class="alert alert-dark text-center"><h3>Meal's module</h3></div>
    
        <div class="card">
            <div class="card-header bg-success text-white">Register new meal</div>
            <div class="card-body">
                <form  class="form-inline" @submit.prevent="addMeal">
                    <label>Date</label>
                    <input type="date" class="form-control" placeholder="Date of the meal" v-model="newMeal.date" id ="" required>
                    <label>Time</label>
                    <input type="time" class="form-control" placeholder="Time of the meal" v-model="newMeal.time" id ="txtTime" required>
                    <label>Name</label>
                    <input type="text" class="form-control" placeholder="Name of the meal" v-model="newMeal.name" required>
                    <label>Calories</label>
                    <input type="number" class="form-control" placeholder="Number of calories" v-model="newMeal.calories" required>
                    <button class="btn btn-success">Add meal</button>
                </form>
            </div>
        </div>
        <hr>
        <div class="card">
            <div class="card-header bg-primary text-white">My history</div>
            <div class="card-body">
                
                <div class="form-group row">
                    <div class="col-md-4">
                        <label>Filter by </label>
                        <label> Day
                            <input type="radio" v-model="filterBy" value="DAY">
                        </label>
                        <label> Period
                            <input type="radio" v-model="filterBy" value="PERIOD">
                        </label>
                    </div>
                    <div class="form-inline"  :class="col_number" v-if="filterBy == 'DAY'">
                        <label>Date: </label>
                        <input type="date" class="form-control float-right" v-model="dayFilter" >
                    </div>
                    <div class="form-inline" :class="col_number" v-if="filterBy == 'PERIOD'">
                        <label>From: </label>
                        <input type="date" class="form-control float-right" v-model="fromFilter" >
                        <label>To: </label>
                        <input type="date" class="form-control float-right" v-model="toFilter" >
                    </div>
                </div>
                
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                    <th>#</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Meal</th>
                    <th>Calories</th>
                    <th>Options</th>
                    </thead>
                    <tr v-for="(meal, index) in meals">
                        <td>@{{ index + 1 }}</td>
                        <td>@{{ meal.date | dateFormat }}</td>
                        <td>@{{ meal.date | timeFormat }}</td>
                        <td>@{{ meal.name }}</td>
                        <td>@{{ meal.calories }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm" @click="editMeal(meal)">Edit</button>
                            <button class="btn btn-danger btn-sm" @click="deleteMeal(meal.id, index)">Delete</button>
                        </td>
                    </tr>
                </table>
                <p>
                    <h4 class="text-center"><span class="badge badge-pill " :class ="class_result">Total of calories in this @{{ filterBy == 'DAY'?'day':'period' }}: @{{ total_calories }} </span></h4>
                </p>
            </div>
        </div>
    
</div>

@endsection

@section ('script')

<script> 
    var v = new Vue({
        'el': '#meals-module', 
        data: { 
           limit: 0,
           meals: [], 
           newMeal: {}, 
           component: '', 
           modalTitle: '', 
           modalData: '', 
           baseUrl: "{{ url('meals') }}",
           filterBy: 'DAY', 
           dayFilter: moment().format('YYYY-MM-DD'),
           fromFilter : moment().format('YYYY-MM-DD'), 
           toFilter: moment().format('YYYY-MM-DD')
        }, 
        computed: {
            col_number() {
                return this.filterBy == 'DAY' ? 'col-md-3' : 'col-md-6'
            }, 
            total_calories (){
                let total = 0; 
                if(this.meals.length){
                    this.meals.forEach(m => {
                       total += parseFloat(m.calories); 
                    });
                }
                return total;
            }, 
            class_result() {
                return this.total_calories > this.limit ? 'badge-danger' : 'badge-success';
            }, 
            searchParams(){
                return this.filterBy == 'DAY' ? this.dayFilter : this.fromFilter + ',' + this.toFilter;
            }
        },
        created() {
            this.loadMeals();
            this.$http.get('{{url("meals/1")}}').then(response => {
               this.limit = response.data.setting.value; 
            });
        },
        methods: {
            addMeal() {
                this.$http.post('{{url("meals/")}}', this.newMeal).then(response => {
                    alert("Meal saved!");
                    this.loadMeals();
                    this.newMeal = {}
                }, error => {
                    alert(ExplainError(error));
                })
            }, 
            loadMeals() {
                 this.$http.get('{{url("meals/search")}}/' + this.searchParams).then(response => {
                    this.meals = response.data.meals;
                }, error => {
                    alert(ExplainError(error));
                });
            }, 
            deleteMeal(id, index) {
                if(confirm("Are you sure to delete this?")){
                    this.$http.delete('{{url("meals")}}' + '/' + id).then(response => {
                        alert("Meal deleted!");
                        this.meals.splice(index, 1);
                    }, error => {
                        alert(ExplainError(error));
                    })
                }
            }, 
            editMeal(meal) {
                this.modalTitle = "Edit my meal";
                this.component = "app-meal";
                this.modalData = meal;
                $('#myModal').modal('show').on('hidden.bs.modal', function(){
                    v.component = "";
                    v.modalData = "";
                });
            }
        }, 
        watch: {
            dayFilter() {
                this.loadMeals();
            }, 
            fromFilter() {
                this.loadMeals();
            }, 
            toFilter() {
                this.loadMeals();
            }
        }
    })
</script>

@endsection
