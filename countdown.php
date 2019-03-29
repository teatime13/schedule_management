<?php
$dsn = "mysql:host=127.0.0.1;dbname=countdown;charset=utf8";
$user = "planner";
$password = "password";

try {
    $db = new PDO($dsn, $user, $password);
    $stmt = $db->prepare(
        "SELECT * FROM plans WHERE date > DATE_SUB(NOW(), INTERVAL 1 DAY) ORDER BY date DESC"
    );
    $stmt->execute();
} catch (PDOExeption $e) {
    echo "error:" . $e->getMessage();
}
?>

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html charset=UTF-8">
    <title>カウントダウン</title>
</head>

<body>
    <h1>カウントダウン</h1>
    <p><a href="index.php">トップページへ戻る</a></p>
    <h2>予定追加</h2>
    <form action="addplan.php" method="POST">
        <p>予定：<input type="text" name="plan"></p>
        <p>期限：<input type="text" name="endtime">日後</p>
        <p><input type="submit" value="追加"></p>
        <?php if (isset($_GET["error"])) {
            $error = nl2br(htmlspecialchars($_GET["error"], ENT_QUOTES, "UTF-8"), false);
            echo ("<p style='color:#f00'>" . $error . "</p>");
        } ?>
    </form>
    <h2>予定一覧</h2>
    <?php
    while ($row = $stmt->fetch()) :
        $title = nl2br(htmlspecialchars($row["plan"], ENT_QUOTES, "UTF-8"), false);
        $endtime = $row["date"];
        ?>
    <p>予定:<?php echo $title ?></p>
    <p>期限:<?php echo $endtime ?></p>
    <?php endwhile; ?>
</body>

</html> 