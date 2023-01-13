<?php
/**
 * TOUT LE CODE CONTENU DANS LES BALISES <?php et ?>
 * SERA EXECUTÉ COTÉ SERVEUR
 * ET NE SERA PAS VISIBLE DANS LE NAVIGATEUR HTML
 */

session_start();

//une variable PHP de type tableau pour stocker les articles que l'on va récupérer dans la BDD
$articles = [];

try {

  // Connextion à la base de données SQLite
  $pdo = new \PDO('sqlite:' . realpath("./database.sqlite"));

  //Si le formulaire HTML d'ajout a été rempli
  if (isset($_POST['ajout_article'])) {
    $query = $pdo->prepare('INSERT INTO articles ("article_title", "article_content") VALUES (?,?)');
    $query->execute([$_POST['article_title'], $_POST['article_content']]);
  }

  //Récupération des données de la table articles
  $query = $pdo->prepare('SELECT * FROM articles');
  $query->execute();
  $articles = $query->fetchAll(PDO::FETCH_CLASS);
  // echo "<pre>".print_r($articles,true)."</pre>";die; //décommenter pour voir le condtenu du tableau articles

} catch (Exception $e) {
  print "Erreur base de données : " . $e->getMessage() . "<br/>";
  die();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PWS - TP1</title>

  <link rel="stylesheet" href="styles.css">

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

    <a href="?parametre1=valeur1&parametre2=valeur2&unAutre=uneVal">Lien avec paramètres</a>

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