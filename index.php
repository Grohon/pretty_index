<?php

// config
$localhost_url = "http://localhost";
$phpMyAdmin_Url = $localhost_url . "/pma";
$adminer_url = $localhost_url . "/adm";
$current_script_url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
$current_dir_url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']);

// menu bookmarks
$bookmarks = array();
$bookmarks['phpMyAdmin'] = $phpMyAdmin_Url;
$bookmarks['Adminer'] = $adminer_url;

// booleans
$get_public_ip = true;

// core
$date_time = date('l, F j, H:i:s');
$host_name = getHostName();
$host_ip = getHostByName($host_name);
$remote_ip = $_SERVER['REMOTE_ADDR'];
list( $directories, $files ) = getDirContents();
$local_addr = getLocalAddress();
$public_addr = ( $get_public_ip ) ? getPublicAddress() : 'N/A';
$doc_root = $_SERVER['DOCUMENT_ROOT'];
$php_version = phpversion();
$php_ini = php_ini_loaded_file();
$php_tz = date_default_timezone_get();


if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ){
  if(isset($_POST['eval_code'])){
    $name = trim($_POST['eval_code']);
    ob_start();
    eval($name);
    $eval_output = ob_get_contents();
    ob_end_clean();
    echo $eval_output;
    return;
  }else{
    return;
  }
}

if ( isset($_REQUEST['phpinfo']) and $_REQUEST['phpinfo'] == 1 ) {
  phpinfo();
  return;
}

// functions

function getLocalAddress() {
  if(strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
    exec("ipconfig /all", $output);
    foreach($output as $line) {
      if(preg_match("/(.*)IPv4 Address(.*)/", $line)) {
        if( preg_match('/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/', $line, $match) ) {
          if( filter_var($match[0], FILTER_VALIDATE_IP) ) { return trim($match[0]); }
        }
      }
    } // endforeach
  } else if(strtoupper(PHP_OS) == 'LINUX') {
    $methods = array();
    $methods[] = function() { return `ifconfig | grep -Eo 'inet (addr:)?([0-9]*\.){3}[0-9]*' | grep -Eo '([0-9]*\.){3}[0-9]*' | grep -v '127.0.0.1'`; };
    $methods[] = function() { return `ifconfig | sed -En 's/127.0.0.1//;s/.*inet (addr:)?(([0-9]*\.){3}[0-9]*).*/\2/p'`; };
    $methods[] = function() { return `ip route get 1 | awk '{print $NF;exit}'`; };
    foreach( $methods as $method ) {
      $ip = trim($method());
      if( filter_var($ip, FILTER_VALIDATE_IP) ) { return $ip; }
    } // endforeach
  }
  return "N/A";
} // end of getLocalAddress()


function getDirContents( $dir = __DIR__ ) {
  $directories = array();
  $files_list  = array();
  $files = scandir($dir);
  foreach($files as $file) {
     if(($file != '.') && ($file != '..')) {
        if(is_dir($dir . '/' . $file)) {
          $directories[] = $file;
        } else {
          $files_list[] = $file;
        }
     }
  }
  return array( $directories, $files_list );
}


function getPublicAddress() {
  $api_url = "https://api.ipify.org?format=json";
  $data = file_get_contents($api_url);
  $obj = json_decode($data);
  return $obj->ip;
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Localhost</title>
    <style type="text/css">
      .col-1 {width: 8.33%;}
      .col-2 {width: 16.66%;}
      .col-3 {width: 25%;}
      .col-4 {width: 33.33%;}
      .col-5 {width: 41.66%;}
      .col-6 {width: 50%;}
      .col-7 {width: 58.33%;}
      .col-8 {width: 66.66%;}
      .col-9 {width: 75%;}
      .col-10 {width: 83.33%;}
      .col-11 {width: 91.66%;}
      .col-12 {width: 100%;}
      [class*="col-"] {float: left;}
      @media only screen and (max-width: 768px) {
        [class*="col-"] {
          width: 100%;
        }
      }
      .clearfix:after {
        visibility: hidden;
        display: block;
        font-size: 0;
        content: " ";
        clear: both;
        height: 0;
      }
      * html .clearfix { zoom: 1; }
      *:first-child+html .clearfix { zoom: 1; }
      a {
        text-decoration: none !important;
        background: none !important;
      }
      a:hover {
        color: red;
      }
      p{
        margin: 0;
        padding: 2px 0;
      }
      .container {
        font-family: monospace;
        max-width: 768px;
        background: #DDD;
        padding: 10px;
        margin: auto;
      }
      .center {
        text-align: center;
      }
      .left {
        text-align: left;
      }
      .right {
        text-align: right;
      }
      div.block {
        border: 1px solid #000;
        padding: 4px;
        margin: 8px 4px;
        overflow: auto;
      }
      div.eval_output{
        max-height: 250px;
        overflow-wrap: break-word;
        overflow: auto;
      }
      .menu {
        padding: 0 4px;
        font-size: 14px;
      }
      textarea.code {
        width:100%;
        height:100%;
        max-width: 100%;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
      }
      .stretch{
        display: inline-block;
        margin: 0 1vw;
      }
      .host_info{
        text-align: center;
      }
      .block.search{
        padding-top: 7px;
        padding-bottom: 7px;
      }
      .directory_index{
        /*max-height: 20vh;*/
      }
      .current-dir:hover{
        background-color: lightblue;
      }
      ::-webkit-scrollbar {
        width: 6px;
        height: 6px;
      }/* Track */
      ::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
        -webkit-border-radius: 10px;
        border-radius: 10px;
      }
       /* Handle */
      ::-webkit-scrollbar-thumb {
        -webkit-border-radius: 10px;
        border-radius: 10px;
        background: rgba(0,0,0,0.8);
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.5);
      }
      ::-webkit-scrollbar-thumb:window-inactive {
        background: rgba(0,0,0,0.4);
      }
    </style>
    <script type="text/javascript">
      // console.log('Hello, world!');
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script type="text/javascript">
      window.onload = function() {
        jstime('datetime');
        document.getElementById('eval_output').style.display='none';
        if (window.jQuery) {
          // jQuery is loaded
          $(document).ready(function() {
            var form = $('#eval_form'); // contact form
            var submit = $('#submit');  // submit button
            var eval_text = $('#eval_output'); // eval_output div for show alert message
            var info_wrapper = $('#info_wrapper'); // information wrapper
            // form submit event
            form.on('submit', function(e) {
              e.preventDefault(); // prevent default form submit
              // sending ajax request through jQuery
              $.ajax({
                url: '', // form action url
                type: 'POST', // form submit method get/post
                dataType: 'html', // request type html/json/xml
                data: form.serialize(), // serialize form data
                beforeSend: function() {
                  eval_text.fadeOut();
                  submit.html('Processing...'); // change submit button text
                },
                success: function(data) {
                  eval_text.show(); // show the eval box
                  eval_text.html(data).fadeIn(); // fade in response data
                  submit.html('Run'); // reset submit button text
                  info_wrapper.hide(); // hide information fields
                },
                error: function(e) {
                  console.log(e); //show error on console
                }
              });
            });
          });
        } else {
          // jQuery is not loaded
          <?php
            if(isset($_POST['eval_code'])){
            ?>
            document.getElementById('eval_output').style.display='block';
            <?php
              $name = trim($_POST['eval_code']);
              ob_start();
              eval($name);
              $eval_output = ob_get_contents();
              ob_end_clean();
            }
          ?>
        }
      }
    </script>
    <script type="text/javascript">
      function jstime(elem) {
        var dateObj = new Date();
        var datePart = dateObj.toLocaleString("en", { weekday: "long"  })
                          + ', ' + dateObj.toLocaleString("en", { month: "long" })
                          + ' ' + dateObj.toLocaleString("en", { day: "numeric" })
                          + ', ' + dateObj.toLocaleString("en", { year: "numeric"});
        var h = dateObj.getHours();
        var m = dateObj.getMinutes();
        var s = dateObj.getSeconds();
        h = (h < 10) ? "0" + h : h; m = (m < 10) ? "0" + m : m; s = (s < 10) ? "0" + s : s;
        var timePart = h + ":" + m + ":" + s;
        document.getElementById(elem).innerHTML = timePart + ' - ' + datePart;
        var timePart = setTimeout(function() {
          jstime(elem);
        }, 900);
      }
      function phpi() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            var x = window.open('', '', 'location=no, toolbar=0');
            x.document.body.innerHTML = `${this.responseText}`;
          }
        };
        xhttp.open("POST", window.location.href, true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("phpinfo=1");
      }
      function clear_text() {
        document.getElementById("eval_code").value='';
      }
      function reset_text() {
        clear_text();
        document.getElementById("eval_output").innerHTML='';
        document.getElementById("submit").innerHTML='Run';
        document.getElementById("eval_output").style.display='none';
        document.getElementById("info_wrapper").style.display='block';
      }
      function collapseDirContents() {
        var wrapper = document.getElementById('directory_index');
        wrapper.style.display = wrapper.style.display === 'none' ? 'block' : 'none';
      }
    </script>
  </head>
  <body>
    <div class="container">
      <div class="block center">
        <a href="javascript:location.reload();"><h1>localhost | <?php echo $host_ip; ?></h1></a>
      </div>
      <div id="info_wrapper">
        <div class="block center">
          <h3 id="datetime"><?php echo $date_time; ?></h3>
        </div>
        <div class="block host_info clearfix">
          <div class="col-12">
            <div class="col-6 first">
              <p>Public IP : <b><?php echo $public_addr; ?></b></p>
              <p>LAN IP : <b><?php echo $local_addr; ?></b></p>
              <p>Host IP : <b><?php echo $host_ip; ?></b></p>
              <p>Remote IP : <b><?php echo $remote_ip; ?></b></p>
            </div>
            <div class="col-6 last">
              <p>Document Root : <b><?php echo $doc_root; ?></b></p>
              <p>PHP Version : <b><?php echo $php_version; ?> (<a href="javascript:phpi();">phpinfo</a>)</b></p>
              <p>PHP Loaded INI : <b><?php echo $php_ini; ?></b></p>
              <p>PHP Timezone : <b><?php echo $php_tz; ?></b></p>
            </div>
          </div>
        </div>

        <div class="block search clearfix center">
          <div class="col-12 clearfix">
            <div class="col-6">
              <form method="get" action="http://www.google.com/search">
                <input type="text" name="q" size="30" maxlength="255" value="" placeholder="Google search"/>
                <input type="submit" value="Google" />
              </form>
            </div>
            <div class="col-6">
              <form method="get" action="http://www.bing.com/search">
                <input type="text" name="q" size="30" maxlength="255" value="" placeholder="Bing search"/>
                <input type="submit" value="Bing" />
              </form>
            </div>
          </div>
        </div>

        <div class="block clearfix center">
          <div class="col-12 ">
            <?php
            foreach ($bookmarks as $key => $value) {
              echo '<div class="menu stretch"><b><a href="' . $value . '">' . $key . '</a></b></div>';
            }
            ?>
          </div>
        </div>

        <a onclick="collapseDirContents();" href="javascript:;">
          <div class="block clearfix center current-dir">Current directory: <?php echo __DIR__; ?></div>
        </a>
        <div id="directory_index" class="block directory_index clearfix" style="display: none;">
          <div id="dir-contents" class="col-12">
            <div class="col-6 left" >
              <p>Directories</p><hr>
              <?php
              foreach( $directories as $folder ) {
                echo '<b><a href="' . $current_dir_url . '/' . $folder . '">' . $folder . '</a></b><br/>';
              }
              ?>
            </div>
            <div class="col-6 right">
              <p>Files</p><hr>
              <?php
              foreach( $files as $file ) {
                echo '<i><a href="' . $current_dir_url . '/' . $file . '">' . $file . '</a></i><br/>';
              }
              ?>
            </div>
          </div>
        </div>
      </div>
      <div class="block">
        <form id="eval_form" method="post" action="">
          <textarea class="code" id="eval_code" name="eval_code" rows="4" placeholder="PHP code here..."></textarea>
          <br/><button name="submit" type="submit" id="submit">Run</button>
          <button name="clearText" type="button" id="clearText" onclick="clear_text()">Clear Text</button>
          <button name="resetText" type="button" id="resetText" onclick="reset_text()">Reset</button>
        </form>
      </div>
      <div id="eval_output" class="block eval_output">
        <p><?php if(isset($eval_output)) { echo $eval_output; } ?></p>
      </div>
      <footer><div class="right"><a href="https://github.com/sohelamankhan/pretty_index" target="_blank"><i>Pretty Index</i></a></div></footer>
    </div>
  </body>
</html>
