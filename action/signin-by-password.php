<?php
require_once('../config/config.php');
session_start();

if( isset($_POST['signin-by-password']) ){
        
    try {
        $mobile = trim(filter_input(INPUT_POST, 'mobile', FILTER_SANITIZE_SPECIAL_CHARS));
        $password = trim(filter_input(INPUT_POST, 'password', FILTER_DEFAULT));


        $errors = [];

        if (empty($mobile)) {
            $errors[] = "Mobile is required.";
        }

        if (empty($password)) {
            $errors[] = "Password is required.";
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: ../signin-by-password.php');
            exit();
        }

        $query = "SELECT password FROM users WHERE  mobile = :mobile LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bindValue(":mobile", $mobile);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            header('Location: ../homepage.php');
                exit();
        } else {
            $_SESSION['errors'] = ["Incorrect password."];
            header('Location: ../signin-by-password.php');
            exit();
        }

    } catch(PDOException $e){
        echo "Your error massage is ". $e->getMessage();
    }

}
?>