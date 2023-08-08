<?php

namespace apaoww\oraclelogin;

use  cpsc304\web\Session;

/**
 * This is just an example.
 */
class OracleLogin extends \yii\base\Widget
{
    public $username;

    public $password;

    public $dsn;

    public function run()
    {
        $session = new Session;
        if (!@oci_connect($this->username, $this->password, $this->dsn ,"AL32UTF8")) {
            $e = oci_error();
            $session->set('oracle_error', $e['message']);
            return false;
        } else {
            return true;
        }


    }
}
