<?php

class MainController extends BaseController {
    
    public function indexAction()
    {
        return View::make('login');
    }

    public function loginAction()
    {
        $userData = [
            'user_login' => Input::get('userLogin'),
            'password' => Input::get('userPassword')
        ];

        if(Auth::attempt($userData)) 
        {
            return Redirect::to('/dashboard');
        }
        else
        {
            return Redirect::to('/');
        }
    }

    public function logoutAction()
    {
        Auth::logout();
        return Redirect::to(URL::asset('/login'));
    }
}