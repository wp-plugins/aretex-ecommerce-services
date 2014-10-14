<?php
/**
 * Testing the signature verification.
 * */
require_once('Crypt/RSA.php');

$public_key = <<<END_PUB
-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAt+7sDHPFcB+K75yn5Fsl
L5Waost7eBG95v6D51dvw82Zkq4jQhf7Xjgo4+wE0tUBdiaYQHBm0h5GN+g5Ekoh
8L7CAnLV67zGUbvsXop035A6u9UCTE+NIV+n7t1bM+3Rsdyr2KZevTBhoWgOZr15
pyCfSpNI5Bo1hgW0mAihnB7TySx4Vv8yJHn2qJchaeO83LaQ8U8ytkSARgA4S7FH
S147OfvtXvc75rTnZrQ5zW2l9UDxwsg+3S79db3YHgYskId7beuOE5+Fyr68TDV1
6lYdUDq597hBa1Wq7qy+kR7B/+MGdOT3dZ3IGH37cgQF0EjCC6X6uEyaXPxz036P
iwIDAQAB
-----END PUBLIC KEY-----
END_PUB;


$private_key = <<<END_PRI
-----BEGIN RSA PRIVATE KEY-----
MIIEogIBAAKCAQEAt+7sDHPFcB+K75yn5FslL5Waost7eBG95v6D51dvw82Zkq4j
Qhf7Xjgo4+wE0tUBdiaYQHBm0h5GN+g5Ekoh8L7CAnLV67zGUbvsXop035A6u9UC
TE+NIV+n7t1bM+3Rsdyr2KZevTBhoWgOZr15pyCfSpNI5Bo1hgW0mAihnB7TySx4
Vv8yJHn2qJchaeO83LaQ8U8ytkSARgA4S7FHS147OfvtXvc75rTnZrQ5zW2l9UDx
wsg+3S79db3YHgYskId7beuOE5+Fyr68TDV16lYdUDq597hBa1Wq7qy+kR7B/+MG
dOT3dZ3IGH37cgQF0EjCC6X6uEyaXPxz036PiwIDAQABAoIBADwBEbiuPAbsA2NP
8+WnZmYzpBLf1xPAlfc5qMZb2/ZAqI0ViiMRt8tw/sX8RUaSfruQs7Kx+JkrjzTF
6Xhx/siPMrOhyu/w0bHwYJgnCyGz57VHNEy41w3AKwTd6dbzCqm/l8BB5j5J/k+t
pqUVww4mslCd4/WmJzflvJismCxZw/T0kcATTNMz+ZcUAhGtVhCJbamGgYqzWhfC
Cg/B8fBq+L6WYa+tm4KmLqfYeVr4f1GYjXEumEkj6+RLSdCLsa+10y+z7GmxCyA3
ZVnxaHvNHmz/O8dpxIq7Z6OoiyQi2ondhmj0hVnb45Y55tc1tq74iP3N6HGlfjr6
BAqmS8ECgYEA7yveyjcwjKeJNK55+49AGKM7ejTNnaeosKilZyudnxcadUMoEIaq
UgUKDM3dp8uM3c02H40Pm+/1rm5Kxdd16Xij0ovKTH0QcunKJw+IEhTpY+MTbUl+
aV+VURTJcxV5aBto0asgvhUSbqB2IJHgOlb0siF+K8YNlFZQOf6fbvkCgYEAxOAQ
JnosRVUVAUIIigfcBGxyiYF/S2E3mswAzMsQC2ovEZJzHGzU/mCqT7l3GcwFiblP
Xue/Uv4g3qoQSULnya+gklqxXx7BZt8zc1vreyTpXnKwgpQzSGbxzGE8005D5nTV
NC8HogwvnOFJXOXVLRODMQe4VEq7voNLDujQ36MCgYAqrCwi7jfmUJoFYT/4ZzWr
b6xUAInTIC/T3TMttjV4Rhn9ZA8I684Ftkp1wGFU59dpV4zZkkR/sQ+noJwMsoWi
M1kfXruobAP8TMQ5tea0OzDtFn3H2P4J9PjiL5BFzUYNEh7gkeTUpVPVkyGgbAaS
wiMEiT9Gth6EIeZMgqaVmQKBgGF7GEQVBkqmICppSdUeoyBFmkjfp+npDyFElbjR
avZb80ZeH0UZ1jTGJE4pZQGO9ccFzHkPgrpTPm9CAaJk0GQa5ATThzO0BMstBUq/
Xs+wrSSo4SEmxGW7I0qxcu6luBUqEE8wYjUol4K0QiEPZAhXuwPR8ME7584jME0H
ljTFAoGAYlnL1QRVqWj15CTkP6e4XNGrtJ5yrzu1tDL37oVDLIgG7P6fsX0dezxt
arCNVuZJWwQILjpEdg32bheu/gcYTHg2xs/eFhSHlmgjVrCLSVHqOC7SnI8OhduP
3CKAvTjy8ZLPdYCnfxA4+cuLf2Js1fqKDJEnxJnqEOWalVanjXI=
-----END RSA PRIVATE KEY-----
END_PRI;


$message = "It was a dark and stormy night";
$fake_msg = "It was a bright and sunny day";


    
$rsa = new Crypt_RSA();
if (! $rsa->loadKey($private_key))
{
    echo "Failed to Load Private Key";
    exit();
}  

$signature  =  $rsa->sign($message);
echo "<br/><hr/>";
echo base64_encode($signature);
echo "<br/><hr/>";
if (! $rsa->loadKey($public_key))
{
    echo "Failed to Load Public Key";
    exit();
}  
if ($rsa->verify($message,$signature))
{
    echo "$message: Valid";
}
else
{
    echo "$fake_msg: Invalid";   
}

echo "<br/><hr/>";
if ($rsa->verify($fake_msg,$signature))
{
    echo "$message: Valid";
}
else
{
    echo "$fake_msg: Invalid";   
}



?>



