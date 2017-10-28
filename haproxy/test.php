<!DOCTYPE html>
<html>
<head>
<title>Welcome to nginx!</title>
<style>
    body {
        width: 35em;
        margin: 0 auto;
        font-family: Tahoma, Verdana, Arial, sans-serif;
    }
</style>
</head>
<body>
<h1>Welcome to nginx!</h1>
<p>If you see this page, the nginx web server is successfully installed and
working. Further configuration is required.</p>
</p>
<p>You run currently at
<?php passthru ("/bin/hostname"); ?>
</p>
<p>

<p id="demo">hallo, nichts geändert!</p>

<script language="javascript" type="text/javascript">
    var orig = document.location.origin;
    alert ("document.location.origin = " + orig);
    document.getElementById("demo").innerHTML = orig;
    
</script>

Check for php5-gd library:
<br />
<?php
$testGD = get_extension_funcs("gd"); // Grab function list
if (!$testGD)
     echo "GD not even installed.";
else echo"<pre>".print_r($testGD,true)."</pre>";?>
</p>
<p><pre><?php var_export($_SERVER)?></pre></p>
<p><pre><?php echo $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"] . "\n";?></pre></p>
<p><pre><?php echo "HTTP_HOST=" . $_SERVER["HTTP_HOST"] . "\n";?></pre></p>



<p>For online documentation and support please refer to
<a href="http://nginx.org/">nginx.org</a>.<br/>
Commercial support is available at
<a href="http://nginx.com/">nginx.com</a>.</p>

<p><em>Thank you for using nginx.</em></p>
</body>
</html>

