<?php
require_once('../config/config.php');
include 'sendopt.php';
session_start();

if( isset($_POST['signup']) ){
        
    try {
        $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS));
        $password = trim(filter_input(INPUT_POST, 'password', FILTER_DEFAULT));
        $mobile = trim(filter_input(INPUT_POST, 'mobile', FILTER_SANITIZE_SPECIAL_CHARS));


        $errors = [];

        if (empty($name)) {
            $errors[] = "Name is required.";
        }

        if (empty($password)) {
            $errors[] = "Password is required.";
        }

        if (empty($mobile)) {
            $errors[] = "Mobile number is required.";
        } elseif (!preg_match('/^09[0-9]{9}$/', $mobile)) {
            $errors[] = "Invalid mobile number format.";
        }


        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: ../signup.php');
            exit();
        }


        $query = "SELECT * FROM users WHERE (mobile = :mobile)";
        $stmt = $conn->prepare($query);
        $stmt->bindvalue(":mobile",$mobile);   
        $stmt->execute();    
        

        $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

        if($existingUser){
            $_SESSION['errors'] = ["Phone number already exists."];
            header('Location: ../signup.php');
            exit();   
        }  
        else {

            $status = otpsender($mobile,$conn);
            $_SESSION['name'] = $name;
            $_SESSION['mobile'] = $mobile;
            $_SESSION['password'] = $password;


            if ($status === 200 ) {
                header('Location: ../opt.php');
                exit();
            } else {
                $_SESSION['errors'] = ["Failed to send OTP. Please try again."];
                header('Location: ../signup.php');
                exit();
            }
        }

    } catch(PDOException $e){
        echo "Error". htmlspecialchars($e->getMessage());
    }
}
?>