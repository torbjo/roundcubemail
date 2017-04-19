<?php

// TODO:
// * option to customize NOLOGIN_FILE
// * option to customize message
// * option to get message from NOLOGIN_FILE?
// * also force logout for already loged in users?

//define ('NOLOGIN_FILE', RCUBE_INSTALL_PATH . 'nologin');
define ('NOLOGIN_FILE', RCUBE_INSTALL_PATH . '../nologin');

class nologin extends rcube_plugin
{
    public $noframe = true;
    public $noajax  = true;

    private $nologin = false;

    function init()
    {
        //rcube::write_log ('torkel', 'init()');
        $this->add_hook ('authenticate', array($this, 'hook_authenticate'));
        // Q: only add hook if nologin is true?
        // Q: is init() always called before hook_authenticate?
        $this->nologin = file_exists (NOLOGIN_FILE);
    }

    //function hook_authenticate ($host, $user, $pass, $cookiecheck, $valid)
    function hook_authenticate ($args)
    {
        //rcube::write_log ('torkel', 'hook_authenticate()');
        if ($this->nologin) {
            $args['abort'] = true;
            $args['error'] = 'Server maintenance in progress; login is temporarily disabled!';
        }

        return $args;
    }
}

?>
