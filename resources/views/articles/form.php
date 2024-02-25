<form action="<?= BASE_URL ?>articles/add" method="post">
  <label for="article_title">Titre : </label>
  <input type="text" name="article_title">
  <label for="article_content">Contenu : </label>
  <textarea name="article_content"></textarea>
  <input type="submit" value="Ajouter" name="ajout_article">
</form>