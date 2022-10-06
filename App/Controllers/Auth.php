<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class Auth extends Controller
{
    public function loginView()
    {
        !empty($_SESSION['user']) && $this->redirect('/dashboard');
        $this->view('auth/login');
    }

    public function signupView()
    {
        !empty($_SESSION['user']) && $this->redirect('/dashboard');
        $this->view('auth/signup');
    }

    public function login()
    {
        $isValid = $this->validate([ 'email' => 'required|email', 'password' => 'required|min:6' ]);

        !$isValid && $this->back($this->validation_errors);
        try {
            $user = User::find($this->param('email'), 'email');
            if (!$user ) {
                throw new \Exception(json_encode([ 'email' => 'Email address doesn\'t exist' ]), 404);
            }
            if (!password_verify($this->param('password'), $user['password']) ) {
                throw new \Exception(json_encode([ 'password' => 'Incorrect password' ]), 401);
            }

            $_SESSION['user'] = $user;
            $this->redirect('/dashboard');
        } catch (\Exception $e) {
            $this->back([ 'errors' => (array) json_decode($e->getMessage()) ]);
        }
    }

    public function create()
    {
        $validated = $this->validate(
            [
            'name' => 'required|max:255',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
            ]
        );

        !$validated && $this->back([ 'errors' => $this->validation_errors ]);

        try {
            $user = User::find($this->param('email'), 'email');
            if ($user ) {
                throw new \Exception(json_encode([ 'email' => 'Email already exist' ]), 404);
            }

            $user = User::create(
                [
                'name' => $this->param('name'),
                'email' => $this->param('email'),
                'password' => password_hash($this->param('password'), PASSWORD_DEFAULT),
                ]
            );

            $_SESSION['user'] = [
            'name' => $this->param('name'),
            'email' => $this->param('email'),
            ];

            $this->redirect('/dashboard');

        } catch (\Exception $e) {
            $this->back([ 'errors' => (array) json_decode($e->getMessage()) ]);
        }
    }


    public function logout()
    {
        session_destroy();
        $this->redirect('/');
    }
}
