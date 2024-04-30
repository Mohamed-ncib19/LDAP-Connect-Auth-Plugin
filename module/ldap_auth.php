<?php

require_once __DIR__ . '/../config/ldap_config.php';

class LDAPAuthenticator {
    private $ldapConn;

    public function ldapConnect($ldapServer) {
        $this->ldapConn = @ldap_connect($ldapServer);
    
        if (!$this->ldapConn) {
            return false;
        }
    
        ldap_set_option($this->ldapConn, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($this->ldapConn, LDAP_OPT_REFERRALS, 0);
    
        $bind = @ldap_bind($this->ldapConn);
        if (!$bind) {
            ldap_close($this->ldapConn);
            return false;
        }
    
        return true;
    }
    
    
    
    public function ldapAuthenticate($username, $password) {
        if (!$this->ldapConn) {
            return false;
        }

        $userDn = "cn=".$username.",ou=users,ou=system";
        
        if (@ldap_bind($this->ldapConn, $userDn, $password)) {
            ldap_unbind($this->ldapConn);
            return true;
        } else {
            ldap_unbind($this->ldapConn);
            return false;
        }
    }
}

?>
