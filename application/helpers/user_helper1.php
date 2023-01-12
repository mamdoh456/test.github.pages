<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
if(!function_exists('islogged')) {
  function islogged() {
	$CI = & get_instance();
   	$session = $CI->session->userdata('isLogin');
	if($session == FALSE)
		return false;
	else
		return true;
  }
}
 function date_change_db($date){
	 if(!empty($date)){
		$exp_date = explode('/',$date);
		if(sizeof($exp_date)>1)
			return $exp_date[2].'-'.$exp_date[1].'-'.$exp_date[0];
	 }
	 else
	 	return;
	}
	function date_change_crud($date){
	 if(!empty($date)){
		$exp_date = explode('/',$date);
		if(sizeof($exp_date)>1)
			return $exp_date[1].'-'.$exp_date[0].'-'.$exp_date[2];
	 }
	 else
	 	return;
	}
	function date_change_view($date){
		if(!empty($date)){
			$exp_date = explode('-',$date);
			if(sizeof($exp_date)>1)
				return $exp_date[2].'/'.$exp_date[1].'/'.$exp_date[0];
		}
		else		
			return;
	}
	function detail_view($detail){
		$detail = explode('--',$detail);
		return $detail[1];
	}
	function detail_db($detail){
		$detail = explode('--',$detail);
		return $detail[0];
	}
	function date_range_db1($date_range){
		$date1 = explode(' - ',$date_range);
		return $date1[0];
	}
	function date_range_db2($date_range){
		$date2 = explode(' - ',$date_range);
		return $date2[1];
	}
	function amount($amount){
	 if(!empty($amount)){
		$amount1 = explode(',',$amount);
		$counter = sizeof($amount1);
		$count = 0;
		while($counter > 0){
			
				$new_amount = $new_amount.$amount1[$count];
				$count++;
				$counter--;
			}
			return $new_amount;
	 }
	 
	 else
	 	return;
	}
 ?>