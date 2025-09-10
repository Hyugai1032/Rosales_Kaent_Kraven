<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * Controller: UserController
 * 
 * Automatically generated via CLI.
 */
class UserController extends Controller {
    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        $this->call->view('welcome_page');
    }

    function show_all(){
        $users = $this->UserModel->order_by('id', 'ASC');
        return $this->call->view('show_all', ['users' => $users]);
    }

    function add_record(){
        $this->call->view('add_record');
    }

    function add_data(){
        $data = [
            'first_name' => $this->io->post('first_name'),
            'last_name' => $this->io->post('last_name'),
            'email' => $this->io->post('email')
        ];

        $this->UserModel->insert($data);
        redirect('show_all');
    }

    function update_data(){
        $id = $this->io->post('id');
        $data = [
            'first_name' => $this->io->post('first_name'),
            'last_name' => $this->io->post('last_name'),
            'email' => $this->io->post('email')
        ];

        $this->UserModel->update($id, $data);
        redirect('show_all');
    }

    function update_record($id){
        $record = $this->UserModel->find($id);
        return $this->call->view('update_record', ['record' => $record]);
    }

    function delete_record($id){
        $this->UserModel->delete($id);

        redirect('show_all');
    }
}