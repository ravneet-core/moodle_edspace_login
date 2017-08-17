<?php
/**
 * Add custom menu item in site navigation
 * to log into the edSpace
 * @param object $navigation global_navigation
 * @return boolean
 */
function local_edspace_login_extend_navigation(global_navigation $navigation)
{
    global $PAGE, $USER;

    $userId = edspace_encrypt($USER->id, 'e');

    $url = 'http://communityofpractice.app/moodle/auth/' . $userId;
    
    $masterNode = $PAGE->navigation->add(
        'Log into edSpace',
        $url. '" target="_blank',
        navigation_node::TYPE_CONTAINER
    );
    
    $masterNode->title('Log in edSpace');

    return true;
}

/**
 * encrypt the moodle user id
 * @param  string $string
 * @return string
 */
function edspace_encrypt($str)
{
    $secretKey = 'core';
    $secretIV = 'education';
 
    $output = false;
    $encryptMethod = "AES-256-CBC";
    $key = hash('sha256', $secretKey);
    $iv = substr(hash('sha256', $secretIV), 0, 16);
 
    $output = base64_encode(openssl_encrypt($str, $encryptMethod, $key, 0, $iv));
 
    return $output;
}
