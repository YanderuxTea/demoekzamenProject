<?php
session_start();
require_once 'db.php';
if (empty($_SESSION)) {
    header('Location: index.php');
    exit;
}
if ($_SESSION['user_role'] !== 'user') {
    header('Location: index.php');
    exit;
}
if (isset($_POST['submitFeedbackButton'])) {
    $error = '';
    $orderId = $_POST['orderId'];
    $text = $_POST['feedbackText'];
    $stmt = $conn->prepare('UPDATE orders SET feedback=? WHERE id=?');
    $stmt->bind_param('ss', $text, $orderId);
    if ($stmt->execute()) {
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}
$orders = [];
$userId = $_SESSION['user_id'];
$stmt = $conn->prepare('SELECT id, course, status, createdAt, dateEducation, feedback FROM orders WHERE user_id=? ORDER BY createdAt DESC');
$stmt->bind_param('s', $userId);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}
?>
<?php $page_title = "Заявки";
include 'header.php'; ?>

<div class="ordersPage">
    <div class="ordersDiv">
        <h1>Заявки</h1>
        <div class="ordersContainer">
            <?php
            if (empty($orders)):
            ?>
                <p>Заявок нет</p>
            <?php else: ?>
                <?php foreach ($orders as $order): ?>
                    <div class="cardOrder">
                        <h3>Курс: <?php $courseNames = ['algor' => 'Основы алгоритмизации и программирования', 'webdesign' => 'Основы веб-дизайна', 'db' => 'Основы проектирования баз данных'];
                                    echo htmlspecialchars($courseNames[$order['course']]);
                                    ?></h3>
                        <p>Дата обращения: <?php echo htmlspecialchars(date('d.m.Y.H.i', strtotime($order['createdAt'])));  ?></p>
                        <p>Дата начала обучения: <?php echo htmlspecialchars(date('d.m.Y', strtotime($order['dateEducation']))) ?></p>
                        <p>Статус: <?php $statusNames = ['pending' => 'На рассмотрении', 'rejected' => 'Отклонено', 'training' => 'В процессе обучения', 'completed' => 'Завершено'];
                                    echo htmlspecialchars($statusNames[$order['status']]) ?></p>
                        <?php if (!empty($order['feedback'])): ?>
                            <p>Отзыв: <?php echo htmlspecialchars($order['feedback']) ?></p>
                        <?php endif; ?>
                        <?php if (empty($order['feedback']) && $order['status'] === 'completed'): ?>
                            <form method="post" class="feedbackForm">
                                <input required type="hidden" name="orderId" value="<?php echo $order['id'] ?>">
                                <textarea required name="feedbackText" required placeholder="Напишите отзыв"></textarea>
                                <button type="submit" class="submitFeedbackButton" name="submitFeedbackButton">Отправить</button>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>