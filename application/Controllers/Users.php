<?php

class Users
{

    static public function index()
    {
        $view = new View();
        $content = $view->generate_html('Users/login.php', []);
        echo $view->generate_html('wrapper.php', ['title' => 'Login', 'content' => $content]);
    }

    static public function registration()
    {
        $view = new View();
        $content = $view->generate_html('Users/registration.php', []);
        echo $view->generate_html('wrapper.php', ['title' => 'Registration', 'content' => $content]);
    }

    static public function logout()
    {
        $_SESSION['loggedIn'] = false;
        return response(array('status' => 'success', 'message' => 'Logged out'));
    }

    static public function create($inputs)
    {
        $user = new User();
        $data = array();
        $encrypred_pass = md5($inputs['password']);
        array_push($data, null);//add null value for id
        array_push($data, $inputs['username']);
        array_push($data, $encrypred_pass);
        array_push($data, $inputs['name']);
        if ($user->find('username', $inputs['username'])) {
            return response(array('status' => 'danger', 'message' => 'Username already exist'));
        }
        $user->insert($data);
        return response(array('status' => 'success', 'message' => 'User created'));
    }

    static public function login($inputs)
    {
        $user = new User();
        $_SESSION['loggedIn'] = false;
        $data = $user->find('username', $inputs['username']);


        $encrypred_pass = md5($inputs['password']);

        if ($data) {
            $user_data = $data[0];
            if ($user_data['username'] == $inputs['username'] && $user_data['password'] == $encrypred_pass) {
                $_SESSION['loggedIn'] = true;
                $_SESSION['username'] = $user_data['username'];
                $_SESSION['name'] = $user_data['name'];
            }
            else {
                return response(array('status' => 'danger', 'message' => 'Username or password incorrect'));
            }
        }
        return response(array('status' => 'success', 'message' => 'Logged'));
    }
}