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
       $page = 1;
        if(isset($_GET['page']) && ! empty($_GET['page'])) {
            $page = $this->io->get('page');
        }

        $q = '';
        if(isset($_GET['q']) && ! empty($_GET['q'])) {
            $q = trim($this->io->get('q'));
        }

        $records_per_page = 10;

        $all = $this->UserModel->page($q, $records_per_page, $page);
        $users['all'] = $all['records'];
        $total_rows = $all['total_rows'];
        $this->pagination->set_options([
            'first_link'     => '⏮ First',
            'last_link'      => 'Last ⏭',
            'next_link'      => 'Next →',
            'prev_link'      => '← Prev',
            'page_delimiter' => '&page='
        ]);
        $this->pagination->set_theme('tailwind'); // or 'tailwind', or 'custom'
        $this->pagination->initialize($total_rows, $records_per_page, $page, site_url('show_all').'?q='.$q);
        $users['page'] = $this->pagination->paginate();
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