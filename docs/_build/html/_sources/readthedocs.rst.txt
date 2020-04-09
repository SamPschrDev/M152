Installation et utilisation de `readthedocs <http://readthedocs.org>`_
======================================================================

.. note:: Ayant testé que sur linux, je donne la marche a suivre pour linux (ou WSL)

Quick start
-----------

Assumant que vous avez déjà Python d'installé, installez sphinx :

.. code-block:: bash

   $ pip install python3-sphinx

Créer un dossier dans votre projet pour contenir la documentation :

.. code-block:: bash

   $ cd /chemin/du/projet
   $ mkdir docs

Lancé la commande ``sphinx-quickstart`` ici :

.. code-block:: bash

   $ cd docs
   $ sphinx-quickstart

.. warning:: Si la commande n'est pas trouvée, c'est qu'elle n'est pas dans le ``path``. Pour contourner ce soucis, vous pouvez trouver l'endroit dans lequel le script c'est installer et lancé directement le chemin absolue. En général, si le script n'est pas dans le path, il est dans ``~/.local/bin/``. Faites alors :

  .. code-block:: bash

     $ cd docs
     $ ~/.local/bin/sphinx-quickstart

Cette commande est un wizard qui va vous aider à faire une configuration basique de la documentation; dans la plupart des 
cas vous avez juste à accepter les options par défaut. Quand tout est terminer, vous aurez un fichier ``index.rst``, ``conf.py`` et pleins d'autres fichiers.

Une fois que les fichiers on été généré dans le dossier docs, ouvrez le fichier Makefile et regarder pour la ligne 6 où 
la constante ``SPHINXBUILD`` est déclarée. Si besoin, il faudra modifier sa valeur avec le chemin absolu de la commande ``sphinx-build`` se trouvant 
au même endroit que la commande ``sphinx-quickstart``.

Maintenant, pour générer la documentation, lancé la commande :

.. code-block:: bash

   $ make html

Le fichier ``index.rst`` à été générer dans ``index.html`` dans le fichier de sortie de la documentation (généralement ``_build/html/index.html``). 
Ouvrez ce fichier dans votre navigateur pour voir votre doc.

Changement de thème
-------------------

Si vous souhaitez changer de thème pour votre documentation, je vous propose celui de readthedocs. Voici comment l'installer.

Premièrement, il vous faut install le paquet python suivant :

.. code-block:: bash

   $ pip install sphinx_rtd_theme
   
Une fois fait, il suffit de rajouter l'import dans le fichier ``conf.py`` :

.. code-block:: python

   import sphinx_rtd_theme

Et enfin, rajouter l'extension ``sphinx_rtd_theme`` dans le tableau ``extensions`` du fichier ``conf.py`` et modifier la valeur de la variable ``html_theme`` pour ``sphinx_rtd_theme``.

Mise en ligne de la documentation
---------------------------------

Le site utiliser pour mettre en ligne la documentation est `<http://readthedocs.org>`_. Ce site permet de se connecter via votre compte GitHub et ainsi 
avoir accès et tous vos repositories. 
De ce fait, il est possible d'importer des projets directement dans readthedocs et ainsi héberger la documentation.
Pour mettre à jour documentation, il vous faut aller dans l'onglet ``Aperçu`` de votre projet. Cliquer sur le bouton ``Complier une version`` et le tour est joué.
Enfin, pour consulter ce qui à été compiler, il suffit de cliquer sur le bouton vert ``Afficher les Docs``.