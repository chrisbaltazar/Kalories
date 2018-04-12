<template>
    <form @submit.prevent = "save">
        <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" placeholder="User name" v-model="user.name" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" placeholder="User mail" v-model="user.email" required>
        </div>
        <div class="form-group" v-if="!user.id || changePwd">
            <label>Password</label>
            <input type="password" class="form-control" placeholder="User password" v-model="user.password" required>
        </div>
        <div class="form-group" v-if="!user.id || changePwd">
            <label>Confirm</label>
            <input type="password" class="form-control" placeholder="Password confirm" v-model="user.password_confirmation" required>
        </div>
        <div class="form-group">
            <label>Type</label>
            <select class="form-control" required v-model="user.type">
                <option value="">Select</option>
                <option value="ADMIN" :selected = "user.type == 'ADMIN'">ADMIN</option>
                <option value="USER" :selected = "user.type == 'USER'">USER</option>
            </select>
        </div>
        
        <p>
            <button class="btn btn-success btn-lg">Save</button>
            <button class="btn btn-warning btn-lg" v-if="user.id && !changePwd" @click.prevent="changePwd = true">Change password</button>
        </p>
            
    </form>
</template>

<script> 
    export default {
        props: ['modalData', 'baseUrl'], 
        data() {
            return {
                user: {}, 
                changePwd: false 
            }
        }, 
        created() {
            if(this.modalData){
                this.$http.get(this.baseUrl + '/' + this.modalData + '/edit').then(response => {
                   this.user = response.data.user; 
                }, error => {
                    alert(ExplainError(error));
                });
            }
        },
        methods: {
            save() {
                if(this.modalData){
                    this.$http.put(this.baseUrl + '/' + this.modalData, this.user).then(response => {
                        alert("Updated!");
                        $('#myModal').modal('hide');
                        v.loadUsers();
                    }, error => {
                        alert(ExplainError(error));
                    });
                }else{
                    this.$http.post(this.baseUrl, this.user).then(response => {
                        alert("Saved!");
                        v.loadUsers();
                        $('#myModal').modal('hide');
                    }, error => {
                        alert(ExplainError(error));
                    });
                }
            }
        }
    }
</script> 


