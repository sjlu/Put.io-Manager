<?php

/**
 * Copyright (C) 2012  Nicolas Oelgart
 *
 * @author Nicolas Oelgart
 * @license GPL 3 http://www.gnu.org/copyleft/gpl.html
 *
 * This class manages anything related to 'Account'.
 * For precise return values see put.io's documentation here:
 *
 * https://api.put.io/v2/docs/#account
 *
**/

namespace PutIO\Engines\PutIO;

use PutIO\Helpers\PutIO\PutIOHelper;

class AccountEngine extends PutIOHelper
{
    
    /**
     * Returns an array of information about your account.
     * False on error.
     *
     * @retun mixed
     *
    **/
    public function info()
    {
        return $this->get('account/info', array(), false, 'info');
    }
    
    
    /**
     * Returns an array containing your account settings.
     * False on error.
     *
     * @return mixed
     *
    **/
    public function settings()
    {
        return $this->get('account/settings', array(), false, 'settings');
    }
}

?>