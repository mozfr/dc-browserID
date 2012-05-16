<?php
/**
 * Plugin initialisation
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

global $__autoload;
$__autoload['BrowserID'] = dirname(__FILE__).'/BrowserID.php';
        
$core->url->register(
    'browserid', 'browserid', '^browserid(?:/(.+))?$',
    array('BrowserID','display')
);


 
