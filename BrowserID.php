<?php
/**
 * BrowserID class
 * 
 * PHP Version 5
 * 
 * @category Plugin
 * @package  BrowserID
 * @author   Pierre Rudloff <contact@rudloff.pro>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License
 * @link     http://rudloff.pro
 * */
 
 /**
 * Login with BrowserID
 * 
 * PHP Version 5
 * 
 * @category Plugin
 * @package  BrowserID
 * @author   Pierre Rudloff <contact@rudloff.pro>
 * @license  http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License
 * @link     http://rudloff.pro
 * @link     https://browserid.org/
 * */
class BrowserID extends dcUrlHandlers
{
    /**
     * Check if the user is valid
     * 
     * @param object $users    List of users
     * @param object $response Response from browserid.org
     * 
     * @return void
     * */
    static private function _login($users, $response)
    {
        global $core;
        if (rsExtPost::getAuthorEmail($users, false) == $response->email) {
            if ($core->auth->checkUser($users->__get("user_id"))) {
                $cookie_params=session_get_cookie_params();
                session_set_cookie_params(
                    $cookie_params["lifetime"],
                    dirname($_SERVER["PHP_SELF"])."/admin/"
                );
                /*if(function_exists('ini_set')) {
                    ini_set('session.cookie_path', $cookie_params[3]."admin/");
                }*/
                $core->session->start();
                $_SESSION['sess_user_id'] = $users->__get("user_id");
                $_SESSION['sess_browser_uid'] = http::browserUID(DC_MASTER_KEY);
                http::redirect('admin/index.php');
            } 
        }
    }
    
    /**
     * Display the login page
     * 
     * @param string $args URL parameters
     * 
     * @return void
     * */
    public static function display($args)
    {
        global $core;
        $_ctx =& $GLOBALS['_ctx'];
        $core->tpl->setPath(
            $core->tpl->getPath(),
            dirname(__FILE__)
        );
        if ($args == 'js') {
            self::serveDocument('login.js', 'application/javascript');
        } else if (substr($args, 0, 9)=="assertion") {
            $url = "https://browserid.org/verify";
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt(
                $curl, CURLOPT_POSTFIELDS, "assertion=".strval(
                    substr($args, 10)
                )."&audience=".$_SERVER["HTTP_HOST"]
            );
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $response=json_decode(strval(curl_exec($curl)));
            curl_close($curl);
            if ($response->status==="okay") {
                $users=$core->getUsers();
                while (!$users->isEnd()) { 
                    self::_login($users, $response);
                    $users->moveNext();
                }
                self::_login($users, $response);
            } 
        }
        
        self::serveDocument('browserid.html', 'text/html');
    }
}
?>
