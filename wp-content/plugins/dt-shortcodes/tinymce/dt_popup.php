<?php 
// get dt_shortcodes class
require_once( 'shortcodes.class.php' );
//get the popup for the shortcode type
$popup = $_GET['id'];
$shortcode = new dtsc_popup( $popup );
?>
 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>DT Shortcode</title>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script language="javascript" type="text/javascript" src="../../../../wp-includes/js/tinymce/tiny_mce_popup.js"></script>
<script language="javascript" type="text/javascript" src="js/jquery.appendo.js"></script>
<script language="javascript" type="text/javascript" src="js/dt_popup.js"></script>
<link rel="stylesheet" type="text/css" href="css/dt-tinymce-popup.css">
</head>

<body class="shortcode-popup">
    <div class="info">
      <h3><?php echo $shortcode->title; ?></h3>
    </div>
    <form id="<?php echo $popup ?>-dialog" action="/" method="get" accept-charset="utf-8" class="dialog-form">    
      <?php echo $shortcode->output; ?>
    </form>
  </div>
</body>
</html>