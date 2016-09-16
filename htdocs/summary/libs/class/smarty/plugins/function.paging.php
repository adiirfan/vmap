<?php
function smarty_function_paging($params, &$smarty)
{
	$total_page = $params['total_page'];
	$cons=$params['cons'];
	$act_page=$params['act_page'];;
	$key=$params['key'];
	
	$act_page = ($total_page < $act_page) ? $total_page : $act_page;
	$start_page = 1;
	if($act_page > ($cons/2))
		$start_page = $act_page - ($cons/2);
	$end_page = (($start_page+($cons))>$total_page) ? $total_page : $start_page+($cons-1);
	
	$string = '<a href="'.$this_script.$key.'/page/1" class="paging">First</a>&nbsp;';
	
	for($i=$start_page;$i<=$end_page;$i++)
	{
		if($i==$act_page)
			$string .= '<b>'.$i.'</b>&nbsp;';
		else
			$string .= '<a href="'.$this_script.$key.'/page/'.$i.'" class="paging">'.$i.'</a>&nbsp;';
	}
	
	$string .= '<a href="'.$this_script.$key.'/page/'.$total_page.'" class="paging">Last</a>';

	return $string;
}
?>