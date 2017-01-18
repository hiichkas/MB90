<?php

require_once($incPath . 'scripts/dbase_include.php');

		/*var programmes = [
		    {productid:'FI-SW-01',name:'Koi'},
		    {productid:'K9-DL-01',name:'Dalmation'},
		    {productid:'RP-SN-01',name:'Rattlesnake'},
		    {productid:'RP-LI-02',name:'Iguana'},
		    {productid:'FL-DSH-01',name:'Manx'},
		    {productid:'FL-DLH-02',name:'Persian'},
		    {productid:'AV-CB-01',name:'Amazon Parrot'}
		];*/

$mode = $_REQUEST["mode"];
$result = "";

if($mode == "programmes")
{
    foreach( $wpdb->get_results("SELECT * FROM mb90_programmes ORDER BY ID")as $key => $row)
    { 
        $result .= "{ID:'".$row->ID."',name:'".$row->ProgrammeType."'},";
    }
}
else if($mode == "exercise_types")
{
    foreach( $wpdb->get_results("SELECT * FROM mb90_exercise_types ORDER BY ID")as $key => $row)
    { 
        $result .= "{ID:'".$row->ID."',name:'".$row->ExerciseName."'},";
    }  
}
echo $result;

?>
