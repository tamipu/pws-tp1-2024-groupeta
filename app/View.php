<?php

class View
{
  protected $template; //nom du fichier template de la view, par défaut ce sera template.php
  protected $sections; //tableau contenant les noms et noms de fichier des sections HTML/PHP à afficher dans la template
  protected $data; //tableau de variables à remplir par le controller

  function __construct($data = [], $sections = [], $template = 'template', $render = true)
  {
    $this->data = $data;
    $this->sections = $sections;
    $this->template = $template;
    if ($render) $this->render();
  }

  /** 
   * Affiche l'ensemble du contenu de ta page Web en utilisant la template que tu as spécifiée défini par $this->template
   */
  function render()
  {
    echo $this->renderOutput($this->template);//La classe View utilise la fonction renderOutput pour montrer le contenu de la template.
  }

  /**
   * "Montre-moi chacune de ces sections spéciales que j'ai ajoutées à ma page !"  
   */
  function renderSections()
  {
    foreach ($this->sections as $section_name => $section_content) //Cela dit à la classe View de prendre chaque section spéciale que tu as ajoutée et de les examiner une par une.
    {
      echo $this->renderSection($section_name);//Pour chaque section, la classe View appelle la fonction renderSection pour l'afficher.
    }
  }

  /**
   * montrer une section spéciale de ta page Web. Il examine ce que tu as ajouté, que ce soit un fichier, plusieurs fichiers, ou même une autre vue, et il s'assure que tout est affiché correctement.
   * Si la section est un nom de fichier et que le fichier existe, on fait un render
   * Sinon si la section est un objet View, on appelle la fonction render() sur l'objet
   */
  function renderSection($section_name)
  {
    if (isset($this->sections[$section_name])) { //Cela vérifie si la section spéciale que tu veux afficher existe vraiment.
      if (is_string($this->sections[$section_name])) { //Cela vérifie si la valeur de la section est une chaîne de texte, ce qui signifie que c'est probablement le nom d'un fichier.
        echo $this->renderOutput($this->sections[$section_name]);//Si c'est le cas, la classe View utilise la fonction renderOutput pour montrer le contenu de ce fichier.
      } elseif (is_array($this->sections[$section_name])) { // Si la valeur est un tableau, cela signifie que tu as peut-être plusieurs fichiers à montrer dans cette section.
        foreach($this->sections[$section_name] as $filename) {
          echo $this->renderOutput($filename);//Elle parcourt chaque fichier et utilise renderOutput pour les afficher.
        }
      } elseif (is_a($this->sections[$section_name], get_class($this))) { //Si la valeur est une instance de la classe View, cela signifie que tu as une autre vue que tu veux inclure.
        $this->sections[$section_name]->render(); //La classe View appelle la fonction render sur cette autre vue pour l'afficher.
      }
    }
  }

  function renderOutput($filename) {
    if (!file_exists('resources/views/' . $filename . '.php')) { //Si le fichier n'existe pas, on affiche un message d'erreur
      return 'Erreur template ' . $filename . ' non trouvée';
    }

    //Sinon on génère l'affichage, même méthode que dans la fonction render()
    ob_start(); //ouvre un buffer pour capturer un output (l'output peut être du html ou du texte dans les fichiers ainsi que du code php echo), mais sans le montrer tout de suite.
    extract($this->data); //extrait les variables du tableau $data pour les rendre accessibles dans le fichier de la view
    require 'resources/views/' . $filename . '.php'; //inclusion du fichier squelette de la view, par défaut resources/views/template.php
    $str = ob_get_contents(); //récupère l'output généré sous forme de string
    ob_end_clean(); //nettoie et ferme le buffer d'output
    return $str; //renvoie la string générée
  }
}