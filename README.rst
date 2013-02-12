SDToolsBundle
=============

Project level tools for speed development

For install sh tools - add to you composer.json (if not exist):

.. code-block:: json

    "config": {
        "bin-dir": "bin"
    },

For install dev version:

.. code-block:: json

    "minimum-stability": "dev",


Commands
++++++++

sdt:prepare - prepare tools for work on project (clone skeleton for generate crud in app folder, create app/assets.yml file)

sdt:assets:clone - clone site level assets (for example jquery) to web path

sdt:generate:crud - generate crud, based on site template

For remove Acme/DemoBundle - run from console: ./bin/removeAcme.sh