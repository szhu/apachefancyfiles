<?php

$file = realpath($_SERVER['PATH_TRANSLATED']);

if ($_SERVER['QUERY_STRING'] == 'raw') {

  header('Content-type: text/plain');
  echo file_get_contents($file);

}

else {

  header('Content-type: text/html; charset=utf-8');

  $mdExtensions = array('md', 'mdown', 'markdown');
  $fileExt = strtolower(substr($file, strrpos($file, '.') + 1));

  $isMd = in_array($fileExt, $mdExtensions);
?>
<!DOCTYPE html>
<html>
<head>
  <title><?php echo $_SERVER['REQUEST_URI'] ?></title>
  <meta name="content-type" http-equiv="content-type" value="text/html; utf-8"/>
  <style>
  html, body {
    margin: 0;
    padding: 0;
  }
  h1.filename, h1.filename a {
    color: #FFF;
  }
  h1.filename {
    background: #000;
    margin: 0;
    margin-bottom: 10px;
    font-family: Courier, monospace;
    font-weight: normal;
    font-size: 20px;
    padding: 8px;
  }
  <?php if (!$isMd) { ?>
  pre.prettyprint {
    margin: 0;
    padding: 0;
    border: none !important;
    white-space: pre-wrap;
  }
  pre.prettyprint li {
    background: none !important;
    list-style-type: decimal !important;
    color: gainsboro !important;
  }
  <?php } ?>
  </style>
  <?php if ($isMd) { ?>
  <link rel="stylesheet" type="text/css" href="<?php echo dirname($_SERVER['SCRIPT_NAME']) ?>/markdown-style.css" />
  <?php } else { ?>
  <script src="//google-code-prettify.googlecode.com/svn/loader/run_prettify.js"></script>
  <script src="//google-code-prettify.googlecode.com/svn/trunk/src/lang-r.js"></script>
  <?php } ?>
</head>
<body>
  <h1 class="filename"><a href=".">..</a> <a href="?raw">raw</a> <?php echo htmlspecialchars($_SERVER['REQUEST_URI']) ?></h1>
<?php
if ($isMd) {
  require('markdown.php');
?><div class="markdown"><?php
  echo Markdown(file_get_contents($file));
?></div><?php
} else {
?><pre class="prettyprint linenums"><?php
  echo htmlspecialchars(file_get_contents($file));
?></pre><?php
}
?>
</body>
</html>
<?php
}
?>