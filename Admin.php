<!DOCTYPE html>
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
      <nav class="navbar navbar-default navbar-fixed-top">
         <div class="container">
            <div class="navbar-header">
               <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               </button>
               <a class="navbar-brand" href="homepage.html"><span class="glyphicon glyphicon-home"></span> ADMINISTRATOR </a>				
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
               <ul class="nav navbar-nav navbar-right">
                  <li>
                     <a  href="admin.php"> Clients</a>
                  </li>                 
                  <li>
                     <a href="analytics.php"> Buses</a>
                  </li>
                  <li>
                     <a href="analytics.php"> Routes</a>
                  </li>
                  <li>
                     <a href="analytics.php"> Bookings</a>
                  </li>
                  <li>
                     <a href="analytics.php"> Feedback</a>
                  </li>
               </ul>
            </div>
         </div>
      </nav>
      <br><br><br><br>
      <div class="container mt-3" >         
        <form action="#">
        <div class="form-row">            
            <div class="form-group col-md-4">
            <label for="inputState">Category</label>
            <select id="category" class="form-control">
                <option value="0">Select Category</option>
                <option value="1">Manufacturer</option>
                <option value="2">National Storage Facility</option>
                <option value="3">Regional Hospital</option>
                <option value="4">Health Center</option>
                <option value="5">Vacine Outreach</option>
                
            </select>
            </div>
            <div class="form-group col-md-4">
            <label for="inputCity">Name</label>
            <input type="text" class="form-control" id="name">
            </div>
            <div class="form-group col-md-4">
            <label for="inputZip">Email</label>
            <input type="text" class="form-control" id="email">
            </div>
        </div>       
        <button type="submit" class="btn btn-primary" onclick="save()">Create Account</button>
        <div id="success"> </div>
        </form><br><hr>
		<table class="table table-striped">
			<thead>
				<tr>				
				<th scope="col">ID</th>
				<th scope="col">Name</th>
				<th scope="col">Category</th>
                <th scope="col">Email</th>
                <th>Control</th>
				</tr>
			</thead>
			<tbody>
            <?php
                include "connect.php";
                $query = mysqli_query($connect,"SELECT * FROM accounts");                          
               while($rs = mysqli_fetch_array($query)){
                  echo "
                  <tr>                  
                  <td>$rs[0]</td>
                  <td>$rs[1]</td>
                  <td>$rs[2]</td>
                  <td>$rs[4]</td>
                  <td><button class=\" form-control btn-danger\">Delete</button></td>
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
   <script src="bootrsap/jquery.js"></script>
   <script>
       function save(){          
			var name = $("#name").val();
            var email = $("#email").val();
            var cat_id = $("#category").val();
            var cat_name = $("#category option:selected").text();
            if(cat_id <1){
                alert("Select Category");
                return
            }
			
			if(email.length<1 || name.length<1){
				alert("Please Fill the fields");
				return;
			}            

			var formdata = new FormData();
			formdata.append('name',name);
			formdata.append('email',email);
			formdata.append('cat_id',cat_id);
      formdata.append('cat_name',cat_name);
      formdata.append('stage','account');
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
                        .append("<strong>Account Created Successfull!! </strong>");
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
   </script>
</html>