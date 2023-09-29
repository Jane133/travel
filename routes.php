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
     $query = mysqli_query($connect,"SELECT * FROM routes");  
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
               <a class="navbar-brand" href="#><span class="glyphicon glyphicon-home"></span> ADMINISTRATOR </a>				
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav navbar-right">
                  <li>
                     <a  href="clients.php" > Clients</a>
                  </li>                 
                  <li>
                     <a href="buses.php" > Buses</a>
                  </li>
                  <li>
                     <a href="routes.php" class="active"> Routes</a>
                  </li>
                  <li>
                     <a href="bookings.php"> Bookings</a>
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
      <h3>New Route </h3>       

        <div class="form">
        <div class="form-row">           
            <div class="form-group col-md-4">
            <label for="inputCity">Departure</label>
            <input type="text" class="form-control" id="start">
            </div>
            <div class="form-group col-md-4">
            <label for="inputCity">Destination</label>
            <input type="text" class="form-control" id="end">
            </div>
            <div class="form-group col-md-4">
            <label for="inputZip">Cost</label>
            <input type="number" class="form-control" id="cost">
            </div>
        </div>       
        <button type="submit" class="btn btn-primary" onclick="save()">Add Route</button>
        <div id="success"> </div>
        </div><br><hr>
        <h3>Available Routes <?php echo $rows;?></h3>
		<table class="table table-striped">
			<thead>
				<tr>				
				<th scope="col">ID</th>
				<th scope="col">Departure</th>
				<th scope="col">Destination</th>
                <th scope="col">Cost</th>
                <th scope="col">Date Created</th>
                <th>Control</th>
				</tr>
			</thead>
			<tbody>
            <?php
                include "connect.php";
                $query = mysqli_query($connect,"SELECT * FROM routes");                          
               while($rs = mysqli_fetch_array($query)){
                  echo "
                  <tr>                  
                  <td>$rs[0]</td>
                  <td>$rs[1]</td>
                  <td>$rs[2]</td>
                  <td>$rs[3]</td>
                  <td>$rs[4]</td>
                  <td><button class=\" form-control btn-danger\" onclick=\"delete_route(".$rs[0].")\">Delete</button></td>
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
   </body>
   <script src="bootstrap/jquery.js"></script>
   <script>
       function save(){          
			var start = $("#start").val();
            var end = $("#end").val();
            var cost = $("#cost").val();           
			
			if(start.length<1 || end.length<1 && cost.length<1){
				alert("Please Fill the fields");
				return;
			}            

			var formdata = new FormData();
			formdata.append('start',start);
			formdata.append('end',end);
			formdata.append('cost',cost);           
            formdata.append('stage','route');
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
                    $('#success').html("<div class='alert alert-success'>");
                    $('#success > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
                        .append("</button>");
                    $('#success > .alert-success')
                        .append("<strong>"+ data+" </strong>");
                    $('#success > .alert-success')
                        .append('</div>');

                    //clear all fields
                    $('#contactForm').trigger("reset");
                },
                error: function() {
                    // Fail message
                    $('#success').html("<div class='alert alert-danger'>");
                    $('#success > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
                        .append("</button>");
                    $('#success > .alert-danger').append("<strong>Sorry, it seems that my mail server is not responding...</strong> Could you please email me directly to <a href='mailto:me@example.com?Subject=Message_Me from myprogrammingblog.com'>me@example.com</a> ? Sorry for the inconvenience!");
                    $('#success > .alert-danger').append('</div>');
                    //clear all fields
                    $('#contactForm').trigger("reset");
                },
            })
         }

         function delete_route(id){
            var formdata = new FormData();			
			formdata.append('id',id);           
            formdata.append('stage','route_delete');
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