<?php
@session_start();

require_once ('general.php');

if (!isset($_SESSION["id"])) {
	header("Location: login.php");
	exit ;
}

if (!isset($_GET["start_date_two"]) || !isset($_GET["end_date_two"]))
{
    die("error 08x398493");
    exit;
}

$table_columns = array(
	"match_id",
	"date_rec",
	"Mdate",
	"Mtime",
	"Continent_id",
	"Country_code",
	"champion",
	"champ_id",
	"gender",
	"car1",
	"car1_id",
	"car2",
	"car2_id"
    );

$db = new dbase();
$db->connect_mysql();


$start_dt = $_GET["start_date_two"];
$end_dt = $_GET["end_date_two"];



$sql="SELECT  a.match_id, step, car1_points, car2_points, Total_Points as total_points, 
--a.Over, a.car1_lap, a.car2_lap, a.car1_win, a.car2_win,
date_rec,Mdate,Mtime,Continent_id,Country_code,champion,a.champ_id,gender,car1,car1_id,car2,car2_id,
b.Over as dover, b.car1_lap, b.car2_lap, b.car1_win, b.car2_win
 FROM history1 as a 
 left join w_championship on w_championship.champ_id = a.champ_id 
 left join history_detail as b on b.match_id = a.match_id  
 where (a.date_rec BETWEEN  '$start_dt 00:00' AND '$end_dt 23:59') order by a.match_id, step DESC";

//////////////////////////////////////FETCH ROWS
$stmt = $db->getConnection()->prepare($sql);
$stmt->execute();
$rows_sql = $stmt->fetchAll();
$rows     = array();
$x=-1;
$last_match_id = -1;
$prin_details = false;

if (!$rows_sql)
{
    die("man plans, the god laughs!");
    exit;
}

foreach($rows_sql as $row_key){
	
	if ($last_match_id != $row_key["match_id"])
	{	
		$prin_details = false;
		$x+=1;
	}
    
    if (!$prin_details) {
        
        for($i = 0; $i < 13; $i++) //set the default table fields
        {
            $rows[$x][$table_columns[$i]] = $row_key[$table_columns[$i]];         
        }

        $prin_details = true;
    }

	$step = $row_key["step"];
	$rows[$x][$step."_c1_points"] = $row_key["car1_points"];
	$rows[$x][$step."_c2_points"] = $row_key["car2_points"];
	$rows[$x][$step."_total_points"] = $row_key["total_points"];
	$rows[$x][$step."_over"] = $row_key["dover"];
	$rows[$x][$step."_c1_lap"] = $row_key["car1_lap"];
	$rows[$x][$step."_c2_lap"] = $row_key["car2_lap"];
	$rows[$x][$step."_c1_win"] = $row_key["car1_win"];
	$rows[$x][$step."_c2_win"] = $row_key["car2_win"];
	
	$last_match_id = $row_key["match_id"]; //match_id
}


//`match_id` int(10) unsigned NOT NULL,
	$sql = "INSERT INTO `history2` (match_id, date_rec, Mdate, Mtime, Continent_id, Country_code, champion, champ_id, gender, car1, car1_id, car2, car2_id, 0_car1_points, 0_car2_points, 0_total_points, 0_over, 0_car1_lap, 0_car2_lap, 0_car1_win, 0_car2_win, 1_car1_points, 1_car2_points, 1_total_points, 1_over, 1_car1_lap, 1_car2_lap, 1_car1_win, 1_car2_win, 2_car1_points, 2_car2_points, 2_total_points, 2_over, 2_car1_lap, 2_car2_lap, 2_car1_win, 2_car2_win, 3_car1_points, 3_car2_points, 3_total_points, 3_over, 3_car1_lap, 3_car2_lap, 3_car1_win, 3_car2_win, 4_car1_points, 4_car2_points, 4_total_points, 4_over, 4_car1_lap, 4_car2_lap, 4_car1_win, 4_car2_win, 5_car1_points, 5_car2_points, 5_total_points, 5_over, 5_car1_lap, 5_car2_lap, 5_car1_win, 5_car2_win, 6_car1_points, 6_car2_points, 6_total_points, 6_over, 6_car1_lap, 6_car2_lap, 6_car1_win, 6_car2_win, 7_car1_points, 7_car2_points, 7_total_points, 7_over, 7_car1_lap, 7_car2_lap, 7_car1_win, 7_car2_win, 8_car1_points, 8_car2_points, 8_total_points, 8_over, 8_car1_lap, 8_car2_lap, 8_car1_win, 8_car2_win, 9_car1_points, 9_car2_points, 9_total_points, 9_over, 9_car1_lap, 9_car2_lap, 9_car1_win, 9_car2_win, 10_car1_points, 10_car2_points, 10_total_points, 10_over, 10_car1_lap, 10_car2_lap, 10_car1_win, 10_car2_win, 11_car1_points, 11_car2_points, 11_total_points, 11_over, 11_car1_lap, 11_car2_lap, 11_car1_win, 11_car2_win, 12_car1_points, 12_car2_points, 12_total_points, 12_over, 12_car1_lap, 12_car2_lap, 12_car1_win, 12_car2_win, 13_car1_points, 13_car2_points, 13_total_points, 13_over, 13_car1_lap, 13_car2_lap, 13_car1_win, 13_car2_win, 14_car1_points, 14_car2_points, 14_total_points, 14_over, 14_car1_lap, 14_car2_lap, 14_car1_win, 14_car2_win, 15_car1_points, 15_car2_points, 15_total_points, 15_over, 15_car1_lap, 15_car2_lap, 15_car1_win, 15_car2_win, 16_car1_points, 16_car2_points, 16_total_points, 16_over, 16_car1_lap, 16_car2_lap, 16_car1_win, 16_car2_win, 17_car1_points, 17_car2_points, 17_total_points, 17_over, 17_car1_lap, 17_car2_lap, 17_car1_win, 17_car2_win, 18_car1_points, 18_car2_points, 18_total_points, 18_over, 18_car1_lap, 18_car2_lap, 18_car1_win, 18_car2_win, 19_car1_points, 19_car2_points, 19_total_points, 19_over, 19_car1_lap, 19_car2_lap, 19_car1_win, 19_car2_win, 20_car1_points, 20_car2_points, 20_total_points, 20_over, 20_car1_lap, 20_car2_lap, 20_car1_win, 20_car2_win, 21_car1_points, 21_car2_points, 21_total_points, 21_over, 21_car1_lap, 21_car2_lap, 21_car1_win, 21_car2_win, 22_car1_points, 22_car2_points, 22_total_points, 22_over, 22_car1_lap, 22_car2_lap, 22_car1_win, 22_car2_win, 23_car1_points, 23_car2_points, 23_total_points, 23_over, 23_car1_lap, 23_car2_lap, 23_car1_win, 23_car2_win, 24_car1_points, 24_car2_points, 24_total_points, 24_over, 24_car1_lap, 24_car2_lap, 24_car1_win, 24_car2_win, 25_car1_points, 25_car2_points, 25_total_points, 25_over, 25_car1_lap, 25_car2_lap, 25_car1_win, 25_car2_win, 26_car1_points, 26_car2_points, 26_total_points, 26_over, 26_car1_lap, 26_car2_lap, 26_car1_win, 26_car2_win, 27_car1_points, 27_car2_points, 27_total_points, 27_over, 27_car1_lap, 27_car2_lap, 27_car1_win, 27_car2_win, 28_car1_points, 28_car2_points, 28_total_points, 28_over, 28_car1_lap, 28_car2_lap, 28_car1_win, 28_car2_win, 29_car1_points, 29_car2_points, 29_total_points, 29_over, 29_car1_lap, 29_car2_lap, 29_car1_win, 29_car2_win, 30_car1_points, 30_car2_points, 30_total_points, 30_over, 30_car1_lap, 30_car2_lap, 30_car1_win, 30_car2_win, 31_car1_points, 31_car2_points, 31_total_points, 31_over, 31_car1_lap, 31_car2_lap, 31_car1_win, 31_car2_win, 32_car1_points, 32_car2_points, 32_total_points, 32_over, 32_car1_lap, 32_car2_lap, 32_car1_win, 32_car2_win, 33_car1_points, 33_car2_points, 33_total_points, 33_over, 33_car1_lap, 33_car2_lap, 33_car1_win, 33_car2_win, 34_car1_points, 34_car2_points, 34_total_points, 34_over, 34_car1_lap, 34_car2_lap, 34_car1_win, 34_car2_win, 35_car1_points, 35_car2_points, 35_total_points, 35_over, 35_car1_lap, 35_car2_lap, 35_car1_win, 35_car2_win, 36_car1_points, 36_car2_points, 36_total_points, 36_over, 36_car1_lap, 36_car2_lap, 36_car1_win, 36_car2_win, 37_car1_points, 37_car2_points, 37_total_points, 37_over, 37_car1_lap, 37_car2_lap, 37_car1_win, 37_car2_win, 38_car1_points, 38_car2_points, 38_total_points, 38_over, 38_car1_lap, 38_car2_lap, 38_car1_win, 38_car2_win, 39_car1_points, 39_car2_points, 39_total_points, 39_over, 39_car1_lap, 39_car2_lap, 39_car1_win, 39_car2_win, 40_car1_points, 40_car2_points, 40_total_points, 40_over, 40_car1_lap, 40_car2_lap, 40_car1_win, 40_car2_win, 41_car1_points, 41_car2_points, 41_total_points, 41_over, 41_car1_lap, 41_car2_lap, 41_car1_win, 41_car2_win, 42_car1_points, 42_car2_points, 42_total_points, 42_over, 42_car1_lap, 42_car2_lap, 42_car1_win, 42_car2_win, 43_car1_points, 43_car2_points, 43_total_points, 43_over, 43_car1_lap, 43_car2_lap, 43_car1_win, 43_car2_win, 44_car1_points, 44_car2_points, 44_total_points, 44_over, 44_car1_lap, 44_car2_lap, 44_car1_win, 44_car2_win, 45_car1_points, 45_car2_points, 45_total_points, 45_over, 45_car1_lap, 45_car2_lap, 45_car1_win, 45_car2_win, 46_car1_points, 46_car2_points, 46_total_points, 46_over, 46_car1_lap, 46_car2_lap, 46_car1_win, 46_car2_win, 47_car1_points, 47_car2_points, 47_total_points, 47_over, 47_car1_lap, 47_car2_lap, 47_car1_win, 47_car2_win, 48_car1_points, 48_car2_points, 48_total_points, 48_over, 48_car1_lap, 48_car2_lap, 48_car1_win, 48_car2_win, 49_car1_points, 49_car2_points, 49_total_points, 49_over, 49_car1_lap, 49_car2_lap, 49_car1_win, 49_car2_win, 50_car1_points, 50_car2_points, 50_total_points, 50_over, 50_car1_lap, 50_car2_lap, 50_car1_win, 50_car2_win, 51_car1_points, 51_car2_points, 51_total_points, 51_over, 51_car1_lap, 51_car2_lap, 51_car1_win, 51_car2_win, 52_car1_points, 52_car2_points, 52_total_points, 52_over, 52_car1_lap, 52_car2_lap, 52_car1_win, 52_car2_win, 53_car1_points, 53_car2_points, 53_total_points, 53_over, 53_car1_lap, 53_car2_lap, 53_car1_win, 53_car2_win, 54_car1_points, 54_car2_points, 54_total_points, 54_over, 54_car1_lap, 54_car2_lap, 54_car1_win, 54_car2_win, 55_car1_points, 55_car2_points, 55_total_points, 55_over, 55_car1_lap, 55_car2_lap, 55_car1_win, 55_car2_win, 56_car1_points, 56_car2_points, 56_total_points, 56_over, 56_car1_lap, 56_car2_lap, 56_car1_win, 56_car2_win, 57_car1_points, 57_car2_points, 57_total_points, 57_over, 57_car1_lap, 57_car2_lap, 57_car1_win, 57_car2_win, 58_car1_points, 58_car2_points, 58_total_points, 58_over, 58_car1_lap, 58_car2_lap, 58_car1_win, 58_car2_win, 59_car1_points, 59_car2_points, 59_total_points, 59_over, 59_car1_lap, 59_car2_lap, 59_car1_win, 59_car2_win, 60_car1_points, 60_car2_points, 60_total_points, 60_over, 60_car1_lap, 60_car2_lap, 60_car1_win, 60_car2_win, 61_car1_points, 61_car2_points, 61_total_points, 61_over, 61_car1_lap, 61_car2_lap, 61_car1_win, 61_car2_win, 62_car1_points, 62_car2_points, 62_total_points, 62_over, 62_car1_lap, 62_car2_lap, 62_car1_win, 62_car2_win, 63_car1_points, 63_car2_points, 63_total_points, 63_over, 63_car1_lap, 63_car2_lap, 63_car1_win, 63_car2_win, 64_car1_points, 64_car2_points, 64_total_points, 64_over, 64_car1_lap, 64_car2_lap, 64_car1_win, 64_car2_win, 65_car1_points, 65_car2_points, 65_total_points, 65_over, 65_car1_lap, 65_car2_lap, 65_car1_win, 65_car2_win, 66_car1_points, 66_car2_points, 66_total_points, 66_over, 66_car1_lap, 66_car2_lap, 66_car1_win, 66_car2_win, 67_car1_points, 67_car2_points, 67_total_points, 67_over, 67_car1_lap, 67_car2_lap, 67_car1_win, 67_car2_win, 68_car1_points, 68_car2_points, 68_total_points, 68_over, 68_car1_lap, 68_car2_lap, 68_car1_win, 68_car2_win, 69_car1_points, 69_car2_points, 69_total_points, 69_over, 69_car1_lap, 69_car2_lap, 69_car1_win, 69_car2_win, 70_car1_points, 70_car2_points, 70_total_points, 70_over, 70_car1_lap, 70_car2_lap, 70_car1_win, 70_car2_win, 71_car1_points, 71_car2_points, 71_total_points, 71_over, 71_car1_lap, 71_car2_lap, 71_car1_win, 71_car2_win, 72_car1_points, 72_car2_points, 72_total_points, 72_over, 72_car1_lap, 72_car2_lap, 72_car1_win, 72_car2_win, 73_car1_points, 73_car2_points, 73_total_points, 73_over, 73_car1_lap, 73_car2_lap, 73_car1_win, 73_car2_win, 74_car1_points, 74_car2_points, 74_total_points, 74_over, 74_car1_lap, 74_car2_lap, 74_car1_win, 74_car2_win, 75_car1_points, 75_car2_points, 75_total_points, 75_over, 75_car1_lap, 75_car2_lap, 75_car1_win, 75_car2_win, 76_car1_points, 76_car2_points, 76_total_points, 76_over, 76_car1_lap, 76_car2_lap, 76_car1_win, 76_car2_win, 77_car1_points, 77_car2_points, 77_total_points, 77_over, 77_car1_lap, 77_car2_lap, 77_car1_win, 77_car2_win, 78_car1_points, 78_car2_points, 78_total_points, 78_over, 78_car1_lap, 78_car2_lap, 78_car1_win, 78_car2_win, 79_car1_points, 79_car2_points, 79_total_points, 79_over, 79_car1_lap, 79_car2_lap, 79_car1_win, 79_car2_win, 80_car1_points, 80_car2_points, 80_total_points, 80_over, 80_car1_lap, 80_car2_lap, 80_car1_win, 80_car2_win, 81_car1_points, 81_car2_points, 81_total_points, 81_over, 81_car1_lap, 81_car2_lap, 81_car1_win, 81_car2_win, 82_car1_points, 82_car2_points, 82_total_points, 82_over, 82_car1_lap, 82_car2_lap, 82_car1_win, 82_car2_win, 83_car1_points, 83_car2_points, 83_total_points, 83_over, 83_car1_lap, 83_car2_lap, 83_car1_win, 83_car2_win) VALUES (:match_id, :date_rec, :Mdate, :Mtime, :Continent_id, :Country_code, :champion, :champ_id, :gender, :car1, :car1_id, :car2, :car2_id, :0_car1_points, :0_car2_points, :0_total_points, :0_over, :0_car1_lap, :0_car2_lap, :0_car1_win, :0_car2_win, :1_car1_points, :1_car2_points, :1_total_points, :1_over, :1_car1_lap, :1_car2_lap, :1_car1_win, :1_car2_win, :2_car1_points, :2_car2_points, :2_total_points, :2_over, :2_car1_lap, :2_car2_lap, :2_car1_win, :2_car2_win, :3_car1_points, :3_car2_points, :3_total_points, :3_over, :3_car1_lap, :3_car2_lap, :3_car1_win, :3_car2_win, :4_car1_points, :4_car2_points, :4_total_points, :4_over, :4_car1_lap, :4_car2_lap, :4_car1_win, :4_car2_win, :5_car1_points, :5_car2_points, :5_total_points, :5_over, :5_car1_lap, :5_car2_lap, :5_car1_win, :5_car2_win, :6_car1_points, :6_car2_points, :6_total_points, :6_over, :6_car1_lap, :6_car2_lap, :6_car1_win, :6_car2_win, :7_car1_points, :7_car2_points, :7_total_points, :7_over, :7_car1_lap, :7_car2_lap, :7_car1_win, :7_car2_win, :8_car1_points, :8_car2_points, :8_total_points, :8_over, :8_car1_lap, :8_car2_lap, :8_car1_win, :8_car2_win, :9_car1_points, :9_car2_points, :9_total_points, :9_over, :9_car1_lap, :9_car2_lap, :9_car1_win, :9_car2_win, :10_car1_points, :10_car2_points, :10_total_points, :10_over, :10_car1_lap, :10_car2_lap, :10_car1_win, :10_car2_win, :11_car1_points, :11_car2_points, :11_total_points, :11_over, :11_car1_lap, :11_car2_lap, :11_car1_win, :11_car2_win, :12_car1_points, :12_car2_points, :12_total_points, :12_over, :12_car1_lap, :12_car2_lap, :12_car1_win, :12_car2_win, :13_car1_points, :13_car2_points, :13_total_points, :13_over, :13_car1_lap, :13_car2_lap, :13_car1_win, :13_car2_win, :14_car1_points, :14_car2_points, :14_total_points, :14_over, :14_car1_lap, :14_car2_lap, :14_car1_win, :14_car2_win, :15_car1_points, :15_car2_points, :15_total_points, :15_over, :15_car1_lap, :15_car2_lap, :15_car1_win, :15_car2_win, :16_car1_points, :16_car2_points, :16_total_points, :16_over, :16_car1_lap, :16_car2_lap, :16_car1_win, :16_car2_win, :17_car1_points, :17_car2_points, :17_total_points, :17_over, :17_car1_lap, :17_car2_lap, :17_car1_win, :17_car2_win, :18_car1_points, :18_car2_points, :18_total_points, :18_over, :18_car1_lap, :18_car2_lap, :18_car1_win, :18_car2_win, :19_car1_points, :19_car2_points, :19_total_points, :19_over, :19_car1_lap, :19_car2_lap, :19_car1_win, :19_car2_win, :20_car1_points, :20_car2_points, :20_total_points, :20_over, :20_car1_lap, :20_car2_lap, :20_car1_win, :20_car2_win, :21_car1_points, :21_car2_points, :21_total_points, :21_over, :21_car1_lap, :21_car2_lap, :21_car1_win, :21_car2_win, :22_car1_points, :22_car2_points, :22_total_points, :22_over, :22_car1_lap, :22_car2_lap, :22_car1_win, :22_car2_win, :23_car1_points, :23_car2_points, :23_total_points, :23_over, :23_car1_lap, :23_car2_lap, :23_car1_win, :23_car2_win, :24_car1_points, :24_car2_points, :24_total_points, :24_over, :24_car1_lap, :24_car2_lap, :24_car1_win, :24_car2_win, :25_car1_points, :25_car2_points, :25_total_points, :25_over, :25_car1_lap, :25_car2_lap, :25_car1_win, :25_car2_win, :26_car1_points, :26_car2_points, :26_total_points, :26_over, :26_car1_lap, :26_car2_lap, :26_car1_win, :26_car2_win, :27_car1_points, :27_car2_points, :27_total_points, :27_over, :27_car1_lap, :27_car2_lap, :27_car1_win, :27_car2_win, :28_car1_points, :28_car2_points, :28_total_points, :28_over, :28_car1_lap, :28_car2_lap, :28_car1_win, :28_car2_win, :29_car1_points, :29_car2_points, :29_total_points, :29_over, :29_car1_lap, :29_car2_lap, :29_car1_win, :29_car2_win, :30_car1_points, :30_car2_points, :30_total_points, :30_over, :30_car1_lap, :30_car2_lap, :30_car1_win, :30_car2_win, :31_car1_points, :31_car2_points, :31_total_points, :31_over, :31_car1_lap, :31_car2_lap, :31_car1_win, :31_car2_win, :32_car1_points, :32_car2_points, :32_total_points, :32_over, :32_car1_lap, :32_car2_lap, :32_car1_win, :32_car2_win, :33_car1_points, :33_car2_points, :33_total_points, :33_over, :33_car1_lap, :33_car2_lap, :33_car1_win, :33_car2_win, :34_car1_points, :34_car2_points, :34_total_points, :34_over, :34_car1_lap, :34_car2_lap, :34_car1_win, :34_car2_win, :35_car1_points, :35_car2_points, :35_total_points, :35_over, :35_car1_lap, :35_car2_lap, :35_car1_win, :35_car2_win, :36_car1_points, :36_car2_points, :36_total_points, :36_over, :36_car1_lap, :36_car2_lap, :36_car1_win, :36_car2_win, :37_car1_points, :37_car2_points, :37_total_points, :37_over, :37_car1_lap, :37_car2_lap, :37_car1_win, :37_car2_win, :38_car1_points, :38_car2_points, :38_total_points, :38_over, :38_car1_lap, :38_car2_lap, :38_car1_win, :38_car2_win, :39_car1_points, :39_car2_points, :39_total_points, :39_over, :39_car1_lap, :39_car2_lap, :39_car1_win, :39_car2_win, :40_car1_points, :40_car2_points, :40_total_points, :40_over, :40_car1_lap, :40_car2_lap, :40_car1_win, :40_car2_win, :41_car1_points, :41_car2_points, :41_total_points, :41_over, :41_car1_lap, :41_car2_lap, :41_car1_win, :41_car2_win, :42_car1_points, :42_car2_points, :42_total_points, :42_over, :42_car1_lap, :42_car2_lap, :42_car1_win, :42_car2_win, :43_car1_points, :43_car2_points, :43_total_points, :43_over, :43_car1_lap, :43_car2_lap, :43_car1_win, :43_car2_win, :44_car1_points, :44_car2_points, :44_total_points, :44_over, :44_car1_lap, :44_car2_lap, :44_car1_win, :44_car2_win, :45_car1_points, :45_car2_points, :45_total_points, :45_over, :45_car1_lap, :45_car2_lap, :45_car1_win, :45_car2_win, :46_car1_points, :46_car2_points, :46_total_points, :46_over, :46_car1_lap, :46_car2_lap, :46_car1_win, :46_car2_win, :47_car1_points, :47_car2_points, :47_total_points, :47_over, :47_car1_lap, :47_car2_lap, :47_car1_win, :47_car2_win, :48_car1_points, :48_car2_points, :48_total_points, :48_over, :48_car1_lap, :48_car2_lap, :48_car1_win, :48_car2_win, :49_car1_points, :49_car2_points, :49_total_points, :49_over, :49_car1_lap, :49_car2_lap, :49_car1_win, :49_car2_win, :50_car1_points, :50_car2_points, :50_total_points, :50_over, :50_car1_lap, :50_car2_lap, :50_car1_win, :50_car2_win, :51_car1_points, :51_car2_points, :51_total_points, :51_over, :51_car1_lap, :51_car2_lap, :51_car1_win, :51_car2_win, :52_car1_points, :52_car2_points, :52_total_points, :52_over, :52_car1_lap, :52_car2_lap, :52_car1_win, :52_car2_win, :53_car1_points, :53_car2_points, :53_total_points, :53_over, :53_car1_lap, :53_car2_lap, :53_car1_win, :53_car2_win, :54_car1_points, :54_car2_points, :54_total_points, :54_over, :54_car1_lap, :54_car2_lap, :54_car1_win, :54_car2_win, :55_car1_points, :55_car2_points, :55_total_points, :55_over, :55_car1_lap, :55_car2_lap, :55_car1_win, :55_car2_win, :56_car1_points, :56_car2_points, :56_total_points, :56_over, :56_car1_lap, :56_car2_lap, :56_car1_win, :56_car2_win, :57_car1_points, :57_car2_points, :57_total_points, :57_over, :57_car1_lap, :57_car2_lap, :57_car1_win, :57_car2_win, :58_car1_points, :58_car2_points, :58_total_points, :58_over, :58_car1_lap, :58_car2_lap, :58_car1_win, :58_car2_win, :59_car1_points, :59_car2_points, :59_total_points, :59_over, :59_car1_lap, :59_car2_lap, :59_car1_win, :59_car2_win, :60_car1_points, :60_car2_points, :60_total_points, :60_over, :60_car1_lap, :60_car2_lap, :60_car1_win, :60_car2_win, :61_car1_points, :61_car2_points, :61_total_points, :61_over, :61_car1_lap, :61_car2_lap, :61_car1_win, :61_car2_win, :62_car1_points, :62_car2_points, :62_total_points, :62_over, :62_car1_lap, :62_car2_lap, :62_car1_win, :62_car2_win, :63_car1_points, :63_car2_points, :63_total_points, :63_over, :63_car1_lap, :63_car2_lap, :63_car1_win, :63_car2_win, :64_car1_points, :64_car2_points, :64_total_points, :64_over, :64_car1_lap, :64_car2_lap, :64_car1_win, :64_car2_win, :65_car1_points, :65_car2_points, :65_total_points, :65_over, :65_car1_lap, :65_car2_lap, :65_car1_win, :65_car2_win, :66_car1_points, :66_car2_points, :66_total_points, :66_over, :66_car1_lap, :66_car2_lap, :66_car1_win, :66_car2_win, :67_car1_points, :67_car2_points, :67_total_points, :67_over, :67_car1_lap, :67_car2_lap, :67_car1_win, :67_car2_win, :68_car1_points, :68_car2_points, :68_total_points, :68_over, :68_car1_lap, :68_car2_lap, :68_car1_win, :68_car2_win, :69_car1_points, :69_car2_points, :69_total_points, :69_over, :69_car1_lap, :69_car2_lap, :69_car1_win, :69_car2_win, :70_car1_points, :70_car2_points, :70_total_points, :70_over, :70_car1_lap, :70_car2_lap, :70_car1_win, :70_car2_win, :71_car1_points, :71_car2_points, :71_total_points, :71_over, :71_car1_lap, :71_car2_lap, :71_car1_win, :71_car2_win, :72_car1_points, :72_car2_points, :72_total_points, :72_over, :72_car1_lap, :72_car2_lap, :72_car1_win, :72_car2_win, :73_car1_points, :73_car2_points, :73_total_points, :73_over, :73_car1_lap, :73_car2_lap, :73_car1_win, :73_car2_win, :74_car1_points, :74_car2_points, :74_total_points, :74_over, :74_car1_lap, :74_car2_lap, :74_car1_win, :74_car2_win, :75_car1_points, :75_car2_points, :75_total_points, :75_over, :75_car1_lap, :75_car2_lap, :75_car1_win, :75_car2_win, :76_car1_points, :76_car2_points, :76_total_points, :76_over, :76_car1_lap, :76_car2_lap, :76_car1_win, :76_car2_win, :77_car1_points, :77_car2_points, :77_total_points, :77_over, :77_car1_lap, :77_car2_lap, :77_car1_win, :77_car2_win, :78_car1_points, :78_car2_points, :78_total_points, :78_over, :78_car1_lap, :78_car2_lap, :78_car1_win, :78_car2_win, :79_car1_points, :79_car2_points, :79_total_points, :79_over, :79_car1_lap, :79_car2_lap, :79_car1_win, :79_car2_win, :80_car1_points, :80_car2_points, :80_total_points, :80_over, :80_car1_lap, :80_car2_lap, :80_car1_win, :80_car2_win, :81_car1_points, :81_car2_points, :81_total_points, :81_over, :81_car1_lap, :81_car2_lap, :81_car1_win, :81_car2_win, :82_car1_points, :82_car2_points, :82_total_points, :82_over, :82_car1_lap, :82_car2_lap, :82_car1_win, :82_car2_win, :83_car1_points, :83_car2_points, :83_total_points, :83_over, :83_car1_lap, :83_car2_lap, :83_car1_win, :83_car2_win)";
	$stmt = $db->getConnection()->prepare($sql);



$add=0;
$decline=0;

foreach ($rows as $fields) {
    $tmp_line=null;
    $x += 1;

    //set the default table fields
	for($i = 0; $i < 13; $i++)
	{
       $stmt->bindValue($table_columns[$i] , $fields[$table_columns[$i]]);
    }

    //for only the 0-83 steps
	for($i = 0; $i < 84; $i++)
	{
        //when is not set, means no record @ source table, we adjust the code as per logic
        if (!isset($fields[$i."_c1_points"]))
        {
            $stmt->bindValue(":".$i."_car1_points" , 0 );
            $stmt->bindValue(":".$i."_car2_points", 0 );
            $stmt->bindValue(":".$i."_total_points" , 0 );
            $stmt->bindValue(":".$i."_over" , 0 );
            $stmt->bindValue(":".$i."_car1_lap" , 0 );
            $stmt->bindValue(":".$i."_car2_lap" , 0 );
            $stmt->bindValue(":".$i."_car1_win" , 0 );
            $stmt->bindValue(":".$i."_car2_win" , 0 );
        }
        else {
            $stmt->bindValue(":".$i."_car1_points" , is_null($fields[$i."_c1_points"]) ? 0 : $fields[$i."_c1_points"] );
            $stmt->bindValue(":".$i."_car2_points", is_null($fields[$i."_c2_points"]) ? 0 : $fields[$i."_c2_points"] );
            $stmt->bindValue(":".$i."_total_points" , is_null($fields[$i."_total_points"]) ? 0 : $fields[$i."_total_points"] );
            $stmt->bindValue(":".$i."_over" , is_null($fields[$i."_over"]) ? 0 : $fields[$i."_over"] );
            $stmt->bindValue(":".$i."_car1_lap" , is_null($fields[$i."_c1_lap"]) ? 0 : $fields[$i."_c1_lap"] );
            $stmt->bindValue(":".$i."_car2_lap" , is_null($fields[$i."_c2_lap"]) ? 0 : $fields[$i."_c2_lap"] );
            $stmt->bindValue(":".$i."_car1_win" , is_null($fields[$i."_c1_win"]) ? 0 : $fields[$i."_c1_win"] );
            $stmt->bindValue(":".$i."_car2_win" , is_null($fields[$i."_c2_win"]) ? 0 : $fields[$i."_c2_win"] );
        }

    }

    try{
        $stmt->execute();
    }  catch (Exception $e) {
        if ($e->getCode() != '23000')
            throw $e;
    }
    

    $res = $stmt->rowCount();

    if($res == 1)
	    $add+=1;
    else
        $decline+=1;
}

$status = <<<EOD
<style>
* {
  font-family: "Roboto",sans-serif;
}
</style>
Clone status of the data between <strong>$start_dt - $end_dt</strong><br>
-------------------------------------------------------------------------------<br>
rows added : <strong><span style="color:green;">$add</span></strong> <br>
rows decline due <strong>match_id</strong> constraint violation : <strong><span style="color:red;">$decline</span></strong> 
EOD;


echo $status;
