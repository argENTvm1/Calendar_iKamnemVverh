<?php

namespace Controller;
use Model\User;


class UserController
{
    private User $user;

    public function __construct()
    {
        $this->user = new User();
    }
    public function getRegistrateForm()
    {
        require_once "./../View/registrate.php";
    }
    public function registrate()
    {
        $errors =$this->validate();
        if (empty($errors)) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $pass = $_POST['password'];
            $repass = $_POST['repassword'];


            $hash = password_hash($pass, PASSWORD_DEFAULT);


            $this->user->createNewUser($name, $email, $hash);
            header('Location: /login');
        }

        require_once "./../View/registrate.php";


    }



    public function login( )
    {

        $errors = $this->validate();

        if(empty($errors)) {

            $login = $_POST['login'];
            $pass = $_POST['password'];



            $data = $this->user->getByLogin($login);


            if(empty($data)){
                $errors['login'] = "Пароль или Логин неверный";

            }else{
                $pass_db = $data->getPassword() ;

                if(password_verify($pass, $pass_db)) {

                    session_start();
                    $_SESSION['user_id'] = $data->getId();
                    header('Location: /calendar');
                }
                else{
                    $errors['login'] = "Пароль или Логин неверный";

                }
            }

        }
        require_once "./../View/registrate.php";

    }
    public function validate()
    {
        $errors = [];

        if(!isset($_POST['login'])){
            $errors['login'] = "Поле email должно быть заполнено";
        }



        if(!isset($_POST['password'])) {
            $errors['password'] = "Поле password должно быть заполнено";
        }

        return $errors;
    }



}