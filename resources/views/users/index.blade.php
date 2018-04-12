@extends ('base')

@section ('content')



<div id ="user-module">
    @include('modal')
        
    <div class="alert alert-dark text-center"><h3>User's module</h3></div>

    <transition appear enter-active-class ="animated fadeInUp">
        <div>
            <button class="btn btn-info pull-right" @click="addUser">Add user</button> 

            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Type</th>
                <th>Options</th>
                </thead>
                <tr v-for="(user, index) in users">
                    <td> @{{ index + 1 }}</td>
                    <td> @{{ user.name }} </td>
                    <td> @{{ user.email }} </td>
                    <td> @{{ user.type }} </td>
                    <td>
                        <button class="btn btn-warning btn-sm pull-right" @click="editUser(user.id)"> Edit</button>
                        <button class="btn btn-danger btn-sm pull-right" @click="deleteUser(user.id, index)"> Delete</button>
                    </td>
                </tr>
            </table>
        </div>
    </transition>

</div>
    
@endsection

@section ('script')

<script> 
    var v = new Vue({
        'el': '#user-module', 
        data: {
            users: [], 
            component: '',
            modalData: '', 
            modalTitle: ''
        }, 
        created() {
            this.loadUsers();
        },
        methods: {
            addUser() {
                this.modalTitle = "New user";
                this.component = "app-user";
                $('#myModal').modal('show').on('hidden.bs.modal', function(){
                   v.component = "";
                   v.modalData = "";
                });
            }, 
            editUser(id) {
                this.modalTitle = "Edit user";
                this.component = "app-user";
                this.modalData = id;
                $('#myModal').modal('show').on('hidden.bs.modal', function(){
                   v.component = "";
                   v.modalData = "";
                });
            }, 
            deleteUser(id, index) {
                if(confirm("re you sure?")){
                    this.$http.delete('/users/' + id).then(response => {
                        this.users.splice(index, 1);
                        alert("User is gone!");
                    }, error => {
                        alert(ExplainError(error));
                    })
                }
            }, 
            loadUsers() {
                this.$http.get('/users/show').then(response => {
                    this.users = response.data.users; 
                 }, error => {
                    alert(ExplainError(error));
                 });
            }
        }
    })
</script>

@endsection
