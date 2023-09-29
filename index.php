<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
  <link href="bootstrap/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="bootstrap/bootstrap-networks.css">
    <!-- <link href="bootstrap/bootstrap-responsive.css" rel="stylesheet"> -->
  
</head>
<body>

<div class="container">
  <h2>Login form</h2>
      
  <div class="form-signin" >
        <h2 class="form-signin-heading text-success">Please sign in</h2>
    <label><small>Email Address</small><br>
        <input type="text" class="form-control" placeholder="Email address" id="email" autofocus required>
    </label>
    <label><small>Password</small><br>
        <input type="password" class="form-control" placeholder="Password" id="password" required>
    </label>
        
        <p class="text-center"><button class="btn btn-primary"  onclick="login()">Sign in</button></p>
            
</div>
       
    </div>
</div>
<script src="../js/jQuery-2.1.3.min.js"></script>
<script>
    function login(){
            var email = $("#email").val();
            var password = $("#password").val();

            if(email.length<1 || password.length<1){
				alert("Please Fill the fields");
				return;
			}            

			var formdata = new FormData();		
			formdata.append('email',email);
			formdata.append('password',password);           
            formdata.append('stage','login');
                $.ajax({
                    url: "crad.php",
                    dataType:"text",
                    type: "POST",
                    data: formdata,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data) {                 
                        // Success message
                        console.log(data);
                        if(data== 1){
                            window.location.href = "buses.php";
                            
                        }else{
                            alert("Incorrect login details");
                        }
                        
                        
                     
                    },
                    error: function() {
                        // Fail message
                       alert("Error Occured");
                    },
                })
        }

</script>
</body>
</html>
