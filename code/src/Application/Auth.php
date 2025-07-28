<?php

namespace Geekbrains\Application1\Application;

class Auth {
    public static function getPasswordHash(string $rawPassword): string {
        return password_hash($rawPassword, PASSWORD_BCRYPT);
    }

    public function proceedAuth(string $login, string $password): bool{
        if (strlen($login) < 3 || strlen($login) > 50) {
            return false; // Логин: длина
        }
        if (strlen($password) < 6 || strlen($password) > 255) {
            return false; // Пароль: длина
        }
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $login)) {
            return false; // Логин: спец символы
        }

        if (empty($login) || empty($password)) {
            return false; // Логин/пароль: пустые значения
        }
        if (strpos($login, ' ') !== false || strpos($password, ' ') !== false) {
            return false; // Логин/пароль: пробелы
        }
        $sql = "SELECT id_user, user_name, user_lastname, password_hash FROM users WHERE login = :login";
        $handler = Application::$storage->get()->prepare($sql);
        $handler->execute(['login' => $login]);
        $result = $handler->fetchAll();

        if(!empty($result) && password_verify($password, $result[0]['password_hash'])){
            $_SESSION['user_name'] = htmlspecialchars($result[0]['user_name'], ENT_QUOTES, 'UTF-8');
            $_SESSION['user_lastname'] = htmlspecialchars($result[0]['user_lastname'], ENT_QUOTES, 'UTF-8');
            $_SESSION['id_user'] = $result[0]['id_user'];

            return true;
        }
        else {
            return false;
        }
    }
}