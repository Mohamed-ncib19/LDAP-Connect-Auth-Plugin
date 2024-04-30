<?php

require_once __DIR__ . '/config/ldap_config.php';
require_once __DIR__ . '/module/ldap_auth.php';

echo "enter ldap server: ";
$ldapServer = trim(fgets(STDIN));



echo "-----------------------\n";

$ldapAuthenticator = new LDAPAuthenticator();



echo "lets try to connect to  : ". $ldapServer."\n";
if ($ldapAuthenticator->ldapConnect($ldapServer)) {


echo "\n\nconnected\n\n";



echo "----------------------\n";
echo "check ldap user : \n";


echo "enter ldap username : ";
$username = trim(fgets(STDIN));

echo "enter ldap user password : ";
$password = trim(fgets(STDIN));

  if ($ldapAuthenticator->ldapAuthenticate($username, $password)) {
        echo "user authenticated successfully\n";
    } else {
        echo "user authentication failed.\n";
    }
} else {
    echo "failed to connect to LDAP server.\n";
    exit();
}

?>
