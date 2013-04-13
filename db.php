<?php

class areadata {

    var $data;
    var $mobs;
    var $objs;
    var $rooms;
    var $specials;
    var $resets;
    var $shops;

    function __construct() {
        $this->data     = array();
        $this->mobs     = array();
        $this->objs     = array();
        $this->rooms    = array();
        $this->specials = array();
        $this->resets   = array();
        $this->shops    = array();
    }

}

function load_area($fp) {

    $area = new areadata();
    do {
        $c = fgetc($fp);
        if ($c === false)
            break;

        if ($c == '#') {

            $word = fread_word($fp);

            if ($word == '$')
                break;

            //var_dump($word);
            switch ($word) {
                case 'AREADATA':
                    $area->data     = load_areadata($fp);
                    break;
                case 'MOBILES':
                    $area->mobs     = load_mobs($fp);
                    break;
                case 'OBJECTS':
                    $area->objs     = load_objs($fp);
                    break;
                case 'ROOMS':
                    $area->rooms    = load_rooms($fp);
                    break;
                case 'SPECIALS':
                    $area->specials = load_specials($fp);
                    break;
                case 'RESETS':
                    $area->resets   = load_resets($fp);
                    break;
                case 'SHOPS':
                    $area->shops    = load_shops($fp);
                    break;
            }
        }
    } while ($c <> '$' || !feof($fp));

    return $area;
}

/**
 * Envy Diku Mud Area File parser in PHP
 * Created by Code For Art IT Consulting on Apr 13, 2013
 *
 */
// Helper Functions
function fread_letter($fp) {

    do {
        $c = fgetc($fp);
    } while (isspace($c));

    return $c;
}

function isspace($c) {

    if ($c == ' ' ||
            $c == "\t" ||
            $c == "\r" ||
            $c == "\n")
        return true;

    return false;
}

function is_number($c) {
    if ($c >= '0' && $c <= '9')
        return true;
    return false;
}

function fread_eol($fp) {
    $buf = '';
    /*
      do {
      $c = fgetc($fp);
      } while (isspace($c) && !feof($fp));
     */
    do {
        $c = fgetc($fp);
        $buf .= $c;
    } while ($c <> "\n");

    return trim($buf);
}

function fread_string($fp) {
    $buf = '';

    do {
        $c = fgetc($fp);
    } while (isspace($c));

    while ($c <> '~') {
        $buf .= $c;
        $c = fgetc($fp);
    }

    return (trim($buf));
}

function fread_word($fp) {
    $buf = '';

    do {
        $c = fgetc($fp);
    } while (isspace($c) && !feof($fp));

    while ($c <> "\n" && !isspace($c) && !feof($fp)) {
        $buf .= $c;
        $c = fgetc($fp);
    }

    return trim($buf);
}

function fread_number($fp) {
    $buf = '';

    do {
        $c = fgetc($fp);
    } while (isspace($c) && !feof($fp));

    $sign = false;
    if ($c == '+')
        $c    = fgetc($fp);
    else if ($c == '-') {
        $sign = true;
        $c    = fgetc($fp);
    }

    while (is_number($c) && !feof($fp)) {
        $buf .= $c;
        $c = fgetc($fp);
    }

    if ($sign)
        $buf = 0 - $buf;

    if ($c == '|')
        $buf += fread_number($fp);

    return (int) $buf;
}

// loading functions
function load_areadata($fp) {

    $area = new stdClass();

    do {
        $word = fread_word($fp);

        switch ($word) {
            case 'Name':
                $area->name    = fread_string($fp);
                break;
            case 'Builders':
                $area->builder = fread_string($fp);
                break;
            case 'VNUMs':
                $area->vnums[] = fread_number($fp);
                $area->vnums[] = fread_number($fp);
                break;
            case 'Recall':
                $area->recall  = fread_number($fp);
                break;
            case 'Security':
                $area->recall  = fread_number($fp);
                break;
        }
    } while ($word <> 'End');

    return $area;
}

function load_mobs($fp) {
    $mobs    = array();
    $skipped = false;
    for (;;) {
        if (!$skipped)
            $c = fread_letter($fp);

        $skipped = false;

        if ($c <> '#') {
            debug_print_backtrace();
            exit;
        }

        $vnum = fread_number($fp);
        if ($vnum == 0) {
            return $mobs;
        }

        $mob              = new stdClass();
        $mob->vnum        = $vnum;
        $mob->name        = fread_string($fp);
        $mob->short_descr = fread_string($fp);
        $mob->long_descr  = fread_string($fp);
        $mob->description = fread_string($fp);

        $mob->act         = fread_number($fp);
        $mob->affected_by = fread_number($fp);
        $mob->alignment   = fread_number($fp);
        fread_letter($fp);

        $mob->level   = fread_number($fp);
        $mob->hitroll = fread_number($fp);
        $mob->ac      = fread_number($fp);

        fread_word($fp); // two words not being used so i just ignroe it
        fread_word($fp);

        $mob->gold = fread_number($fp);
        fread_number($fp);

        fread_number($fp);
        fread_number($fp);
        fread_number($fp);

        for (;;) {
            $l = fread_letter($fp);
            if ($l == '#') {
                $skipped = true;
                break;
            }
            if ($l == 'P') {
                $mob->script = fread_eol($fp);
            }
        }

        //$mob->sex = fread_number($fp);

        $mobs[] = $mob;
    }
}

function load_objs($fp) {

    $objs    = array();
    $obj     = new stdClass();
    $skipped = false;

    for (;;) {
        if (!$skipped)
            $c = fread_letter($fp);

        $skipped = false;

        if ($c <> '#') {
            debug_print_backtrace();
            exit;
        }

        $vnum = fread_number($fp);
        if ($vnum == 0) {
            return $objs;
        }

        $obj = new stdClass();

        $obj->vnum        = $vnum;
        $obj->name        = fread_string($fp);
        $obj->short_descr = fread_string($fp);
        $obj->description = fread_string($fp);
        $obj->action_desc = fread_string($fp);

        $obj->item_type   = fread_number($fp);
        $obj->extra_flags = fread_number($fp);
        $obj->wear_flag   = fread_number($fp);
        /*
          $obj->trap_eff    = fread_number($fp);
          $obj->trap_dam    = fread_number($fp);
          $obj->trap_charge = fread_number($fp);
         */
        $obj->values[0]   = fread_string($fp);
        $obj->values[1]   = fread_string($fp);
        $obj->values[2]   = fread_string($fp);
        $obj->values[3]   = fread_string($fp);

        $obj->weight       = fread_number($fp);
        $obj->cost         = fread_number($fp);
        $obj->cost_per_day = fread_number($fp);

        for (;;) {
            $letter = fread_letter($fp);
            if ($letter == 'A') {
                $paf              = new stdClass();
                $paf->type        = -1;
                $paf->duration    = -1;
                $paf->affect_type = fread_number($fp);
                $paf->modifier    = fread_number($fp);
                $paf->bitvector   = 0;

                $obj->affected[] = $paf;
            } else if ($letter == 'E') {
                $ed              = new stdClass();
                $ed->keyword     = fread_string($fp);
                $ed->description = fread_string($fp);

                $obj->extra_desc[] = $ed;
            } else {
                $c       = $letter;
                $skipped = true;
                break;
            }
        }

        $objs[] = $obj;
    }
}

function load_rooms($fp) {
    $rooms = array();

    for (;;) {
        $letter = fread_letter($fp);

        if ($letter != '#') {
            debug_print_backtrace();
            exit;
        }

        $vnum = fread_number($fp);
        if ($vnum == 0)
            break;

        $room              = new stdClass();
        $room->vnum        = $vnum;
        $room->name        = fread_string($fp);
        $room->description = fread_string($fp);
        fread_number($fp);
        $room->room_flags  = fread_number($fp);
        $room->sector_type = fread_number($fp);
        $room->light       = 0;

        for (;;) {
            $letter = fread_letter($fp);
            if ($letter == 'S')
                break;
            if ($letter == 'D') {
                $pexit = new stdClass();
                $door  = fread_number($fp);

                $pexit->description = fread_string($fp);
                $pexit->keyword     = fread_string($fp);
                $pexit->locks       = fread_number($fp);
                $pexit->key         = fread_number($fp);
                $pexit->vnum        = fread_number($fp);
                $room->exit[$door]  = $pexit;
            }

            if ($letter == 'E') {
                $ed              = new stdClass();
                $ed->kewyrod     = fread_string($fp);
                $ed->description = fread_string($fp);

                $room->extra_desc[] = $ed;
            }
        }

        //print_r($room);
        $rooms[] = $room;
    }

    return $rooms;
}

function load_resets($fp) {

    $resets = array();

    for (;;) {
        $letter = fread_letter($fp);

        if ($letter == 'S')
            break;

        if ($letter == '*') {
            fread_eol($fp);
            continue;
        }

        $reset          = new stdClass();
        $reset->command = $letter;

        fread_number($fp);
        $reset->arg1 = fread_number($fp);
        $reset->arg2 = fread_number($fp);
        $reset->arg3 = ($letter == 'G' || $letter == 'R') ? 0 : fread_number($fp);

        fread_eol($fp);

        $resets[] = $reset;
    }

    return $resets;
}

function load_specials($fp) {
    // todo
}

function load_shops($fp) {
    // todo
}

function save_objs($objs, $pdo) {

    foreach ($objs as $obj) {
        $str = 'INSERT INTO object (
                    vnum, name, short_descr, description, item_type,
                    extra_flags, wear_flag, weight, cost,
                    v0, v1, v2, v3
                )
                VALUES (:vnum, :name, :short, :descr, :item_type,
                    :extra_flags, :wear_flag, :weight, :cost,
                    :v0, :v1, :v2, :v3
                );';

        $stmt = $pdo->prepare($str); /* @var $stmt PDOStatement */
        $stmt->bindparam(':vnum', $obj->vnum, PDO::PARAM_INT);
        $stmt->bindparam(':name', $obj->name, PDO::PARAM_STR);
        $stmt->bindparam(':short', $obj->short_descr, PDO::PARAM_STR);
        $stmt->bindparam(':descr', $obj->description, PDO::PARAM_STR);
        $stmt->bindparam(':item_type', $obj->item_type, PDO::PARAM_INT);

        $stmt->bindparam(':extra_flags', $obj->extra_flags, PDO::PARAM_INT);
        $stmt->bindparam(':wear_flag', $obj->wear_flag, PDO::PARAM_INT);
        $stmt->bindparam(':weight', $obj->weight, PDO::PARAM_INT);
        $stmt->bindparam(':cost', $obj->cost, PDO::PARAM_INT);

        $stmt->bindparam(':v0', $obj->values[0], PDO::PARAM_STR);
        $stmt->bindparam(':v1', $obj->values[1], PDO::PARAM_STR);
        $stmt->bindparam(':v2', $obj->values[2], PDO::PARAM_STR);
        $stmt->bindparam(':v3', $obj->values[3], PDO::PARAM_STR);

        $stmt->execute() or die(print_r($stmt->errorInfo(), true) . $str . print_r($obj, true));

        if (isset($obj->extra_desc))
            foreach ($obj->extra_desc as $a) {
                $stmt = $pdo->prepare('INSERT INTO object_ed
                        (obj_vnum, keyword, description)
                        VALUES
                        (:obj_vnum, :keyword, :description);');
                $stmt->bindParam('obj_vnum', $obj->vnum, PDO::PARAM_INT);
                $stmt->bindParam('keyword', $a->keyword, PDO::PARAM_STR);
                $stmt->bindParam('description', $a->description, PDO::PARAM_STR);
                $stmt->execute() or die(print_r($stmt->errorInfo(), true) . $str . print_r($obj, true));
            }

        if (isset($obj->affected))
            foreach ($obj->affected as $a) {
                $stmt = $pdo->prepare('INSERT INTO object_affects
                        (obj_vnum, flag, modifier)
                        VALUES
                        (:obj_vnum, :flag, :modifier)');
                $stmt->bindParam(':obj_vnum', $obj->vnum, PDO::PARAM_INT);
                $stmt->bindParam(':flag', $a->affect_type, PDO::PARAM_INT);
                $stmt->bindParam(':modifier', $a->modifier, PDO::PARAM_INT);

                $stmt->execute() or die(print_r($stmt->errorInfo(), true) . $str . print_r($obj, true));
            }

        printf('inserting %s' . PHP_EOL, $obj->name);
    }
}

function save_rooms($rooms, $pdo) {

    foreach ($rooms as $obj) {
        $str = 'INSERT INTO room VALUES (
            :vnum, :name, :descr,
            :flags, :sector_type, :light
        );';

        $stmt = $pdo->prepare($str); /* @var $stmt PDOStatement */
        $stmt->bindparam(':vnum', $obj->vnum, PDO::PARAM_INT);
        $stmt->bindparam(':name', $obj->name, PDO::PARAM_STR);
        $stmt->bindparam(':descr', $obj->description, PDO::PARAM_STR);

        $stmt->bindparam(':flags', $obj->room_flags, PDO::PARAM_INT);
        $stmt->bindparam(':sector_type', $obj->sector_type, PDO::PARAM_INT);
        $stmt->bindparam(':light', $obj->light, PDO::PARAM_INT);

        $stmt->execute() or die(print_r($stmt->errorInfo(), true) . $str . print_r($obj, true));

        if (isset($obj->exit))
            foreach ($obj->exit as $direction => $exit) {
                $str  = 'INSERT INTO room_exits VALUES (
                    :room_vnum, :to_room, :direction,
                    :description, :keyword, :lock_vnum
                );';
                $stmt = $pdo->prepare($str);
                $stmt->bindparam(':room_vnum', $obj->vnum, PDO::PARAM_INT);
                $stmt->bindparam(':to_room', $exit->vnum, PDO::PARAM_STR);
                $stmt->bindparam(':direction', $direction, PDO::PARAM_STR);
                $stmt->bindparam(':description', $exit->description, PDO::PARAM_STR);
                $stmt->bindparam(':keyword', $exit->keyword, PDO::PARAM_STR);
                $stmt->bindparam(':lock_vnum', $exit->locks, PDO::PARAM_STR);

                $stmt->execute() or die(print_r($stmt->errorInfo(), true) . $str . print_r($obj, true));
            }

        printf('inserting %s' . PHP_EOL, $obj->name);
    }
}

function save_mobs($mobs, $pdo) {

    foreach ($mobs as $obj) {
        $str = 'INSERT INTO mob VALUES (
            :vnum, :name, :short, :long, :descr,
            :act, :affected_by, :alignment, :level,
            :hitroll, :ac, :gold, :script
        );';

        $stmt = $pdo->prepare($str); /* @var $stmt PDOStatement */
        $stmt->bindparam(':vnum', $obj->vnum, PDO::PARAM_INT);
        $stmt->bindparam(':name', $obj->name, PDO::PARAM_STR);
        $stmt->bindparam(':short', $obj->short_descr, PDO::PARAM_STR);
        $stmt->bindparam(':long', $obj->long_descr, PDO::PARAM_STR);
        $stmt->bindparam(':descr', $obj->description, PDO::PARAM_STR);

        $stmt->bindparam(':act', $obj->act, PDO::PARAM_INT);
        $stmt->bindparam(':affected_by', $obj->affected_by, PDO::PARAM_INT);
        $stmt->bindparam(':alignment', $obj->alignment, PDO::PARAM_INT);
        $stmt->bindparam(':level', $obj->level, PDO::PARAM_INT);

        $stmt->bindparam(':hitroll', $obj->hitroll, PDO::PARAM_INT);
        $stmt->bindparam(':ac', $obj->ac, PDO::PARAM_INT);
        $stmt->bindparam(':gold', $obj->gold, PDO::PARAM_INT);
        $stmt->bindparam(':script', $obj->script, PDO::PARAM_INT);

        $stmt->execute() or die(print_r($stmt->errorInfo(), true) . $str . print_r($obj, true));

        printf('inserting %s' . PHP_EOL, $obj->name);
    }
}

function save_resets($resets, $pdo) {

    foreach ($resets as $obj) {

        if ($obj->command == 'M') {
            $tbl_name = 'mob_in_room';
            $mob      = $obj->arg1;
        } else if ($obj->command == 'O') {
            $tbl_name = 'obj_in_room';
        } else if ($obj->command == 'P') {
            $tbl_name = 'obj_in_obj';
        } else if (in_array($obj->command, array('E', 'G'))) {
            $obj->arg2 = $mob;
            $tbl_name  = 'obj_in_mob_equip';
        } else {
            $tbl_name = 'resets';
        }
        $str  = 'INSERT INTO ' . $tbl_name . ' VALUES ( :command, :arg1, :arg2, :arg3 );';
        $stmt = $pdo->prepare($str); /* @var $stmt PDOStatement */
        $stmt->bindparam(':command', $obj->command, PDO::PARAM_STR);
        $stmt->bindparam(':arg1', $obj->arg1, PDO::PARAM_INT);
        $stmt->bindparam(':arg2', $obj->arg2, PDO::PARAM_INT);
        $stmt->bindparam(':arg3', $obj->arg3, PDO::PARAM_INT);
        $stmt->execute() or die(print_r($stmt->errorInfo(), true) . $str . print_r($obj, true));

//        printf('inserting %s' . PHP_EOL, $obj->name);
    }
}

function dump_area($area) {
    global $pdo; // @var $pdo PDO

    if (!file_exists($area)) {
        echo $area . ' file does not exist';
        return;
    }
    $fp = fopen($area, 'r');
    if ($fp == null)
        die('can not open file');

    $area = load_area($fp);
    save_mobs($area->mobs, $pdo);
    save_objs($area->objs, $pdo);
    save_rooms($area->rooms, $pdo);
    save_resets($area->resets, $pdo);

    fclose($fp);
}