<?php
class Dashboard extends Controller
{
    public function index()
    {
        if (!$_SESSION['login']) {
            header('Location: ' . BASEURL . 'login');
            exit();
        } else {
            $data['judul'] = 'Menu Admin';
            $data['sumUsers'] = $this->model('dashboard_model')->sumUsers();
            $data['sumProducts'] = $this->model('dashboard_model')->sumProducts();
            $data['sumSoldOut'] = $this->model('dashboard_model')->sumSoldOut();
            $data['carts'] = $this->model('dashboard_model')->loadCart();
            $this->view('templates/header', $data);
            $this->view('dashboard/index', $data);
            $this->view('templates/footer');
        }
    }

    public function logout()
    {
        if ($_SESSION['login']) {
            session_destroy();
            header('Location: ' . BASEURL . 'login');
            exit();
        }
    }
}
