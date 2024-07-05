
<?php
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Easy set variables
	 */
	
	/* Array of database columns which should be read and sent back to DataTables. Use a space where
	 * you want to insert a non-database field (for example a counter or static image)
	 */
	$aColumns = array('ID' );
	
	/* Indexed column (used for fast and accurate table cardinality) */
	$sIndexColumn = "ID";
	
	/* DB table to use */
	$sTable = "wp_users";
	
	/* Database connection information */
	$gaSql['user']       = "taichi";
	$gaSql['password']   = "poF5P6nmZ5AbHhcUNVUd";
	$gaSql['db']         = "wp_taichi";
	$gaSql['server']     = "127.0.0.1";
	
	/* REMOVE THIS LINE (it just includes my SQL connection user/pass) */
	//include( $_SERVER['DOCUMENT_ROOT']."/datatables/mysql.php" );
	
	
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * If you just want to use the basic configuration for DataTables with PHP server-side, there is
	 * no need to edit below this line
	 */
	
	/* 
	 * MySQL connection
	 */
	$gaSql['link'] =  mysql_pconnect( $gaSql['server'], $gaSql['user'], $gaSql['password']  ) or
		die( 'Could not open connection to server' );
	
	mysql_select_db( $gaSql['db'], $gaSql['link'] ) or 
		die( 'Could not select database '. $gaSql['db'] );
	
	
	/* 
	 * Paging
	 */
	$sLimit = "";
	if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
	{
		$sLimit = "LIMIT ".intval( $_GET['iDisplayStart'] ).", ".
			intval( $_GET['iDisplayLength'] );
	}
	
	
	/*
	 * Ordering
	 */
	$sOrder = "";
	if ( isset( $_GET['iSortCol_0'] ) )
	{
		$sOrder = "ORDER BY  ";
		for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
		{
			if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
			{
				$sOrder .= "`".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."` ".
					($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
			}
		}
		
		$sOrder = substr_replace( $sOrder, "", -2 );
		if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "";
		}
	}
	
	
	/* 
	 * Filtering
	 * NOTE this does not match the built-in DataTables filtering which does it
	 * word by word on any field. It's possible to do here, but concerned about efficiency
	 * on very large tables, and MySQL's regex functionality is very limited
	 */
	$sWhere = "";
	if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" )
	{
		$sWhere = "WHERE (";
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			$sWhere .= "`".$aColumns[$i]."` LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";
		}
		$sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ')';
	}
	
	/* Individual column filtering */
	for ( $i=0 ; $i<count($aColumns) ; $i++ )
	{
		if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
		{
			if ( $sWhere == "" )
			{
				$sWhere = "WHERE ";
			}
			else
			{
				$sWhere .= " AND ";
			}
			$sWhere .= "`".$aColumns[$i]."` LIKE '%".mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";
		}
	}
	
	
	/*
	 * SQL queries
	 * Get data to display
	 */
	



$offset = $_POST['offset'];


if (isset($_POST['country']) && $_POST['country'] != '' )
{
$sQuery = "

SELECT distinct `wp_users`.ID FROM `wp_users`
INNER JOIN wp_groups_user_group
ON  `wp_users`.`ID` = wp_groups_user_group.user_id
INNER JOIN wp_Instructors_Certification
ON  `wp_users`.`ID` = wp_Instructors_Certification.instructor_id
INNER JOIN wp_usermeta
ON  `wp_users`.`ID` = wp_usermeta.user_id

WHERE group_id = 4 and wp_Instructors_Certification.certification_expiry_date > curdate() and meta_key = 'country' and meta_value = '{$_POST['country']}' limit 5 OFFSET $offset ";

}
else
{

$sQuery = "
		   SELECT distinct `wp_users`.* FROM `wp_users`
INNER JOIN wp_groups_user_group
ON  `wp_users`.`ID` = wp_groups_user_group.user_id
INNER JOIN wp_Instructors_Certification
ON  `wp_users`.`ID` = wp_Instructors_Certification.instructor_id

WHERE group_id = 4 and wp_Instructors_Certification.certification_expiry_date > curdate()  limit 5 OFFSET $offset
		";
}



	$rResult = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
	
	/* Data set length after filtering */
	$sQuery = "
		SELECT FOUND_ROWS()
	";
	$rResultFilterTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
	$aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
	$iFilteredTotal = $aResultFilterTotal[0];
	
	/* Total data set length */
	$sQuery = "
		SELECT COUNT(`".$sIndexColumn."`)
		FROM   $sTable
	";
	$rResultTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
	$aResultTotal = mysql_fetch_array($rResultTotal);
	$iTotal = $aResultTotal[0];
	
	
	/*
	 * Output
	 */
	$output = array(
		"sEcho" => intval($_GET['sEcho']),
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iFilteredTotal,
		"aaData" => array()
	);
	
	while ( $aRow = mysql_fetch_array( $rResult ) )
	{
		$row = array();
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] == "version" )
			{
				/* Special output formatting for 'version' column */
				$row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ];
			}
			else if ( $aColumns[$i] != ' ' )
			{
				/* General output */
				$aRow['ID'];				
				$row[] = $aRow[ $aColumns[$i] ];
			}
		}
		
///			full name

$lastname = "
    SELECT * FROM `wp_usermeta` where meta_key = 'last_name' and user_id = ".$aRow['ID']."
    		   ";
$lastn = mysql_query( $lastname) or die(mysql_error());
$ln = mysql_fetch_array( $lastn );
$firstname = "
    SELECT * FROM `wp_usermeta` where meta_key = 'first_name' and user_id = ".$aRow['ID']."
    		   ";
$firstn = mysql_query( $firstname) or die(mysql_error());
$fn = mysql_fetch_array( $firstn );	
$row[] =  "<a href = 'http://taichi.wpengine.com/profile/".$aRow['ID']."'>".$ln['meta_value'].",".$fn['meta_value']."</a>";	

///			full name
		

///			state,suburb,country

$state = "SELECT * FROM `wp_usermeta` where meta_key = 'state' and user_id = ".$aRow['ID']."
    		   ";
$staten = mysql_query( $state) or die(mysql_error());
$stn = mysql_fetch_array( $staten );
$row[] = $stn['meta_value'];

$suburb = "SELECT * FROM `wp_usermeta` where meta_key = 'suburb' and user_id = ".$aRow['ID']."
    		   ";
$suburbn = mysql_query( $suburb) or die(mysql_error());
$subn = mysql_fetch_array( $suburbn );	
$row[] = $subn['meta_value'];

$country = "SELECT * FROM `wp_usermeta` where meta_key = 'country' and user_id = ".$aRow['ID']."
    		   ";
$countryn = mysql_query( $country) or die(mysql_error());
$cn = mysql_fetch_array( $countryn );	
$row[] = $cn['meta_value'];




///			state,suburb,country


///			certifications

$certification = "SELECT * FROM `wp_usermeta` where meta_key = 'certification' and user_id = ".$aRow['ID']."
    		   ";
$certn = mysql_query( $certification) or die(mysql_error());
$ctn = mysql_fetch_array( $certn );
$cert = $ctn['meta_value'];
$display = '';

////////////////	certcode
$certi = explode(',',$cert);
						$ind = 0;
						for($i = 0;$i<= sizeof($certi);$i++)
						{
							if ( $certi[$i] != '')
							{$certif[$ind] = $certi[$i];$ind++;}
						}
						



		$certif = array_filter($certif);			


 
$queryy = "SELECT * FROM `wp_Instructors_Certification` where instructor_id = {$aRow['ID']} and certification_expiry_date > CURDATE() ";

	$user_certs_query_result = mysql_query($queryy);	
	

	
	while ($cert_obj = mysql_fetch_object($user_certs_query_result))
{						if($cert_obj->name == '')
					continue;		
	$cert_id_query_result = mysql_query( "SELECT ID FROM wp_posts where post_title ='{$cert_obj->name}' and post_type = 'certificate_template' ");
	$cert_id = mysql_fetch_object($cert_id_query_result);
	$cert_aid_query_result = mysql_query( "SELECT meta_value FROM `wp_postmeta` where post_id = $cert_id->ID and meta_key = '_thumbnail_id'");
	$cert_aid = mysql_fetch_object($cert_aid_query_result);
	$val_result = mysql_query( "SELECT guid FROM wp_posts where ID ={$cert_aid->meta_value}");
	$val = mysql_fetch_object($val_result);
	
	$display .= '<img src="'.$val->guid.'" alt="Smiley face" >&nbsp&nbsp&nbsp';
							
	
							}

$row[] = $display;
$display = null;
$certif = null;



////////////////	certcode

///			certifications

$row[] = $aRow['ID'];
$output['aaData'][] = $row;
	}
	
	echo json_encode( $output );
?>


