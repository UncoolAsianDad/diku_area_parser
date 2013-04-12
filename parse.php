<?php
include_once("db.php");
?>
<!doctype html>
<html lang="utf8">
    <body>
        <?php
        if (isset($argv[1]))
            $area = $argv[1];
        else
            $area = 'D:\\thelostatlantis\\area\\area.lst';

        try {
            $pdo = new PDO(
                    'mysql:dbname=la;host=localhost;charset=utf8',
                    'root',
                    null,
                    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
                    ));
        } catch (PDOException $e) {
            print_r($e);
            return;
        }

        $stmt = $pdo->prepare('delete from objs');
        $stmt->execute() or die($stmt->errorCode());

        $stmt = $pdo->prepare('delete from objs_affects');
        $stmt->execute() or die($stmt->errorCode());

        $dir = dirname($area) . '\\';
        dump_area($dir . 'mahntor.are');
        return;

        $areas = file($area);
        foreach ($areas as $area_file) {
            $area_file = trim($area_file);
            var_dump($area_file);

            if (preg_match('/\w*\.are/', $area_file))
                dump_area($dir . $area_file);
        }

        echo 'done';
        ?>

    </body>
</html>
