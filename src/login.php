<?php
session_start();
if (!empty($_SESSION)) {
    header('Location: index.php');
    exit;
}
require_once 'db.php';
if (isset($_POST['loginButton'])) {
    $error = '';
    $login = $_POST['login'];
    $pass = $_POST['password'];
    if (empty($login) || empty($pass)) {
        $error = 'Заполните все поля';
    }
    $stmt = $conn->prepare('SELECT password, role, id FROM users WHERE login=?');
    $stmt->bind_param('s', $login);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    if ($user && password_verify($pass, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = $user['role'];
        header('Location: index.php');
        exit;
    } else {
        $error = 'Неверный логин или пароль';
    }
}
?>
<?php $page_title = "Вход";
include 'header.php'; ?>
<div class="loginPage">
    <form method="post" class="formLogin">
        <h1>Вход</h1>
        <input required maxlength="15" minlength="5" type="text" name="login" placeholder="Логин" autocomplete="login">
        <input required type="password" name="password" placeholder="Пароль" autocomplete="current-password">
        <button name="loginButton" type="submit">Войти</button>
        <p>Нет аккаунта? <a href="/register.php">Регистрация</a></p>
    </form>
</div>
<?php include 'footer.php'; ?>