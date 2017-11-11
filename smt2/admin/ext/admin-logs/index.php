
<?php
// server settings are required - relative path to smt2 root dir
require '../../../config.php';

//Incluso da me per interfaccia bootstrap
include("head_inc.php");


// protect extension from being browsed by anyone
require SYS_DIR.'logincheck.php';
// now you have access to all CMS API

// use ajax settings
require './includes/settings.php';

// insert custom CSS and JS files
$headOpts = array(
  '<link rel="stylesheet" type="text/css" href="styles/table.css" />',
  '<link rel="stylesheet" type="text/css" href="styles/flags.css" />',
  '<link rel="stylesheet" type="text/css" href="styles/ui-lightness/custom.css" />'
);
add_head($headOpts);


include INC_DIR.'header.php';

// display a warning message for javascript-disabled browsers
echo check_noscript();

// check defaults from DB or current sesion
$show = (isset($_SESSION['limit']) && $_SESSION['limit'] > 0) ? $_SESSION['limit'] : db_option(TBL_PREFIX.TBL_CMS, "recordsPerTable");
// sanitize
if (!$show) { $show = $defaultNumRecords; }

  

  
  

?>

    <p><a href="./howto/">Some guides are available</a> to help you with these logs.</p>
    
    <div class="panel panel-info">
    <div class="panel-heading"><h2>User Logs</h2></div>
    <div class="panel-body">
      
      <div id="records">
        <?php check_notified_request("records") ?>
        <div class="panel-body">
        <div class="table-responsive">
        <table class="table table-hover">
        <thead id="attributes">
        <tr>
          <th title="Anonymized data">user ID</th>
          <th title="Anonymized data">location</th>
          <th>domain ID</th>
          <th>page ID</th>
          <th title="Format: yyyy/mm/dd">date</th>
          <th title="In seconds">time</th>
          <!--<th>interaction time</th>-->
          <th># clicks</th>
          <!--
          <th>% moves</th>
          <th>% vscroll</th>
          -->
          <th># notes</th>
          <th>action</th>
        </tr>
        </thead>
        <tbody>
          <?php include './includes/tablerows.php'; ?>
        </tbody>
        </table>
		 </div> 
		 </div>
        
        <?php
        // the 'more' button
        if (!empty($displayMoreButton)) {
           echo '<a href="./?page='.++$page.'&amp;'.$resetFlag.'" class="btn btn-primary" id="more">'.$showMoreText.'</a>';
        } else {
          echo $noMoreText;
        }
        
        // helper functions
        function checkbox($id, $label)
        {
          $select = (isset($_SESSION[$id])) ? 'checked="checked"' : null;
          $c  = '<input type="checkbox" '.$select.' id="'.$id.'" name="'.$id.'" />';
          $c .= ' <label for="'.$id.'" class="mr">'.$label.'</label>';
          return $c;
        }
        function select_tbl($table,$id,$label)
        {
          $s  = '<label for="'.$id.'">'.$label.'</label> ';
          $s .= '<select id="'.$id.'" name="'.$id.'" class="mr">';
          $s .= '<option value="">---</option>';
          $rows = db_select_all($table, "*", "1");
          foreach ($rows as $row) {
            $select = (isset($_SESSION[$id]) && $row['id'] == $_SESSION[$id]) ? 'selected="selected"' : null;
            $s .= '<option '.$select.' value="'.$row['id'].'">'.$row['name'].'</option>'; 
          }
          $s .= '</select>';
          return $s;
        }
        function select_date($id)
        { 
          $d  = '<label for="'.$id.'" class="ml">'.ucfirst($id).'</label> ';
          $val = (!empty($_SESSION['filterquery']) && isset($_SESSION[$id])) ? $_SESSION[$id] : null;
          $d .= '<input type="text" id="'.$id.'" name="'.$id.'" class="text datetime" value="'.$val.'" />';
          return $d;
        }
        function select_cache() 
        {
          $s  = '<label for="cache">Page</label> ';
          $s .= '<select id="cache" name="cache_id" class="mr">';
          $s .= '<option value="">---</option>';
          $rows = db_select_all(TBL_PREFIX.TBL_CACHE, "id, title", "1 ORDER BY id DESC");
          // pad with zeros the page id
          $num = db_select(TBL_PREFIX.TBL_CACHE, "MAX(id) as max", 1);
          $n = strlen($num['max']);
          foreach ($rows as $row) {
            $select = (isset($_SESSION['cache_id']) && $row['id'] == $_SESSION['cache_id']) ? 'selected="selected"' : null;
            $s .= '<option '.$select.' value="'.$row['id'].'">'.pad_number($row['id'],$n).': '.trim_text($row['title']).'</option>';
          }
          $s .= '</select>';
          return $s;
        }
        function select_domain() 
        {
          $s  = '<label for="cache">Domain</label> ';
          $s .= '<select id="domain" name="domain_id" class="mr">';

          $s .= '<option value="">---</option>';
          $rows = db_select_all(TBL_PREFIX.TBL_DOMAINS, "id, domain", "1 ORDER BY id DESC"); // GROUP BY domain?
          // pad with zeros the domain id
          $num = db_select(TBL_PREFIX.TBL_DOMAINS, "MAX(id) as max", 1);          
          $n = strlen($num['max']);
          foreach ($rows as $row) {
            $select = (isset($_SESSION['domain_id']) && $row['id'] == $_SESSION['domain_id']) ? 'selected="selected"' : null;
            $s .= '<option '.$select.' value="'.$row['id'].'">'.pad_number($row['id'],$n).': '.trim_chars($row['domain']).'</option>';            
          }
          $s .= '</select>';
          return $s;
        } 
			/* filtraggio degli utenti */
			
        function select_client() 
        {
          $s  = '<label for="client">User</label> ';
          $s .= '<select id="client" name="client_id" class="mr">';
          $s .= '<option value="">---</option>';
          $rows = db_select_all(TBL_PREFIX.TBL_RECORDS, "DISTINCT client_id", "1");
          foreach ($rows as $row) {
            $select = (isset($_SESSION['client_id']) && $row['client_id'] == $_SESSION['client_id']) ? 'selected="selected"' : null;
            $s .= '<option '.$select.' value="'.$row['client_id'].'">'.mask_client($row['client_id']).'</option>'; 
          }
          $s .= '</select>';
          return $s;
        }
        function select_fps() 
        {
          $s  = '<label for="fps">FPS</label> ';
          $s .= '<select id="fps" name="fps" class="mr">';
          $s .= '<option value="">---</option>';
          $rows = db_select_all(TBL_PREFIX.TBL_RECORDS, "DISTINCT fps", "1");
          foreach ($rows as $row) {
            $select = (isset($_SESSION['fps']) && $row['fps'] == $_SESSION['fps']) ? 'selected="selected"' : null;
            $s .= '<option '.$select.' value="'.$row['fps'].'">'.$row['fps'].'</option>'; 
          }
          $s .= '</select>';
          return $s;
        }        
        function select_group() 
        {
          $s  = '<label for="groupby">Group result by</label> ';
          $s .= '<select id="groupby" name="groupby" class="mr">';
          $s .= '<option value="">---</option>';
          $opt = array(
                        "client_id"  => "Client",
                        "cache_id"   => "Page",
                        //"domain_id"  => "Domain",
                        "ip"         => "Location"
                      );
          foreach ($opt as $key => $val) {
            $select = (!empty($_SESSION['groupby']) && $key == $_SESSION['groupby']) ? 'selected="selected"' : null;
            $s .= '<option '.$select.' value="'.$key.'">'.$val.'</option>'; 
          }
          $s .= '</select>';
          return $s;
        }
        function select_records()
        { 
          $s  = '<label for="limit">Records per query</label> ';
          $s .= '<select id="limit" name="limit" class="mr">';
          $s .= '<option value="">---</option>';
          $num = array(10,50,100,200,500,1000);
          foreach ($num as $n) {
            $select = (!empty($_SESSION['limit']) && $n == $_SESSION['limit']) ? 'selected="selected"' : null;
            $s .= '<option '.$select.' value="'.$n.'">'.$n.'</option>'; 
          }
          $s .= '</select>';
          return $s;
        }
        function input_time($id) 
        {
          $value = (!empty($_SESSION[$id]) && strlen($_SESSION[$id]) < 5) ? $_SESSION[$id] : "0";
          $c  = '<label for="'.$id.'" class="ml">'.$id.'</label> ';
          $c .= '<input type="text" class="text" size="2" id="'.$id.'" name="'.$id.'" value="'.$value.'" />';
          return $c;
        }
        ?>
      </div>
	  </div>
	  </div>
      
		<?php if (db_records()) { ?>
		<br><br>
		
		
      <div class="panel panel-info">
	  <div class="panel-heading"><h2>Mine Results</h2></div>
      <div class="panel-body">
      <?php check_notified_request("mine"); ?>
      
      </div>
      <form id="filter" class="center" action="filter.php" method="post">
        <fieldset class="panel panel-default">
          <legend>Filter by</legend>
          <?php 
		  //Stampa del filtraggio degli utenti //
            echo select_client();
            echo select_domain();            
            echo select_cache();
            echo select_tbl(TBL_PREFIX.TBL_OS, "os_id", "OS");
            echo select_tbl(TBL_PREFIX.TBL_BROWSERS, "browser_id", "Browser");
            echo select_fps();
          ?>
        </fieldset>
		
		<br>
        
		<fieldset class="panel panel-default">
          <legend>Grouping</legend>
          <?=select_group()?>
          <?=select_records()?>
          <?=checkbox("ftu", "Display only first-time users")?>
        </fieldset>
		
		<br>
		
        <fieldset class="panel panel-default">
          <legend>Date range</legend>
          <?=select_date("from")?>
          <?=select_date("to")?>
        </fieldset>
		
		<br>
		
        <fieldset class="panel panel-default">
          <legend>Time range (seconds)</legend>
          <div id="slider-wrap">
            <div id="slider-range">
              <?=input_time("mintime")?>
              <?=input_time("maxtime")?>
            </div>
            <p class="center" id="slider-amount"></p>
          </div><!-- end slider-wrap -->
        </fieldset>
		
		<br>
		
        <fieldset class="panel panel-default">
          <legend>Action</legend>
         <input type="submit" class="btn btn-primary" value="Apply filter" />
       <input type="submit" name="reset" class="btn btn-danger"  value="Reset filter" />
			 <?php
			 /*
			 // massive bulk function (not implemented)
			 if (is_root() && isset($_SESSION['filterquery'])) {
				echo '<input type="submit" name="delete" class="button round delete conf" value="Delete filtered logs" />';
			 }
			 */
			 ?>
        </fieldset>
		
		<br>
		
        <fieldset class="panel panel-default">
          <legend>Export</legend>
            <!--<?=checkbox("export-all", "Whole database")?>-->
            <label for="csv">Format:</label>
			
			<br>

            <input id="csv" type="radio" name="format" class="radio" value="csv" checked="checked" style="float:left" />
            <label for="csv"><abbr title="Comma Separated Values">CSV</abbr></label>
            <br>
            <input id="tsv" type="radio" name="format" class="radio" value="tsv" style="float:left"/>
            <label for="tsv"><abbr title="Tab Separated Values">TSV</abbr></label>
<!--
            <input id="txt" type="radio" name="format" class="radio" value="txt" /> 
            <label for="txt"><abbr title="plain TeXT (each field is preceded by a newline char)">TXT</abbr></label>

            <input id="xml" type="radio" name="format" class="radio" value="xml" />
            <label for="xml"><abbr title="eXtensible Markup Language">XML</abbr></label>
-->
			
            <br><br>
            <input type="submit" class="btn btn-success"  name="download" value="Download logs" />	
            <?php
					    /*if (!isset($_SESSION['filterquery'])) {
						    echo checkbox("dumpdb", "Dump whole database");
					    }*/
				    ?>
				  <!--
          <p class="left">
            <small>
              <sup>1</sup> each log is stored in a single file, then all are compressed in a ZIP file.
            <br />
              <sup>2</sup> all logs are dumped in a single file (logs are separated by a newline).
            </small>
          </p>
          -->
        </fieldset>

      </form>
      
	 <?php } ?>
	 
    </div><!-- end centered table -->
    
    <script type="text/javascript" src="<?=ADMIN_PATH?>js/jquery.stripy.js"></script>
    <script type="text/javascript" src="<?=ADMIN_PATH?>js/jquery.tablesorter.min.js"></script>
    <script type="text/javascript" src="<?=ADMIN_PATH?>js/jquery.tablesorter.widgets.min.js"></script>
    <script type="text/javascript" src="<?=ADMIN_PATH?>js/jquery.ui.core.js"></script>
    <script type="text/javascript" src="<?=ADMIN_PATH?>js/jquery.ui.datepicker.js"></script>
    <script type="text/javascript" src="<?=ADMIN_PATH?>js/jquery.ui.slider.js"></script>
    <script type="text/javascript" src="<?=ADMIN_PATH?>js/jquery.ui.timepicker.js"></script>
    <script type="text/javascript">
    //<![CDATA[
    $(function(){

      // shorcut for jQuery selectors
      var legends = "fieldset legend";
      var records = "#records table";
      
  		// shorcut to (smt)2 aux functions
  		var aux = window.smt2fn;
  		// check saved cookie
  		var cookieId = "smt-hiddenFieldsets";
  		if (aux.cookies.checkCookie(cookieId)) {
  			var hide = aux.cookies.getCookie(cookieId).split(",");
  			for (var i = 0; i < hide.length; ++i) {
  				$(legends).eq(hide[i]).nextAll().toggle();
  			}
  		}
  		// save routine
  		function savePos()
  		{
  			var hideElems = [];
  			$(legends).attr('title', "Toggle fieldset").each(function(i, val) {
  				if ( $(this).nextAll().is(':hidden') ) {
  					hideElems.push(i);
  				}
  			});
  			aux.cookies.setCookie(cookieId, hideElems, 30);
  		};
  		
  		// click behaviour
  		$(legends).attr('title', "toggle fieldset").css('cursor', "pointer").click(function(){
    			var elems = $(this).nextAll();
    			elems.toggle();
    			savePos();
  		});

      // display nice table
      $(records).tablesorter({
			    widgets        : ['zebra', 'columns'],
			    //usNumberFormat : false,
			    //sortReset      : true,
			    //sortRestart    : true,
          headers: {
            8: { sorter: false }
          },
          cssHeader: "headerNormal"
      });
      
      // date picker UI widget
      $('.datetime').datepicker({
        	duration: '',
          showTime: true,
          constrainInput: false,
          beforeShow: function(i,e) {
            e.dpDiv.css( 'z-index', aux.getNextHighestDepth() );
          }
      });
      
      // slider UI widget
      var sliderElem = $('#slider-range');
      var minInput = $('input#mintime');
      var maxInput = $('input#maxtime');
      
      function formatSlider(arrValues)
      {
        $("#slider-amount").html('min. ' + arrValues[0] + ' &mdash; max. ' + arrValues[1]);
      };

      <?php
      $time = db_select(TBL_PREFIX.TBL_RECORDS, "MAX(sess_time) as max", 1);
      $maxTime = ceil( $time['max'] );
      if (!isset($_SESSION['filterquery'])) {
      ?>
      // set time range
      minInput.val(0);
      maxInput.val(<?=$maxTime?>);
      <?php
      }
      ?>
      // hide regular input fields
      sliderElem.find("input,label").hide();
      // a silly check before configuring the time slider
      if (maxInput.val() == 0) { maxInput.val(<?=$maxTime?>); }
      sliderElem.slider({
    			range: true,
    			min: 0,
    			max: <?=$maxTime?>,
    			//step: 5,
    			values: [minInput.val(), maxInput.val()],
    			slide: function(event, ui) {
    				formatSlider(ui.values);
    			},
    			stop: function(event, ui) {
            minInput.val(ui.values[0]);
            maxInput.val(ui.values[1]);
          }
  		});
  		formatSlider( sliderElem.slider("values") );
      
      // append more records to main table (see include/settings.php)
      var page = <?=$page?>;
      var show = <?=$show?>;
      var more = $('a#more');
      more.click(function(e){
          // remove focus
          $(this).blur();
          // async request
          $.get('includes/tablerows.php?page='+page+'&show='+show, function(data){
              $(records+' tbody').append(data);
              $(records).stripy().trigger("update");
              // update CMS links, delete buttons, etc.
              SetupCMS.all();
              // increment page counter
              ++page;
              // remove the 'more' link if there are no more records
              var r = new RegExp('<?=$noMoreText?>');
              var s = data.search(r);
              if (s != -1) {
                more.parent().append('<?=$noMoreText?>');
                more.remove();
              }
          });
          // cancel default action
          e.preventDefault();
      });
      
    });
    //]]>
    </script>
	</div>
	</div>

<?php //include INC_DIR.'footer.php'; ?>    <!-- Commentato da noi per non far comparire il footer -->
