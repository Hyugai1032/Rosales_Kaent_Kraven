<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * Controller: AuthController
 * 
 * Automatically generated via CLI.
 */
class AuthController extends Controller {
    public function __construct()
    {
        parent::__construct();
        $this->call->library('auth');
        $this->call->library('session');
    }

    public function register()
    {
        if ($this->io->method() == 'post') {
            $username = $this->io->post('username');
            $email = $this->io->post('email');
            $password = $this->io->post('password');
            $role = $this->io->post('role') ?? 'player';

            if ($this->auth->register($username, $email, $password, $role)) {
                redirect('auth/login');
            }
        }

        $this->call->view('auth/register');
    }

    public function login()
    {
        
        if ($this->io->method() == 'post') {
            $username = $this->io->post('username');
            $password = $this->io->post('password');

            if ($this->auth->login($username, $password)) {
                redirect('auth/dashboard');
            } else {
                echo 'Login failed!';
            }
        }

        $this->call->view('auth/login');
    }

    public function dashboard()
    {

        if (!$this->auth->is_logged_in()) {
            redirect('auth/login');
        }

        // Get the role of the logged in user
        $role = $this->session->userdata('role');
        $username = $this->auth->userdata('username'); 

        if ($role === 'admin') {
            $this->call->view('dashboard/admin', ['username' => $username]);
        } else if ($role === 'player') {
            $this->call->view('dashboard/player', ['username' => $username]);
        } else {
            // Fallback if role is unknown
            echo 'Access denied!';
            exit;
        }
    }



    public function logout()
    {
        $this->auth->logout();
        $this->session->sess_destroy();

        redirect('auth/login'); 
    }

}