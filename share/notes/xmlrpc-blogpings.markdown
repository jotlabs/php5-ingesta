

Wordpress pings for both  publish and updates.

Request:

    192.3.88.66 - - [12/Apr/2014:11:32:29 +0100] "POST /ping/ HTTP/1.0" 200 818 "-" "The Incutio XML-RPC PHP Library -- WordPress/3.8.2"

Entity body:

    <?xml version="1.0"?>
    <methodCall>
    <methodName>weblogUpdates.extendedPing</methodName>
    <params>
    <param><value><string>Geek Declutter</string></value></param>
    <param><value><string>http://geekdeclutter.com/</string></value></param>
    <param><value><string>http://geekdeclutter.com/feed/</string></value></param>
    </params></methodCall>

