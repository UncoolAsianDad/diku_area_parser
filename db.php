<?php

function load_area($fp) {

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
                    $areadata = load_areadata($fp);
                    break;
                case 'MOBILES':
                    $mobs     = load_mobs($fp);
                    break;
                case 'OBJECTS':
                    $objs     = load_objs($fp);
                    break;
                case 'ROOMS':
                    $rooms    = load_rooms($fp);
                    break;
                case 'SPECIALS':
                    $specials = load_specials($fp);
                    break;
                case 'RESETS':
                    $resets   = load_resets($fp);
                    break;
                case 'SHOPS':
                    $shops    = load_shops($fp);
                    break;
            }
        }
    } while ($c <> '$' || !feof($fp));

    $area          = array();
    $area['objs']  = $objs;
    $area['mobs']  = $mobs;
    $area['rooms'] = $rooms;

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

    do {
        $c = fgetc($fp);
    } while (isspace($c) && !feof($fp));

    while ($c <> "\n" && $fp) {
        $buf .= $c;
        $c = fgetc($fp);
    }

    return $buf;
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
    $mobs = array();
    $skipped = false;
    for (;;) {
        if ( !$skipped )
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
        $mob->player_name = fread_string($fp);
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
        $obj->wear_flags  = fread_number($fp);
        /*
          $obj->trap_eff    = fread_number($fp);
          $obj->trap_dam    = fread_number($fp);
          $obj->trap_charge = fread_number($fp);
         */
        $line             = str_replace('~', '', fread_eol($fp));
        $obj->values      = explode(' ', $line);

        $obj->weight       = fread_number($fp);
        $obj->cost         = fread_number($fp);
        $obj->cost_per_day = fread_number($fp);

        for (;;) {
            $letter = fread_letter($fp);
            if ($letter == 'A') {
                $paf            = new stdClass();
                $paf->type      = -1;
                $paf->duration  = -1;
                $paf->affect_type  = fread_number($fp);
                $paf->modifier  = fread_number($fp);
                $paf->bitvector = 0;

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
        $room->lignt       = 0;

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

function load_specials($fp) {
    // todo
}

function load_resets($fp) {
    // todo
}

function load_shops($fp) {
    // todo
}

function dump_area($area) {
    if (!file_exists($area)) {
        echo $area . ' file does not exist';
        return;
    }
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
                    VALUES (%d, "%s", "%s", "%s", "%s",  %d, %d, %d, %d, %d);',
                $obj->vnum, $obj->name, $obj->short_descr, $obj->description,
                $obj->action_desc, $obj->item_type, $obj->extra_flags,
                $obj->wear_flags, $obj->weight, $obj->cost
        );
        mysql_query($str) or print(mysql_error() . PHP_EOL);
        printf('inserting %s' . PHP_EOL, $obj->name);


        if (isset($obj->affected))
            foreach ($obj->affected as $a) {
                $str = sprintf('INSERT INTO objs_affects
                        (obj_vnum, flag, modifier)
                        VALUES
                        (%d, %d, %d)
                        ', $obj->vnum, $a->affect_type, $a->modifier
                );
                mysql_query($str);
            }
    }
}