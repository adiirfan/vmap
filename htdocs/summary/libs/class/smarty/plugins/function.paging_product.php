<?php
function smarty_function_paging_product($params, &$smarty)
{
	$this_script = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
	$total_page = $params['total_page'];
	$cons=$params['cons'];
	$act_page=$params['act_page'];;
	$key=$params['key'];
	
	$act_page = ($total_page < $act_page) ? $total_page : $act_page;
	$start_page = 1;
	if($act_page > ($cons/2))
		$start_page = $act_page - ($cons/2);
	$end_page = (($start_page+($cons))>$total_page) ? $total_page : $start_page+($cons-1);
	
	$string = '<a href="'.$this_script.$key.'/page/1" class="paging_link"><</a>&nbsp;';
	
	for($i=$start_page;$i<=$end_page;$i++)
	{
		if($i==$act_page)
			$string .= '<b>'.$i.'</b>&nbsp;';
		else
			$string .= '<a href="'.$this_script.$key.'/page/'.$i.'" class="paging_link">'.$i.'</a>&nbsp;.&nbsp;';
	}
	$string .= '<a href="'.$this_script.$key.'/page/'.$total_page.'" class="paging_link">></a>';
	
	return $string;
}
?>