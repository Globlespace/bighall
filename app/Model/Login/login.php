<?php

namespace app\Model;

class login extends Model{

    function isAlreadyExist($email){
        $query="SELECT * FROM `login` WHERE Email='$email';";
        $result=mysqli_query(Model::Connection(),$query);
         if(mysqli_num_rows($result)>0){
             $this->message="Email is Already Exist";
             $this->Code=112;
             $this->success=false;
             return true;
         }
         return false;
    }
    function Register($name,$email,$password,$ConformationCode){
        $query="INSERT INTO `login` (`Id`, `Name`, `Password`, `Email`, `Active`, `Code`) VALUES (NULL, '$name', '$password', '$email', '0', '$ConformationCode');";
        return mysqli_query(Model::Connection(),$query);
    }
    function isActvatedUser($email){
        $query="SELECT * FROM `login` WHERE Email='$email' && Active='1';";
        $result=mysqli_query(Model::Connection(),$query);
        if(mysqli_num_rows($result)>0){
            $this->message="Email is Already Activated";
            $this->Code=112;
            $this->success=false;
            return true;
        }
        return false;
    }
    function activateUser($email, $code){
        $query="UPDATE `login` SET `Active` = '1' WHERE `login`.`Email` = '$email' && Code='$code';";
        $mysqli=Model::Connection();
        $results= mysqli_query($mysqli,$query);
        if(mysqli_affected_rows($mysqli)<1){
            $this->message="Invalid Code";
            $this->Code=112;
            $this->success=false;
            return false;
        }
        $this->Code=200;
        $this->success=true;
        return true;
    }
    function resendcode($email){
        $query="SELECT * FROM `login` WHERE Email='$email';";
        $result=mysqli_query(Model::Connection(),$query);
        $row= mysqli_fetch_assoc($result);
        return $row["Code"];
    }
    function login($email,$password){
        $query="SELECT * FROM `login` WHERE Email='$email';";
        $result=mysqli_query(Model::Connection(),$query);

        $row=mysqli_fetch_assoc($result);
        if(mysqli_num_rows($result)>0 && check($password,$row["Password"])){
            return true;
        }
        $this->message="Invalid Email or Password";
        $this->Code=113;
        $this->success=false;
        return false;


    }
    function isLoggedin(){

    }


}