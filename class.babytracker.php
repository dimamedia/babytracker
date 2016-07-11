<?php

class babytracker {

	private $db;
	
	public function __construct() {
		global $db;
		$this->db = $db;
	}

	public function get($id) {
		$result = $this->db->select('babytracker','id = '.$id, '', '*', 1);
		return $result[0]; 
	}

	public function add($post) {
		unset($post['save']);
		if(!empty($post['additions'])) $post['additions'] = implode(",",$post['additions']);
		if(!empty($post['temperature'])) $post['temperature'] = str_replace(",",".",$post['temperature']);
		
		if($id = $this->db->insert('babytracker', $post)) {
			return array('status'=>'ok', 'info'=>'Uusi tieto tallennettu.', 'id'=>$id);
		}
		else return array('status'=>'error', 'info'=>'Virhe tallennuksessa.');
	}
	public function update($id, $post) {
		unset($post['save']);
		if(!empty($post['additions'])) $post['additions'] = implode(",",$post['additions']);
		if(!empty($post['temperature'])) $post['temperature'] = str_replace(",",".",$post['temperature']);
		
		$result = $this->db->update('babytracker', $post, "id = '$id'");
		if($result > 0) return array('status'=>'ok', 'info'=>'Tiedot päivitetty.');
		else return array('status'=>'error', 'info'=>'Virhe päivityksessä.');
	}
	
	public function delete($id) {
		$result = $this->db->delete('babytracker', "id = '$id'");
		if($result > 0) return array('status'=>'ok', 'info'=>'Tiedot poistettu.');
		else return array('status'=>'error', 'info'=>'Virhe poistossa.');		
	}
	
	public function getList($all = false) {
		if(!$all) $where = "WHERE time > '".date('Y-m-d', strtotime('-10 days', time()))."'";
		else $where = null;
		
		$result = $this->db->run("SELECT *, breast+bottleBreast+bottleSubstitute+bottleOther as sumIn, pee+poo as sumOut FROM babytracker $where ORDER BY time");
		$newResult = array();
		foreach($result as $row) {
			$currDatetime = strtotime($row['time']);
			$currTime = date("H:i", $currDatetime);
			$currDate = date("d-m-Y", $currDatetime);

			if($currTime < DAYSUMRESETTIME.":00") $deadline = strtotime($currDate." ".DAYSUMRESETTIME.":00");
			else $deadline = strtotime("+1 day", strtotime($currDate." ".DAYSUMRESETTIME.":00"));

			if($deadline == $lastdeadline AND $currDatetime < $deadline) $daySum += $row['sumIn'];
			else $daySum = $row['sumIn'];
			
			$row['daySum'] = $daySum;
			$newResult[] = $row;
			$lastdeadline = $deadline;
		}
		krsort($newResult);
		return $newResult;
	}
	
	public function getChartList() {
		$result = $this->db->run("SELECT time, weight, height, breast, bottleBreast, bottleSubstitute, bottleOther, breast+bottleBreast as breastMilk, breast+bottleBreast+bottleSubstitute+bottleOther as sumIn, pee+poo as sumOut FROM babytracker ORDER BY time");
		$data = array();
		foreach($result as $row) {
			if($row['weight'] > 0) $weight = $row['weight']; 
			if($row['height'] > 0) $height = $row['height']; 
			$currDate = date("d\.m\.Y", strtotime($row['time']));
			$data[$currDate]['weight'] = $weight;
			$data[$currDate]['height'] = $height;
			$data[$currDate]['breast'] += $row['breast'];
			$data[$currDate]['bottleBreast'] += $row['bottleBreast'];
			$data[$currDate]['bottleSubstitute'] += $row['bottleSubstitute'];
			$data[$currDate]['bottleOther'] += $row['bottleOther'];
			$data[$currDate]['breastMilk'] += $row['breastMilk'];
			$data[$currDate]['in'] += $row['sumIn'];
			$data[$currDate]['out'] += $row['sumOut'];
		}
		return $data;	
	}

}

?>