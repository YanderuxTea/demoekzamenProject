<?php
require_once 'db.php';
if (isset($_POST['registerButton'])) {
    $login = $_POST['login'];
    $mail = $_POST['mail'];
    $pass = $_POST['password'];
    $error = '';

    if (empty($login) || empty($mail) || empty($pass)) {
        $error = 'Заполните все поля';
    }
    if (strlen($login) > 15 || strlen($login) < 5) {
        $error = 'Укажите корректный логин(5-15 символов)';
    }
    $hash = password_hash($pass, PASSWORD_BCRYPT);

    $stmt = $conn->prepare('INSERT INTO users (login, password, email) VALUES (?,?,?)');
    $stmt->bind_param('sss', $login, $hash, $mail);

    try {
        $stmt->execute();
        header('Location: login.php');
        exit;
    } catch (mysqli_sql_exception) {
        $error = 'Логин или почта уже используется';
    }
}
?>
<?php $page_title = "Регистрация";
include 'header.php';  ?>
<div class="registerPage">
    <form method="post" class="formRegister">
        <h1>Регистрация</h1>
        <input required name="login" maxlength="15" minlength="5" type="text" placeholder="Логин">
        <input required name="mail" type="email" placeholder="Почта">
        <input required name="password" type="password" placeholder="Пароль" autocomplete="new-password">
        <button name="registerButton" type="submit">Создать аккаунт</button>
        <p>Есть аккаунт? <a href="/login.php">Вход</a></p>
    </form>
</div>
<?php include 'footer.php'; ?>