<?php
session_start();
require_once 'db.php';
if (empty($_SESSION)) {
    header('Location: index.php');
    exit;
}
if ($_SESSION['user_role'] !== 'admin') {
    header('Location: index.php');
    exit;
}

$orders = [];
$sort = 'DESC';
$status = '';
if (!empty($_GET['sort'])) {
    $sort = $_GET['sort'] === 'asc' ? 'ASC' : 'DESC';
}
if (!empty($_GET['status'])) {
    $status = $_GET['status'];
}
if (isset($_POST['changeStatusButton'])) {
    $newStatus = $_POST['selectStatus'];
    $orderId = $_POST['orderId'];
    $stmt = $conn->prepare('UPDATE orders SET status = ? WHERE id =? ');
    $stmt->bind_param('ss', $newStatus, $orderId);
    $stmt->execute();
}
$query = "SELECT orders.id, orders.status, orders.createdAt, orders.dateEducation, orders.feedback, orders.course, users.login FROM orders JOIN users ON orders.user_id = users.id WHERE 1=1 AND orders.status = '$status' ORDER BY orders.createdAt $sort";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}
$count = count($orders);
?>
<?php $page_title = "Админ панель";
include 'header.php'; ?>
<div class="adminPage">
    <div class="adminDiv">
        <h1>Админ панель</h1>
        <div class="sortedDiv">
            <div class="filter-links">
                <a href="?<?php echo http_build_query(array_merge($_GET, ['sort' => 'desc'])); ?>">Сначала новые</a>
                <a href="?<?php echo http_build_query(array_merge($_GET, ['sort' => 'asc'])); ?>">Сначала старые</a>
                <br />
                <a href="?<?php echo http_build_query(array_merge($_GET, ['status' => 'pending'])); ?>">Только новые</a>
                <a href="?<?php echo http_build_query(array_merge($_GET, ['status' => 'completed'])); ?>">Только завершенные</a>
                <a href="?<?php echo http_build_query(array_merge($_GET, ['status' => 'rejected'])); ?>">Только отклоненные</a>
                <a href="?<?php echo http_build_query(array_merge($_GET, ['status' => 'training'])); ?>">Только активные</a>

            </div>
        </div>
        <div class="adminContainer">
            <?php if ($count === 0): ?>
                <p>Заявок нет</p>
            <?php else: ?>
                <?php foreach ($orders as $order): ?>
                    <div class="cardOrder">
                        <h3><?php $courseNames = ['algor' => 'Основы алгоритмизации и программирования', 'webdesign' => 'Основы веб-дизайна', 'db' => 'Основы проектирования баз данных'];
                            echo htmlspecialchars($courseNames[$order['course']]);
                            ?></h3>
                        <p>Дата заявки: <?php echo htmlspecialchars(date('d.m.Y.H.i', strtotime($order['createdAt'])));  ?></p>
                        <p>Дата начала обучения: <?php echo htmlspecialchars(date('d.m.Y', strtotime($order['dateEducation']))) ?></p>
                        <p>Статус: <?php $statusNames = ['pending' => 'На рассмотрении', 'rejected' => 'Отклонено', 'training' => 'В процессе обучения', 'completed' => 'Завершено'];
                                    echo htmlspecialchars($statusNames[$order['status']]) ?></p>
                        <?php if (!empty($order['feedback'])): ?>
                            <p>Отзыв: <?php echo htmlspecialchars($order['feedback']) ?></p>
                        <?php endif; ?>
                        <form method="POST" class="feedbackForm">
                            <input type="hidden" name="orderId" value="<?php echo $order['id'] ?>">

                            <select name="selectStatus" id="selectStatus" class="selectStatus">
                                <option value="pending" <?php echo $order['status'] === 'pending' ? 'selected' : '' ?>>На рассмотрении</option>
                                <option value="rejected" <?php echo $order['status'] === 'rejected' ? 'selected' : '' ?>>Отклонено</option>
                                <option value="training" <?php echo $order['status'] === 'training' ? 'selected' : '' ?>>В процессе обучения</option>
                                <option value="completed" <?php echo $order['status'] === 'completed' ? 'selected' : '' ?>>Завершено</option>
                            </select>

                            <button type="submit" name="changeStatusButton" class="submitFeedbackButton">Изменить</button>
                        </form>

                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>