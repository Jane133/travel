<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" type="text/css" href="custom.css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!------ Include the above in your HEAD tag ---------->

<div class="wrapper fadeInDown">
  <div id="formContent">
    <!-- Tabs Titles -->

    <!-- Icon -->
    <div class="fadeIn first">
      <!-- <img src="http://danielzawadzki.com/codepen/01/icon.svg" id="icon" alt="User Icon" /> -->
    </div>

    <!-- Login Form -->
    <form action="#">
      <input type="text" class="fadeIn second" id="username" placeholder="Email ">
      <input type="text"  class="fadeIn third" id="password" placeholder="password">
      <input  class=" btn  btn-info fadeIn fourth" value="Log In" onclick="login()">
    </form>

    <!-- Remind Passowrd -->
    <div id="formFooter">
      <!-- <a class="underlineHover" href="#">Forgot Password?</a> -->
    </div>

  </div>
</div>

<script type="text/javascript">
   function login(){          
      var email = $("#username").val();
      var password = $("#password").val();          

      var formdata = new FormData();
      formdata.append('email',email);
      formdata.append('password',password);      
      formdata.append('stage','auth');
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

              if(data==1){
                window.location.href = "admin.php";
              }else{
                alert("Incorect Login detail");
              }             
          },
          error: function() {
              // Fail message
              alert("Error..");
          },
      })
   }
</script>