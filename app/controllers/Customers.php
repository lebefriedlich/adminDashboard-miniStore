<?php
class Customers extends Controller
{
    public function index()
    {
        if (!$_SESSION['login']) {
            header('Location: ' . BASEURL . 'login');
            exit();
        } else {
            $data['judul'] = 'Menu Admin - Customers';
            $data['users'] = $this->model('customers_model')->loadUser();
            $this->view('templates/header', $data);
            $this->view('customers/index', $data);
            $this->view('templates/footer');
        }
    }

    public function addUser()
    {
        if (isset($_POST['addUser'])) {
            $password = $_POST['password'];
            $password2 = $_POST['password2'];

            if ($password !== $password2) {
                Flasher::setFlash('Passwords do not match. ', 'Please re-enter.', 'danger');
                header('Location: ' . BASEURL . 'customers');
                exit;
            }

            $emails = $this->model('customers_model')->checkEmailUser($_POST['email']);
            if ($emails) {
                Flasher::setFlash('email is already ', '', 'danger');
                header('Location: ' . BASEURL . 'customers');
                exit;
            }

            if ($this->model('customers_model')->addUser($_POST) > 0) {
                Flasher::setFlash('have successfully', 'add user', 'success');
                header('Location: ' . BASEURL . 'customers');
                exit;
            } else {
                Flasher::setFlash('Failed to', 'add user', 'danger');
                header('Location: ' . BASEURL . 'customers');
                exit;
            }
        }
    }
    public function edit()
    {
        if (isset($_POST['edit'])) {
            if ($_POST['password'] === $_POST['passwordOld']) {
                unset($_POST['password']);
            }

            if ($this->model('customers_model')->edit($_POST) > 0) {
                Flasher::setFlash('have successfully ', 'edit user', 'success');
            } else {
                Flasher::setFlash('failed to ', 'edit user', 'danger');
            }

            header('Location: ' . BASEURL . 'customers');
            exit;
        }
    }

    public function delete($params)
    {
        if ($this->model('customers_model')->delete($params) > 0) {
            Flasher::setFlash('have successfully ', 'delete', 'success');
            header('Location: ' . BASEURL . 'customers');
            exit;
        } else {
            Flasher::setFlash('failed to ', 'delete', 'danger');
            header('Location: ' . BASEURL . 'customers');
            exit;
        }
    }

    public function logout(){
        if($_SESSION['login']){
            session_destroy();
            header('Location: ' . BASEURL . 'login');
            exit();
        }
    }  
}
