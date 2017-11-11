  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="Robots" content="noindex, nofollow" />

  <title><?=CMS_TITLE?> | admin interface</title>
  
  <link href="<?=ADMIN_PATH?>favicon.ico" rel="icon" type="image/x-icon" />
  <link href="<?=ADMIN_PATH?>favicon.ico" rel="shortcut icon" type="image/x-icon" />

<!--//commentato da me
  <link rel="stylesheet" type="text/css" href="<?=CSS_PATH?>base.css" />
  <link rel="stylesheet" type="text/css" href="<?=CSS_PATH?>admin.css" />
  <link rel="stylesheet" type="text/css" href="<?=CSS_PATH?>theme.css" />
-->
  <script type="text/javascript" src="<?=ADMIN_PATH?>js/jquery-1.7.2.min.js"></script>
  <script type="text/javascript" src="<?=ADMIN_PATH?>js/flashdetect.min.js"></script>
  <script type="text/javascript" src="<?=ADMIN_PATH?>js/setupcms.js"></script>
  <script type="text/javascript" src="<?=SMT_AUX?>"></script>
  
  
   <!-- jQuery (necessario per i plugin Javascript di Bootstrap) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> 
<!-- Includi tutti i plugin compilati (sotto), o includi solo i file individuali necessari -->
<script src="bootstrap/js/bootstrap.min.js"></script>




  <?php
  // check custom headers
  if (count($_headAdded) > 0)
  {
    foreach ($_headAdded as $tag)
    {
      echo $tag.PHP_EOL;
    }
  }
  ?>
