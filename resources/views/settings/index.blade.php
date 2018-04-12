
@extends ('base')

@section ('content')

<form id ="settings-module" @submit.prevent ="setSettings">
    
    <div class="alert alert-dark text-center"><h3>Settings's module</h3></div>
    
    <transition appear enter-active-class ="animated fadeInUp"> 
        <div class="card">
            <div class="card-header bg-danger text-white">Set options here</div>
            <div class="card-body">
                <div class="form-group form-inline">
                    <label>Set max calories per day: </label> 
                    <input type="number" class="form-control" placeholder="Max calories" v-model="calories" required> 
                    <button class="btn btn-dark" >Set</button>
                </div>
            </div>
        </div>
    </transition>
</form>

@endsection

@section ('script')

<script> 
    var v = new Vue({
        'el': '#settings-module', 
        data: {
           calories: 0
        }, 
        created() {
            this.load();
        }, 
        methods: {
            load() {
                this.$http.get('/settings/show').then(response => {
                    this.calories = response.data.calories; 
                 }, error => {
                     alert(ExplainError(error));
                 });
            }, 
            setSettings() {
                this.$http.put('/settings/1', {value: this.calories}).then(response => {
                    alert("Settings saved!");
                }, error => {
                    alert(ExplainError(error));
                });
            }
        }
    })
</script>

@endsection
