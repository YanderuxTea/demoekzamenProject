<?php
session_start();
if (empty($_SESSION)) {
    header('Location: index.php');
    exit;
}
if ($_SESSION['user_role'] !== 'user') {
    header('Location: index.php');
    exit;
}
require_once 'db.php';
if (isset($_POST['createRqButton'])) {
    $error = '';
    $course = $_POST['course'];
    $dateEducation = $_POST['dateEducation'];
    $fullDateTime = $dateEducation . ' 00:00:00';
    $userId = $_SESSION['user_id'];
    if (empty($course) || empty($dateEducation) || empty($userId)) {
        $error = 'Произошла ошибка';
    }
    $stmt = $conn->prepare('INSERT INTO orders (course, dateEducation, user_id) VALUES (?,?,?)');
    $stmt->bind_param('sss', $course, $fullDateTime, $userId);
    if ($stmt->execute()) {
        header('Location: orders.php');
        exit;
    } else {
        $error = 'Произошла ошибка';
    }
}
?>
<?php $page_title = 'Создание заявки';
include 'header.php';
?>
<div class="createRqPage">
    <form method="post" class="createRqForm">
        <h1>Формирование заявки</h1>
        <div class="containerFormCreateRq">
            <label for="courseId">
                Курс:
                <select name="course" required id="courseId">
                    <option value="" disabled selected hidden>Выберите курс</option>
                    <option value="algor">Основы алгоритмизации и программирования</option>
                    <option value="webdesign">Основы веб-дизайна</option>
                    <option value="db">Основы проектирования баз данных</option>
                </select>
            </label>
            <label for="dateEdu">
                Дата начала обучения:
                <input type="date" name="dateEducation" id='dateEdu' min="<?php echo date('Y-m-d'); ?>">
            </label>
        </div>
        <button type="submit" name="createRqButton" class="createRqButton">Отправить</button>
    </form>
</div>
<?php include 'footer.php'; ?>