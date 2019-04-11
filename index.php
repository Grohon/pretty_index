<?php

$pi = new Pi();
$current_dir_url = rtrim("//" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']), '/');
list( $directories, $files ) = $pi->getDirContents();
$local_addr = $pi->getLocalAddress();

function colStyleGen($prefix = "col") {
  $temp = '';
  for ($i = 1; $i < 13; $i++) {$w = round($i * (100 / 12), 2);
    $temp .= '.' . $prefix . "-{$i} {width: {$w}%;}\n";}
  return $temp;
} // end of colStyleGen()

?>

<!DOCTYPE html>
<html>
<head>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Pretty Index</title>
  <style type="text/css">
    * { box-sizing: border-box; }
    html { font-family: "Lato", sans-serif; }
    .row::after { content: ""; clear: both; display: table; }
    [class*="col-"] { float: left; padding: 10px; }
    .header { background-color: teal; color: white; padding: 15px; }
    .menu ul { list-style-type: none; margin: 0; padding: 0; }
    .menu li {
      padding: 8px;
      margin-bottom: 7px;
      background-color: purple;
      color: white;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
    }
    .menu li:hover { background-color: skyblue; }
    .aside {
      background-color: purple;
      padding: 15px;
      color: white;
      text-align: center;
      font-size: 14px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
    }
    .footer {
      background-color: teal;
      color: white;
      text-align: center;
      font-size: 12px;
      padding: 15px;
    }
    button {
      background-color: darkslategray;
      border: none;
      color: white;
      padding: 5px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      cursor: pointer;
    }
    input[type=text], textarea {
      border: 1px solid darkslategray;
      padding: 4px;
      box-sizing: border-box;
    }
    select { padding: 4px; border: none; }
    .spinner { display: inline; }
    .spinner:after {
      content: " ";
      display: block;
      width: 18px;
      height: 18px;
      margin: 1px;
      border-radius: 50%;
      border: 3px solid darkslategray;
      border-color: darkslategray transparent darkslategray transparent;
      animation: spinner 1.2s linear infinite;
    }
    @keyframes spinner {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    /* For mobile phones: */
    [class*="col-"] { width: 100%; }

    @media only screen and (min-width: 600px) {
      /* For tablets: */
      <?php print colStyleGen('col-s');?>
    }

    @media only screen and (min-width: 768px) {
      /* For desktop: */
      <?php print colStyleGen();?>
    }
  </style>
  <style type="text/css">
    @media only screen and (min-width: 600px) {
      /* For tablets: */
      .center { width: 80%; }
    }
    @media only screen and (min-width: 768px) {
      /* For desktop: */
      .center { width: 40%; }
    }
    @media only screen and (min-width: 960px) {
      /* For desktop 2: */
      .center { width: 50%; }
    }

    .main a { text-decoration: none; color: royalblue; }
    .main a:hover { color: crimson; }
    .center { text-align: center; margin: 0 auto; }
    .text-right { text-align: right; }
    .text-left { text-align: left; }
    .pad-right { padding-right: 10px; }
    .pad-left { padding-left: 10px; }
    .pad { padding: 4px; }
    .hidden { display: none; }
    .dark-matter { visibility: hidden; }
    .blurry { opacity: 0.4; }
    .callout { border: 1px solid black; margin: 4px; padding: 4px; }
    .spacer { height: 10px; }
    .current-dir:hover { background-color: whitesmoke; }
    .main textarea { width: 100%; }
    .main #search-query { min-width: 50%; }
    .main #code-result { overflow-x: auto; }
    .error { color: red; }
    .warn { color: orange; }
    .main textarea, #code-result { font-family: monospace, sans-serif; background-color: whitesmoke; }
    .spinner { display: none; float: right; }

  </style>
  </meta>
</head>

<body>

  <div class="spacer"></div>

  <div class="main">

    <div class="row" id="host-wrapper">
      <div class="center">
        <div class="callout">
          <a href="javascript:location.reload();"><h1>localhost | <?php echo getHostByName(getHostName()); ?></h1></a>
        </div>
      </div>
    </div>

    <div class="row" id="time-wrapper">
      <div class="center">
        <div class="callout">
          <h3 id="datetime"><?php echo date('l, F j, H:i:s'); ?></h3>
        </div>
      </div>
    </div>

    <div class="row" id="infobox-wrapper">
      <div class="center">
        <div class="row callout">
          <div class="col-6 col-s-6 text-right">
            <div>Public IP : <b><span id="public-ip">N/A</span></b></div>
            <div>LAN IP : <b><?php echo $local_addr; ?></b></div>
            <div>Host IP : <b><?php echo getHostByName(getHostName()); ?></b></div>
            <div>Remote IP : <b><?php echo $_SERVER['REMOTE_ADDR']; ?></b></div>
          </div>
          <div class="col-6 col-s-6 text-left">
            <div>Document Root : <b><?php echo $_SERVER['DOCUMENT_ROOT']; ?></b></div>
            <div>PHP : <a href="#" id="phpinfo"><b><?php echo phpversion(); ?></b></a></div>
            <div>INI : <b><?php echo php_ini_loaded_file(); ?></b></div>
            <div>Timezone : <b><?php echo date_default_timezone_get(); ?></b></div>
          </div>
        </div>
      </div>
    </div>

    <div class="row" id="search-wrapper">
      <div class="center">
        <div class="callout">
          <div class="pad">
            <input type="text" id="search-query" maxlength="255" placeholder="Search" />
            <button class="search-button" data-uri="https://www.google.com/search?q=">Google</button>
          </div>
          <div class="pad">
            <button class="search-button" data-uri="https://duckduckgo.com/?q=">DuckDuckGo</button>
            <button class="search-button" data-uri="https://stackoverflow.com/search?q=">StackOverFlow</button>
            <button class="search-button" data-uri="https://github.com/search?q=">Github</button>
            <button class="search-button" data-uri="https://packagist.org/search/?q=">Packagist</button>
            <button class="search-button" data-uri="https://www.npmjs.com/search?q=">NPM</button>
          </div>
        </div>
      </div>
    </div>
    
    <!-- <div class="row" id="bookmarks-wrapper">
      <div class="center">
        <div class="callout">
          Bookmarks
        </div>
      </div>
    </div> -->

    <div class="row" id="current-dir-wrapper">
      <div class="center">
        <div class="callout current-dir">
          <a href="#" id="current-dir"><div><strong><?php echo __DIR__; ?></strong></div></a>
        </div>
      </div>
    </div>
    
    <div class="row hidden" id="dir-listing">
      <div class="center">
        <div class="row callout">
          <div class="col-6 col-s-6 text-left">
            <div>Directories</div><hr>
            <?php foreach ($directories as $folder) {
              echo '<b><a href="' . $current_dir_url . '/' . $folder . '">' . $folder . '</a></b><br/>';
            } ?>
          </div>
          <div class="col-6 col-s-6 text-right">
            <div>Files</div><hr>
            <?php foreach ($files as $file) {
              echo '<i><a href="' . $current_dir_url . '/' . $file . '">' . $file . '</a></i><br/>';
            } ?>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="center">
        <div class="callout text-left">
          <textarea class="code-box" id="code-box" name="code-box" rows="10" placeholder="Code..." autofocus></textarea><br>
          <select name="operation" id="operation">
            <option value="eval">PHP</option>
            <option value="jsonlint">JSON Lint</option>
            <option value="base64encode">Base64 Encode</option>
            <option value="base64decode">Base64 Decode</option>
            <option value="serialize">Serialize</option>
            <option value="unserialize">Unserialize</option>
          </select>
          <button id="code-submit">Execute</button>
          <div class="spinner" id="spinner"></div>
        </div>
      </div>
    </div>
    <div class="row hidden" id="code-result-wrapper">
      <div class="center">
        <div class="callout text-left" id="code-result"></div>
      </div>
    </div>

    <div class="row">
      <div class="center">
        <div class="blurry text-right pad-right"><em><a href="https://github.com/sohelaman/pretty-index" target="_blank">Pretty Index</a></em></div>
      </div>
    </div>
    
  </div><!-- main -->

</body>

<script type="text/javascript">
  class Pi {

    init() {
      this.registerEvents();
      this.ipfy('https://api.ipify.org?format=json').then(response => {
        if (response) { document.getElementById('public-ip').innerHTML = JSON.parse(response).ip; }
      }, error => { console.log(error); });
      
    } // end of init()

    ipfy(url) {
      return new Promise(function(resolve, reject) {
        var request = new XMLHttpRequest();
        request.open('GET', url);
        request.onload = () => {
          if(request.status === 200) resolve( request.response );
          else reject(Error('Failed to load IP. Error code: ' + request.statusText));
        };
        request.onerror = () => { reject(Error('Request failed.')); };
        request.send();
      });
    } // end of ipfy()

    phpinfo() {
      let xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = () => {
        if (xhttp.readyState == 4 && xhttp.status == 200) {
          let x = window.open('', '', 'location=no, toolbar=0');
          x.document.body.innerHTML = `${xhttp.responseText}`;
        }
      };
      xhttp.open("POST", window.location.href, true);
      xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhttp.send("phpinfo=1");
    } // end of phpinfo()

    codeSubmit() {
      let code = document.getElementById('code-box').value;
      code = typeof code === 'string' ? code.trim() : false;
      let op = document.getElementById('operation').value;
      if (!code || !op) return;
      this.loaderSpinner();
      let xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = () => {
        if (xhttp.readyState == 4) {
          let result = xhttp.status === 200 ? `${xhttp.responseText}` : '<em class="error">[Error ' + xhttp.status + ' - ' + xhttp.statusText + ']</em>';
          document.getElementById('code-result').innerHTML = result ? '<pre>' + result + '</pre>' : '<em class="warn">[No output]<em>';
          document.getElementById('code-result-wrapper').style.display = 'block';
          document.getElementById('infobox-wrapper').style.display = 'none';
          document.getElementById('search-wrapper').style.display = 'none';
          document.getElementById('current-dir-wrapper').style.display = 'none';
          document.getElementById('time-wrapper').style.display = 'none';
          this.loaderSpinner(true);
        }
      };
      xhttp.open("POST", window.location.href, true);
      xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhttp.send('code-box=' + code + '&operation=' + op);
    } // end of codeSubmit()

    showHide(elementID) {
      var elem = document.getElementById(elementID);
      elem.style.display = !elem.style.display || elem.style.display === 'none' ? 'block' : 'none';
    }

    loaderSpinner(hide) {
      let disp = hide ? 'none' : 'inline';
      document.getElementById('spinner').style.display = disp;
    }

    registerEvents() {
      document.getElementById('phpinfo').addEventListener('click', e => {
        e.preventDefault();
        this.phpinfo();
      });
      document.getElementById('search-query').addEventListener('keyup', e => {
        if (e.keyCode === 13) window.open('https://www.google.com/search?q=' + e.target.value, '_blank').focus();
      });
      // search buttons click
      document.querySelectorAll('.search-button').forEach((v) => {
        v.addEventListener('click', e => {
          let uri = e.target.getAttribute('data-uri'), query = document.getElementById('search-query').value;
          window.open(uri + query, '_blank').focus();
        });
      });
      document.getElementById('current-dir').addEventListener('click', e => {
        e.preventDefault();
        this.showHide('dir-listing');
      });
      document.getElementById('code-submit').addEventListener('click', e => {
        this.codeSubmit();
      });
      document.getElementById('code-box').addEventListener('keydown', e => {
        if (e.ctrlKey && e.keyCode === 13) this.codeSubmit();
      });
    } // end of registerEvents()

  } // end of class Pi
</script>
<script type="text/javascript">
  let pi = new Pi();
  pi.init();
</script>
</html>

<?php

class Pi {

  function __construct() {
    $this->_handleRequests();
  }

  private function _handleRequests() {
    if ( !empty($_REQUEST['phpinfo']) && $_REQUEST['phpinfo'] == 1 ) {
      phpinfo();
      exit;
    } else if( !empty($_POST['code-box']) && isset($_POST['operation']) ) {
      $code = trim($_POST['code-box']);
      $operation = $_POST['operation'];
      ob_start();
      switch ($operation) {
        case 'base64encode':
          echo base64_encode($code);
          break;
        case 'base64decode':
          echo base64_decode($code);
          break;
        case 'serialize':
          print serialize($code);
          break;
        case 'unserialize':
          print_r(unserialize($code));
          break;
        case 'jsonlint':
          $data = json_decode($code);
          $jout = json_last_error() === JSON_ERROR_NONE ? json_encode($data, JSON_PRETTY_PRINT) : '<em class="warn">[Invalid JSON]</em>';
          print $jout;
          break;
        default:
          eval($code);
          break;
      }
      $output = ob_get_contents();
      ob_end_clean();
      echo $output;
      exit;
    }
  } // end of _handleRequests()

  public function getLocalAddress() {
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
      $interfaces = array_diff(explode(PHP_EOL, `ls -1 /sys/class/net`), ['', 'lo', 'docker0', 'virbr0']);
      foreach( $interfaces as $interface ) {
        // $methods[] = function() { return exec("ifconfig $interface | grep -Eo 'inet (addr:)?([0-9]*\.){3}[0-9]*' | grep -Eo '([0-9]*\.){3}[0-9]*' | grep -v '127.0.0.1'"); };
        // $methods[] = function() { return exec("ifconfig $interface | sed -En 's/127.0.0.1//;s/.*inet (addr:)?(([0-9]*\.){3}[0-9]*).*/\2/p'"); };
      }
      $methods[] = function() { return `hostname -I | awk '{print $1}'`; };
      // $methods[] = function() { return `ip route get 1 | awk '{print $NF;exit}'`; };
      foreach( $methods as $method ) {
        $ip = trim($method());
        if( filter_var($ip, FILTER_VALIDATE_IP) ) { return $ip; }
      } // endforeach
    }
    return "N/A";
  } // end of getLocalAddress()

  public function getDirContents( $dir = __DIR__ ) {
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
  } // end of getDirContents()

} // end of class Pi

?>
