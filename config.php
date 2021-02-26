<?php 
/* 
 * Database and API Configuration 
 */ 
 
// Database configuration 
define('DB_HOST', 'localhost'); 
define('DB_USERNAME', 'root'); 
define('DB_PASSWORD', ''); 
define('DB_NAME', 'facebook_app'); 
define('DB_USER_TBL', 'users'); 
define('DB_POST_TBL', 'user_posts'); 
 
// Facebook API configuration 
define('FB_APP_ID', '832575460820824'); // Replace {app-id} with your app id 
define('FB_APP_SECRET', 'c3a7514de037db58c1a0bcdbf5f20a76'); // Replace {app-secret} with your app secret 
define('FB_REDIRECT_URL', 'http://localhost/facebook/');  
define('FB_POST_LIMIT', '10'); 
 
// Start session 
if(!session_id()){ 
    session_start(); 
} 
 
// Include the autoloader provided in the SDK 
require_once __DIR__ . '/Facebook/autoload.php'; 
 
// Include required libraries 
use Facebook\Facebook; 
use Facebook\Exceptions\FacebookResponseException; 
use Facebook\Exceptions\FacebookSDKException; 
 
// Call Facebook API 
$fb = new Facebook(array( 
    'app_id' => FB_APP_ID, 
    'app_secret' => FB_APP_SECRET, 
    'default_graph_version' => 'v3.2', 
)); 
 
// Get redirect login helper 
$helper = $fb->getRedirectLoginHelper(); 
 
// Try to get access token 
try { 
    if(isset($_SESSION['facebook_access_token'])){ 
        $accessToken = $_SESSION['facebook_access_token']; 
    }else{ 
          $accessToken = $helper->getAccessToken(); 
    } 
} catch(FacebookResponseException $e) { 
     echo 'Graph returned an error: ' . $e->getMessage(); 
      exit; 
} catch(FacebookSDKException $e) { 
    echo 'Facebook SDK returned an error: ' . $e->getMessage(); 
      exit; 
}