<?php


class Authentication {

    public function __construct(){
    }

    public static function authenticate($row, $toast){
        $_SESSION['USER'] = $row;
        $_SESSION['Toast'] = $toast;
    }

    public static function logout(){
        if (isset($_SESSION['USER'])){
            unset($_SESSION['USER']);
        }
    }

    public static function logged_in(){
        if (isset($_SESSION['USER'])){
            return true;
        }
        return false;
    }
}