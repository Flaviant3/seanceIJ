<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fichier de test de la séance I-J</title>
</head>
<body>
<h1>Fichier de test de la séance I-J</h1>
<?php
spl_autoload_register(function ($class_name) {
    require $class_name . '.php';
});

// Classe Abstraite Humain
class Humain {
    protected $nom;
    protected $prenom;
    protected $dateNaissance;

    public function __construct($nom, $prenom, $dateNaissance) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->dateNaissance = $dateNaissance;
    }

    public function sePresente() {
        return "Je suis {$this->prenom} {$this->nom}, né le {$this->dateNaissance}.";
    }
}

// Classe Artiste
class Artiste extends Humain {
    protected $specialite;
    protected $image;

    public function __construct($nom, $prenom, $dateNaissance, $specialite, $image) {
        parent::__construct($nom, $prenom, $dateNaissance);
        $this->specialite = $specialite;
        $this->image = $image;
    }

    public function sePresente() {
        return parent::sePresente() . " Je suis un artiste spécialisé en {$this->specialite}.";
    }
}

// Classe Auteur
class Auteur extends Artiste {
    public function __construct($nom, $prenom, $dateNaissance, $image) {
        parent::__construct($nom, $prenom, $dateNaissance, 'écrire', $image);
    }
}

// Classe Livre (abstraite)
abstract class Livre {
    protected $titre;
    protected $nbPages;
    protected $auteurs = [];

    public function __construct($titre, $nbPages) {
        $this->titre = ucwords($titre); // Met le titre en majuscules sur chaque mot.
        $this->nbPages = $nbPages;
    }

    public function addAuteur(Auteur $auteur) {
        $this->auteurs[] = $auteur;
    }

    public function supprimerAuteur(Auteur $auteur) {
        $key = array_search($auteur, $this->auteurs);
        if ($key !== false) {
            unset($this->auteurs[$key]);
        }
    }

    public abstract function afficheLivre();
}

// Classe Roman
class Roman extends Livre {
    public function afficheLivre() {
        $auteursStr = implode(', ', array_map(function ($auteur) {
            return $auteur->sePresente();
        }, $this->auteurs));
        return "Titre: {$this->titre}<br>Nombre de pages: {$this->nbPages}<br>Auteurs: {$auteursStr}";
    }
}

// Classe BandeDessinee
class BandeDessinee extends Livre {
    protected $dessinateurs = [];

    public function addDessinateur(Artiste $dessinateur) {
        $this->dessinateurs[] = $dessinateur;
    }

    public function afficheLivre() {
        $auteursStr = implode(', ', array_map(function ($auteur) {
            return $auteur->sePresente();
        }, $this->auteurs));
        $dessinateursStr = implode(', ', array_map(function ($dessinateur) {
            return $dessinateur->sePresente();
        }, $this->dessinateurs));
        return "Titre: {$this->titre}<br>Nombre de pages: {$this->nbPages}<br>Auteurs: {$auteursStr}<br>Dessinateurs: {$dessinateursStr}";
    }
}

// Création d'objets et affichage
$artiste = new Artiste('Mozart', 'Wolfgang Amadeus', '27/01/1756', 'Compositeur', 'mozart.jpg');
echo $artiste->sePresente();

$auteur = new Auteur('Corbeyran', 'Eric', '14/12/1964', 'corbeyran.jpg');
$auteurRoman = new Auteur('Conan Doyle', 'Arthur', '22/05/1859', 'doyle.jpg');

$livre = new Roman("L'étude en Rouge", 136);
$livre->addAuteur($auteurRoman);

echo $livre->afficheLivre();

$bd = new BandeDessinee('Lucky Luke: OK Corral', 48);
$bd->addAuteur($auteurRoman);

echo $bd->afficheLivre();

$auteurBd = new Auteur('Morris', '', '01/12/1923', 'morris.jpg');
$bd->addDessinateur($auteurBd);

echo $bd->afficheLivre();
?>
</body>
</html>
<!-- coded by flaviant3 -->