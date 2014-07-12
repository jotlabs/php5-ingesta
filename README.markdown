Ingesta
=======

A service that ingests external data, processes it, and exports it.


Currently supports:

* [Wordpress XML-RPC API](http://codex.wordpress.org/XML-RPC_WordPress_API) -- wp.getPosts, wp.getPost, wp.getUsers
* [Instagram API](http://instagram.com/developer/) -- `/tags/[tag-name]/media/recent`


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

### Wordpress recipe

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
            "filter": [
                "updatedSinceLastCheck",
                "isPublished"
            ],
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

Save this to `share/recipes/example-wordpress.json` and run it with the following:

    bin/ingesta --recipe=example-wordpress

This will connect to your Wordpress instance's XML-RPC api endpoint to retrieve recent posts, and outputs a simple JSON document to `/tmp/wp-updated-posts.json` containing just the posts that have updated since the last run.


### Instagram recipe

An example recipe, for getting tagged images from Instagram looks like this:

    {
        "input": {
            "type":     "instagram",
            "method":   "getTagRecent",
            "clientId": "[YOUR_INSTAGRAM_API_KEY]",
            "tag":      "{tag}"
        },
        "processing": {
            "filter": "updatedSinceLastCheck",
            "format": [
                "SimpleBlogFormat"
            ]
        },
        "output": {
            "type": "JsonFileWriter",
            "file": "/tmp/instagram-{tag}.json"
        }
    }

After putting in your Instagram key and saving the file to `share/recipes/instagram-by-tag.json`, and running it with:

    bin/ingesta --recipe=instagram-by-tag --tag=mattdamon

This will connect to Instagram's API and grab all media posts tagged with `mattdamon`, and outputs a simple JSON document to `/tmp/instagram-mattdamon.json`.


