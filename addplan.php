<?php
    $plan = $_POST["plan"];
    $gettime = $_POST["endtime"];

    $dsn = "mysql:host=127.0.0.1;dbname=countdown;charset=utf8";
    $user = "planner";
    $password = "password";

    if(!preg_match("/^[0-9]+$/", $gettime) || $gettime < 0) {
        header("Location: countdown.php?error=IT'S A BAD REQUEST!!");
        exit();
    }

    $endtime = date("Y-m-d", strtotime($gettime . " day"));

    try {
        $db = new PDO($dsn, $user, $password);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $stmt = $db->prepare(
            "INSERT INTO plans (plan, date)
                VALUES (:plan, :endtime)"
        );
        $stmt->bindParam(":plan", $plan, PDO::PARAM_STR);
        $stmt->bindParam(":endtime", $endtime, PDO::PARAM_STR);
        $stmt->execute();

        header("Location: countdown.php");
        exit();
    } catch(PDOException $e) {
        die("エラー:" . $e->getMessage());
    }
?>