<?php
class DB 
{
	var $date;
	var $call;

	function DB ($hostname,$username,$dbname,$dbpass)
    {
		$this->date = date("M")."_".date("d")."_".date("Y");

		$this->call = new PDO('mysql:host='.$hostname.';dbname='.$dbname.';charset=utf8', $username, $dbpass);
		$this->call->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->call->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		
		return $this->call;
    }

    function getData($table, $rows="*", $where=null, $limit=null, $order=null, $optWhere="AND", $parameter=null){
    	if(is_null($parameter)) $parameter = '=';
    	if(is_array($rows) AND count($rows) > 0)
    		$rows = implode(", ", $rows);
    	
    	if(is_array($where) AND count($where) > 0){
    		$tmpWhere = array();
    		foreach($where as $keyRow => $keyValue){
    			if(preg_match('/\s/',$keyRow)) {
    				$tmpKeyRows = explode(" ", $keyRow);
    				$tmpWhere[] = $tmpKeyRows[0] . " " . $tmpKeyRows[1] . " ?";
    			}else{
    				$tmpWhere[] = $keyRow . $parameter . " ?";
    			}

    			$bindingData[] = $keyValue;
    		}

    		$where = "WHERE " . implode(" " . $optWhere . " ", $tmpWhere);
    	}elseif (!is_null($where)) {
    		$where = " where ".$where;
    	}

    	if(!is_null($order))
    		$where .= " ORDER BY {$order} ";

    	// limit data
    	if(!is_null($limit) AND is_array($limit) AND count($limit) == 2)
    		$where .= " LIMIT {$limit[0]}, {$limit[1]} ";

    	// /echo "<!-- SELECT {$rows} FROM {$table} " . $where; echo $bindingData[0]."-->";

    	if(is_null($bindingData)){
    		$stmt = $this->call->query("SELECT {$rows} FROM {$table} " . $where);
    	}else{
    		// create query
	    	$stmt = $this->call->prepare("SELECT {$rows} FROM {$table} " . $where);
	    	// prepare data where
	    	if(is_array($bindingData) AND count($bindingData) > 0)
				$stmt->execute($bindingData);
    	}
    	// get data
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    	
		if(count($rows) == 0)
			return NULL;
		elseif(count($rows) == 1)
			return (object) $rows[0];
		else
			return (object) $rows;
    }
	
	function insertData($table, $params){
		if(is_array($params) AND count($params) > 0){
			$tmpRows = $tmpValue = array();
			foreach($params as $rows => $value){
				$tmpRows[] 	= $rows;
				$tmpValue[] = "?";
				$tmpData[]	= $value;
			}
			$query	= "INSERT INTO $table (". implode(", ", $tmpRows) .") VALUES (". implode(", ", $tmpValue) .")";
			//echo "<pre>";var_dump($tmpData);die;
			$stmt = $this->call->prepare($query);
			try {	
				$stmt->execute($tmpData);
			} catch(PDOException $ex) {
				echo'<pre>'; print_r($ex); die('</pre>');
			}

			$insertId = $this->call->lastInsertId();
			return $insertId;
		}

		return 0;
	}

	function updateData($table, $update=array(), $where=null, $optWhere="AND"){
		$bindingData = array();

    	if(is_array($update) AND count($update) > 0){
	    	$tmpUpdate = array();
	    	foreach($update as $rowUpdate => $valueUpdate){
	    		$tmpUpdate[] 	= $rowUpdate . " = ?";
	    		$bindingData[]	= $valueUpdate;
	    	}

	    	$update = "SET " . implode(", ", $tmpUpdate);
	    }else{
	    	die("Error when execute function!");	
	    }
    	if(is_array($where) AND count($where) > 0){
    		$tmpWhere = array();
    		foreach($where as $keyRow => $keyValue){
    			if(preg_match('/\s/',$keyRow)) {
    				$tmpKeyRows = explode(" ", $keyRow);
    				$tmpWhere[] = $tmpKeyRows[0] . " " . $tmpKeyRows[1] . " ?";
    			}else{
    				$tmpWhere[] = $keyRow . " = ?";
    			}
    		}

    		$bindingData[] = $keyValue;
    		$where = " WHERE " . implode($optWhere . " ", $tmpWhere);
    	}elseif(!is_null($where)){
    		$where = " where ".$where;
    	}
    	
    	// create query
    	
    	$stmt = $this->call->prepare("UPDATE {$table} " . $update . $where);
    	
    	// prepare data where
    	if(is_array($bindingData) AND count($bindingData) > 0){
			$stmt->execute($bindingData);
			$affected_rows = $stmt->rowCount();
			return $affected_rows;
		}

		return 0;
	}

	function deleteData($table, $where){
		$optWhere	= "and";
		if(is_array($where) AND count($where) > 0){
    		$tmpWhere = array();
    		foreach($where as $keyRow => $keyValue){
    			if(preg_match('/\s/',$keyRow)) {
    				$tmpKeyRows = explode(" ", $keyRow);
    				$tmpWhere[] = $tmpKeyRows[0] . " " . $tmpKeyRows[1] . " ?";
    			}else{
    				$tmpWhere[] = $keyRow . " = ?";
    			}

    			$bindingData[] = $keyValue;
    		}

    		$where = "WHERE " . implode(" " . $optWhere . " ", $tmpWhere);

    		if(is_null($bindingData)){
	    		$stmt = $this->call->query("DELETE FROM {$table} " . $where);
	    	}else{
	    		// create query
		    	$stmt = $this->call->prepare("DELETE FROM {$table} " . $where);
		    	// prepare data where
		    	if(is_array($bindingData) AND count($bindingData) > 0)
					$stmt->execute($bindingData);
	    	}
		}

		return 0;
	}
	function truncateTable($table){
	    $stmt = $this->call->query("TRUNCATE TABLE {$table}");
		//mysql_query($query);
		//$stmt = $this->call->prepare($query);
		//var_dump($query);die();
	}
}
?>