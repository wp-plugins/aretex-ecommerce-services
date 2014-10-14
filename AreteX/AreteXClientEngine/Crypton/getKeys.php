<?php
require_once('Crypt/RSA.php');
$rsa = new Crypt_RSA();
echo microtime(true);
$keys = $rsa->createKey(2048);
echo '<br/><hr/>';
echo microtime(true);
echo '<br/><hr/>';
?>
<pre>
<?php echo $keys['privatekey'] ?>
<hr />
<?php echo $keys['publickey'] ?>
</pre>