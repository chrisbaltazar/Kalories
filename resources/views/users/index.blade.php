@extends ('base')

@section ('content')



<div id ="user-module">
    @include('modal')
        
    <div class="alert alert-dark text-center"><h3>User's module</h3></div>

    <button style="margin-bottom: 10px" class="btn btn-info float-right" @click="addUser">Add user</button> 
    
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
        <th>#</th>
        <th>Name</th>
        <th>Email</th>
        <th>Type</th>
        <th>Options</th>
        </thead>
        <tr v-for="(user, index) in users">
            <td v-text = " index + 1 "></td>
            <td v-text = " user.name "></td>
            <td v-text = " user.email "></td>
            <td v-text = " user.type "></td>
            <td>
                <button class="btn btn-warning btn-sm pull-right" @click="editUser(user.id)"> Edit</button>
                <button class="btn btn-danger btn-sm pull-right" @click="deleteUser(user.id, index)"> Delete</button>
            </td>
        </tr>
    </table>


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
            modalTitle: '', 
            baseUrl: "{{url('users')}}"
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
                if(confirm("Are you sure?")){
                    this.$http.delete('{{url("users")}}' + '/' + id).then(response => {
                        this.users.splice(index, 1);
                        alert("User is gone!");
                    }, error => {
                        alert(ExplainError(error));
                    })
                }
            }, 
            loadUsers() {
                this.$http.get('{{url("users/show")}}').then(response => {
                    this.users = response.data.users; 
                 }, error => {
                    alert(ExplainError(error));
                 });
            }
        }
    })
</script>

@endsection
