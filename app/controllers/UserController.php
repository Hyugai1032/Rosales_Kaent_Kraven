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
        $this->call->library('auth');
        $this->call->library('session');
        $this->call->database();
        $this->call->library('upload');
    }

    public function index(){
        $this->call->view('welcome_page');
    }

    function show_all(){

        if (!$this->auth->is_logged_in()) {
            redirect('auth/login');
        }

       $page = 1;
        if(isset($_GET['page']) && ! empty($_GET['page'])) {
            $page = $this->io->get('page');
        }

        $q = '';
        if(isset($_GET['q']) && ! empty($_GET['q'])) {
            $q = trim($this->io->get('q'));
        }

        $records_per_page = 10;

        $user = $this->UserModel->page($q, $records_per_page, $page);
        $data['user'] = $user['records'];
        $total_rows = $user['total_rows'];
        $this->pagination->set_options([
            'first_link'     => '<< First',
            'last_link'      => 'Last >>',
            'next_link'      => 'Next →',
            'prev_link'      => '← Prev',
            'page_delimiter' => '&page='
        ]);
        $this->pagination->set_theme('custom');

        // Custom classes for dark mode pagination
        $this->pagination->set_custom_classes([
            'ul' => 'flex space-x-2 justify-center mt-6', // flexbox, spacing, centered
            'li' => '', // li doesn’t need much styling, spacing handled by ul
            'a'  => 'px-3 py-1 rounded-md bg-gray-800 text-gray-200 hover:bg-gray-700 transition-colors duration-150',
            'active' => 'px-3 py-1 rounded-md bg-indigo-600 text-white font-semibold',
            'disabled' => 'px-3 py-1 rounded-md bg-gray-900 text-gray-500 cursor-not-allowed',
        ]);
        $this->pagination->initialize($total_rows, $records_per_page, $page, site_url('/admin/manage_users').'?q='.$q);
        $data['page'] = $this->pagination->paginate();
        return $this->call->view('show_all', $data);
    }

    function add_record(){

        if (!$this->auth->is_logged_in()) {
            redirect('auth/login');
        }

        if ($this->io->method() == 'post') {
            $username = $this->io->post('username');
            $email = $this->io->post('email');
            $password = $this->io->post('password');
            $role = $this->io->post('role') ?? 'player';

            if ($this->auth->register($username, $email, $password, $role)) {
                redirect('admin/manage_users');
            }
        }

        $this->call->view('add_record');
    }


    function update_data(){

        if (!$this->auth->is_logged_in()) {
            redirect('auth/login');
        }

        $id = $this->io->post('id');
        $data = [
            'username' => $this->io->post('username'),
            'role' => $this->io->post('role'),
            'email' => $this->io->post('email')
        ];

        $this->UserModel->update($id, $data);
        redirect('/admin/manage_users');
    }

    function update_record($id){

        if (!$this->auth->is_logged_in()) {
            redirect('auth/login');
        }

        $record = $this->UserModel->find($id);
        return $this->call->view('update_record', ['record' => $record]);
    }

    function delete_record($id){
        $this->UserModel->delete($id);

        redirect('/admin/manage_users');
    }

    public function view_profile()
    {
        if (!$this->auth->is_logged_in()) {
            redirect('auth/login');
        }
        // Assume you have session with user_id
        $userId = $this->session->userdata('user_id');

        $user = $this->UserModel->find($userId); // fetch user from DB

        $this->call->view('profile', ['user' => $user]);
    }


    public function profile()
    {

        if (!$this->auth->is_logged_in()) {
            redirect('auth/login');
        }

        $user_id = $_SESSION['user_id']; // assuming you store logged-in user ID in session
        $user = $this->db->table('users')->where('id', $user_id)->get();

        if ($this->io->method() === 'post') {
            $data = [
                'username' => $this->io->post('username'),
                'email'    => $this->io->post('email'),
            ];

            // Handle password change if provided
            if (!empty($this->io->post('password'))) {
                $data['password'] = password_hash($this->io->post('password'), PASSWORD_DEFAULT);
            }

            // Handle profile pic upload
            if (!empty($_FILES['profile_pic']['name'])) {
                $config = [
                    'upload_path'   => 'uploads/profile_pics/',
                    'allowed_types' => 'jpg|jpeg|png|gif',
                    'max_size'      => 2048, // 2MB
                    'encrypt_name'  => true, // safer filenames
                ];
                $this->upload->initialize($config);

                if ($this->upload->do_upload('profile_pic')) {
                    $upload_data = $this->upload->data();
                    $data['profile_pic'] = $upload_data['file_name'];
                } else {
                    $error = $this->upload->display_errors();
                    return $this->call->view('profile/manage', [
                        'user' => $user,
                        'error' => $error
                    ]);
                }
            }

            $this->db->table('users')->where('id', $user_id)->update($data);

            // Refresh session values if needed
            $_SESSION['username'] = $data['username'];

            redirect('/profile'); // refresh page after update
        }

        $this->call->view('profile/manage', ['user' => $user]);
    }

}