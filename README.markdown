Ingesta
=======

A service that ingests external data, processes it, and exports it.


Currently supports:

* [Wordpress XML-RPC API](http://codex.wordpress.org/XML-RPC_WordPress_API)


Usage
-----

    bin/ingesta --recipe=example-wordpress

Runs the `example-wordpress` recipe (which is defined in `share/recipes/example-wordpress.json` directory).

The structure of a recipe is the straight-forward Input -> Processing -> Output model:

* **Input** defines where the data comes from
* **Processing** describes how the input data is to be processed
* **Export** defines how the processed data is stored/persisted/sent.


Recipes
-------

A recipe describes the process for ingesting data, describing how the input is collected, how it is to be processed, and defines a mechanism to output the resulting data.

An example recipe, for gathering updates from a Wordpress blog looks like this:

    {
        "input": {
            "type": "wordpress",
            "url": "http://[YOUR_SUBDOMAIN].wordpress.com/xmlrpc.php",
            "username": "[YOUR_WORDPRESS_USERNAME]",
            "password": "[YOUR_WORDPRESS_PASSWORD]",
            "method": "wp.getPosts"
        },
        "processing": {
            "filter": "updatedSinceLastCheck",
            "format": [
                "WordpressContentFormat"
                "SimpleBlogFormat"
            ]
        },
        "output": {
            "type": "JsonFileWriter",
            "file": "/tmp/wp-updated-posts.json"
        }
    }

Save this as `example-wordpress.json` in `share\recipes\`, and run it with the following:

    bin/ingesta --recipe=example-wordpress

This will connect to your Wordpress instance's XML-RPC api endpoint to retrieve recent posts, and outputs a simple JSON document to `/tmp/wp-updated-posts.json` containing just the posts that have updated since the last run.


