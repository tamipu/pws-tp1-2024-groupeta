<?php

/**
 * TOUT LE CODE CONTENU DANS LES BALISES <?php et ?>
 * SERA EXECUTÉ COTÉ SERVEUR
 * ET NE SERA PAS VISIBLE DANS LE NAVIGATEUR HTML
 */

session_start(); //inititialise la session. Permet de créer un lien avec chaque visiteur et de stocker des informations dans $_SESSION

//Variables

//Une constante pour spécifier l'url du site
//utilisée pour les liens hypertextes, les feuilles de style, les fichiers Javascript, les images, etc.
define('BASE_URL', '/'); //à utiliser si vous utilisez la commande "php -S localhost:2023" pour accéder au projet
// define('BASE_URL','/PWS-TP1/'); //à utiliser si vous utiliser une stack WAMP/LAMP/MAMP et que vous accédez au projet avec une url du type http://localhost/PWS-TP1/

//une variable PHP de type tableau pour stocker les articles que l'on va récupérer dans la BDD
$articles = [];

//Base de données
try {

  // Connextion à la base de données SQLite
  $pdo = new \PDO('sqlite:' . realpath("./database.sqlite"));

  //Si le formulaire HTML d'ajout d'article a été rempli
  if (isset($_POST['ajout_article'])) {
    $query = $pdo->prepare('INSERT INTO articles ("article_title", "article_content") VALUES (?,?)'); //préparation d'une requête SQL d'insertion d'un article
    $query->execute([$_POST['article_title'], $_POST['article_content']]); //execution de la requête en injectant les valeurs à la place des ? ci-dessus
  }

  //Récupération des données de la table articles
  $query = $pdo->prepare('SELECT * FROM articles');
  $query->execute();
  $articles = $query->fetchAll(PDO::FETCH_CLASS);
  // echo "<pre>".print_r($articles,true)."</pre>";die; //décommenter pour voir le condtenu du tableau articles

} catch (Exception $e) { //le bloc try / catch permet de capturer les erreurs
  print "Erreur base de données : " . $e->getMessage() . "<br/>";
  die();
}

// Session

//Si le paramètre ajoutSession est présent dans l'URL, on ajoute une valeur aléatoire dans la session
//Ces valeurs seront conservées pour l'utilisateur tant que la session sera valide ou non détruite
if (isset($_GET['ajoutSession'])) {
  $_SESSION['variables_session'][] = rand();
}
//Si le paramètre detruireSession est présent dans l'URL, on détruit la session et on en initialise une nouvelle
if (isset($_GET['detruireSession'])) {
  session_destroy();
  session_start();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PWS - TP1</title>

  <link rel="stylesheet" href="<?= BASE_URL ?>styles.css">

</head>

<body>

  <header>
    <h1>Programmation Web Serveur - TP1 - Introduction au PHP</h1>
  </header>

  <section class="articles">
    <h2>Liste des articles</h2>
    <?php foreach ($articles as $article) { ?>
      <article>
        <h3><?= $article->article_title ?></h3>
        <p><?= $article->article_content ?></p>
        <small><?= $article->article_date ?></small>
      </article>
    <?php } ?>
  </section>

  <aside>

    <h2>Ajout d'un article</h2>

    <p>Les données du formulaire seront envoyées vers le serveur en méthode HTTP "post" et seront disponibles côté serveur dans la variable PHP $_POST</p>

    <form action="" method="post">
      <label for="article_title">Titre : </label>
      <input type="text" name="article_title">
      <label for="article_content">Contenu : </label>
      <textarea name="article_content"></textarea>
      <input type="submit" value="Ajouter" name="ajout_article">
    </form>


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

  <footer>
    <h2>Informations PHP : </h2>
    Contenu de la variable PHP $_GET : <br>
    <pre><?= print_r($_GET, true) ?></pre>
    Contenu de la variable PHP $_POST : <br>
    <pre><?= print_r($_POST, true) ?></pre>
    Contenu de la variable PHP $_SESSION : <br>
    <pre><?= print_r($_SESSION, true) ?></pre>
  </footer>

</body>

</html>