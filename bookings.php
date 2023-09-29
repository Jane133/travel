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
      <title>Booking Page</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
      <link rel="stylesheet" href="bootstrap/custom.css">
      <link href="font-awesome-4.2.0/css/font-awesome.min.css" rel="stylesheet" />
      <style>
         .modal{
           
         }
        .modal .modal-body {
          height : 80% !important;
          overflow-y: scroll;
         }
         .loader {
         width: 48px;
         height: 48px;
         border: 5px solid #FFF;
         border-bottom-color: transparent;
         border-radius: 50%;
         display: inline-block;
         box-sizing: border-box;
         animation: rotation 1s linear infinite;
         }
      </style>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
      <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
   </head>
   <body>
    <?php
     include "connect.php";
     $query = mysqli_query($connect,"SELECT * FROM bookings WHERE userId = '$id'");  
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
               <a class="navbar-brand" href="homepage.html"><span class="glyphicon glyphicon-home"></span> Welcome, <?php echo $name?> </a>				
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
      <span class="float-right"><button class="btn btn-success" onclick="openModel()">New Booking</button></span>
        <p id="bid"></p>
      
        <br><hr>
		<table class="table table-striped">
			<thead>
				<tr>				
				<th scope="col">ID</th>
				<th scope="col">Company</th>				
            <!-- <th scope="col">Vehicle Plate</th>             -->
            <th scope="col">Departure</th>
            <th scope="col">Destination</th>
            <th scope="col">Cost</th>
            <th scope="col">Date</th>
            <th scope="col">Status</th>
            <th scope="col">Control</th>
				</tr>
			</thead>
			<tbody>
            <?php
                                       
               while($rs = mysqli_fetch_array($query)){
                  if($rs[13]==0){
                     $s = "<p style=\"color:maroon\">Payment Pending</p>";
                     $b = "<button class=\"btn btn-success\" onclick=\"payModal($rs[0])\">Pay</button>";
                  }elseif($rs[13]==1){
                     $s = "<p style=\"color:green\">PAID</p>";
                     $b = "<button class=\"btn btn-danger\" onclick=\"cancel($rs[0])\">Cancel</button>";
                  }elseif($rs[13]==2){
                     $s = "<p style=\"color:red\">CANCELED</p>";
                     $b = "";
                  }
                  echo "
                  <tr>                  
                  <td>$rs[0]</td>
                  <td>$rs[7]</td>
                  <td>$rs[3]</td>
                  <td>$rs[4]</td>
                  <td>$rs[5]</td>
                  <td>$rs[6]</td>
                  <td>$s</td>
                  <td>$b</td>
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
                        <label class="control-label">Enter Paying Phone </label>
                        <input type="text" class="form-control input-lg" id="phonee" value="">                            
                  </div>
                  <div class="alert alert-info" style="display:none" id="alert_pay">Simulating Mpesa Payment <i class="fa fa-spinner fa-spin"></i></div>
                  <button class="btn btn-success" onclick="simulatePay()" >PAY!!</button>                               
               </div>
            </div>
         </div>
      </div>
      <div class="modal bd-example-modal-lg" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                  <h5 class="modal-title">Create New Booking!!!</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeModal()">
                  <span aria-hidden="true">&times;</span>
                  </button>
            </div>
            <div class="modal-body">
               <p id="cstep" >1</p>
               <div class="step1">               
                  <p>Step 1</p>
                  <!-- <hr style="padding-top:-10px"> -->
                  <div class="form-group">               
                     <label class="control-label">Select Company</label>
                     <select class="form-control" id="comp">
                        <option value="">Select Option</option>
                        <option value="Metro">Metro</option>
                        <option value="Mash Poa">Mash Poa</option>
                        <option value="Tahmil Poa">Tahmil Poa</option>
                     </select>                                  
                  </div>
                  <div class="form-group">               
                     <label class="control-label">Bus Type</label>
                     <select class="form-control" id="bType">
                        <option value="">Select Option</option>
                        <option value="Express">Express</option>
                        <option value="Multi Stops">Multi Stops</option>
                     </select>                                  
                  </div>
                  <div class="form-group">               
                     <label class="control-label">Confort Type</label>
                     <select class="form-control" id="cType">
                        <option value="">Select Option</option>
                        <option value="VIP">VIP</option>
                        <option value="Normal">Normal</option>
                     </select>                                  
                  </div>
                  <div class="form-group">               
                     <label class="control-label">Select Deperture</label>
                     <select class="form-control" id="dep">
                        <option value="">Select Option</option>
                        <option value="Kisumu">Kisumu</option>
                        <option value="Nairobi">Nairobi</option>
                        <option value="Nakuru">Nakuru</option>
                        <option value="Mombasa">Mombasa</option>
                        <option value="Eldoret">Eldoret</option>
                        <option value="Naivasha">Naivasha</option>
                     </select>                                  
                  </div>
                  <div class="form-group">               
                     <label class="control-label">Select Destination</label>
                     <select class="form-control" id="des">
                        <option value="">Select Destination</option>
                        <option value="Kisumu">Kisumu</option>
                        <option value="Nairobi">Nairobi</option>
                        <option value="Nakuru">Nakuru</option>
                        <option value="Mombasa">Mombasa</option>
                        <option value="Eldoret">Eldoret</option>
                        <option value="Naivasha">Naivasha</option>
                     </select>                                    
                  </div>
                  
               </div>  
               <div class="step2"> 
                  <p>Step 2</p>
                  <div class="form-group">               
                     <label class="control-label">Children below 2 years </label>
                     <select class="form-control" id="child">
                        <option value="0">Select Option</option>
                        <option value="VIP">No</option>
                        <option value="Normal">Yes</option>
                     </select>                                  
                  </div>
                  <div class="form-group">               
                     <label class="control-label">Enter Your names </label>
                     <input type="text" class="form-control input-lg" id="names" value="">                            
                  </div>
                  <div class="form-group">               
                     <label class="control-label">Enter Your Phone </label>
                     <input type="text" class="form-control input-lg" id="phones" value="">                            
                  </div>
               </div> 
               <div class="step3">
                  <p>Step 3</p> 
                  <div class="form-group">               
                     <label class="control-label">Departure Date</label>
                     <input type="date" class="form-control input-lg" id="datee" value="">               
                  </div>                  
                  <div class="form-group">               
                     <label class="control-label">Enter Seat Number</label>
                     <input type="number" class="form-control" placeholder="Enter seat between 3 - 26" id="sNo"> 
                     <button>Available Seats</button>                       
                  </div>
                  <div class="form-group">               
                     <label class="control-label">Select Payment </label>
                     <select class="form-control" id="payment">
                        <option value="0">Select Option</option>
                        <option value="Mpesa">Mpesa</option>
                        <option value="Card">Card</option>
                     </select>                                  
                  </div>
               </div>
               <div class="float-left">
               <button class="btn btn-info" onclick="next()" id="btnNext">Next</button>
               <button class="btn btn-info" onclick="back()" id="btnBack">Back</button>
               <button class="btn btn-success" onclick="saveInfo()" id="btnsave">Save!!</button>
               </div>                   
            </div>
         </div>
      </div>

   </body>
   <script src="bootstrap/jquery.js"></script>
   <script>
      $('.step2').fadeOut();
      $('.step3').fadeOut();
      $('#btnsave').fadeOut();
      $('#btnBack').fadeOut();
      $('#cstep').fadeOut();
      function next(){
         var s = $('#cstep').text();
         s = Number(s)+1; 
         $('#cstep').text(s);      
         if(s==3){
            $('#btnsave').fadeIn();
            $('#btnNext').fadeOut();
         }

         if(s==1){
            $('.step2').fadeOut();
            $('.step1').fadeIn();
            $('.step3').fadeOut();
            $('#btnBack').fadeOut();
            $('#btnNext').fadeIn();
         }

         if(s==2){
            $('.step2').fadeIn();
            $('.step1').fadeOut();
            $('.step3').fadeOut();
            $('#btnBack').fadeIn();
         }

         if(s==3){
            $('.step2').fadeOut();
            $('.step1').fadeOut();
            $('.step3').fadeIn();
            $('#btnBack').fadeIn();
         }
      }
      function back(){
         var s = $('#cstep').text();
         s = Number(s)-1; 
         $('#cstep').text(s);      
         if(s==3){
            $('#btnsave').fadeIn();
            $('#btnNext').fadeOut();
         }

         if(s==1){
            $('.step2').fadeOut();
            $('.step1').fadeIn();
            $('.step3').fadeOut();
            $('#btnBack').fadeOut();
            $('#btnNext').fadeIn();
         }

         if(s==2){
            $('.step2').fadeIn();
            $('.step1').fadeOut();
            $('.step3').fadeOut();
            $('#btnBack').fadeIn();
         }

         if(s==3){
            $('.step2').fadeOut();
            $('.step1').fadeOut();
            $('.step3').fadeIn();
            $('#btnBack').fadeIn();
         }
      }

      function cancel(id){
         // var id = $('#bid').text();
         var formdata = new FormData();
			   formdata.append('stage',"update_booking1");
            formdata.append('id',id);
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
                    alert("Cancelled Successfully")
                   
                },
                error: function() {
                    // Fail message
                    alert("Error Has occured");
                   
                },
            });
      }

      function simulatePay(){
         var num = $('#phonee').val();
         if(num.length >9){
            $('#alert_pay').fadeIn();
            setTimeout(() => {              
               $('#alert_pay').addClass("alert-success");
            }, 2000);
            var id = $('#bid').text();  
            
            var formdata = new FormData();
			   formdata.append('stage',"update_booking");
            formdata.append('id',id);
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
                    console.log(data)
                    $('#alert_pay').text("Payment Completed!!!");
                    $('#alert_pay').addClass("alert-success");
                    setTimeout(() => {
                     $('#exampleModal1').fadeOut();
                     location.reload();
                    }, 3000);
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
      function payModal(id){
         $('#exampleModal1').fadeIn();
         $('#bid').text(id);
      }
      function openModel(){
         $('.modal').fadeIn();
      }
       function saveInfo(){          
			var comp = $("#comp").val();
         var busType = $("#bType").val();         
         var confort = $("#cType").val();
         var seat = $("#sNo").val();
         var dep = $("#dep").val();
         var des = $("#des").val();
         var phone = $("#phones").val();
         var names = $("#names").val();   
         var payment = $("#payment").val();   
         var child = $("#child").val(); 
         var datee = $("#datee").val();           
			
         
       
			if(comp.length<1 || busType.length<1 || datee.length<1 || confort.length<1 || des.length<1 || dep.length<1 ||
          seat.length<1 || phone.length<1 || names.length<1 || payment.length<1 || child.length<1){
				alert("Please Fill the fields");
				return;
			}            

			var formdata = new FormData();
			formdata.append('company',comp);
			formdata.append('busType',busType);			
         formdata.append('confort',confort);
         formdata.append('seat',seat);
         formdata.append('phone',phone);
         formdata.append('names',names);
         formdata.append('des',des);
         formdata.append('dep',dep);
         formdata.append('payment',payment);         
         formdata.append('datee',datee);
         formdata.append('child',child);         
         formdata.append('stage','booking');
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
                    console.log(data)
                    alert(data);
                },
                error: function() {
                    // Fail message
                    alert("Error Has occured");
                   
                },
            });
      }

      function delete_booking(id){
            var formdata = new FormData();			
			formdata.append('id',id);           
            formdata.append('stage','booking_delete');
            $.ajax({
                url: "crad.php",
                dataType:"text",
                type: "POST",
                data: formdata,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {                 
                    alert(data);
                },
                error: function() {
                   alert("Error Occured while remove record");
                },
            })
         }
   </script>
</html>