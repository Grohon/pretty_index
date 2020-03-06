<?php $pi = new Pi(); /* Pretty Index */ ?>

<!DOCTYPE html>
<html>
<head>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Pretty Index</title>
  <link rel="icon" type="image/x-icon" href="#"/>
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
    .btn {
      background-color: darkslategray;
      border: none;
      color: white;
      padding: 5px;
      margin: 3px 1px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      cursor: pointer;
    }
    input[type=text], textarea {
      border: 1px solid darkslategray;
      padding: 4px;
      box-sizing: border-box;
      color: inherit;
      background-color: inherit;
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

    .disappear {
      animation: cssAnimDisappear 0s 3s forwards;
      visibility: visible;
    }
    @keyframes cssAnimDisappear {
      to { visibility: hidden; }
    }

    /* For mobile phones: */
    [class*="col-"] { width: 100%; }

    @media only screen and (min-width: 600px) {
      /* For tablets: */
      <?php print Pi::colStyleGen('col-s');?>
    }

    @media only screen and (min-width: 768px) {
      /* For desktop: */
      <?php print Pi::colStyleGen();?>
    }
  </style>
  <style type="text/css">
    @media only screen and (min-width: 600px) {
      /* For tablets: */
      .center { width: 80%; }
    }
    @media only screen and (min-width: 768px) {
      /* For desktop: */
      .center { width: 60%; }
    }

    .content a { text-decoration: none; color: royalblue; }
    .content a:hover { color: crimson; }
    .center { text-align: center; margin: 0 auto; }
    .text-right { text-align: right; }
    .text-left { text-align: left; }
    .right { float: right; }
    .left { float: left; }
    .pad-right { padding-right: 10px; }
    .pad-left { padding-left: 10px; }
    .pad { padding: 4px; }
    .pad-sides { padding: 0 4px; }
    .wide { width: 100%; }
    .word-wrap { word-wrap: break-word; }
    .hidden { display: none; }
    .dark-matter { visibility: hidden; }
    .blurry { opacity: 0.4; }
    .callout { border: 1px solid black; margin: 4px; padding: 4px; }
    .spacer { height: 10px; }
    .current-dir:hover { background-color: whitesmoke; }
    .content textarea { width: 100%; resize: vertical; }
    .content textarea#code-box, #code-result { font-family: monospace, sans-serif; background-color: whitesmoke; }
    .content #search-query { min-width: 50%; }
    .content #code-result, #todo-list, #history-list { overflow-x: auto; }
    .error { color: red; }
    .warn { color: orange; }
    .spinner { display: none; }
    .content .exterminate a.bookmark, .content .excavate a.bookmark { color: red; }
    .content .exterminate a.bookmark:hover { text-decoration: line-through; }
    .content .excavate a.bookmark:hover { font-weight: bold; }
    /*.sidepane { padding-left: 0; }*/
    .bold, .delete-todo { font-weight: bold; }
    .underlined { text-decoration: underline; }
    .content h3, .content h1 { margin: 14px; }
    .infobox { padding: 2px 10px; }
    a#dark-mode { color: inherit; padding-left: 4px; }
    .dark { color: lightgray; background-color: black; }
    .dark .callout { border: 1px solid lightgray; }
    .dark .current-dir:hover { background-color: darkslategrey; }
    .dark textarea#code-box, .dark #code-result { background-color: darkslategrey; color: white; }
    .dark textarea#code-box::placeholder { color: darkgrey; }
    .dark a { color: teal; }
    .dark a#dark-mode { color: white; }
    .truncate { width: 9rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
  </style>
</head>

<body>

  <div class="spacer"></div>

  <div class="content center">
    <div class="row">

      <div class="main col-9 col-s-12">
        <div class="row" id="host-wrapper">
          <div class="callout">
            <a href="javascript:location.reload();"><h1><?php echo $pi->getDetails('host') . ' | ' . getHostByName(gethostname()); ?></h1></a>
          </div>
        </div>

        <div class="row" id="time-wrapper">
          <div class="callout">
            <h3 id="datetime"><?php echo date('l, F j, H:i:s'); ?></h3>
          </div>
        </div>

        <div class="row" id="infobox-wrapper">
          <div class="row callout">
            <div class="row">
              <div class="col-6 col-s-6 infobox text-right">
                <div>Public IP : <b><span id="public-ip">N/A</span></b></div>
                <div>LAN IP : <b><?php echo $pi->getLocalAddress(); ?></b></div>
                <div>Host IP : <b><?php echo getHostByName(gethostname()); ?></b></div>
                <div>Remote IP : <b><?php echo $_SERVER['REMOTE_ADDR']; ?></b></div>
              </div>
              <div class="col-6 col-s-6 infobox text-left word-wrap">
                <div>DocRoot : <b><?php echo $_SERVER['DOCUMENT_ROOT']; ?></b></div>
                <div class="truncate">PHP : <a href="#" id="phpinfo" title="<?php echo phpversion(); ?>"><b><?php echo phpversion(); ?></b></a></div>
                <div>INI : <b><?php echo php_ini_loaded_file(); ?></b></div>
                <div>Timezone : <b><?php echo date_default_timezone_get(); ?></b></div>
              </div>
              <div class="row"><a href="#" id="more-info" title="More info">&#128899;</a></div>
            </div>
          </div>
        </div>
        <div class="row hidden" id="infobox-more">
          <div class="row callout">
            <?php $mem = $pi->getDetails('mem'); if ($mem): ?><div class="pad"><b>Memory:</b> <em><?php print $mem; ?></em></div><?php endif; ?>
            <?php $disk = $pi->getDetails('disk'); if ($disk): ?><div class="pad"><b>Root Filesystem:</b> <em><?php print $disk; ?></em></div><?php endif; ?>
            <?php $who = $pi->getDetails('who'); if ($who): ?><div class="pad"><b>User:</b> <em><?php print $who; ?></em></div><?php endif; ?>
            <div class="pad"><b>Hostname:</b> <em><?php print getHostName(); ?></em></div>
            <div class="pad"><b>Server Software:</b> <em><?php print $pi->getDetails('sw'); ?></em></div>
            <?php $sys = $pi->getDetails('sys'); if ($disk): ?><div class="pad"><b>System:</b> <em><?php print $sys; ?></em></div><?php endif; ?>
            <div class="pad"><b>UA:</b> <em id="user-agent"><?php print $pi->getDetails('ua'); ?></em></div>
            <div class="pad"><b>PHP Extensions:</b> <em id="php-exts"><?php print $pi->getDetails('phpexts'); ?></em></div>
          </div>
        </div>

        <div class="row" id="search-wrapper">
          <div class="callout">
            <div class="pad">
              <input type="text" id="search-query" maxlength="255" placeholder="Search" />
              <button class="btn search-button" data-uri="https://www.google.com/search?q=">Google</button>
            </div>
            <div class="pad">
              <button class="btn search-button" data-uri="https://duckduckgo.com/?q=">DuckDuckGo</button>
              <button class="btn search-button" data-uri="https://stackoverflow.com/search?q=">StackOverFlow</button>
              <button class="btn search-button" data-uri="https://github.com/search?q=">Github</button>
              <button class="btn search-button" data-uri="https://packagist.org/search/?q=">Packagist</button>
              <button class="btn search-button" data-uri="https://www.npmjs.com/search?q=">NPM</button>
            </div>
          </div>
        </div>

        <div class="row" id="bookmark-wrapper">
          <div class="callout text-left">
            <button id="bookmark-add" title="Add bookmark"><b>&plus;</b></button>&nbsp;
            <span class="right">&nbsp;
              <button id="bookmark-edit" title="Edit bookmark"><b>~</b></button>
              <button id="bookmark-delete" title="Delete bookmark"><b>&times;</b></button>
            </span>
            <span id="bookmark-list"></span>
          </div>
        </div>
        <div class="row hidden" id="bookmark-detail-wrapper">
          <div class="callout">
            <div class="row">
              <div class="col-3 col-s-3">
                <input class="wide" type="text" name="bookmark-name" id="bookmark-name" placeholder="Name">
              </div>
              <div class="col-7 col-s-7">
                <input class="wide" type="text" name="bookmark-url" id="bookmark-url" placeholder="Real URL">
              </div>
              <div class="col-2 col-s-2">
                <button class="btn" id="bookmark-save" data-id="0">Save</button>
              </div>
            </div>
          </div>
        </div>

        <div class="row" id="current-dir-wrapper">
          <div class="callout current-dir">
            <a href="#" id="current-dir" title="Toggle"><div><strong><?php echo __DIR__; ?></strong></div></a>
          </div>
        </div>

        <?php $current_dir_url = rtrim("//" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']), '/'); ?>
        <?php list($directories, $files) = $pi->getDirContents(); ?>

        <div class="row hidden" id="dir-listing">
          <div class="row callout word-wrap">
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

        <div class="row">
          <div class="callout text-left">
            <textarea class="code-box" id="code-box" name="code-box" rows="10" placeholder="Code..." autofocus></textarea><br>
            <select name="operation" id="operation">
              <option value="eval">PHP</option>
              <option value="md5">MD5</option>
              <option value="base64encode">Base64 Encode</option>
              <option value="base64decode">Base64 Decode</option>
              <option value="serialize">Serialize</option>
              <option value="unserialize">Unserialize</option>
              <option value="beautifyJson">Beautify JSON</option>
              <option value="parseUri">Parse URI</option>
            </select>
            <button class="btn" id="code-submit">Execute</button>
            <button class="btn" id="copy-code">Copy</button>
            <button class="btn hidden" id="copy-result">Copy Result</button>
            <button class="btn hidden" id="raw-result" title="Raw result">{ }</button>
            <em class="pad hidden" id="code-msg"></em>
            <div class="spinner right" id="spinner"></div>
          </div>
        </div>
        <div class="row hidden" id="code-result-wrapper">
          <div class="callout text-left" id="code-result"></div>
        </div>
        <div class="row hidden">
          <form id="raw-result-form" method="post" target="_blank">
            <input id="raw-result-val" type="text" name="raw-result" value="">
          </form>
        </div>

        <div class="row">
          <div class="blurry text-right pad-right">
            <em><a href="https://github.com/sohelaman/pretty-index" target="_blank">Pretty Index</a></em>
            <span><a href="#" id="dark-mode" title="Toggle dark mode">&#127767;</a></span><!-- 127769 -->
          </div>
        </div>
      </div><!-- main -->

      <div class="sidepane col-3 col-s-12 text-left">
        <div class="callout">
          <div class="pad">
            <div><strong>Todos</strong></div>
            <div class="spacer"></div>
            <textarea id="todo-box" placeholder="What to do?" title="Hit Ctrl+Return to save"></textarea>
            <div id="todo-list"></div>
          </div>
        </div>
        <div class="spacer"></div>
        <div class="callout">
          <div class="pad">
            <div><strong>History &nbsp;<a href="#" id="clear-histories" title="Clear all histories">&times;</a></strong></div>
            <div class="spacer"></div>
            <div id="history-list"></div>
          </div>
        </div>
      </div><!-- sidepane -->

    </div><!-- row -->

  </div><!-- content -->


</body>

<script type="text/javascript">
  class Pi {
    constructor() {
      this._prefix = '_pretty_index__';
      this._conf = {};
      this.configure();
      this.init();
    }

    configure() {
      let defaults = {
        darkMode: true,
        maxHistories: 30, // maximum number of histories to keep.
        historyExcerptLength: 22, // history excerpt length before truncating.
      };
      Object.keys(defaults).forEach(v => {
        let conf = this.confStore(v);
        this._conf[v] = conf ? conf : defaults[v];
      });
    }

    init() {
      if (this._conf.darkMode) document.getElementsByTagName('body')[0].classList.add('dark');
      this.binds();
      this.listBookmarks();
      this.listTodos();
      this.listHistories();
      this.ipfy('https://api.ipify.org?format=json').then(response => {
        if (response) { document.getElementById('public-ip').innerHTML = JSON.parse(response).ip; }
      }, error => { console.log('ipfy error', error); });
      let ua = document.getElementById('user-agent');
      if (ua.innerHTML === 'N/A') ua.innerHTML = navigator.userAgent;
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
      if (!code || !op) { this.showMsg('Execute Order 66'); return; }
      this.loaderSpinner();
      let xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = () => {
        if (xhttp.readyState == 4) {
          let result = xhttp.status === 200 ? `${xhttp.responseText}` : '<em class="error">[Error ' + xhttp.status + ' - ' + xhttp.statusText + ']</em>';
          document.getElementById('code-result').innerHTML = result ? '<pre>' + result + '</pre>' : '<em class="warn">[No output]<em>';
          document.getElementById('code-result-wrapper').classList.remove('hidden');
          document.getElementById('copy-result').classList.remove('hidden');
          document.getElementById('raw-result').classList.remove('hidden');
          this.hideOtherBoxes();
          this.loaderSpinner(true);
        }
      };
      xhttp.open("POST", window.location.href, true);
      xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhttp.send('code-box=' + btoa(code) + '&operation=' + op);
      this.addHistory();
    } // end of codeSubmit()

    showMsg(msg) {
      let codeMsg = document.getElementById('code-msg');
      codeMsg.innerHTML = msg;
      codeMsg.classList.remove('hidden');
      setTimeout(() => { codeMsg.classList.add('hidden'); codeMsg.innerHTML = ''; }, 3000);
    } // end of showMsg()

    copyCode() {
      let codeBox = document.getElementById('code-box');
      if (!codeBox.value) { this.showMsg('Such empty!'); return; }
      codeBox.select();
      document.execCommand("copy");
      this.showMsg('Code copied');
    }

    copyResult() {
      let result = document.querySelector('#code-result pre');
      if (!result || !result.textContent) { this.showMsg('Such empty!'); return; }
      let str = result.textContent; // result.textContent or result.innerHTML
      let resultCopyListener = e => {
        e.clipboardData.setData("text/html", str);
        e.clipboardData.setData("text/plain", str);
        e.preventDefault();
      };
      document.addEventListener("copy", resultCopyListener);
      document.execCommand("copy");
      document.removeEventListener("copy", resultCopyListener);
      this.showMsg('Result copied');
    } // end of copyResult()

    rawResult() {
      let result = document.querySelector('#code-result pre');
      if (!result || !result.textContent) { this.showMsg('Such empty!'); return; }
      let str = result.innerHTML; // result.textContent or result.innerHTML
      document.getElementById('raw-result-val').value = encodeURI(str);
      document.forms["raw-result-form"].submit();
    } // end of rawResult()

    hideOtherBoxes() {
      let boxes = ['infobox-wrapper', 'infobox-more', 'search-wrapper', 'current-dir-wrapper', 'time-wrapper', 'bookmark-wrapper', 'bookmark-detail-wrapper'];
      boxes.forEach(v => { document.getElementById(v).classList.add('hidden'); });
    }

    loaderSpinner(hide) {
      let disp = hide ? 'none' : 'inline';
      document.getElementById('spinner').style.display = disp;
    }

    isValidURL(str) {
      try {
        new URL(str);
        return true;
      } catch (_) {
        return false;
      }
    }

    confStore(key, val) {
      if (typeof val === 'undefined' || val === null) {
        let config = this.getItem('conf', key);
        return config ? config.body : null;
      } else this.addItem('conf', {id: key, body: val});
    }

    addItem(type, data) {
      if (!localStorage) { alert('Your browser does not seem to support localStorage!'); return; }
      if (typeof data.id === 'undefined' || data.id === null) {
        let indexKey = this._prefix + type + '_index';
        let index = localStorage.getItem(indexKey);
        index = index ? parseInt(index) : 0;
        index++;
        data.id = index;
        let key = this._prefix + type + '-' + index;
        localStorage.setItem(key, JSON.stringify(data));
        localStorage.setItem(indexKey, index);
      } else {
        let key = this._prefix + type + '-' + data.id;
        localStorage.setItem(key, JSON.stringify(data));
      }
    } // end of addItem()

    deleteItem(type, index) {
      let key = this._prefix + type + '-' + index;
      localStorage.removeItem(key);
    } // end of deleteItem()

    getItem(type, index) {
      let key = this._prefix + type + '-' + index;
      let item = localStorage.getItem(key);
      return item ? JSON.parse(item) : false;
    } // end of getItem()

    getItems(type, descending) {
      if (!localStorage) return false;
      let items = [], keyPrefix = this._prefix + type + '-';
      let keys = Object.keys(localStorage);
      keys.forEach(v => {
        if (v.includes(keyPrefix)) items.push(JSON.parse(localStorage[v]));
      });
      if (!!descending)
        items.sort((a,b) => (a.id < b.id) ? 1 : ((b.id < a.id) ? -1 : 0));
      else
        items.sort((a,b) => (a.id > b.id) ? 1 : ((b.id > a.id) ? -1 : 0));
      return items;
    } // end of getItems();

    listBookmarks() {
      let bms = this.getItems('bookmark');
      let list = document.getElementById('bookmark-list');
      while (list.firstChild) {
        list.removeChild(list.firstChild);
      }
      bms.forEach(v => {
        let a = document.createElement('a');
        a.innerHTML = v.name;
        a.href = v.url;
        a.classList.add('bookmark');
        a.classList.add('pad-right');
        a.setAttribute('data-id', v.id);
        a.setAttribute('target', '_blank');
        a.addEventListener('click', e => {
          if (document.getElementById('bookmark-wrapper').classList.contains('exterminate')) {
            e.preventDefault();
            this.deleteBookmark(e.target.getAttribute('data-id'));
            document.getElementById('bookmark-wrapper').classList.remove('exterminate');
          } else if (document.getElementById('bookmark-wrapper').classList.contains('excavate')) {

            e.preventDefault();
            document.querySelectorAll('#bookmark-list a.bookmark').forEach(v => {
              v.classList.remove('bold');
            });
            e.target.classList.add('bold');
            let index = e.target.getAttribute('data-id');
            let bm = this.getItem('bookmark', index);
            document.getElementById('bookmark-detail-wrapper').classList.remove('hidden');
            document.getElementById('bookmark-save').setAttribute('data-id', index);
            document.getElementById('bookmark-name').value = bm.name;
            document.getElementById('bookmark-url').value = bm.url;
          }
        });
        list.appendChild(a);
      });
      if (!list.firstChild) list.innerHTML = '<em>Such empty!</em>';
    } // end of listBookmarks()

    addBookmark(updateId) {
      let name = document.getElementById('bookmark-name');
      let url = document.getElementById('bookmark-url');
      if (!name.value || !url.value || !name.value.trim() || !url.value.trim()) { alert('Something is missing! Mhmm, your intelligence.'); return; }
      if (!this.isValidURL(url.value)) { alert("I said the 'real' URL."); return; }
      let bm = { id: null, name: name.value.trim(), url: url.value.trim() };
      if (updateId && parseInt(updateId) > 0) bm.id = updateId;
      this.addItem('bookmark', bm);
      name.value = null;
      url.value = null;
      document.getElementById('bookmark-detail-wrapper').classList.add('hidden');
      document.getElementById('bookmark-wrapper').classList.remove('excavate');
      this.listBookmarks();
    } // end of addBookmark()

    deleteBookmark(index) {
      if (!confirm('Delete bookmark?')) return;
      this.deleteItem('bookmark', index);
      this.listBookmarks();
    }

    listTodos() {
      let todos = this.getItems('todo');
      let list = document.getElementById('todo-list');
      while (list.firstChild) {
        list.removeChild(list.firstChild);
      }
      if (todos.length > 0) list.appendChild(document.createElement('hr'));
      todos.forEach(v => {
        let del = document.createElement('a');
        del.innerHTML = '&times;';
        del.href = '#';
        del.classList.add('delete-todo');
        del.setAttribute('data-id', v.id);
        del.setAttribute('title', 'Delete');
        del.addEventListener('click', e => {
          e.preventDefault();
          this.deleteTodo(e.target.getAttribute('data-id'));
        });
        list.appendChild(del);
        let elm = document.createElement('span');
        elm.innerHTML = v.body;
        elm.classList.add('todo');
        elm.classList.add('pad');
        elm.setAttribute('data-id', v.id);
        list.appendChild(elm);
        list.appendChild(document.createElement('hr'));
      });
      // if (!list.firstChild) list.innerHTML = '<em>Such empty!</em>';
    } // end of listTodos()

    addTodo() {
      let body = document.getElementById('todo-box');
      if (!body.value || !body.value.trim()) { window.location.href = 'https://en.wikipedia.org/wiki/Nothing'; return; }
      let todo = { id: null, body: body.value.trim() };
      this.addItem('todo', todo);
      body.value = null;
      this.listTodos();
    } // end of addTodo()

    deleteTodo(index) {
      if (!confirm('Delete todo?')) return;
      this.deleteItem('todo', index);
      this.listTodos();
    } // end of deleteTodo()

    addHistory() {
      let body = document.getElementById('code-box');
      if (!body.value || !body.value.trim()) return;
      let code = body.value.trim();
      let hash = this.int32Hash(code);
      let histories = this.getItems('history', true), removedOne = false;
      for (let i = 0; i < histories.length; i++) {
        if (histories[i].hash === hash) {
          this.deleteItem('history', histories[i].id);
          removedOne = true;
          break;
        }
      } // endfor
      if (histories.length >= this._conf.maxHistories && !removedOne)
        this.deleteItem('history', histories[histories.length - 1].id);
      let excerpt = code.substring(0, this._conf.historyExcerptLength);
      if (code.length > this._conf.historyExcerptLength) excerpt += '...';
      let op = document.getElementById('operation').value;
      let hist = {id: null, hash: hash, op: op, excerpt: excerpt, body: btoa(code)};
      this.addItem('history', hist);
      this.listHistories();
    } // end of addHistory()

    deleteHistory(index) {
      if (!confirm('Delete history?')) return;
      this.deleteItem('history', index);
      this.listHistories();
    } // end of deleteHistory()

    clearHistories() {
      if (!confirm('Clear all histories?')) return;
      let hists = this.getItems('history');
      hists.forEach(v => { this.deleteItem('history', v.id); });
      this.listHistories();
    } // end of clearHistories()

    listHistories() {
      let hists = this.getItems('history', true);
      let list = document.getElementById('history-list');
      while (list.firstChild) {
        list.removeChild(list.firstChild);
      }
      // if (hists.length > 0) list.appendChild(document.createElement('hr'));
      hists.forEach(v => {
        let del = document.createElement('a');
        del.innerHTML = '&times;&nbsp;';
        del.href = '#';
        del.classList.add('delete-history');
        del.setAttribute('data-id', v.id);
        del.setAttribute('title', 'Delete');
        del.addEventListener('click', e => {
          e.preventDefault();
          this.deleteHistory(e.target.getAttribute('data-id'));
        });
        list.appendChild(del);
        let elm = document.createElement('a');
        elm.href = '#';
        elm.innerHTML = v.excerpt;
        elm.classList.add('history');
        elm.classList.add('pad-sides');
        elm.setAttribute('data-id', v.id);
        elm.addEventListener('click', e => {
          e.preventDefault();
          this.loadHistory(e.target.getAttribute('data-id'));
        });
        list.appendChild(elm);
        list.appendChild(document.createElement('br'));
      });
      if (!list.firstChild) list.innerHTML = '<em>The entire history of you.</em>';
    } // end of listHistories()

    loadHistory(index) {
      let hist = this.getItem('history', index);
      if (hist) {
        document.getElementById('code-box').value = atob(hist.body);
        document.getElementById('operation').value = hist.op;
        this.hideOtherBoxes();
      }
    } // end of loadHistory()

    int32Hash(str) {
      // source: https://stackoverflow.com/questions/7616461
      var hash = 0, i, chr;
      if (str.length === 0) return hash;
      for (i = 0; i < str.length; i++) {
        chr   = str.charCodeAt(i);
        hash  = ((hash << 5) - hash) + chr;
        hash |= 0; // Convert to 32bit integer
      }
      return hash;
    } // end of int32Hash()

    binds() {
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
        document.getElementById('dir-listing').classList.toggle('hidden');
      });
      document.getElementById('code-submit').addEventListener('click', e => {
        this.codeSubmit();
      });
      document.getElementById('code-box').addEventListener('keydown', e => {
        if (e.ctrlKey && e.keyCode === 13) this.codeSubmit();
      });
      document.getElementById('bookmark-add').addEventListener('click', e => {
        document.getElementById('bookmark-detail-wrapper').classList.toggle('hidden');
      });
      document.getElementById('bookmark-save').addEventListener('click', e => {
        this.addBookmark(e.target.getAttribute('data-id'));
      });
      document.getElementById('bookmark-delete').addEventListener('click', e => {
        if (document.querySelectorAll('#bookmark-list a.bookmark').length > 0)
          document.getElementById('bookmark-wrapper').classList.toggle('exterminate');
        else this.showMsg('Silence is golden.');
      });
      document.getElementById('bookmark-edit').addEventListener('click', e => {
        if (document.querySelectorAll('#bookmark-list a.bookmark').length > 0)
          document.getElementById('bookmark-wrapper').classList.toggle('excavate');
        else this.showMsg('Silence is golden.');
        if (!document.getElementById('bookmark-wrapper').classList.contains('excavate')) {
          document.getElementById('bookmark-detail-wrapper').classList.add('hidden');
          document.querySelectorAll('#bookmark-list a.bookmark').forEach(v => {
            v.classList.remove('bold');
          });
        }
      });
      document.getElementById('copy-code').addEventListener('click', e => {
        this.copyCode();
      });
      document.getElementById('copy-result').addEventListener('click', e => {
        this.copyResult();
      });
      document.getElementById('raw-result').addEventListener('click', e => {
        this.rawResult();
      });
      document.getElementById('clear-histories').addEventListener('click', e => {
        e.preventDefault();
        this.clearHistories();
      });
      document.getElementById('todo-box').addEventListener('keydown', e => {
        if (e.ctrlKey && e.keyCode === 13) this.addTodo();
      });
      document.getElementById('more-info').addEventListener('click', e => {
        e.preventDefault();
        document.getElementById('infobox-more').classList.toggle('hidden');
      });
      document.getElementById('dark-mode').addEventListener('click', e => {
        e.preventDefault();
        let body = document.getElementsByTagName('body')[0];
        body.classList.toggle('dark');
        this._conf.darkMode = !this._conf.darkMode;
        this.confStore('darkMode', this._conf.darkMode);
      });
    } // end of binds()

  } // end of class Pi
</script>

<script type="text/javascript">let pi = new Pi();</script>

</html>

<?php

class Pi {
  function __construct() {
    $this->_handleRequests();
  }

  private function _handleRequests() {
    if (!empty($_REQUEST['raw-result'])) {
      die(urldecode($_REQUEST['raw-result']));
    } else if (!empty($_REQUEST['phpinfo']) && $_REQUEST['phpinfo'] == 1) {
      phpinfo();
      exit;
    } else if(!empty($_POST['code-box']) && isset($_POST['operation'])) {
      $code = base64_decode( strtr( $_POST['code-box'], ' ', '+')) ;
      $operation = $_POST['operation'];
      ob_start();
      switch ($operation) {
        case 'md5':
          echo md5($code);
          break;
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
        case 'parseUri':
          print $this->parseURI($code);
          break;
        case 'beautifyJson':
          $data = json_decode(trim($code));
          $jout = json_last_error() === JSON_ERROR_NONE ? json_encode($data, JSON_PRETTY_PRINT) : '<em class="warn">[Invalid format]</em>';
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

  public function getOS() {
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') return 'WINDOWS';
    else if (strtoupper(PHP_OS) === 'LINUX') return 'LINUX';
    else return PHP_OS;
  }

  public function getLocalAddress() {
    if ($this->getOS() === 'WINDOWS') {
      exec("ipconfig /all", $output);
      foreach ($output as $line) {
        if (preg_match("/(.*)IPv4 Address(.*)/", $line)) {
          if (preg_match('/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/', $line, $match)) {
            if (filter_var($match[0], FILTER_VALIDATE_IP)) { return trim($match[0]); }
          }
        }
      } // endforeach
    } else if ($this->getOS() === 'LINUX') {
      $methods = array();
      $ifs = explode(PHP_EOL, `ls -1 /sys/class/net`);
      $interfaces = array_diff($ifs ? $ifs : [], ['', 'lo', 'docker0', 'virbr0']);
      $methods[] = function() { return `hostname -i | awk '{print $1}'`; };
      $methods[] = function() { return `hostname -I | awk '{print $1}'`; };
      foreach ($interfaces as $interface) {
        $methods[] = function() use($interface) { return exec("ip a $interface | grep -Eo 'inet (addr:)?([0-9]*\.){3}[0-9]*' | grep -Eo '([0-9]*\.){3}[0-9]*' | grep -v '127.0.0.1'"); };
        $methods[] = function() use($interface) { return exec("ifconfig $interface | sed -En 's/127.0.0.1//;s/.*inet (addr:)?(([0-9]*\.){3}[0-9]*).*/\2/p'"); };
      }
      foreach ($methods as $method) {
        $ip = trim($method());
        if (filter_var($ip, FILTER_VALIDATE_IP)) { return $ip; }
      } // endforeach
    }
    return "N/A";
  } // end of getLocalAddress()

  public function getDirContents($dir = __DIR__) {
    $directories = array();
    $files_list  = array();
    $files = scandir($dir);
    foreach($files as $file) {
       if(($file != '.') && ($file != '..')) {
          if (is_dir($dir . '/' . $file)) $directories[] = $file;
          else $files_list[] = $file;
       }
    }
    return array($directories, $files_list);
  } // end of getDirContents()

  public function getDetails($what = 'sys') {
    if ($what === 'mem') return exec('free -g | grep \'Mem:\' | awk \'{print $3"/"$2"G Used"}\'');
    else if ($what === 'disk') return exec('df -h | grep \' /$\' | awk \'{print "Used: "$5" | Free: "$4"/"$2}\'');
    else if ($what === 'ua') return isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'N/A';
    else if ($what === 'sw') return isset($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : 'N/A';
    else if ($what === 'host') return isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : gethostname();
    else if ($what === 'who') return exec('whoami');
    else if ($what === 'phpexts') return exec("php -m | grep -E '^[a-zA-Z\_\-]+' | tr '\n' ' '");
    else return php_uname();
  }

  public function parseURI($str) {
    if (!filter_var($str, FILTER_VALIDATE_URL)) return '<em class="warn">[Invalid URI]</em>';
    $info = parse_url($str);
    $info['length'] = strlen($str);
    $query_params = null;
    $fragment_params = null;
    if (!empty($info['query'])) parse_str($info['query'], $query_params);
    if (!empty($info['fragment'])) parse_str(ltrim($info['fragment'], '?'), $fragment_params);
    $info['query_params'] = $query_params;
    $info['fragment_params'] = $fragment_params;
    return print_r($info, true);
  } // end of parseURI()

  public static function colStyleGen($prefix = "col") {
    $temp = '';
    for ($i = 1; $i < 13; $i++) {$w = round($i * (100 / 12), 2);
      $temp .= '.' . $prefix . "-{$i} {width: {$w}%;}\n";}
    return $temp;
  } // end of colStyleGen()

} // end of class Pi

?>
