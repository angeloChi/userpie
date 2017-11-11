<?php
//incluso da me 
include("head_inc.php");
?>


<?php

function computeDOMelements($arr, $name)
{
  $widget = array_frequency($arr, 5);
  if (!$widget) {
    $status = 'There were no '.$name.'ed elements';
  } else {
    $status = "";
    foreach ($widget as $elem => $freq){
      $status .= $elem.' = '.$freq.'%<br />';
    }
  }
  return $status;
}

if (isset($_GET['cid'])) {
  echo '<p class="center"><em>These tables are computed for ALL pages that this user browsed. Thus, here you have their user model.</em></p>';
}
else if (isset($_GET['pid'])) {
  echo '<p class="center"><em>These tables take into account ALL users that browsed
        <a rel="external" href="track.php?pid='.$_GET['pid'].'">this page</a>.
        Thus, here you have the page model.</em></p>'; 
} else if (isset($_GET['ip'])) {
  $IP = empty($_GET['ip']) ? "NO_IP" : $_GET['ip'];
  echo '<p class="center"><em>These tables are computed for ALL users that came from <strong>'.$IP.'</strong>.
        Thus, here you have their user model.</em></p>';
}
?>

 <div class="panel panel-info">
    <div class="panel-heading"><h3>Interacted elements</h3></div>
 
    <div class="table-responsive">
        <table class="table table-hover">
        <thead id="attributes">
        <tr>
        <th>hovered elements (frequency)</th>
        <th>clicked elements (frequency)</th>
		</div>
      </tr>
  </thead>
  <tbody>
  <?php
  $list  = '<tr class="odd">'.PHP_EOL;
  // log data  
  $list .= '<td>' .PHP_EOL;
  $list .=    computeDOMelements($hovered, "hover");
  $list .= '</td>'.PHP_EOL;
  $list .= '<td>' .PHP_EOL;
  $list .=    computeDOMelements($clicked, "click");
  $list .= '</td>'.PHP_EOL;
  $list .= '</tr>'.PHP_EOL;
  
  echo $list;
  ?>
  </tbody> 
</div>

		
</table>
</div>
</div>
