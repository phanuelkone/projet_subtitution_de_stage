<?php
namespace App;

class Session {
    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function add(string $key, $data) {
        $_SESSION[$key] = $data;
    }

    public function get(string $key) {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    public function isConnected() {
        return isset($_SESSION['users']);
    }

    public function setCurrentUser(array $userData) {
        $this->add('users', $userData);
    }

    public function getCurrentUserID() {
        return $this->get('users')['id'] ?? null;
    }

    public function destroy() {
        session_unset();
        session_destroy();
    }

    public function setCookie(string $name, string $value, int $expiry, string $path = "/", string $domain = "", bool $secure = false, bool $httponly = true) {
        setcookie($name, $value, time() + $expiry, $path, $domain, $secure, $httponly);
    }


    public function getCookie(string $name) {
        return isset($_COOKIE[$name]) ? $_COOKIE[$name] : null;
    }

    public function deleteCookie(string $name, string $path = "/", string $domain = "") {
        if (isset($_COOKIE[$name])) {
            setcookie($name, "", time() - 3600, $path, $domain);
            unset($_COOKIE[$name]);
        }
    }

}
?>
