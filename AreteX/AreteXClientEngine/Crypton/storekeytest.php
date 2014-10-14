<?
require_once('Crypton.php');
 
$keys['privatekey']=<<<END_PRIVATEKEY
-----BEGIN RSA PRIVATE KEY-----
MIICXQIBAAKBgQC4nuy9jz5Ur1EhRNhUzRIjLlQ/D+dwu3Ih67eOTPVy/mZ2Axig
qQrdb+a4wGa9lIDoG5TtNU4XjE1HG5NCGu+UURy5i+40Hi7iwvXSVXyzCZVvN21D
aTJZjZuJ4OR8LqWOj9VdvfROM7XbRxvAE9ZiDhOw/lEPI/wfng+DaufRsQIDAQAB
AoGAVt3QHlDrzwS+c5zk/OGQiyUdVp6xEwXfab5zG21yf6zboONMDyv6hL5GHN/K
d6EMFioEJKhUGhhVtANxgkUSPDZAun48HDpoJKAXTiwZ2MPsbqw0TybNNplBBHqa
uUPUQZPW/0wRMJhvRzzrp4vEUuN7Aqmc2DeEKN+omo2k3pECQQDiFVRL9duOG8od
eB0yuCGA//Km5H4JSd8UozKQO31v+KtTEfI5T6OkoVCcPpQzEqCr3TFWgdt8FKiZ
ehnHX1XLAkEA0Q0I376+MP9Hd7soG0vANY3cQ7uVoQaenZGD0R102CIZmROf1BKU
OsyuskdM0zeHiXtrqL5Io+qETXZ6Sl/m8wJBANEaly/2go4qh8K/4ImTonFUyVKx
DR18NJc65j5et4MDxTn85EM7tIhFJ3CLtLiUJwUufT6ctqtJ1DK3qvYq6AcCQQDA
l2qafybHCxfzZVgQtZvxeqz3NaUnAWs1rO6sw5920wuULDEt9qPa++Dh27AaUukq
LqtDfXJ8mLykhMcrJ+kjAkBcJZybslu09D2VaKALTQ5wQN3FfOUIySm9Lm0cEYKp
ZBHRJwAhSQ4ZxvvSUm1W02yfuZss1pN/BTp/P4HgACM8
-----END RSA PRIVATE KEY-----    
END_PRIVATEKEY;


$keys['publickey']=<<<END_PUBLICKEY
-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC4nuy9jz5Ur1EhRNhUzRIjLlQ/
D+dwu3Ih67eOTPVy/mZ2AxigqQrdb+a4wGa9lIDoG5TtNU4XjE1HG5NCGu+UURy5
i+40Hi7iwvXSVXyzCZVvN21DaTJZjZuJ4OR8LqWOj9VdvfROM7XbRxvAE9ZiDhOw
/lEPI/wfng+DaufRsQIDAQAB
-----END PUBLIC KEY-----
END_PUBLICKEY;

$crypton = new Crypton();

$password = 'a3a5bed30edc1edba6ec0cd273f5d834';
$newpassword = 'xyzzyABCDEFG';
//$crypton->store_keys($keys,'aretex_wp',$newpassword);

echo '<pre>';
$keys = $crypton->get_keys('aretex_wp',$password);
var_dump($keys);



//$crypton->change_password($newpassword,$password);


?>