<?php

require_once __DIR__ . '/config/ldap_config.php';
require_once __DIR__ . '/module/ldap.class.php';
require_once __DIR__ . '/api/controller/get_token.php';
require_once __DIR__ . '/api/controller/get_user.php';

function login_zentao($username,$password) {
    echo "Enter LDAP server: ";
    $ldapServer = ldapServer;

    echo "-----------------------\n";

    $ldapAuthenticator = new LDAP();

    echo "let's try to connect to: " . $ldapServer . "\n";

    if ($ldapAuthenticator->ldapConnect($ldapServer)) {
        echo "\n\nConnected\n\n";
        echo "----------------------\n";
        echo "check LDAP user: \n\n";

        echo "enter LDAP username: ";
        $username = trim(fgets(STDIN));

        echo "enter LDAP user password: ";
        $password = trim(fgets(STDIN));

        if ($ldapAuthenticator->ldapAuthenticate($username, $password)) {
            echo "LDAP authentication Done\n";
            global $AdminAcess;
            $token = getToken($AdminAcess);
            if ($token == null) {
                echo 'failed to get token';
                exit();
            } else {
                $res = checkUser($token, $username, $password);

                if (is_bool($res)) {
                        echo "User exists in Zentao\n";
                    
                } else {
                    echo "Error: " . $res['message'] . "\n";
                }
                
            }
        } else {
            echo "LDAP authentication failed.\n";
        }
    } else {
        echo "failed to connect to LDAP server.\n";
        exit();
    }
}


login_zentao($username,$password);
?>
