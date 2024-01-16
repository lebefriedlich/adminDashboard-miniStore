<?php

class admins_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function loadAdmin()
    {
        $query = "SELECT * FROM users WHERE id_role = '1'";
        $this->db->query($query);
        return $this->db->resultSet();
    }

    public function checkEmailAdmin($email)
    {
        $query = "SELECT email FROM users WHERE email = :email AND id_role = '1'";
        $this->db->query($query);
        $this->db->bind('email', $email);
        return $this->db->single();
    }
    public function addAdmin($data)
    {
        $password = $data['password'];
        $password2 = $data['password2'];

        if ($password !== $password2) {
            Flasher::setFlash('Passwords do not match. ', 'Please re-enter.', 'danger');
            header('Location: ' . BASEURL . 'admins');
            return false;
        } else {
            $query = "INSERT INTO users
                        VALUES
                      ('', :name_user , :email, :pass, '1')";
            $this->db->query($query);
            $this->db->bind("name_user", $data['Name']);
            $this->db->bind("email", $data['email']);
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
            $this->db->bind("pass", $data['password']);
            $this->db->execute();
            return $this->db->Rowcount();
        }
    }

    public function edit($data)
    {
        $query = "UPDATE users
              SET name_user = :name_user, email = :email";

        if (isset($data['password']) && !empty($data['password'])) {
            $query .= ", pass = :pass";
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        $query .= " WHERE id_user = :id_user";

        $this->db->query($query);
        $this->db->bind("name_user", $data['name']);
        $this->db->bind("email", $data['email']);

        if (isset($data['password']) && !empty($data['password'])) {
            $this->db->bind("pass", $data['password']);
        }

        $this->db->bind('id_user', $data['id_user']);
        $this->db->execute();

        return $this->db->rowCount();
    }

    public function delete($params)
    {
        $query = "DELETE FROM users WHERE id_user = :id_user";
        $this->db->query($query);
        $this->db->bind("id_user", $params);
        $this->db->execute();

        return $this->db->rowCount();
    }
}