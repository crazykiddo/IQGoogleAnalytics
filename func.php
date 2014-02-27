<?php
//session_start();
/*
	IQuantum Google Analytics
*/
function enableDebug(){
	ini_set('display_errors',1);
	ini_set('display_startup_errors',1);
	error_reporting(-1);
}


function GetDataTest($projectId){
	global $client;
	global $service;
	// 74627844  = throa
	//$projectId = '74627844';

	// metrics
	$_params[] = 'date';
	$_params[] = 'date_year';
	$_params[] = 'date_month';
	$_params[] = 'date_day';
	// dimensions
	$_params[] = 'visits';
	$_params[] = 'pageviews';
	$_params[] = 'bounces';
	$_params[] = 'entrance_bounce_rate';
	$_params[] = 'visit_bounce_rate';
	$_params[] = 'avg_time_on_site';

	$from = date('Y-m-d', time()-7*24*60*60); // 7 days
	$to = date('Y-m-d'); // today

	$metrics = 'ga:visits,ga:pageviews,ga:bounces,ga:entranceBounceRate,ga:visitBounceRate,ga:avgTimeOnSite';
	$dimensions = 'ga:date,ga:year,ga:month,ga:day';
	$data = $service->data_ga->get('ga:'.$projectId, $from, $to, $metrics, array('dimensions' => $dimensions));

	foreach($data['rows'] as $row) {
		$dataRow = array();
		//foreach($_params as $colNr => $column) echo $column . ': '.$row[$colNr].', ';
		foreach($_params as $colNr => $column) {
			echo $column . ': '.$row[$colNr].'<br>';
		}
		echo "<hr>";
	}
	//Google_Service_Analytics
}
function GetDataTest2($projectId){
	global $client;
	global $service;
	
	// metrics
	$_params[] = 'date';
	$_params[] = 'date_year';
	$_params[] = 'date_month';
	$_params[] = 'date_day';
	// dimensions
	$_params[] = 'visits';
	$_params[] = 'pageviews';
	$_params[] = 'bounces';
	//$_params[] = 'entrance_bounce_rate';
	//$_params[] = 'visit_bounce_rate';
	//$_params[] = 'avg_time_on_site';

	$from = date('Y-m-d', time()-7*24*60*60); // 7 days
	$to = date('Y-m-d'); // today

	//$metrics = 'ga:visits,ga:pageviews,ga:bounces,ga:entranceBounceRate,ga:visitBounceRate,ga:avgTimeOnSite';
	$metrics = 'ga:visits,ga:pageviews,ga:bounces';
	$dimensions = 'ga:date,ga:year,ga:month,ga:day';
	$data = $service->data_ga->get('ga:'.$projectId, $from, $to, $metrics, array('dimensions' => $dimensions));

	foreach($data['rows'] as $row) {
		$dataRow = array();
		foreach($_params as $colNr => $column) {
			echo $column . ': '.$row[$colNr].'<br>';
		}
		echo "<hr>";
	}
	//Google_Service_Analytics
}


function GetAccountList(){
	global $client;
	global $service;
	try {
		$props = $service->management_webproperties->listManagementWebproperties("~all");
		echo '<h1>Available Google Analytics projects</h1><ul>'."\n";
		foreach($props['items'] as $item) printf('<li>%1$s</li>', $item['name']);
		echo '</ul>';
	} catch (Exception $e) {
		die('An error occured: ' . $e->getMessage()."\n");
	}
}

function GetAccountListDropdown(){
	global $client;
	global $service;
	$tmp = "";
	try {
		$props = $service->management_webproperties->listManagementWebproperties("~all");
		foreach($props['items'] as $item){
			$acc_id = $item['id'];
			$acc_id_cleansp = explode("-", $acc_id);
			$acc_id_clean = $acc_id_cleansp[1];
			$acc_name = $item['name'];
			$acc_created = $item['created'];
			$acc_kind = $item['kind'];
			//echo $acc_id_clean."<br>";
			$acc_pid = getProfileIdFromAccount($service, $acc_id_clean);
			
			$acc_valset = $acc_id.",".$acc_pid;
			$setsel = "";
			$tmp2 = "";
			if (isset($_SESSION['aid']) && isset($_SESSION['pid'])){
				$aid = $_SESSION['aid'];			
				$pid = $_SESSION['pid'];
				$tmp2 = $aid.",".$pid;
			}
			if ($tmp2==$acc_valset){
				//$setsel = " SELECTED";
				$tmp.="<option SELECTED value='".$acc_valset."'>".$acc_name."</option>\n";
			}else{
				$tmp.="<option".$setsel." value='".$acc_valset."'>".$acc_name."</option>\n";
			}
			//$tmp.="<option".$setsel." value='".$acc_valset."'>".$acc_name."</option>\n";
			//$tmp.="<option value='".$acc_id."'>".$acc_name."</option>\n";
		}
		return $tmp;
	} catch (Exception $e) {
		die('An error occured: ' . $e->getMessage()."\n");
	}
}

function getProfileIdFromAccount($analytics, $firstAccountId) {
    $accounts = $analytics->management_accounts->listManagementAccounts();
	if (count($accounts->getItems()) > 0) {
		$items = $accounts->getItems();
        //$firstAccountId = $items[0]->getId();
        $webproperties = $analytics->management_webproperties->listManagementWebproperties($firstAccountId);
        if (count($webproperties->getItems()) > 0) {
            $items = $webproperties->getItems();
            $firstWebpropertyId = $items[0]->getId();
            $profiles = $analytics->management_profiles->listManagementProfiles($firstAccountId, $firstWebpropertyId);
            if (count($profiles->getItems()) > 0) {
                $items = $profiles->getItems();
                return $items[0]->getId();
            } else {
            throw new Exception('No views (profiles) found for this user.');
            }
        } else {
            throw new Exception('No webproperties found for this user.');
        }
    } else {
        throw new Exception('No accounts found for this user.');
    }
}

function getFirstprofileId($analytics) {
    $accounts = $analytics->management_accounts->listManagementAccounts();
    if (count($accounts->getItems()) > 0) {
        $items = $accounts->getItems();
        $firstAccountId = $items[0]->getId();
        $webproperties = $analytics->management_webproperties->listManagementWebproperties($firstAccountId);
        if (count($webproperties->getItems()) > 0) {
            $items = $webproperties->getItems();
            $firstWebpropertyId = $items[0]->getId();
            $profiles = $analytics->management_profiles->listManagementProfiles($firstAccountId, $firstWebpropertyId);
            if (count($profiles->getItems()) > 0) {
                $items = $profiles->getItems();
                return $items[0]->getId();
            } else {
            throw new Exception('No views (profiles) found for this user.');
            }
        } else {
            throw new Exception('No webproperties found for this user.');
        }
    } else {
        throw new Exception('No accounts found for this user.');
    }
}

?>