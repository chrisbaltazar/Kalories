@extends ('base')

@section ('style')

<style type="text/css">
    #login {
        margin-top: 100px;
        border: 2px solid black; 
        border-radius: 10px;
        padding: 10px; 
        -webkit-box-shadow: 3px 5px 39px 16px rgba(48,43,48,0.55);
        -moz-box-shadow: 3px 5px 39px 16px rgba(48,43,48,0.55);
        box-shadow: 3px 5px 39px 16px rgba(48,43,48,0.55);
        background-color: #6699ff;
        color: white;
    }
</style>

@endsection

@section ('content')

<form id ="login" method ="post" action ="{{url('login')}}">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-6 offset-3">
            <h2 class="text-center"><span class="badge badge-pill badge-dark">Kalories application</span></h2>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-6 offset-3">
            <form>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" name ="username" placeholder="use your email" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" name ="password" placeholder="enter your password" required>
                </div>
                <button class="btn btn-dark btn-lg">Login</button>
            </form>
        </div>
    </div>
</form>
    

@endsection 

@section ('script')

<script>
    
    var v = new Vue({
        el: '#login'
    })
    
</script>

@endsection 
