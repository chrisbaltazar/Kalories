<template>
    <form @submit.prevent ="updateMeal">
        <div class="form-group">
            <label>Date</label>
            <input type="date" class="form-control" v-model="meal.date" placeholder="Date for meal" required>
        </div>
        <div class="form-group">
            <label>Time</label>
            <input type="time" class="form-control" v-model="meal.time" placeholder="Time for meal" required>
        </div>
        <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" v-model="meal.name" placeholder="Name for meal" required>
        </div>
        <div class="form-group">
            <label>Calories</label>
            <input type="number" class="form-control" v-model="meal.calories" placeholder="Clories in this meal" required>
        </div>
        <p><button class="btn btn-success btn-lg" >Update</button></p>
    </form>
</template>

<script> 
    export default {
        props: ['modalData', 'baseUrl'], 
        data () {
            return {
                meal: {}
            }
        },
        computed: {
          dateMeal() {
                return this.modalData.date.split(" ")[0];
          },  
          timeMeal() {
              return this.modalData.date.split(" ")[1];              
          }  
        },      
        created() {
            this.meal.id =  this.modalData.id;
            this.meal.date = this.dateMeal,
            this.meal.time = this.timeMeal, 
            this.meal.name = this.modalData.name,
            this.meal.calories = this.modalData.calories
        },
        methods: {
            updateMeal() {
                this.$http.put(this.baseUrl + '/' + this.meal.id, this.meal).then(response => {
                    alert("Meal updated!");
                    v.loadMeals();
                    $('#myModal').modal('hide');
                }, error => {
                   alert(ExplainError(error)); 
                });
            }
        }
    }
</script>
