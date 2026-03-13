<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// echo '<pre>';
// print_r($_SESSION); // Это покажет все данные сессии
// echo '</pre>';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/media/image02.jpg" type="image/x-icon">
    <link rel="stylesheet" href="styles.css">
    <title><?php echo isset($page_title) ? $page_title : "Дэмоэкзамен"; ?></title>
    <?php if (isset($page_script)): ?>
        <script src="<?php echo $page_script; ?>"></script>
    <?php endif; ?>
    <?php if (isset($error)): ?>
        <script>
            alert('<?php echo addslashes($error); ?>')
        </script>
    <?php endif; ?>
</head>

<body>
    <header>
        <div class="containerHeader">
            <a href="/" class='logo'>EduPlus</a>
            <nav>
                <?php if (empty($_SESSION)): ?>
                    <a href="/login.php" class="loginNav">Вход</a>
                    <a href="/register.php" class="registerNav">Регистрация</a>
                <?php endif; ?>
                <?php if (!empty($_SESSION)): ?>
                    <?php if ($_SESSION['user_role'] === 'user'): ?>
                        <a href="/create-requests.php" class="requestsCreateNav">Создать заявку</a>
                        <a href="/orders.php" class="ordersNav">Заявки</a>
                    <?php endif; ?>
                    <?php if ($_SESSION['user_role'] === 'admin'): ?>
                        <a href="/admin.php" class="adminNav">Админ панель</a>
                    <?php endif; ?>
                    <a href="/logout.php" class="logoutNav">Выйти</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
    <main>