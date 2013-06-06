function aj_nd(curmonth,curyear,mid) 
{
	new Ajax(server_url+'modules/mod_jalendar/mod_jalendar.php',{method: 'post',update: 'idcal',data:'curmonth='+curmonth+'&curyear='+curyear+'&mid='+mid}).request();
}