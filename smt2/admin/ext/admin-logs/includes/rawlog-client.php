<?php
//incluso da me 
include("head_inc.php");
?>

 <div class="panel panel-info">
    <div class="panel-heading"><h3>Client details</h3></div>
    
    
	<div class="panel-body">
    <div class="table-responsive">
	
  
        <table class="table table-hover">
        <thead id="attributes">
        <tr>
        <th>source URL</th>
        <th>cache log</th>
        <th>user agent</th>
        <th>resolution</th>
        <th>viewport</th>
        <th>tracking frequency</th>
	
      </tr>
  </thead>
  </div>

  

 
  <tbody>
  <?php
 $list  = '<tr class="odd">'.PHP_EOL;
  // log data  
  $list .= '<td>' .PHP_EOL;
  if ($log['url']) {
    $list .= '<a href="'.$log['url'].'" rel="external" title="'.$log['title'].'">'.trim_text($log['title']).'</a>';
  }
  $list .= '</td>'.PHP_EOL;
  $list .= '<td>' .PHP_EOL;
  $list .=    '<a href="'.CACHE_DIR.$log['file'].'" rel="external">'.trim_text($log['file']).'</a>'.PHP_EOL;
  $list .= '</td>'.PHP_EOL;
  $list .= '<td>' .PHP_EOL;
  $list .=    '<acronym title="'.$log['user_agent'].'">'.$log['browser'].' '.$log['browser_ver'].'</acronym> on '.$log['os'].PHP_EOL;
  $list .= '</td>'.PHP_EOL;
  $list .= '<td>' .PHP_EOL;
  $list .=    $log['scr_width'].' x '.$log['scr_height'].PHP_EOL;
  $list .= '</td>'.PHP_EOL;
  $list .= '<td>' .PHP_EOL;
  $list .=    $log['vp_width'].' x '.$log['vp_height'].PHP_EOL;
  $list .= '</td>'.PHP_EOL;
  $list .= '<td>' .PHP_EOL;
  $list .=    $log['fps'].' fps'.PHP_EOL;
  $list .= '</td>'.PHP_EOL;
  $list .= '</tr>'.PHP_EOL;
    
  echo $list;
  ?>
  </tbody>  
</table>
</div>




