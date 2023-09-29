<?php
include 'connect.php';
    $stage = $_POST['stage'];  

    if($stage=="bus"){
        $name = $_POST['name'];
        $capacity = $_POST['capacity'];
        $plate = $_POST['plate']; 
        $datee = date("jS  F Y");      
    
        $query = mysqli_query($connect,"INSERT INTO buses(name,plate,capacity,dor) 
        VALUES('$name','$plate','$capacity','$datee')");
        if($query){
            echo "Bus Added successfully";
        }else{
            echo mysqli_error($connect);
        }
    }elseif($stage=="bus_delete"){
        $id = $_POST['id'];  
        $query = mysqli_query($connect,"DELETE FROM buses WHERE id=$id");
        if($query){
            echo "Deleted successfully";
        }else{
            echo mysqli_error($connect);
        }
    }elseif($stage=="route"){
        $start = $_POST['start'];
        $end = $_POST['end'];
        $cost = $_POST['cost']; 
        $datee = date("jS  F Y");      
    
        $query = mysqli_query($connect,"INSERT INTO routes(start,end,price,dor) 
        VALUES('$start','$end','$cost','$datee')");
        if($query){
            echo "Route Created successfully";
        }else{
            echo mysqli_error($connect);
        }
    }elseif($stage=="route_delete"){
        $id = $_POST['id'];  
        $query = mysqli_query($connect,"DELETE FROM routes WHERE id=$id");
        if($query){
            echo "Deleted successfully";
        }else{
            echo mysqli_error($connect);
        }
    }elseif($stage=="feedback_delete"){
        $id = $_POST['id'];  
        $query = mysqli_query($connect,"DELETE FROM feedback WHERE id=$id");
        if($query){
            echo "Deleted successfully";
        }else{
            echo mysqli_error($connect);
        }
    }elseif($stage=="booking_delete"){
        $id = $_POST['id'];  
        $query = mysqli_query($connect,"DELETE FROM bookings WHERE id=$id");
        if($query){
            echo "Deleted successfully";
        }else{
            echo mysqli_error($connect);
        }
    }elseif($stage=="ro_confirm"){
        $id = $_POST['id'];  
        $query = mysqli_query($connect,"UPDATE storage SET status=2  WHERE id=$id") ;
        if($query){
            echo "Update successfully";
        }else{
            echo mysqli_error($connect);
        }
    }elseif($stage=="ho_confirm"){
        $id = $_POST['id'];  
        $query = mysqli_query($connect,"UPDATE centers SET status=2  WHERE id=$id") ;
        if($query){
            echo "Update successfully";
        }else{
            echo mysqli_error($connect);
        }
    }elseif($stage=="login"){
        $password = $_POST['password']; 
        $hash_pass = md5($password);
        
        $email = $_POST['email'];        
        $query = mysqli_query($connect, "SELECT * FROM admin where email='$email' AND password ='$hash_pass' LIMIT 1");
        $row = mysqli_num_rows($query);
        $rs = mysqli_fetch_row($query);        
        
        if($row==1){
            $_SESSION['id']=$rs[0];
            $_SESSION['name']=$rs[1];
            echo 1;
          }else{
            echo 0;
          }
    }




?>