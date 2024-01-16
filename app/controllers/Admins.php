<?php
class Admins extends Controller
{
    public function index()
    {
        if (!$_SESSION['login']) {
            header('Location: ' . BASEURL . 'login');
            exit();
        } else {
            $data['judul'] = 'Menu Admin - Admins';
            $data['admins'] = $this->model('admins_model')->loadAdmin();
            $this->view('templates/header', $data);
            $this->view('admins/index', $data);
            $this->view('templates/footer');
        }
    }
    public function addAdmin()
    {
        if (isset($_POST['addAdmin'])) {
            $password = $_POST['password'];
            $password2 = $_POST['password2'];

            if ($password !== $password2) {
                Flasher::setFlash('Passwords do not match. ', 'Please re-enter.', 'danger');
                header('Location: ' . BASEURL . 'admins');
                exit;
            }

            $emails = $this->model('admins_model')->checkEmailAdmin($_POST['email']);
            if ($emails) {
                Flasher::setFlash('email is already ', '', 'danger');
                header('Location: ' . BASEURL . 'admins');
                exit;
            }

            if ($this->model('admins_model')->addAdmin($_POST) > 0) {
                Flasher::setFlash('have successfully', 'add user', 'success');
                header('Location: ' . BASEURL . 'admins');
                exit;
            } else {
                Flasher::setFlash('Failed to', 'add user', 'danger');
                header('Location: ' . BASEURL . 'admins');
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

            if ($this->model('admins_model')->edit($_POST) > 0) {
                Flasher::setFlash('have successfully ', 'edit user', 'success');
            } else {
                Flasher::setFlash('failed to ', 'edit user', 'danger');
            }

            header('Location: ' . BASEURL . 'admins');
            exit;
        }
    }

    public function delete($params)
    {
        if ($this->model('admins_model')->delete($params) > 0) {
            Flasher::setFlash('have successfully ', 'delete', 'success');
            header('Location: ' . BASEURL . 'admins');
            exit;
        } else {
            Flasher::setFlash('failed to ', 'delete', 'danger');
            header('Location: ' . BASEURL . 'admins');
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
