<!DOCTYPE html>
<?php
    @session_start();
    if(!isset($_SESSION['id'])){
      header("location:../index.php");
      exit;
    }else if($_SESSION['id'] <=0){
      header("location: ../index.php");
      exit;
    }
    require_once('connect.php');
    $name = $_SESSION['name'];  
    $id = $_SESSION['id'];  
?>
<html lang="en">
   <head>
      <title>Admin Page</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
      <link rel="stylesheet" href="bootstrap/custom.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
      <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
   </head>
   <body>
    <?php
    
     include "connect.php";
     $id = $_SESSION['id'];
     $query = mysqli_query($connect,"SELECT * FROM feedback WHERE sender_id = '$id'");  
     $rows = mysqli_num_rows($query);
    ?>
      <nav class="navbar navbar-default navbar-fixed-top">
         <div class="container">
            <div class="navbar-header">
               <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               </button>
               <a class="navbar-brand" href="#"><span class="glyphicon glyphicon-home"></span>Welcome, <?php echo $name?>  </a>				
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
               <ul class="nav navbar-nav navbar-right">
                  <li>
                     <a href="bookings.php" class="active"> Bookings</a>
                  </li>
                  <li>
                     <a href="feedback.php"> Feedback</a>
                  </li>
               </ul>
            </div>
         </div>
      </nav>
      <br><br><br><br>
      <div class="container mt-3" > 
      <span class="float-right"><button class="btn btn-success" onclick="payModal()">New Feedback</button></span>
      
        
		<table class="table table-striped">
			<thead>
				<tr>				
				<th scope="col">ID</th>        
            <th scope="col">Message</th>                
            <th scope="col">Date</th>
            
				</tr>
			</thead>
			<tbody>
            <?php
                                       
               while($rs = mysqli_fetch_array($query)){
                  echo "
                  <tr>                  
                  <td>$rs[0]</td>
                  <td>$rs[4]</td>
                  <td>$rs[5]</td>                              
                  </tr>
                  ";
               }

            ?>
				
			</tbody>
		</table>
		</div>
      <footer class="container-fluid text-center">
         <a href="#signUpPage" title="To Top">
         <span class="glyphicon glyphicon-chevron-up"></span>
         </a>
         <!-- <p>Vaccine Distribution</p> -->
      </footer>
      <div class="modal" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
               <div class="modal-header">
                     <h5 class="modal-title">Create New Booking!!!</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                     <span aria-hidden="true">&times;</span>
                     </button>
               </div>
               <div class="modal-body">
                  <div class="form-group">               
                     <label class="control-label">Enter Your  Phone </label>                        
                     <input type="text" class="form-control" id="phone">                   
                  </div>
                  <div class="form-group">               
                     <label class="control-label">Enter Your  Email </label>                        
                     <input type="text" class="form-control" id="email">                   
                  </div>
                  <div class="form-group">               
                        <label class="control-label">Enter Your feedback  </label>                        
                        <textarea  cols="30" rows="5" id="msg" class="form-control">

                        </textarea>                            
                  </div>
                  <button class="btn btn-success" onclick="sendMsg()" >SEND!!</button>                               
               </div>
            </div>
         </div>
      </div>
   </body>
   <script src="bootstrap/jquery.js"></script>
   <script>
       function payModal(id){
         $('#exampleModal1').fadeIn();
         // $('#bid').text(id);
      }
      
      function sendMsg(){
         var msg = $('#msg').val();
         var phone = $('#phone').val();
         var email = $('#email').val();
         if(msg.length >3){           
            var formdata = new FormData();
			   formdata.append('stage',"send_msg");
            formdata.append('msg',msg);
            formdata.append('email',email);
            formdata.append('phone',phone);
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
                                     
                    alert(data);
                },
                error: function() {
                    // Fail message
                    alert("Error Has occured");
                   
                },
            });
            
         }else{
            $('#alert_pay').fadeIn();
            $('#alert_pay').text("Please enter the correct phone number");
            $('#alert_pay').addClass("alert-danger");
         }
         
      }

       
   </script>
</html>