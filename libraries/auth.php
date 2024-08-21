<?php
    session_start();
    function isLogin(){
        if(isset($_SESSION['valid']))
        return true;
        return false;
    }
    function validUser($username, $password){
        $result = dbSelect("tbl_user", "*", "username='$username' and password=md5('" . $password . "')", "");
        $num = mysqli_num_rows($result);
        if($num == 1){
            $row = mysqli_fetch_array($result);
            $_SESSION['username'] = $username;
            $_SESSION['fullname'] = $row['fullname'];
            $_SESSION['valid'] = true;
            $_SESSION['isAdmin'] = $row['role'];
            date_default_timezone_set('Asia/Bangkok');
            $d = date("Y-m-d h:i:s a") . "";
            $data = ["lastlogin"=>"$d"];
            dbUpdate("tbl_user",$data , "username='$username'");
            return true;
        }else return false;
    }
    function logOut(){
        session_destroy();
    }
?>