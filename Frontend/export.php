<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require 'config.php';

$results = $pdo->query("SELECT * FROM results ORDER BY system, type")->fetchAll(PDO::FETCH_ASSOC);


$ar = array();
$ar["h1"] = array('System', 'Benchmark', 'Type', 'runs');
$ar["h2"] = array("", "", "");
for ($i = 0; $i < 20; $i++)
    $ar["h2"][] = $i + 1;


foreach ($results as $result) {
    switch ($result['benchmark']) {
        case 1:
            if (!isset($ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type'] . "-0"])) {
                $system = $pdo->query("SELECT * FROM system WHERE id_system = " . $result['system'])->fetch(PDO::FETCH_ASSOC);
                $type = $pdo->query("SELECT * FROM type WHERE id_type = " . $result['type'])->fetch(PDO::FETCH_ASSOC);
                $benchmark = $pdo->query("SELECT * FROM benchmark WHERE id_bench = " . $result['benchmark'])->fetch(PDO::FETCH_ASSOC);

                $ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type'] . "-0"] = array(
                    $system['id_system'] . " - " . $system['cpu'],
                    $benchmark['name'] . " - HPL",
                    $type['name']
                );
                $ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type'] . "-1"] = array(
                    $system['id_system'] . " - " . $system['cpu'],
                    $benchmark['name'] . " - DGEMM",
                    $type['name']
                );
                $ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type'] . "-2"] = array(
                    $system['id_system'] . " - " . $system['cpu'],
                    $benchmark['name'] . " - RA",
                    $type['name']
                );
                $ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type'] . "-3"] = array(
                    $system['id_system'] . " - " . $system['cpu'],
                    $benchmark['name'] . " - Stream",
                    $type['name']
                );
            }
            $r = json_decode($result['result']);
            $ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type'] . "-0"][] = $r->hpl;
            $ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type'] . "-1"][] = $r->dgemm;
            $ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type'] . "-2"][] = $r->ra;
            $ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type'] . "-3"][] = $r->stream;
            break;
        case 2:
            if (!isset($ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type'] . "-0"])) {
                $system = $pdo->query("SELECT * FROM system WHERE id_system = " . $result['system'])->fetch(PDO::FETCH_ASSOC);
                $type = $pdo->query("SELECT * FROM type WHERE id_type = " . $result['type'])->fetch(PDO::FETCH_ASSOC);
                $benchmark = $pdo->query("SELECT * FROM benchmark WHERE id_bench = " . $result['benchmark'])->fetch(PDO::FETCH_ASSOC);

                $ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type'] . "-0"] = array(
                    $system['id_system'] . " - " . $system['cpu'],
                    $benchmark['name'] . " - Random IOPS read",
                    $type['name']
                );
                $ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type'] . "-1"] = array(
                    $system['id_system'] . " - " . $system['cpu'],
                    $benchmark['name'] . " - Random IOPS write",
                    $type['name']
                );
                $ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type'] . "-2"] = array(
                    $system['id_system'] . " - " . $system['cpu'],
                    $benchmark['name'] . " - sequential IOPS read",
                    $type['name']
                );
                $ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type'] . "-3"] = array(
                    $system['id_system'] . " - " . $system['cpu'],
                    $benchmark['name'] . " - sequential IOPS write",
                    $type['name']
                );
                $ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type'] . "-4"] = array(
                    $system['id_system'] . " - " . $system['cpu'],
                    $benchmark['name'] . " - Random read speed",
                    $type['name']
                );
                $ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type'] . "-5"] = array(
                    $system['id_system'] . " - " . $system['cpu'],
                    $benchmark['name'] . " - Random write speed",
                    $type['name']
                );
                $ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type'] . "-6"] = array(
                    $system['id_system'] . " - " . $system['cpu'],
                    $benchmark['name'] . " - sequential read speed",
                    $type['name']
                );
                $ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type'] . "-7"] = array(
                    $system['id_system'] . " - " . $system['cpu'],
                    $benchmark['name'] . " - sequential write speed",
                    $type['name']
                );
            }
            $r = json_decode($result['result']);
            $ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type'] . "-0"][] = $r->randiopsr;
            $ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type'] . "-1"][] = $r->randiopsw;
            $ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type'] . "-2"][] = $r->seqiopsr;
            $ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type'] . "-3"][] = $r->seqiopsw;
            $ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type'] . "-4"][] = $r->randsr;
            $ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type'] . "-5"][] = $r->randsw;
            $ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type'] . "-6"][] = $r->seqsr;
            $ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type'] . "-7"][] = $r->seqsw;
            break;
        case 3:
            if (!isset($ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type'] . "-0"])) {
                $system = $pdo->query("SELECT * FROM system WHERE id_system = " . $result['system'])->fetch(PDO::FETCH_ASSOC);
                $type = $pdo->query("SELECT * FROM type WHERE id_type = " . $result['type'])->fetch(PDO::FETCH_ASSOC);
                $benchmark = $pdo->query("SELECT * FROM benchmark WHERE id_bench = " . $result['benchmark'])->fetch(PDO::FETCH_ASSOC);

                $ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type'] . "-0"] = array(
                    $system['id_system'] . " - " . $system['cpu'],
                    $benchmark['name'] . " - Ping",
                    $type['name']
                );
                $ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type'] . "-1"] = array(
                    $system['id_system'] . " - " . $system['cpu'],
                    $benchmark['name'] . " - Iperf send",
                    $type['name']
                );
                $ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type'] . "-2"] = array(
                    $system['id_system'] . " - " . $system['cpu'],
                    $benchmark['name'] . " - iperf receive",
                    $type['name']
                );
                $ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type'] . "-3"] = array(
                    $system['id_system'] . " - " . $system['cpu'],
                    $benchmark['name'] . " - iperf UDP",
                    $type['name']
                );
            }
            $r = json_decode($result['result']);
            $ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type'] . "-0"][] = $r->ping;
            $ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type'] . "-1"][] = $r->iperfs;
            $ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type'] . "-2"][] = $r->iperfr;
            $ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type'] . "-3"][] = $r->iperfu;
            break;
        case 4:
            if (!isset($ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type']])) {
                $system = $pdo->query("SELECT * FROM system WHERE id_system = " . $result['system'])->fetch(PDO::FETCH_ASSOC);
                $type = $pdo->query("SELECT * FROM type WHERE id_type = " . $result['type'])->fetch(PDO::FETCH_ASSOC);
                $benchmark = $pdo->query("SELECT * FROM benchmark WHERE id_bench = " . $result['benchmark'])->fetch(PDO::FETCH_ASSOC);

                $ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type']] = array(
                    $system['id_system'] . " - " . $system['cpu'],
                    $benchmark['name'],
                    $type['name']
                );
            }
            $r = json_decode($result['result']);
            $ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type']][] = $r->r;
            break;
        case 5:
            if (!isset($ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type']])) {
                $system = $pdo->query("SELECT * FROM system WHERE id_system = " . $result['system'])->fetch(PDO::FETCH_ASSOC);
                $type = $pdo->query("SELECT * FROM type WHERE id_type = " . $result['type'])->fetch(PDO::FETCH_ASSOC);
                $benchmark = $pdo->query("SELECT * FROM benchmark WHERE id_bench = " . $result['benchmark'])->fetch(PDO::FETCH_ASSOC);

                $ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type']] = array(
                    $system['id_system'] . " - " . $system['cpu'],
                    $benchmark['name'],
                    $type['name']
                );
            }
            $r = json_decode($result['result']);
            $ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type']][] = $r->r;
            break;
        case 6:
            if (!isset($ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type']])) {
                $system = $pdo->query("SELECT * FROM system WHERE id_system = " . $result['system'])->fetch(PDO::FETCH_ASSOC);
                $type = $pdo->query("SELECT * FROM type WHERE id_type = " . $result['type'])->fetch(PDO::FETCH_ASSOC);
                $benchmark = $pdo->query("SELECT * FROM benchmark WHERE id_bench = " . $result['benchmark'])->fetch(PDO::FETCH_ASSOC);

                $ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type']] = array(
                    $system['id_system'] . " - " . $system['cpu'],
                    $benchmark['name'],
                    $type['name']
                );
            }
            $r = json_decode($result['result']);
            $ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type']][] = $r->r;
            break;
        case 7:
            if (!isset($ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type']])) {
                $system = $pdo->query("SELECT * FROM system WHERE id_system = " . $result['system'])->fetch(PDO::FETCH_ASSOC);
                $type = $pdo->query("SELECT * FROM type WHERE id_type = " . $result['type'])->fetch(PDO::FETCH_ASSOC);
                $benchmark = $pdo->query("SELECT * FROM benchmark WHERE id_bench = " . $result['benchmark'])->fetch(PDO::FETCH_ASSOC);

                $ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type']] = array(
                    $system['id_system'] . " - " . $system['cpu'],
                    $benchmark['name'],
                    $type['name']
                );
            }
            $r = json_decode($result['result']);
            $ar[$result['system'] . "-" . $result['benchmark'] . "-" . $result['type']][] = $r->r;
            break;
    }
}
// echo "<pre>";
// print_r($ar);
// echo "</pre>";

function array_to_csv_download($array, $filename = "export.csv", $delimiter = ";")
{
    // open raw memory as file so no temp files needed, you might run out of memory though
    $f = fopen('php://memory', 'w');
    // loop over the input array
    foreach ($array as $line) {
        // generate csv lines from the inner arrays
        fputcsv($f, $line, $delimiter);
    }
    // reset the file pointer to the start of the file
    fseek($f, 0);
    // tell the browser it's going to be a csv file
    header('Content-Type: text/csv');
    // tell the browser we want to save it instead of displaying it
    header('Content-Disposition: attachment; filename="' . $filename . '";');
    // make php send the generated csv lines to the browser
    fpassthru($f);
}

array_to_csv_download($ar, "results.csv");
