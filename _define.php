<?php
/**
 * Plugin description
 * 
 * PHP Version 5
 * 
 * @category Plugin
 * @package  BrowserID
 * @author   Pierre Rudloff <contact@rudloff.pro>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License
 * @link     http://rudloff.pro
 * */
if (!defined('DC_RC_PATH')) {
    return;
}
 
$this->registerModule(
    /* Name */            'BrowserID',
    /* Description */        'Login with BrowserID',
    /* Author */            'Pierre Rudloff',
    /* Version */            '0.1.1',
    /* Permissions */        'usage,contentadmin'
);
?>
