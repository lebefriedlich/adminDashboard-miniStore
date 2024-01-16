<?php
class Products extends Controller
{
    public function index()
    {
        if (!$_SESSION['login']) {
            header('Location: ' . BASEURL . 'login');
            exit();
        } else {
            $data['judul'] = 'Menu Admin - Products';
            $data['products'] = $this->model('products_model')->loadProducts();
            $this->view('templates/header', $data);
            $this->view('products/index', $data);
            $this->view('templates/footer');
        }
    }

    public function addProduct()
    {
        if (isset($_POST['add'])) {
            $_POST['image'] = $_FILES['image']['name'];

            if ($this->model('products_model')->addProduct($_POST) > 0) {
                Flasher::setFlash('have successfully ', 'added product', 'success');
                header('Location: ' . BASEURL . 'products');
                exit;
            } else {
                Flasher::setFlash('failed to ', 'added product', 'danger');
                header('Location: ' . BASEURL . 'products');
                exit;
            }
        }
    }

    public function editProduct()
    {
        if (isset($_POST['edit'])) {
            if (empty($_FILES['image']['name'])) {
                unset($_POST['image']);
            }

            if ($this->model('products_model')->editProduct($_POST) > 0) {
                Flasher::setFlash('have successfully ', 'edit product', 'success');
                header('Location: ' . BASEURL . 'products');
                exit;
            } else {
                Flasher::setFlash('failed to ', 'edit product', 'danger');
                header('Location: ' . BASEURL . 'products');
                exit;
            }
        }
    }

    public function deleteProduct($params)
    {
        if ($this->model('products_model')->deleteProduct($params) > 0) {
            Flasher::setFlash('have successfully ', 'delete', 'success');
            header('Location: ' . BASEURL . 'products');
            exit;
        } else {
            Flasher::setFlash('failed to ', 'delete', 'danger');
            header('Location: ' . BASEURL . 'products');
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