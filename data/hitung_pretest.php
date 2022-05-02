<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('HTTP/1.0 403 Forbidden', TRUE, 403);
    die(header('location: ../index.php'));
}


include('../config/db.php');
session_start();

function mode($armodul)
{
    $v = array_count_values($armodul);
    arsort($v);
    foreach ($v as $k => $v) {
        $total = $k;
        break;
    }
    return $total;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "SELECT id FROM student where class_id = '{$_POST['id']}'  order by id ASC";
    $query = mysqli_query($conn, $sql);
    $students = mysqli_fetch_all($query, MYSQLI_ASSOC);
    $murid = [];
    $i = 0;
    foreach ($students as $key => $s) {
        $i++;
        $sql = "SELECT * FROM pre_test_answer WHERE student_id = '{$s['id']}'";
        $query = mysqli_query($conn, $sql);
        $answer = mysqli_fetch_array($query, MYSQLI_ASSOC);
        $murid[$s['id']] = array(
            'modul_1' => $answer['modul_1'],
            'modul_2' => $answer['modul_2'],
            'modul_3' => $answer['modul_3'],
            'modul_4' => $answer['modul_4'],
            'modul_5' => $answer['modul_5'],
            'modul_6' => $answer['modul_6'],
            'modul_7' => $answer['modul_7'],
            'modul_8' => $answer['modul_8'],
            'modul_9' => $answer['modul_9'],
            'modul_10' => $answer['modul_10'],
            'modul_11' => $answer['modul_11'],
            'modul_12' => $answer['modul_12'],
        );
    }

    // var_dump($murid);


    //HITUNG P, ability, dan difficulty, p_modul,

    $sum_modul_1 = array();
    $sum_modul_2 = array();
    $sum_modul_3 = array();
    $sum_modul_4 = array();
    $sum_modul_5 = array();
    $sum_modul_6 = array();
    $sum_modul_7 = array();
    $sum_modul_8 = array();
    $sum_modul_9 = array();
    $sum_modul_10 = array();
    $sum_modul_11 = array();
    $sum_modul_12 = array();
    foreach ($murid as $key => $m) {
        ${'p_user_' . $key} = array_sum($m) / count($m);
        $p_user = array('p_user' => ${'p_user_' . $key});
        // array_push($murid[$key], $p_user);
        $murid[$key]['p_user'] = ${'p_user_' . $key};
        $ability = log($murid[$key]['p_user'] / (1 - $murid[$key]['p_user']));
        $murid[$key]['ability'] = $ability;
        $sum_modul_1[] = $murid[$key]['modul_1'];
        $sum_modul_2[] = $murid[$key]['modul_2'];
        $sum_modul_3[] = $murid[$key]['modul_3'];
        $sum_modul_4[] = $murid[$key]['modul_4'];
        $sum_modul_5[] = $murid[$key]['modul_5'];
        $sum_modul_6[] = $murid[$key]['modul_6'];
        $sum_modul_7[] = $murid[$key]['modul_7'];
        $sum_modul_8[] = $murid[$key]['modul_8'];
        $sum_modul_9[] = $murid[$key]['modul_9'];
        $sum_modul_10[] = $murid[$key]['modul_10'];
        $sum_modul_11[] = $murid[$key]['modul_11'];
        $sum_modul_12[] = $murid[$key]['modul_12'];
    }

    //HITUNG P Modul
    $p_modul_1 = array_sum($sum_modul_1) / count($sum_modul_1);
    $p_modul_2 = array_sum($sum_modul_2) / count($sum_modul_2);
    $p_modul_3 = array_sum($sum_modul_3) / count($sum_modul_3);
    $p_modul_4 = array_sum($sum_modul_4) / count($sum_modul_4);
    $p_modul_5 = array_sum($sum_modul_5) / count($sum_modul_5);
    $p_modul_6 = array_sum($sum_modul_6) / count($sum_modul_6);
    $p_modul_7 = array_sum($sum_modul_7) / count($sum_modul_7);
    $p_modul_8 = array_sum($sum_modul_8) / count($sum_modul_8);
    $p_modul_9 = array_sum($sum_modul_9) / count($sum_modul_9);
    $p_modul_10 = array_sum($sum_modul_10) / count($sum_modul_10);
    $p_modul_11 = array_sum($sum_modul_11) / count($sum_modul_11);
    $p_modul_12 = array_sum($sum_modul_12) / count($sum_modul_12);

    //Hitung difficulty Modul
    $difficulty_modul_1 = log((1 - $p_modul_1) / $p_modul_1);
    $difficulty_modul_2 = log((1 - $p_modul_2) / $p_modul_2);
    $difficulty_modul_3 = log((1 - $p_modul_3) / $p_modul_3);
    $difficulty_modul_4 = log((1 - $p_modul_4) / $p_modul_4);
    $difficulty_modul_5 = log((1 - $p_modul_5) / $p_modul_5);
    $difficulty_modul_6 = log((1 - $p_modul_6) / $p_modul_6);
    $difficulty_modul_7 = log((1 - $p_modul_7) / $p_modul_7);
    $difficulty_modul_8 = log((1 - $p_modul_8) / $p_modul_8);
    $difficulty_modul_9 = log((1 - $p_modul_9) / $p_modul_9);
    $difficulty_modul_10 = log((1 - $p_modul_10) / $p_modul_10);
    $difficulty_modul_11 = log((1 - $p_modul_11) / $p_modul_11);
    $difficulty_modul_12 = log((1 - $p_modul_12) / $p_modul_12);

    //Masukan difficulty modul menjadi 1 array
    $difficultys = [
        $difficulty_modul_1, $difficulty_modul_2, $difficulty_modul_3, $difficulty_modul_4, $difficulty_modul_5, $difficulty_modul_6, $difficulty_modul_7, $difficulty_modul_8, $difficulty_modul_9, $difficulty_modul_10, $difficulty_modul_11, $difficulty_modul_12
    ];

    //hitung average difficulty
    $difficulty_average = array_sum($difficultys) / count($difficultys);

    //hitung adjust difficulty
    $adj_difficulty_modul_1 = $difficulty_modul_1 - $difficulty_average;
    $adj_difficulty_modul_2 = $difficulty_modul_2 - $difficulty_average;
    $adj_difficulty_modul_3 = $difficulty_modul_3 - $difficulty_average;
    $adj_difficulty_modul_4 = $difficulty_modul_4 - $difficulty_average;
    $adj_difficulty_modul_5 = $difficulty_modul_5 - $difficulty_average;
    $adj_difficulty_modul_6 = $difficulty_modul_6 - $difficulty_average;
    $adj_difficulty_modul_7 = $difficulty_modul_7 - $difficulty_average;
    $adj_difficulty_modul_8 = $difficulty_modul_8 - $difficulty_average;
    $adj_difficulty_modul_9 = $difficulty_modul_9 - $difficulty_average;
    $adj_difficulty_modul_10 = $difficulty_modul_10 - $difficulty_average;
    $adj_difficulty_modul_11 = $difficulty_modul_11 - $difficulty_average;
    $adj_difficulty_modul_12 = $difficulty_modul_12 - $difficulty_average;

    $adj_difficultys = [
        $adj_difficulty_modul_1,
        $adj_difficulty_modul_2,
        $adj_difficulty_modul_3,
        $adj_difficulty_modul_4,
        $adj_difficulty_modul_5,
        $adj_difficulty_modul_6,
        $adj_difficulty_modul_7,
        $adj_difficulty_modul_8,
        $adj_difficulty_modul_9,
        $adj_difficulty_modul_10,
        $adj_difficulty_modul_11,
        $adj_difficulty_modul_12
    ];

    $adj_difficultys_avg = array_sum($adj_difficultys) / count($adj_difficultys);

    //Mulai Hitung ITERASI

    //Hitung iterasi pertama

    $iterasi1_harap = array();
    foreach ($murid as $key => $m) {
        $iterasi1_harap[$key] = array(
            'modul_1' => exp($murid[$key]['ability'] - $adj_difficulty_modul_1) / (1 + exp($murid[$key]['ability'] - $adj_difficulty_modul_1)),
            'modul_2' => exp($murid[$key]['ability'] - $adj_difficulty_modul_2) / (1 + exp($murid[$key]['ability'] - $adj_difficulty_modul_2)),
            'modul_3' => exp($murid[$key]['ability'] - $adj_difficulty_modul_3) / (1 + exp($murid[$key]['ability'] - $adj_difficulty_modul_3)),
            'modul_4' => exp($murid[$key]['ability'] - $adj_difficulty_modul_4) / (1 + exp($murid[$key]['ability'] - $adj_difficulty_modul_4)),
            'modul_5' => exp($murid[$key]['ability'] - $adj_difficulty_modul_5) / (1 + exp($murid[$key]['ability'] - $adj_difficulty_modul_5)),
            'modul_6' => exp($murid[$key]['ability'] - $adj_difficulty_modul_6) / (1 + exp($murid[$key]['ability'] - $adj_difficulty_modul_6)),
            'modul_7' => exp($murid[$key]['ability'] - $adj_difficulty_modul_7) / (1 + exp($murid[$key]['ability'] - $adj_difficulty_modul_7)),
            'modul_8' => exp($murid[$key]['ability'] - $adj_difficulty_modul_8) / (1 + exp($murid[$key]['ability'] - $adj_difficulty_modul_8)),
            'modul_9' => exp($murid[$key]['ability'] - $adj_difficulty_modul_9) / (1 + exp($murid[$key]['ability'] - $adj_difficulty_modul_9)),
            'modul_10' => exp($murid[$key]['ability'] - $adj_difficulty_modul_10) / (1 + exp($murid[$key]['ability'] - $adj_difficulty_modul_10)),
            'modul_11' => exp($murid[$key]['ability'] - $adj_difficulty_modul_11) / (1 + exp($murid[$key]['ability'] - $adj_difficulty_modul_11)),
            'modul_12' => exp($murid[$key]['ability'] - $adj_difficulty_modul_12) / (1 + exp($murid[$key]['ability'] - $adj_difficulty_modul_12)),
        );
    }

    $iterasi1_varian = array();
    $sum_moduls_varian = array();
    $sum_moduls_varian['modul_1'] = 0;
    $sum_moduls_varian['modul_2'] = 0;
    $sum_moduls_varian['modul_3'] = 0;
    $sum_moduls_varian['modul_4'] = 0;
    $sum_moduls_varian['modul_5'] = 0;
    $sum_moduls_varian['modul_6'] = 0;
    $sum_moduls_varian['modul_7'] = 0;
    $sum_moduls_varian['modul_8'] = 0;
    $sum_moduls_varian['modul_9'] = 0;
    $sum_moduls_varian['modul_10'] = 0;
    $sum_moduls_varian['modul_11'] = 0;
    $sum_moduls_varian['modul_12'] = 0;
    foreach ($murid as $key => $m) {
        $iterasi1_varian[$key]['modul_1'] = $iterasi1_harap[$key]['modul_1'] * (1 - $iterasi1_harap[$key]['modul_1']);
        $iterasi1_varian[$key]['modul_2'] = $iterasi1_harap[$key]['modul_2'] * (1 - $iterasi1_harap[$key]['modul_2']);
        $iterasi1_varian[$key]['modul_3'] = $iterasi1_harap[$key]['modul_3'] * (1 - $iterasi1_harap[$key]['modul_3']);
        $iterasi1_varian[$key]['modul_4'] = $iterasi1_harap[$key]['modul_4'] * (1 - $iterasi1_harap[$key]['modul_4']);
        $iterasi1_varian[$key]['modul_5'] = $iterasi1_harap[$key]['modul_5'] * (1 - $iterasi1_harap[$key]['modul_5']);
        $iterasi1_varian[$key]['modul_6'] = $iterasi1_harap[$key]['modul_6'] * (1 - $iterasi1_harap[$key]['modul_6']);
        $iterasi1_varian[$key]['modul_7'] = $iterasi1_harap[$key]['modul_7'] * (1 - $iterasi1_harap[$key]['modul_7']);
        $iterasi1_varian[$key]['modul_8'] = $iterasi1_harap[$key]['modul_8'] * (1 - $iterasi1_harap[$key]['modul_8']);
        $iterasi1_varian[$key]['modul_9'] = $iterasi1_harap[$key]['modul_9'] * (1 - $iterasi1_harap[$key]['modul_9']);
        $iterasi1_varian[$key]['modul_10'] = $iterasi1_harap[$key]['modul_10'] * (1 - $iterasi1_harap[$key]['modul_10']);
        $iterasi1_varian[$key]['modul_11'] = $iterasi1_harap[$key]['modul_11'] * (1 - $iterasi1_harap[$key]['modul_11']);
        $iterasi1_varian[$key]['modul_12'] = $iterasi1_harap[$key]['modul_12'] * (1 - $iterasi1_harap[$key]['modul_12']);
        $iterasi1_varian[$key]['sum'] = -1 * (array_sum($iterasi1_varian[$key]));
        $sum_moduls_varian['modul_1'] += $iterasi1_varian[$key]['modul_1'];
        $sum_moduls_varian['modul_2'] += $iterasi1_varian[$key]['modul_2'];
        $sum_moduls_varian['modul_3'] += $iterasi1_varian[$key]['modul_3'];
        $sum_moduls_varian['modul_4'] += $iterasi1_varian[$key]['modul_4'];
        $sum_moduls_varian['modul_5'] += $iterasi1_varian[$key]['modul_5'];
        $sum_moduls_varian['modul_6'] += $iterasi1_varian[$key]['modul_6'];
        $sum_moduls_varian['modul_7'] += $iterasi1_varian[$key]['modul_7'];
        $sum_moduls_varian['modul_8'] += $iterasi1_varian[$key]['modul_8'];
        $sum_moduls_varian['modul_9'] += $iterasi1_varian[$key]['modul_9'];
        $sum_moduls_varian['modul_10'] += $iterasi1_varian[$key]['modul_10'];
        $sum_moduls_varian['modul_11'] += $iterasi1_varian[$key]['modul_11'];
        $sum_moduls_varian['modul_12'] += $iterasi1_varian[$key]['modul_12'];
    }

    $sum_moduls_varian['modul_1'] = -1 * $sum_moduls_varian['modul_1'];
    $sum_moduls_varian['modul_2'] = -1 * $sum_moduls_varian['modul_2'];
    $sum_moduls_varian['modul_3'] = -1 * $sum_moduls_varian['modul_3'];
    $sum_moduls_varian['modul_4'] = -1 * $sum_moduls_varian['modul_4'];
    $sum_moduls_varian['modul_5'] = -1 * $sum_moduls_varian['modul_5'];
    $sum_moduls_varian['modul_6'] = -1 * $sum_moduls_varian['modul_6'];
    $sum_moduls_varian['modul_7'] = -1 * $sum_moduls_varian['modul_7'];
    $sum_moduls_varian['modul_8'] = -1 * $sum_moduls_varian['modul_8'];
    $sum_moduls_varian['modul_9'] = -1 * $sum_moduls_varian['modul_9'];
    $sum_moduls_varian['modul_10'] = -1 * $sum_moduls_varian['modul_10'];
    $sum_moduls_varian['modul_11'] = -1 * $sum_moduls_varian['modul_11'];
    $sum_moduls_varian['modul_12'] = -1 * $sum_moduls_varian['modul_12'];

    $iterasi1_residual = array();
    $sum_moduls_residual['modul_1'] = 0;
    $sum_moduls_residual['modul_2'] = 0;
    $sum_moduls_residual['modul_3'] = 0;
    $sum_moduls_residual['modul_4'] = 0;
    $sum_moduls_residual['modul_5'] = 0;
    $sum_moduls_residual['modul_6'] = 0;
    $sum_moduls_residual['modul_7'] = 0;
    $sum_moduls_residual['modul_8'] = 0;
    $sum_moduls_residual['modul_9'] = 0;
    $sum_moduls_residual['modul_10'] = 0;
    $sum_moduls_residual['modul_11'] = 0;
    $sum_moduls_residual['modul_12'] = 0;
    foreach ($murid as $key => $m) {
        $iterasi1_residual[$key]['modul_1'] = $murid[$key]['modul_1'] - $iterasi1_harap[$key]['modul_1'];
        $iterasi1_residual[$key]['modul_2'] = $murid[$key]['modul_2'] - $iterasi1_harap[$key]['modul_2'];
        $iterasi1_residual[$key]['modul_3'] = $murid[$key]['modul_3'] - $iterasi1_harap[$key]['modul_3'];
        $iterasi1_residual[$key]['modul_4'] = $murid[$key]['modul_4'] - $iterasi1_harap[$key]['modul_4'];
        $iterasi1_residual[$key]['modul_5'] = $murid[$key]['modul_5'] - $iterasi1_harap[$key]['modul_5'];
        $iterasi1_residual[$key]['modul_6'] = $murid[$key]['modul_6'] - $iterasi1_harap[$key]['modul_6'];
        $iterasi1_residual[$key]['modul_7'] = $murid[$key]['modul_7'] - $iterasi1_harap[$key]['modul_7'];
        $iterasi1_residual[$key]['modul_8'] = $murid[$key]['modul_8'] - $iterasi1_harap[$key]['modul_8'];
        $iterasi1_residual[$key]['modul_9'] = $murid[$key]['modul_9'] - $iterasi1_harap[$key]['modul_9'];
        $iterasi1_residual[$key]['modul_10'] = $murid[$key]['modul_10'] - $iterasi1_harap[$key]['modul_10'];
        $iterasi1_residual[$key]['modul_11'] = $murid[$key]['modul_11'] - $iterasi1_harap[$key]['modul_11'];
        $iterasi1_residual[$key]['modul_12'] = $murid[$key]['modul_12'] - $iterasi1_harap[$key]['modul_12'];
        $iterasi1_residual[$key]['sum_residual'] = array_sum($iterasi1_residual[$key]);
        $iterasi1_residual[$key]['new_ability'] = $murid[$key]['ability'] - $iterasi1_residual[$key]['sum_residual'] / $iterasi1_varian[$key]['sum'];
        $sum_moduls_residual['modul_1'] += $iterasi1_residual[$key]['modul_1'];
        $sum_moduls_residual['modul_2'] += $iterasi1_residual[$key]['modul_2'];
        $sum_moduls_residual['modul_3'] += $iterasi1_residual[$key]['modul_3'];
        $sum_moduls_residual['modul_4'] += $iterasi1_residual[$key]['modul_4'];
        $sum_moduls_residual['modul_5'] += $iterasi1_residual[$key]['modul_5'];
        $sum_moduls_residual['modul_6'] += $iterasi1_residual[$key]['modul_6'];
        $sum_moduls_residual['modul_7'] += $iterasi1_residual[$key]['modul_7'];
        $sum_moduls_residual['modul_8'] += $iterasi1_residual[$key]['modul_8'];
        $sum_moduls_residual['modul_9'] += $iterasi1_residual[$key]['modul_9'];
        $sum_moduls_residual['modul_10'] += $iterasi1_residual[$key]['modul_10'];
        $sum_moduls_residual['modul_11'] += $iterasi1_residual[$key]['modul_11'];
        $sum_moduls_residual['modul_12'] += $iterasi1_residual[$key]['modul_12'];
    }

    $sum_moduls_residual['modul_1'] = -1 * $sum_moduls_residual['modul_1'];
    $sum_moduls_residual['modul_2'] = -1 * $sum_moduls_residual['modul_2'];
    $sum_moduls_residual['modul_3'] = -1 * $sum_moduls_residual['modul_3'];
    $sum_moduls_residual['modul_4'] = -1 * $sum_moduls_residual['modul_4'];
    $sum_moduls_residual['modul_5'] = -1 * $sum_moduls_residual['modul_5'];
    $sum_moduls_residual['modul_6'] = -1 * $sum_moduls_residual['modul_6'];
    $sum_moduls_residual['modul_7'] = -1 * $sum_moduls_residual['modul_7'];
    $sum_moduls_residual['modul_8'] = -1 * $sum_moduls_residual['modul_8'];
    $sum_moduls_residual['modul_9'] = -1 * $sum_moduls_residual['modul_9'];
    $sum_moduls_residual['modul_10'] = -1 * $sum_moduls_residual['modul_10'];
    $sum_moduls_residual['modul_11'] = -1 * $sum_moduls_residual['modul_11'];
    $sum_moduls_residual['modul_12'] = -1 * $sum_moduls_residual['modul_12'];

    $new_difficulty['modul_1'] = $adj_difficulty_modul_1 - $sum_moduls_residual['modul_1'] / $sum_moduls_varian['modul_1'];
    $new_difficulty['modul_2'] = $adj_difficulty_modul_2 - $sum_moduls_residual['modul_2'] / $sum_moduls_varian['modul_2'];
    $new_difficulty['modul_3'] = $adj_difficulty_modul_3 - $sum_moduls_residual['modul_3'] / $sum_moduls_varian['modul_3'];
    $new_difficulty['modul_4'] = $adj_difficulty_modul_4 - $sum_moduls_residual['modul_4'] / $sum_moduls_varian['modul_4'];
    $new_difficulty['modul_5'] = $adj_difficulty_modul_5 - $sum_moduls_residual['modul_5'] / $sum_moduls_varian['modul_5'];
    $new_difficulty['modul_6'] = $adj_difficulty_modul_6 - $sum_moduls_residual['modul_6'] / $sum_moduls_varian['modul_6'];
    $new_difficulty['modul_7'] = $adj_difficulty_modul_7 - $sum_moduls_residual['modul_7'] / $sum_moduls_varian['modul_7'];
    $new_difficulty['modul_8'] = $adj_difficulty_modul_8 - $sum_moduls_residual['modul_8'] / $sum_moduls_varian['modul_8'];
    $new_difficulty['modul_9'] = $adj_difficulty_modul_9 - $sum_moduls_residual['modul_9'] / $sum_moduls_varian['modul_9'];
    $new_difficulty['modul_10'] = $adj_difficulty_modul_10 - $sum_moduls_residual['modul_10'] / $sum_moduls_varian['modul_10'];
    $new_difficulty['modul_11'] = $adj_difficulty_modul_11 - $sum_moduls_residual['modul_11'] / $sum_moduls_varian['modul_11'];
    $new_difficulty['modul_12'] = $adj_difficulty_modul_12 - $sum_moduls_residual['modul_12'] / $sum_moduls_varian['modul_12'];

    $avg_new_difficulty = array_sum($new_difficulty) / count($new_difficulty);

    //hitung adjust new difficulty
    $adj_new_difficulty['modul_1'] = $new_difficulty['modul_1'] - $avg_new_difficulty;
    $adj_new_difficulty['modul_2'] = $new_difficulty['modul_2'] - $avg_new_difficulty;
    $adj_new_difficulty['modul_3'] = $new_difficulty['modul_3'] - $avg_new_difficulty;
    $adj_new_difficulty['modul_4'] = $new_difficulty['modul_4'] - $avg_new_difficulty;
    $adj_new_difficulty['modul_5'] = $new_difficulty['modul_5'] - $avg_new_difficulty;
    $adj_new_difficulty['modul_6'] = $new_difficulty['modul_6'] - $avg_new_difficulty;
    $adj_new_difficulty['modul_7'] = $new_difficulty['modul_7'] - $avg_new_difficulty;
    $adj_new_difficulty['modul_8'] = $new_difficulty['modul_8'] - $avg_new_difficulty;
    $adj_new_difficulty['modul_9'] = $new_difficulty['modul_9'] - $avg_new_difficulty;
    $adj_new_difficulty['modul_10'] = $new_difficulty['modul_10'] - $avg_new_difficulty;
    $adj_new_difficulty['modul_11'] = $new_difficulty['modul_11'] - $avg_new_difficulty;
    $adj_new_difficulty['modul_12'] = $new_difficulty['modul_12'] - $avg_new_difficulty;


    //Mulai looping iterasi
    // $i = 2;
    $l = 0;
    for ($l = 2; $l <= $i; $l++) {
        ${'iterasi' . $l . '_harap'} = array();
        $r = $l - 1;
        foreach ($murid as $key => $m) {
            ${'iterasi' . $l . '_harap'}[$key] = array(
                'modul_1' => exp(${'iterasi' . $r . '_residual'}[$key]['new_ability'] - $adj_new_difficulty['modul_1']) / (1 + exp(${'iterasi' . $r . '_residual'}[$key]['new_ability'] - $adj_new_difficulty['modul_1'])),
                'modul_2' => exp(${'iterasi' . $r . '_residual'}[$key]['new_ability'] - $adj_new_difficulty['modul_2']) / (1 + exp(${'iterasi' . $r . '_residual'}[$key]['new_ability'] - $adj_new_difficulty['modul_2'])),
                'modul_3' => exp(${'iterasi' . $r . '_residual'}[$key]['new_ability'] - $adj_new_difficulty['modul_3']) / (1 + exp(${'iterasi' . $r . '_residual'}[$key]['new_ability'] - $adj_new_difficulty['modul_3'])),
                'modul_4' => exp(${'iterasi' . $r . '_residual'}[$key]['new_ability'] - $adj_new_difficulty['modul_4']) / (1 + exp(${'iterasi' . $r . '_residual'}[$key]['new_ability'] - $adj_new_difficulty['modul_4'])),
                'modul_5' => exp(${'iterasi' . $r . '_residual'}[$key]['new_ability'] - $adj_new_difficulty['modul_5']) / (1 + exp(${'iterasi' . $r . '_residual'}[$key]['new_ability'] - $adj_new_difficulty['modul_5'])),
                'modul_6' => exp(${'iterasi' . $r . '_residual'}[$key]['new_ability'] - $adj_new_difficulty['modul_6']) / (1 + exp(${'iterasi' . $r . '_residual'}[$key]['new_ability'] - $adj_new_difficulty['modul_6'])),
                'modul_7' => exp(${'iterasi' . $r . '_residual'}[$key]['new_ability'] - $adj_new_difficulty['modul_7']) / (1 + exp(${'iterasi' . $r . '_residual'}[$key]['new_ability'] - $adj_new_difficulty['modul_7'])),
                'modul_8' => exp(${'iterasi' . $r . '_residual'}[$key]['new_ability'] - $adj_new_difficulty['modul_8']) / (1 + exp(${'iterasi' . $r . '_residual'}[$key]['new_ability'] - $adj_new_difficulty['modul_8'])),
                'modul_9' => exp(${'iterasi' . $r . '_residual'}[$key]['new_ability'] - $adj_new_difficulty['modul_9']) / (1 + exp(${'iterasi' . $r . '_residual'}[$key]['new_ability'] - $adj_new_difficulty['modul_9'])),
                'modul_10' => exp(${'iterasi' . $r . '_residual'}[$key]['new_ability'] - $adj_new_difficulty['modul_10']) / (1 + exp(${'iterasi' . $r . '_residual'}[$key]['new_ability'] - $adj_new_difficulty['modul_10'])),
                'modul_11' => exp(${'iterasi' . $r . '_residual'}[$key]['new_ability'] - $adj_new_difficulty['modul_11']) / (1 + exp(${'iterasi' . $r . '_residual'}[$key]['new_ability'] - $adj_new_difficulty['modul_11'])),
                'modul_12' => exp(${'iterasi' . $r . '_residual'}[$key]['new_ability'] - $adj_new_difficulty['modul_12']) / (1 + exp(${'iterasi' . $r . '_residual'}[$key]['new_ability'] - $adj_new_difficulty['modul_12'])),
            );
        }


        //HITUNG ITERASI KE-n VARIAN
        ${'iterasi' . $l . '_varian'} = array();
        $sum_moduls_varian = array();
        $sum_moduls_varian['modul_1'] = 0;
        $sum_moduls_varian['modul_2'] = 0;
        $sum_moduls_varian['modul_3'] = 0;
        $sum_moduls_varian['modul_4'] = 0;
        $sum_moduls_varian['modul_5'] = 0;
        $sum_moduls_varian['modul_6'] = 0;
        $sum_moduls_varian['modul_7'] = 0;
        $sum_moduls_varian['modul_8'] = 0;
        $sum_moduls_varian['modul_9'] = 0;
        $sum_moduls_varian['modul_10'] = 0;
        $sum_moduls_varian['modul_11'] = 0;
        $sum_moduls_varian['modul_12'] = 0;
        foreach ($murid as $key => $m) {
            ${'iterasi' . $l . '_varian'}[$key]['modul_1'] = ${'iterasi' . $l . '_harap'}[$key]['modul_1'] * (1 - ${'iterasi' . $l . '_harap'}[$key]['modul_1']);
            ${'iterasi' . $l . '_varian'}[$key]['modul_2'] = ${'iterasi' . $l . '_harap'}[$key]['modul_2'] * (1 - ${'iterasi' . $l . '_harap'}[$key]['modul_2']);
            ${'iterasi' . $l . '_varian'}[$key]['modul_3'] = ${'iterasi' . $l . '_harap'}[$key]['modul_3'] * (1 - ${'iterasi' . $l . '_harap'}[$key]['modul_3']);
            ${'iterasi' . $l . '_varian'}[$key]['modul_4'] = ${'iterasi' . $l . '_harap'}[$key]['modul_4'] * (1 - ${'iterasi' . $l . '_harap'}[$key]['modul_4']);
            ${'iterasi' . $l . '_varian'}[$key]['modul_5'] = ${'iterasi' . $l . '_harap'}[$key]['modul_5'] * (1 - ${'iterasi' . $l . '_harap'}[$key]['modul_5']);
            ${'iterasi' . $l . '_varian'}[$key]['modul_6'] = ${'iterasi' . $l . '_harap'}[$key]['modul_6'] * (1 - ${'iterasi' . $l . '_harap'}[$key]['modul_6']);
            ${'iterasi' . $l . '_varian'}[$key]['modul_7'] = ${'iterasi' . $l . '_harap'}[$key]['modul_7'] * (1 - ${'iterasi' . $l . '_harap'}[$key]['modul_7']);
            ${'iterasi' . $l . '_varian'}[$key]['modul_8'] = ${'iterasi' . $l . '_harap'}[$key]['modul_8'] * (1 - ${'iterasi' . $l . '_harap'}[$key]['modul_8']);
            ${'iterasi' . $l . '_varian'}[$key]['modul_9'] = ${'iterasi' . $l . '_harap'}[$key]['modul_9'] * (1 - ${'iterasi' . $l . '_harap'}[$key]['modul_9']);
            ${'iterasi' . $l . '_varian'}[$key]['modul_10'] = ${'iterasi' . $l . '_harap'}[$key]['modul_10'] * (1 - ${'iterasi' . $l . '_harap'}[$key]['modul_10']);
            ${'iterasi' . $l . '_varian'}[$key]['modul_11'] = ${'iterasi' . $l . '_harap'}[$key]['modul_11'] * (1 - ${'iterasi' . $l . '_harap'}[$key]['modul_11']);
            ${'iterasi' . $l . '_varian'}[$key]['modul_12'] = ${'iterasi' . $l . '_harap'}[$key]['modul_12'] * (1 - ${'iterasi' . $l . '_harap'}[$key]['modul_12']);
            ${'iterasi' . $l . '_varian'}[$key]['sum'] = -1 * (array_sum(${'iterasi' . $l . '_varian'}[$key]));
            $sum_moduls_varian['modul_1'] += ${'iterasi' . $l . '_varian'}[$key]['modul_1'];
            $sum_moduls_varian['modul_2'] += ${'iterasi' . $l . '_varian'}[$key]['modul_2'];
            $sum_moduls_varian['modul_3'] += ${'iterasi' . $l . '_varian'}[$key]['modul_3'];
            $sum_moduls_varian['modul_4'] += ${'iterasi' . $l . '_varian'}[$key]['modul_4'];
            $sum_moduls_varian['modul_5'] += ${'iterasi' . $l . '_varian'}[$key]['modul_5'];
            $sum_moduls_varian['modul_6'] += ${'iterasi' . $l . '_varian'}[$key]['modul_6'];
            $sum_moduls_varian['modul_7'] += ${'iterasi' . $l . '_varian'}[$key]['modul_7'];
            $sum_moduls_varian['modul_8'] += ${'iterasi' . $l . '_varian'}[$key]['modul_8'];
            $sum_moduls_varian['modul_9'] += ${'iterasi' . $l . '_varian'}[$key]['modul_9'];
            $sum_moduls_varian['modul_10'] += ${'iterasi' . $l . '_varian'}[$key]['modul_10'];
            $sum_moduls_varian['modul_11'] += ${'iterasi' . $l . '_varian'}[$key]['modul_11'];
            $sum_moduls_varian['modul_12'] += ${'iterasi' . $l . '_varian'}[$key]['modul_12'];
        }
        $sum_moduls_varian['modul_1'] = -1 * $sum_moduls_varian['modul_1'];
        $sum_moduls_varian['modul_2'] = -1 * $sum_moduls_varian['modul_2'];
        $sum_moduls_varian['modul_3'] = -1 * $sum_moduls_varian['modul_3'];
        $sum_moduls_varian['modul_4'] = -1 * $sum_moduls_varian['modul_4'];
        $sum_moduls_varian['modul_5'] = -1 * $sum_moduls_varian['modul_5'];
        $sum_moduls_varian['modul_6'] = -1 * $sum_moduls_varian['modul_6'];
        $sum_moduls_varian['modul_7'] = -1 * $sum_moduls_varian['modul_7'];
        $sum_moduls_varian['modul_8'] = -1 * $sum_moduls_varian['modul_8'];
        $sum_moduls_varian['modul_9'] = -1 * $sum_moduls_varian['modul_9'];
        $sum_moduls_varian['modul_10'] = -1 * $sum_moduls_varian['modul_10'];
        $sum_moduls_varian['modul_11'] = -1 * $sum_moduls_varian['modul_11'];
        $sum_moduls_varian['modul_12'] = -1 * $sum_moduls_varian['modul_12'];

        //HITUNG ITERASI KE-n RESIDUAL
        ${'iterasi' . $l . '_residual'} = array();
        $sum_moduls_residual['modul_1'] = 0;
        $sum_moduls_residual['modul_2'] = 0;
        $sum_moduls_residual['modul_3'] = 0;
        $sum_moduls_residual['modul_4'] = 0;
        $sum_moduls_residual['modul_5'] = 0;
        $sum_moduls_residual['modul_6'] = 0;
        $sum_moduls_residual['modul_7'] = 0;
        $sum_moduls_residual['modul_8'] = 0;
        $sum_moduls_residual['modul_9'] = 0;
        $sum_moduls_residual['modul_10'] = 0;
        $sum_moduls_residual['modul_11'] = 0;
        $sum_moduls_residual['modul_12'] = 0;
        foreach ($murid as $key => $m) {
            ${'iterasi' . $l . '_residual'}[$key]['modul_1'] = $murid[$key]['modul_1'] - ${'iterasi' . $l . '_harap'}[$key]['modul_1'];
            ${'iterasi' . $l . '_residual'}[$key]['modul_2'] = $murid[$key]['modul_2'] - ${'iterasi' . $l . '_harap'}[$key]['modul_2'];
            ${'iterasi' . $l . '_residual'}[$key]['modul_3'] = $murid[$key]['modul_3'] - ${'iterasi' . $l . '_harap'}[$key]['modul_3'];
            ${'iterasi' . $l . '_residual'}[$key]['modul_4'] = $murid[$key]['modul_4'] - ${'iterasi' . $l . '_harap'}[$key]['modul_4'];
            ${'iterasi' . $l . '_residual'}[$key]['modul_5'] = $murid[$key]['modul_5'] - ${'iterasi' . $l . '_harap'}[$key]['modul_5'];
            ${'iterasi' . $l . '_residual'}[$key]['modul_6'] = $murid[$key]['modul_6'] - ${'iterasi' . $l . '_harap'}[$key]['modul_6'];
            ${'iterasi' . $l . '_residual'}[$key]['modul_7'] = $murid[$key]['modul_7'] - ${'iterasi' . $l . '_harap'}[$key]['modul_7'];
            ${'iterasi' . $l . '_residual'}[$key]['modul_8'] = $murid[$key]['modul_8'] - ${'iterasi' . $l . '_harap'}[$key]['modul_8'];
            ${'iterasi' . $l . '_residual'}[$key]['modul_9'] = $murid[$key]['modul_9'] - ${'iterasi' . $l . '_harap'}[$key]['modul_9'];
            ${'iterasi' . $l . '_residual'}[$key]['modul_10'] = $murid[$key]['modul_10'] - ${'iterasi' . $l . '_harap'}[$key]['modul_10'];
            ${'iterasi' . $l . '_residual'}[$key]['modul_11'] = $murid[$key]['modul_11'] - ${'iterasi' . $l . '_harap'}[$key]['modul_11'];
            ${'iterasi' . $l . '_residual'}[$key]['modul_12'] = $murid[$key]['modul_12'] - ${'iterasi' . $l . '_harap'}[$key]['modul_12'];
            ${'iterasi' . $l . '_residual'}[$key]['sum_residual'] = array_sum(${'iterasi' . $l . '_residual'}[$key]);
            ${'iterasi' . $l . '_residual'}[$key]['new_ability'] = ${'iterasi' . $r . '_residual'}[$key]['new_ability'] - ${'iterasi' . $l . '_residual'}[$key]['sum_residual'] / ${'iterasi' . $l . '_varian'}[$key]['sum'];
            $sum_moduls_residual['modul_1'] += ${'iterasi' . $l . '_residual'}[$key]['modul_1'];
            $sum_moduls_residual['modul_2'] += ${'iterasi' . $l . '_residual'}[$key]['modul_2'];
            $sum_moduls_residual['modul_3'] += ${'iterasi' . $l . '_residual'}[$key]['modul_3'];
            $sum_moduls_residual['modul_4'] += ${'iterasi' . $l . '_residual'}[$key]['modul_4'];
            $sum_moduls_residual['modul_5'] += ${'iterasi' . $l . '_residual'}[$key]['modul_5'];
            $sum_moduls_residual['modul_6'] += ${'iterasi' . $l . '_residual'}[$key]['modul_6'];
            $sum_moduls_residual['modul_7'] += ${'iterasi' . $l . '_residual'}[$key]['modul_7'];
            $sum_moduls_residual['modul_8'] += ${'iterasi' . $l . '_residual'}[$key]['modul_8'];
            $sum_moduls_residual['modul_9'] += ${'iterasi' . $l . '_residual'}[$key]['modul_9'];
            $sum_moduls_residual['modul_10'] += ${'iterasi' . $l . '_residual'}[$key]['modul_10'];
            $sum_moduls_residual['modul_11'] += ${'iterasi' . $l . '_residual'}[$key]['modul_11'];
            $sum_moduls_residual['modul_12'] += ${'iterasi' . $l . '_residual'}[$key]['modul_12'];
        }
        $sum_moduls_residual['modul_1'] = -1 * $sum_moduls_residual['modul_1'];
        $sum_moduls_residual['modul_2'] = -1 * $sum_moduls_residual['modul_2'];
        $sum_moduls_residual['modul_3'] = -1 * $sum_moduls_residual['modul_3'];
        $sum_moduls_residual['modul_4'] = -1 * $sum_moduls_residual['modul_4'];
        $sum_moduls_residual['modul_5'] = -1 * $sum_moduls_residual['modul_5'];
        $sum_moduls_residual['modul_6'] = -1 * $sum_moduls_residual['modul_6'];
        $sum_moduls_residual['modul_7'] = -1 * $sum_moduls_residual['modul_7'];
        $sum_moduls_residual['modul_8'] = -1 * $sum_moduls_residual['modul_8'];
        $sum_moduls_residual['modul_9'] = -1 * $sum_moduls_residual['modul_9'];
        $sum_moduls_residual['modul_10'] = -1 * $sum_moduls_residual['modul_10'];
        $sum_moduls_residual['modul_11'] = -1 * $sum_moduls_residual['modul_11'];
        $sum_moduls_residual['modul_12'] = -1 * $sum_moduls_residual['modul_12'];

        //HITUNG NEW DIFFICULTY Iterasi ke-n
        $new_difficulty['modul_1'] = $adj_new_difficulty['modul_1'] - $sum_moduls_residual['modul_1'] / $sum_moduls_varian['modul_1'];
        $new_difficulty['modul_2'] = $adj_new_difficulty['modul_2'] - $sum_moduls_residual['modul_2'] / $sum_moduls_varian['modul_2'];
        $new_difficulty['modul_3'] = $adj_new_difficulty['modul_3'] - $sum_moduls_residual['modul_3'] / $sum_moduls_varian['modul_3'];
        $new_difficulty['modul_4'] = $adj_new_difficulty['modul_4'] - $sum_moduls_residual['modul_4'] / $sum_moduls_varian['modul_4'];
        $new_difficulty['modul_5'] = $adj_new_difficulty['modul_5'] - $sum_moduls_residual['modul_5'] / $sum_moduls_varian['modul_5'];
        $new_difficulty['modul_6'] = $adj_new_difficulty['modul_6'] - $sum_moduls_residual['modul_6'] / $sum_moduls_varian['modul_6'];
        $new_difficulty['modul_7'] = $adj_new_difficulty['modul_7'] - $sum_moduls_residual['modul_7'] / $sum_moduls_varian['modul_7'];
        $new_difficulty['modul_8'] = $adj_new_difficulty['modul_8'] - $sum_moduls_residual['modul_8'] / $sum_moduls_varian['modul_8'];
        $new_difficulty['modul_9'] = $adj_new_difficulty['modul_9'] - $sum_moduls_residual['modul_9'] / $sum_moduls_varian['modul_9'];
        $new_difficulty['modul_10'] = $adj_new_difficulty['modul_10'] - $sum_moduls_residual['modul_10'] / $sum_moduls_varian['modul_10'];
        $new_difficulty['modul_11'] = $adj_new_difficulty['modul_11'] - $sum_moduls_residual['modul_11'] / $sum_moduls_varian['modul_11'];
        $new_difficulty['modul_12'] = $adj_new_difficulty['modul_12'] - $sum_moduls_residual['modul_12'] / $sum_moduls_varian['modul_12'];

        //hitung avg new difficulty iterasi ke -n
        $avg_new_difficulty = array_sum($new_difficulty) / count($new_difficulty);

        //hitung adjust new difficulty iterasi ke -n
        $adj_new_difficulty['modul_1'] = $new_difficulty['modul_1'] - $avg_new_difficulty;
        $adj_new_difficulty['modul_2'] = $new_difficulty['modul_2'] - $avg_new_difficulty;
        $adj_new_difficulty['modul_3'] = $new_difficulty['modul_3'] - $avg_new_difficulty;
        $adj_new_difficulty['modul_4'] = $new_difficulty['modul_4'] - $avg_new_difficulty;
        $adj_new_difficulty['modul_5'] = $new_difficulty['modul_5'] - $avg_new_difficulty;
        $adj_new_difficulty['modul_6'] = $new_difficulty['modul_6'] - $avg_new_difficulty;
        $adj_new_difficulty['modul_7'] = $new_difficulty['modul_7'] - $avg_new_difficulty;
        $adj_new_difficulty['modul_8'] = $new_difficulty['modul_8'] - $avg_new_difficulty;
        $adj_new_difficulty['modul_9'] = $new_difficulty['modul_9'] - $avg_new_difficulty;
        $adj_new_difficulty['modul_10'] = $new_difficulty['modul_10'] - $avg_new_difficulty;
        $adj_new_difficulty['modul_11'] = $new_difficulty['modul_11'] - $avg_new_difficulty;
        $adj_new_difficulty['modul_12'] = $new_difficulty['modul_12'] - $avg_new_difficulty;
    }


    foreach ($murid as $key => $m) {
        foreach (${'iterasi' . $i . '_harap'}[$key] as $r => $ir) {
            // echo $ir;
            // echo "<br/><br/>";
            if ($ir >= 0.75) {
                unset(${'iterasi' . $i . '_harap'}[$key][$r]);
            }
        }
        $moduls = array();
        foreach (${'iterasi' . $i . '_harap'}[$key] as $r => $ir) {
            $moduls[] = substr($r, 6);
        }

        $modul_level = array();
        foreach ($moduls as $mo) {
            $sql = "SELECT module_level FROM module WHERE id = '{$mo}'";
            $query = mysqli_query($conn, $sql);
            $level = mysqli_fetch_array($query);
            $modul_level[] = $level['module_level'];
        }

        $level_pre_test = mode($modul_level);
        // echo "Level = " . $level_pre_test . "<br/><br/>";
        // echo "INSERT murid id " . $key . "dengan level = " . $level_pre_test . "<br/><br/>";
        $sql = "INSERT INTO pre_test_result (student_id, level) VALUES('{$key}', '{$level_pre_test}')";
        $query = mysqli_query($conn, $sql);
        if (!$query) {
            echo mysqli_error($conn);
        } else {
            $sql = "SELECT * FROM survey_result WHERE student_id = '{$key}'";
            $query = mysqli_query($conn, $sql);
            $level_survey = mysqli_fetch_array($query, MYSQLI_ASSOC)['level_result'];

            // if ($level_pre_test == $level_survey) {
            //     $level = $level_pre_test;
            // } else {
            //     $level = floor(($level_pre_test + $level_survey) / 2);
            // }
            $level = max($level_pre_test, $level_survey);
            $sql = "INSERT INTO level_student (student_id, level) VALUES('{$key}', '{$level}')";
            $query = mysqli_query($conn, $sql);
            if (!$query) {
                echo mysqli_error($conn);
            } else {
                header('location: ../admin/pre-test.php');
            }
        }
    }
    // var_dump($iterasi32_harap[5]);
}