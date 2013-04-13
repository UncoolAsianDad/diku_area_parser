<?php
include_once("db.php");
?>
<!doctype html>
<html lang="utf8">
    <body>
        <pre>
<?php
            if (isset($argv[1]))
                $area = $argv[1];
            else
                $area = 'D:\\thelostatlantis\\area\\area.lst';

            try {
                $pdo = new PDO(
                        'mysql:dbname=la;host=localhost;charset=utf8', 'root', null, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
                ));
            } catch (PDOException $e) {
                print_r($e);
                return;
            }

            $tables = array('obj_in_mob_equip', 'obj_in_obj', 'obj_in_room', 'mob_in_room', 'mob', 'object', 'object_affects', 'object_ed', 'resets', 'room', 'room_exits');
            foreach ($tables as $table) {
                $stmt = $pdo->prepare('delete from ' . $table);
                $stmt->execute() or die(print_r($stmt->errorInfo(), true));
            }

            $dir = dirname($area) . '\\';
//            dump_area($dir . 'air.are'); return;

            $areas = file($area);
            foreach ($areas as $area_file) {
                $area_file = trim($area_file);
                var_dump($area_file);

                if (preg_match('/\w*\.are/', $area_file))
                    dump_area($dir . $area_file);
            }

            echo 'done';
            ?>
        </pre>
    </body>
</html>
