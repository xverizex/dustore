<?php
class User
{
    private $db;
    private $table = 'users';

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    public function getUserById($id)
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id = :id LIMIT 1';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUsername($id)
    {
        $query = 'SELECT telegram_username FROM ' . $this->table . ' WHERE telegram_id = :id LIMIT 1';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['telegram_username'] : null;
    }


    // 19.05.2025: DEPRECATED

    // TODO: сделать для возможности изменения юзернейма
    // public function updateUsername($data, )
    // {
    //     $query = 'UPDATE ' . $this->table . ' SET username = :username WHERE id = :id';
    //     $stmt = $this->db->prepare($query);
    //     $stmt->bindParam(':username', $newUsername);
    //     $stmt->bindParam(':id', $id);

    //     return $stmt->execute();
    // }

    // public function createUser($username, $email, $password)
    // {
    //     $query = 'INSERT INTO ' . $this->table . ' (username, email, password) VALUES (:username, :email, :password)';
    //     $stmt = $this->db->prepare($query);
    //     $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    //     $stmt->bindParam(':username', $username);
    //     $stmt->bindParam(':email', $email);
    //     $stmt->bindParam(':password', $hashedPassword);

    //     return $stmt->execute();
    // }

    // public function userExists($username)
    // {
    //     $query = 'SELECT id FROM ' . $this->table . ' WHERE username = :username LIMIT 1';
    //     $stmt = $this->db->prepare($query);
    //     $stmt->bindParam(':username', $username);
    //     $stmt->execute();

    //     return $stmt->rowCount() > 0;
    // }


    // public function auth($user, $username){
    //     session_start();
    //     $_SESSION['user_id'] = $user['id'];
    //     $_SESSION['username'] = $username;
    // }


    // 19.05.2025 (c) Alexander Livanov
    // Function to get user privileges
    public function getUserPrivileges($id){
        // TODO: get usernames from DB
        $creators = ['7107471254'];
        $moders = [];
        $admins = [];

        if(in_array($id, $creators, true)){
            return -1;
        }else if(in_array($id, $moders, true)){
            return 1;
        }else if(in_array($id, $admins, true)){
            return 2;
        }else{
            return 0;
        }
    }

    public function printUserPrivileges($id){
        $priv = $this->getUserPrivileges($id);
        switch($priv){
            case -1:
                echo "Создатель";
                break;
            case 0:
                echo "Пользователь";
                break;
            case 1:
                echo "Модератор";
                break;
            case 2:
                echo "Администратор";
            default:
                echo "Неверный идентификатор";
        }
    }
}