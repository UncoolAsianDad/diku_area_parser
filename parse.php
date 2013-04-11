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
            $area = 'D:\\thelostatlantis\\area\\olympus.are';

        $conn = mysql_connect('localhost', 'root', '');
        mysql_set_charset('utf8', $conn);
        mysql_query('use la;');

        dump_area($area);
//            mysql_query('delete from objs;');
//            mysql_query('delete from objs_affects;');

        function dump_area($area) {
            if (!file_exists($area))
                die('file does not exist');
            $fp = fopen($area, 'r');
            if ($fp == null)
                die('can not open file');

            $area = load_area($fp);
            fclose($fp);

            foreach ($area['objs'] as $obj) {
                $str = sprintf('INSERT INTO objs (
                    vnum, name, short_descr, description, action_desc, item_type,
                    extra_flags, wear_flag, weight,cost
                    )
                    VALUES (%d, "%s", "%s", "%s", "%s",  %d, %d, %d, %d, %d);', $obj->vnum, $obj->name, $obj->short_descr, $obj->description, $obj->action_desc, $obj->item_type, $obj->extra_flags, $obj->wear_flags, $obj->weight, $obj->cost
                );
                mysql_query($str) or print(mysql_error() . PHP_EOL);
                printf('inserting %s'.PHP_EOL, $obj->name);


                if (isset($obj->affected))
                    foreach ($obj->affected as $a) {
                        $str = sprintf('INSERT INTO objs_affects
                        (obj_vnum, location, modifier)
                        VALUES
                        (%d, %d, %d)
                        ', $obj->vnum, $a->location, $a->modifier
                        );
                        mysql_query($str);
                    }
            }
        }

        echo 'done';
        ?>

    </body>
</html>
