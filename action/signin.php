<?php
require_once('../config/config.php');
include 'sendopt.php';
session_start();

if( isset($_POST['signin']) ){
        
    try {
        $mobile = trim(filter_input(INPUT_POST, 'mobile', FILTER_SANITIZE_SPECIAL_CHARS));


        $errors = [];
        if (empty($mobile)) {
            $errors[] = "Mobile number is required.";
        } elseif (!preg_match('/^09[0-9]{9}$/', $mobile)) {
            $errors[] = "Invalid mobile number format.";
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: ../signin.php');
            exit();
        }


        $query = "SELECT mobile FROM users WHERE  mobile = :mobile LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(":mobile", $mobile);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        

        if ($user) {
            $status = otpsender($mobile,$conn);
            $_SESSION['mobile'] = $mobile;
            if ($status === 200 ) {
                header('Location: ../opt.php');
                exit();
            } else {
                $_SESSION['errors'] = ["Failed to send OTP. Please try again."];
                header('Location: ../signin.php');
                exit();
            }
        } else{
            $_SESSION['errors'] = ["Mobile number not registered."];
            header('Location: ../signin.php');
            exit();
        }
        

    } catch(PDOException $e){
        echo "Your error massage is ". $e->getMessage();
    }

}
?>