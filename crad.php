<?php
session_start();
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
    }elseif($stage =="booking"){              
        $company = $_POST['company']; 
        $btype = $_POST['busType'];        
        $confort = $_POST['confort']; 
        $seat = $_POST['seat']; 
        $phone = $_POST['phone'];  
        $names = $_POST['names'];
        $payment = $_POST['payment'];  
        $child = $_POST['child']; 
        $date = $_POST['datee']; 
        $des = $_POST['des']; 
        $dep = $_POST['dep'];       
        $userId = $_SESSION['id'];

        // echo $des." ".$dep;

        $query = mysqli_query($connect,"INSERT INTO bookings(name,phone,departure,destination,cost,dob,confort,
        company,bustype,payment,child,userId,status) 
        VALUES('$names','$phone','$dep','$des','00','$date','$confort','$company','$btype','$payment','$child','$userId',0)");
        if($query){
            echo "Client Added successfully";
        }else{
            echo mysqli_error($connect);
        }

    }elseif($stage=="update_booking"){        
        $id = $_POST['id'];  
        $facilities = array('2000', '3200', '1800','2200','1400');
        $key = array_rand($facilities);
        
        $query = mysqli_query($connect,"UPDATE bookings SET status=1,cost=$facilities[$key]  WHERE id=$id") ;
        if($query){
            echo "Update successfully";
        }else{
            echo mysqli_error($connect);
        }
    }elseif($stage=="update_booking1"){
        $id = $_POST['id'];  
        
        $query = mysqli_query($connect,"UPDATE bookings SET status=2  WHERE id=$id") ;
        if($query){
            echo "Update successfully";
        }else{
            echo mysqli_error($connect);
        }
    }elseif($stage=="send_msg"){
        $msg = trim($_POST['msg']);      
        $phone = trim($_POST['phone']);
        $email = trim($_POST['email']);
        $datee = date("jS  F Y");        
        $name = $_SESSION['name'];  
        $sender = $_SESSION['id'];         
    
        $query = mysqli_query($connect,"INSERT INTO feedback(sender,email,phone,messages,dos,sender_id) 
        VALUES('$name','$email','$phone','$msg','$datee','$sender')");
        if($query){
            echo "Feedback send successfully";
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
    }




?>