<?php
require_once 'app/Models/Article.php';

class Home
{
  function index()
  {
    $article_model = new Article();

    $articles = $article_model->list();
    require "resources/views/template.php";
  }

  function add()
  {
    if(isset($_POST['ajout_article'])) {
      $article_model = new Article();
      $article_model->add($_POST);
    }

    $articles = $article_model->list();
    require "resources/views/template.php";
  }

}