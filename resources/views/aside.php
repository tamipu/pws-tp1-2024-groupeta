<aside>

<h2>Ajout d'un article</h2>

<p>Les données du formulaire seront envoyées vers le serveur en méthode HTTP "post" et seront disponibles côté serveur dans la variable PHP $_POST</p>

<?php require 'resources/views/articles/form.php'; ?>



<h2>Lien avec des paramètres</h2>

<p>Par défaut, les liens utilisent la méthode HTTP "get". Le lien ci-dessous contient des paramètres. Les paramètres des URL se situent après le caractère ? et sont sous la forme nomParam=ValeurParam et lié avec le caractère &. Ces paramètres seront disponibles côté serveur dans la variable PHP $_GET</p>

<a href="<?= BASE_URL ?>?parametre1=valeur1&parametre2=valeur2&unAutre=uneVal">Lien avec paramètres</a>

<h2>Ajout de variables de session</h2>

<p>Lien qui déclenchera l'ajout de variable de session, stockées dans $_SESSION </p>

<ul>
  <li><a href="<?= BASE_URL ?>?ajoutSession=true">Ajouter une variable de session</a></li>
  <li><a href="<?= BASE_URL ?>?detruireSession=true">Détruire la session</a></li>
  <li><a href="<?= BASE_URL ?>">Lien sans paramètres</a></li>
</ul>


</aside>