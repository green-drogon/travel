<?php
require_once('../config/config.php');
session_start();

if( isset($_POST['verify']) ){
        
        try {
            $mobile = isset($_SESSION['mobile']) ? $_SESSION['mobile'] : '';
            $opt = trim(filter_input(INPUT_POST, 'opt', FILTER_SANITIZE_SPECIAL_CHARS));
    
    
            $errors = [];
    
            if (empty($opt)) {
                $errors[] = "verify code is required.";
            }
    
            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                header('Location: ../opt.php');
                exit();
            }   
    
            $query = "SELECT opt FROM opt WHERE  mobile = :mobile ORDER BY created_at DESC LIMIT 1";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(":mobile", $mobile);
            $stmt->execute();
    

            $savedopt = $stmt->fetch(PDO::FETCH_ASSOC);
        
            
    
            if ($opt == $savedopt['opt'] ) {
                $query = "SELECT * FROM users WHERE (mobile = :mobile)";
                $stmt = $conn->prepare($query);
                $stmt->bindvalue(":mobile",$mobile);   
                $stmt->execute();    
                

                $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);
               if ($existingUser){
                header('Location: ../homepage.php');
                exit();
               } else {
                $name = $_SESSION['name'];
                $password = $_SESSION['password'];
                $query = "INSERT INTO users (name, password, mobile) VALUES (:name, :password, :mobile)";
                $stmt = $conn->prepare($query);
                $stmt->bindvalue(":name",$name);
                $stmt->bindvalue(":password",password_hash($password, PASSWORD_BCRYPT));
                $stmt->bindvalue(":mobile",$mobile);
                $stmt->execute();
                header('Location: ../homepage.php');
                exit();
               }
            } else {
                $_SESSION['errors'] = ["Incorrect correct code."];
                header('Location: ../signin-by-password.php');
                exit();
            }
            
    
        } catch(PDOException $e){
            echo "Your error massage is ". $e->getMessage();
        }
    
    }
    ?>