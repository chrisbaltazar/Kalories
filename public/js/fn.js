function ExplainError(error){
    console.log(error);
    var e = "Ups: ";
    if(error.body.errors){
//        console.log("1");
        $.each(error.body.errors, function(key, value){
//            console.log("EACH" + value);
            e+= value[0]; // only return the first error to start
        });
    }else if(error.body.message){
//        console.log("2");
        e += error.body.message; // some error from server
    }else{
        e += "something went wrong"; // Something else wrong 
    }
    return e;
}