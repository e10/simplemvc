<?php 
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
ob_start();
session_start();
include_once("include/functions.php");
include "include/settings.php";
global $model,$page;

$page=initPage();
$controllerPage = $BASE."controller/".$page["ctrl"].".php";

if(e_isfile($controllerPage)){
	include $controllerPage;
	checkLogin($page);
}

$actionPage = $BASE."controller/".$page["page"].".php";

if(e_isfile($actionPage)){
	include $actionPage;
	checkLogin($page);
}

$viewPage = $BASE."views/".$page["page"].".php";

if(isset($_REQUEST["json"])){
    header('Content-type: application/json');
    echo json_encode($model);
    ob_flush();
    exit();
}


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title><?php echo $BRAND?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <!-- Le styles -->
    <link href="<?php echo $BASE?>assets/ico/favicon.ico" rel="shortcut icon" />
    <link href="<?php echo $BASE?>assets/css/bootstrap.css" rel="stylesheet" />
    <link href="<?php echo $BASE?>assets/css/bootstrap-responsive.css" rel="stylesheet" />
    <link href="<?php echo $BASE?>assets/aristo/aristo.css" rel="stylesheet" />
    <link href="<?php echo $BASE?>assets/css/app.css" rel="stylesheet" />
    <link href="<?php echo $BASE?>assets/css/system.css" rel="stylesheet" />
    <link href="<?php echo $BASE?>assets/js/google-code-prettify/prettify.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?php echo $BASE?>assets/css/app.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $BASE?>assets/css/app.css" media="print" />
    <link rel="stylesheet" type="text/css" href="<?php echo $BASE?>assets/css/timePicker.css" />
  
    <script type="text/javascript" src="<?php echo $BASE?>scripts/jquery-1.8.2.js"></script>
    <script type="text/javascript" src="<?php echo $BASE?>scripts/jquery-ui-1.9.0.min.js"></script>
    <script type="text/javascript" src="<?php echo $BASE?>scripts/modernizr-2.6.2.js"></script>
    <!--[if lt IE 8]>
      <script src="/scripts/json2.min.js"></script>
    <![endif]-->
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->    
    <!-- Le fav and touch icons -->
    <script type="text/javascript">var root='<?php echo $BASE?>';</script>
    <script type="text/javascript" src="<?php echo $BASE?>assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo $BASE?>scripts/knockout-2.1.0.js"></script>
    <script type="text/javascript" src="<?php echo $BASE?>scripts/jquery.validate.min.js"></script>
    <script type="text/javascript" src="<?php echo $BASE?>scripts/jquery.validate.unobtrusive.min.js"></script>
    <script type="text/javascript" src="<?php echo $BASE?>scripts/jquery.cookie.js"></script>
    <script type="text/javascript" src="<?php echo $BASE?>scripts/fullcalendar.min.js"></script>
    <script type="text/javascript" src="<?php echo $BASE?>scripts/model/dynamicmodel.js"></script>
    <script type="text/javascript" src="<?php echo $BASE?>scripts/highcharts.js"></script>
    <script type="text/javascript" src="<?php echo $BASE?>scripts/jquery.timePicker.min.js"></script>
    <script type="text/javascript" src="<?php echo $BASE?>scripts/boot.js"></script>
  </head>
  <body data-spy="scroll" data-target=".bs-docs-sidebar">
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="<?php echo $Base;?>"><?php echo $BRAND?></a>
          <div class="nav-collapse collapse">
            <ul class="nav">
             <li class=""><a href="<?php echo $BASE?>">Home</a></li>
             <li><a href="<?php echo $BASE?>contact">Contact</a></li> 
             <li><a href="<?php echo $BASE?>help">Help</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <p>&nbsp;</p>
    <script type="text/javascript">var model=<?php echo json_encode($model);?>;</script>
    <div class="container min800"><?php  if(e_isfile($viewPage)){include $viewPage;}?></div>
    <!-- Footer
    ================================================== -->
    <footer class="footer">
      <div class="container">
        <p class="pull-right"><a href="#">Back to top</a></p>
      </div>
    </footer>
    <script type="text/javascript" src="<?php echo $BASE?>scripts/foot.js"></script>  
  </body>
</html>
<?php ob_flush();?>
