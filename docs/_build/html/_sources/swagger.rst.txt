Installation et utilisation de `Swagger <https://swagger.io/>`_
===============================================================

Swagger est un outil de documentation automatique d'API. Dans notre cas, nous l'utiliserons pour les routes d'une application Python-Flask.

Mise en place de Swagger-UI
---------------------------

Assumant que vous avez déjà flask, installez flask_swagger :

.. code-block:: bash

   $ pip install flask_swagger

Prenons un projet flask basique dont la structure est la suivante :

::

    project
    ├── static          
    │   ├── css
    │   │   └── style.css
    │   └── js
    │       └── script.css
    ├── template          
    │   ├── layout
    │   │   └── layout.html
    │   └── index.html
    └── app.py

Notre fichier ``app.py`` contient une application très basique :

.. code-block:: python

    from flask import Flask, jsonify
    app = Flask(__name__)


    @app.route('/')
    def hello():
        return "Hello World!"


    @app.route('/user')
    def hello_name(name):
        data = {
            'fistname': 'John',
            'lastname': 'Doe',
            'addresses': [
                {
                    'town': "Geneva"
                }
            ]
        }
        return jsonify(data)

    if __name__ == '__main__':
        app.run()

Pour implémenter flask_swagger, il faut importer le paquet.

.. code-block:: python

    from flask import Flask, jsonify
    from flask_swagger import swagger

Il est maintenant nécessaire de créer une route retournant les informations dont swagger à besoin.
Pour ce faire, voici la route à ajouter (le nom de la route n'est pas imposé) :

.. code-block:: python

    @app.route("/specs")
    def spec():
        swag = swagger(app)
        swag['info']['version'] = "1.0"
        swag['info']['title'] = "Préparation au TPI"
        return jsonify(swag)

Une fois cela fait, il nous faut une page permettant d'afficher la documentation. Dans notre cas, ce sera ``endpoints.html``.
Il nous faut ajouter cette page au dossier ``template``.
Voici la structure du dossier après l'ajout :

::

    project
    └── template
        ├── layout
        │   └── layout.html
        └── index.html

La page ``endpoints.html`` est un template se trouvant sur `ici <https://github.com/swagger-api/swagger-ui/blob/master/dist/index.html>`_.
En plus de la page, il nous faut rajouter quelque fichiers ``javascript`` dans le dossier ``projet/static/js/``. Les voici : 

- `swagger-ui-bundle.js <https://github.com/swagger-api/swagger-ui/blob/master/dist/swagger-ui-bundle.js>`_
- `swagger-ui-standalone-preset.js <https://github.com/swagger-api/swagger-ui/blob/master/dist/swagger-ui-standalone-preset.js.map>`_

Voici la structure du dossier après l'ajout :

::

    project
    └── static
        └── js
            ├── swagger-ui-bundle.js
            ├── swagger-ui-standalone-preset.js
            └── script.css

Enfin, la dernière chose à faire est de modifier l'url de récupération de la documentation de swagger.
Il suffit de se rendre dans la page ``endpoints.html`` et de modifier la valeur de la clef ``url`` de l'objet passé en paramètre à ``SwaggerUIBundle``.
Voici à quoi devrait ressembler l'objet ``SwaggerUIBundle`` après modifications :

.. code-block:: javascript

    // Begin Swagger UI call region
    const ui = SwaggerUIBundle({
        url: "/specs",
        dom_id: '#swagger-ui',
        deepLinking: true,
        presets: [
            SwaggerUIBundle.presets.apis,
            SwaggerUIStandalonePreset
        ],
        plugins: [
            SwaggerUIBundle.plugins.DownloadUrl
        ],
        layout: "StandaloneLayout"
    });
    // End Swagger UI call region

Votre page de documentation d'API est maintenant configurée et fonctionnelle. Il ne reste plus qu'à documenter les routes !

Docstring des routes
--------------------

Prenons la route ``/user``, présente dans le fichier ``app.py``.

.. code-block:: python

    @app.route('/user')
    def hello_name(name):
        data = {
            'fistname': 'John',
            'lastname': 'Doe',
            'addresses': [
                {
                    'town': "Geneva"
                }
            ]
        }
        return jsonify(data)

Une docstring possible à mettre est la suivante :

.. important:: Cette façon est très bien pour les route retournant simplement quelque valeure et non pas des objets. Il est préférable d'utiliser la méthode suivante si des object sont envoyés

.. code-block:: python

    @app.route('/user')
    def hello_name(name):
        """
        Donne un utilisateur
        ---
        tags:
          - user
        responses:
          200:
            description: Donne un utilisateur
            schema:
              id: User
              properties:
                firstname:
                  type: string
                lastname:
                  type: string
                subitems:
                  type: array
                  items:
                    schema:
                      id: Address
                      properties:
                          town:
                            type: string
        """
        data = {
            'fistname': 'John',
            'lastname': 'Doe',
            'addresses': [
                {
                    'town': "Geneva"
                }
            ]
        }
        return jsonify(data)

Une autre possibilité d'ecrire ceci, c'est avec des références de fichier.

.. code-block:: python

    @app.route('/user')
    def hello_name(name):
        """
        Donne un utilisateur
        ---
        tags:
          - user
        responses:
          200:
            description: Donne un utilisateur
            schema:
              id: User
              $ref: '/static/swagger-components/User.yml#/User'
        """
        data = {
            'fistname': 'John',
            'lastname': 'Doe',
            'addresses': [
                {
                    'town': "Geneva"
                }
            ]
        }
        return jsonify(data)

Le contenu des fichier mis par référence est le suivant :

- Pour ``/static/swagger-components/User.yml`` :

.. code-block:: yaml

   User:
     type: object
     properties:
       firstname:
         type: string
       lastname:
         type: string
       subitems:
         type: array
         items:
           $ref: '/static/swagger-components/Address.yml#/Address'

- Pour ``/static/swagger-components/Address.yml`` :

.. code-block:: yaml

   Address:
     type: object
     properties:
     town:
       type: string

Les fichiers de références se trouvent dans le dossier ``static`` et dans le sous-dossier ``swagger-components``, dont voici la structure :

::

    project
    └── static
        └── swagger-components
            ├── User.yml
            └── Address.yml
