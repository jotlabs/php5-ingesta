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
