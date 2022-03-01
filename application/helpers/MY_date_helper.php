<?php
/*
 *get date type int
 * $time : int - thoi gian muon hien thi ngay
 * $fulll_time : cho biet co lau ca gio phut giay hay khong
 */
function get_date($time,$full_time = true)
{
	$format = '%d-%m-%y';
	if($full_time){
		$format = $format.' - %H:%i:%s';
	}
	$data = mdate($format,$time);
	return $data;
}
