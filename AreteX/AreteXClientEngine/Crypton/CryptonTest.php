<? 

include 'Crypton.php';

$message =<<<END_MSG
Dreamcatcher. Scorpion power girl deacon frost hit-girl x-man offspring green arrow?

Captain universe; angel montana tempest nova franklin "foggy" nelson! Augustus "gus" beezer 
boom boom black knight john stacy micah sanders. Sunspot geldoff hancock crimson dynamo, titanium 
man the ultimate enemy black cat threshold stargirl nova asp, inertia, ultragirl, thanos.

Bishop boomerang dolores betty brant sobek mister fantastic dazzler sunspot carol 
danvers brother voodoo magog lilandra neramani captain planet phoebe mcallister nathaniel richards. 
Medusa doctor spectrum kraven the hunter, thing mr incredible, omniscient. Robbie robertson lockjaw 
sentry matt parkman hard-drive invisible woman monica dawson sabretooth guardian kang the 
conqueror toad light lass. Proteus whizzer frigga fountain captain spain corsair. 
Lieberman firestar saluki agent 13 lady lark hawkwoman maverick arnim zola. Nightwing amphibian vertigo 
elektra plastic man primal screamer, she-hulk johann krauss. Diablo boomerang wong stardust, 
venom franklin "foggy" nelson fountain! Quill sobek alex woolsly polaris captain epic elastigirl toad!

Hawk-owl sasquatch cannonball bling! sabra owl magda fury prowler cannonball gorgon malachi 
"the jellyfish" kelly. Iron fist, apocalypse elongated man daredevil lightning lad, light lass, 
"guy gardner karen grant green arrow, echo." Samual sterns northstar ymir moira mactaggert, pete wisdom, 
phoebe mcallister, punisher vagabond juggernaut; beetle phantom girl. Nina theroux chuck norris jimmy hudson. 
Fred "flash" thompson peter petrelli sabretooth agent 13 stacy x binary micah sanders? Falcon--boom boom 
vampire x mark raxton penultimate jai "the malachi destroyer" amin thunderstrike black canary sasquatch 
captain britain. Spider-man husk captain america james braddock ben reilly thaddeus e. "thunderbolt" 
ross blur adrian toomes geldoff. Dai thomas, "power girl," wondra hawkeye bulldozer enchantress binary 
vykni dash.
END_MSG;

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


$crypt = new Crypton();

$encrypted = $crypt->encrypt_message($message,$private_key);
$deccrypted = $crypt->decrypt_message($encrypted,$public_key);

echo "<pre>$message<hr/>\n$encrypted\n<hr/>\n$deccrypted";



?>