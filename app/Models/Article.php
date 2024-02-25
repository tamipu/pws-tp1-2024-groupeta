<?php
class Article
{
  protected $pdo;

  function __construct()
  {
   try {

      $this->pdo = new \PDO('sqlite:' . DB_PATH);
      
    } catch (Exception $e) {
      print "Erreur de connexion à la base de données : " . $e->getMessage() . "<br/>";
      die();
    }
  }

  function list()
  {
   try {

      $query = $this->pdo->prepare('SELECT * FROM articles');
      $query->execute();
      return $query->fetchAll(PDO::FETCH_CLASS);
  
    } catch (Exception $e) {
      print "Erreur fonction list() dans le modèle Article : " . $e->getMessage() . "<br/>";
      die();
    }
  
  }

  function add($data)
  {
   try {
    
      if (isset($data['article_title']) && isset($data['article_content'])) {
        $query = $this->pdo->prepare('INSERT INTO articles ("article_title", "article_content") VALUES (?,?)');
        $query->execute([$data['article_title'], $data['article_content']]);
        return true;
      }
      return false;
  
    } catch (Exception $e) {
      print "Erreur fonction add($data) dans le modèle Article : " . $e->getMessage() . "<br/>";
      die();
    }
  
  }
}