<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Zend\XmlRpc\Client;
use Ingesta\Services\Wordpress\Wrappers\Post;

$wpBlog = array(
    'blogId'   => 1,
    'siteUrl'  => 'http://[YOUR_SUBDOMAIN].wordpress.com/',
    'username' => '[YOUR_WORDPRESS_USERNAME]',
    'password' => '[YOUR_WORDPRESS_PASSWORD]'
);


$endpoint = "{$wpBlog['siteUrl']}xmlrpc.php";
$client   = new Client($endpoint);


/*

    1. Test a simple echo XML-RPC endpoint

*/


$result   = $client->call('demo.sayHello');

echo "XmlRpc response: ";
print_r($result);
echo "\n----\n";



/*

    2. Test getting a list of recent posts

*/

$params = array(
    $wpBlog['blogId'],
    $wpBlog['username'],
    $wpBlog['password']
);


$result = $client->call('wp.getPosts', $params);
echo "XmlRpc response from wp.getPosts: \n";

$recentPostId = null;

foreach ($result as $post) {
    $padPostId = str_pad($post['post_id'], 3, ' ', STR_PAD_LEFT);
    echo "* ({$padPostId}) {$post['post_modified']}: {$post['post_title']}\n";

    if (!$recentPostId) {
        $recentPostId = $post['post_id'];
    }
}

echo "----\n";



/*

    3. Test get the most recent post

*/


$params = array(
    $wpBlog['blogId'],
    $wpBlog['username'],
    $wpBlog['password'],
    $recentPostId
);

$result = $client->call('wp.getPost', $params);
echo "XmlRpc response: ";
print_r($result);
echo "\n---- Completed.\n";
