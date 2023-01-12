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
 ?>