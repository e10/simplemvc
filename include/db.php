<?php
include "settings.php";
/*$con = mysql_connect($DBSERVER,$DBUNAME,$DBPWD);
if (!$con){die('Could not connect: '.mysql_error());}
mysql_select_db($DBNAME, $con) or die(mysql_error()); 
*/
function makeSQL($myVals,$fields,$inStart,$upStart,$upEnd){
     $sql=array('insert'=>$inStart,'update'=>$upStart);
     $fieldarr = explode(",",$fields);
     $first=$fieldarr[0];
     foreach( $fieldarr as &$fld){
         $fld=trim($fld);
         if(isset($myVals[$fld])){
             if($fld!=$fieldarr[0]){
                 $sql['insert'].=",";
                 $sql['update'].=",";
             }
             $sql['update'].="$fld='".mysql_real_escape_string($myVals[$fld])."'";  
             $sql['insert'].="'".mysql_real_escape_string($myVals[$fld])."'";  
         }else{
            //$sql['insert'].=",null";  
         }
     }
     $sql['insert'].=")";
     $sql['update']=$sql['update'].$upEnd;
     return $sql;
}
?>