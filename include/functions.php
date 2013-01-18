<?php
function mqsafe($val)
{
    return mysql_real_escape_string($val);
}

function e_isfile($relativePath){
    //echo $relativePath;
    $tmp= file_exists(realpath($relativePath));
    //echo " ->".$tmp."<br />";
    return $tmp;
}
function openConnection($DBSERVER,$DBUNAME,$DBPWD,$DBNAME){
    $con=mysql_connect($DBSERVER,$DBUNAME,$DBPWD);
    if (!$con){die('Could not connect: '.mysql_error());}
    mysql_select_db($DBNAME, $con) or die(mysql_error()); 
    return $con;
}
function closeConnection($conn){
    mysql_close($conn);
}
function checkLogin($page){
    if(!isset($_SESSION['user']) && isset($page['secured'])){
        if($page["ctrl"]!="account" && $page["view"]!="login"){
            $loginPage=$BASE."account/login";
            header("Location:$loginPage");
            exit();
        }
    }
}

function initPage(){

    $tmpURI=explode("?",strtolower($_SERVER['REQUEST_URI']));
    $tmp=explode("/",$tmpURI[0]);
    $obj=array(ctrl=>"home",view=>"index");
    
    if(isset($_REQUEST["view"])){ $obj['view']=$_REQUEST["view"];}
    else if($tmp[2]!=""){ $obj['view']=$tmp[2];}

    if(isset($_REQUEST["ctrl"])){ $obj['ctrl']=$_REQUEST["ctrl"];}
    else if($tmp[1]!=""){ $obj['ctrl']=$tmp[1];}

    if(isset($_REQUEST["id"])){ $obj['id']=$_REQUEST["id"];}
    else if($tmp[3]!=""){ $obj['id']=$tmp[3];}

    $obj["page"]=$obj["ctrl"]."/".$obj["view"];
    
    return  $obj;
}
function getNodes($ii,$adm,$pc){

    $sql1 = "Select id, name, parent, vs, fieldname, tablename, dtype from s_custom_fields 
                where parent = '$ii'"; 
    if($adm == "false"){
        $sql1 .= " and admin <> '1'";
    }
    //	if($pc){
    $sql1 .= " and pc = '$pc'";
    $ex1 = mysql_query($sql1);
    $arr = array();
    while($row1 = mysql_fetch_row($ex1)){
        $ll = $row1[1];
        $arr[] = array( "title" =>$ll,"fieldname"=>$row1[4],"children" => getNodes($row1[0],'true',0));
    }//end while
    return  $arr;
}



function getNodes1(){
    $sql1 = "SELECT id, question, dtype from s_additional_data where kunnr = 0001000383 and active = 'true' order by sort_order ASC"; 
    //if($adm == "false"){
    //    $sql1 .= " and admin <> '1'";
    //}
    ////	if($pc){
    //$sql1 .= " and pc = '$pc'";
    $ex1 = mysql_query($sql1);
    $arr = array();
    while($row1 = mysql_fetch_row($ex1)){
        $ll = $row1[1];
        $arr[] = array( "title" =>$ll,"children" => getNodes($row1[0],'true',0));
    }//end while
    return  $arr;
}
function getNodes2(){
    $sql1 = "SELECT id, category FROM act_category WHERE kunnr = 0001000383"; 
    //if($adm == "false"){
    //    $sql1 .= " and admin <> '1'";
    //}
    ////	if($pc){
    //$sql1 .= " and pc = '$pc'";
    $ex1 = mysql_query($sql1);
    $arr = array();
    while($row1 = mysql_fetch_row($ex1)){
        $ll = $row1[1];
        $arr[] = array( "title" =>$ll,"children" => getNodes($row1[1],'true',0));
    }//end while
    return  $arr;
}
function getNodes3($ii,$adm,$pc){

    $sql1 = "SELECT id, name, parent, vs FROM s_reports WHERE parent  = '$ii'"; 
    //if($adm == "false"){
    //    $sql1 .= " and admin <> '1'";
    //}
    //	if($pc){
    //$sql1 .= " and pc = '$pc'";
    $ex1 = mysql_query($sql1);
    $arr = array();
    while($row1 = mysql_fetch_row($ex1)){
        $ll = $row1[1];
        $arr[] = array( "title" =>$ll,"children" => getNodes3($row1[0],'true',0));
    }//end while
    return  $arr;
}
function getNodescontacts($ii,$adm,$pc){

    $sql1 = "Select id, name, parent, vs, fieldname, tablename, dtype from s_custom_fields 
                where parent = '$ii'"; 
    //if($adm == "false"){
    //    $sql1 .= " and admin <> '1'";
    //}
    //	if($pc){
    //$sql1 .= " and pc = '$pc'";
    $ex1 = mysql_query($sql1);
    $arr = array();
    while($row1 = mysql_fetch_row($ex1)){
        $ll = $row1[1];
        $arr[] = array( "title" =>$ll,"children" => getNodescontacts($row1[0],'true',0));
    }//end while
    return  $arr;
}
function getNodesprojects1($ii,$adm,$pc){

    $sql1 = "Select id, name, parent, vs, fieldname, tablename, dtype from s_custom_fields 
                where parent = '$ii'"; 
    //if($adm == "false"){
    //    $sql1 .= " and admin <> '1'";
    //}
    //	if($pc){
    //$sql1 .= " and pc = '$pc'";
    $ex1 = mysql_query($sql1);
    $arr = array();
    while($row1 = mysql_fetch_row($ex1)){
        $ll = $row1[1];
        $arr[] = array( "title" =>$ll,"children" => getNodesprojects1($row1[0],'true',0));
    }//end while
    return  $arr;
}
function getNodesprojects2(){
    $sql1 = "SELECT id, question, dtype from s_additional_data2 where kunnr = 0001000383 and active = 'true' order by sort_order ASC"; 
    //if($adm == "false"){
    //    $sql1 .= " and admin <> '1'";
    //}
    ////	if($pc){
    //$sql1 .= " and pc = '$pc'";
    $ex1 = mysql_query($sql1);
    $arr = array();
    while($row1 = mysql_fetch_row($ex1)){
        $ll = $row1[1];
        $arr[] = array( "title" =>$ll,"children" => getNodesprojects2($row1[0],'true',0));
    }//end while
    return  $arr;
}
function getNodestarget($ii,$adm,$pc){

    $sql1 = "Select id, name, parent, vs, fieldname, tablename, dtype from s_custom_fields 
                where parent = '$ii'"; 
    //if($adm == "false"){
    //    $sql1 .= " and admin <> '1'";
    //}
    //	if($pc){
    //$sql1 .= " and pc = '$pc'";
    $ex1 = mysql_query($sql1);
    $arr = array();
    while($row1 = mysql_fetch_row($ex1)){
        $ll = $row1[1];
        $arr[] = array( "title" =>$ll,"children" => getNodestarget($row1[0],'true',0));
    }//end while
    return  $arr;
}
?>
