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

        $conn = mysql_connect('localhost', 'root', '');
        mysql_set_charset('utf8', $conn);
        mysql_query('use la;');
        mysql_query('delete from objs;');
        mysql_query('delete from objs_affects;');

        $dir = dirname($area).'\\';
        dump_area($dir.'mahntor.are');
        return;

        $areas = file($area);
        foreach ($areas as $area_file) {
            $area_file = trim($area_file);
            var_dump($area_file);

            if (preg_match('/\w*\.are/', $area_file))
                dump_area($dir.$area_file);
        }

        echo 'done';
        ?>

    </body>
</html>
