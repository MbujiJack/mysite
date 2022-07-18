<?php
/**
 * Created by Chadrack Tshinkobo Mbuyi.
 * Date: 02/07/2022
 */

//Display all erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include ('Controller/Controller.php');

$controller = new Controller();
if(isset($_GET['connexion']))
{
    $controller->connexionController(htmlspecialchars($_POST['utilisateur']),htmlspecialchars($_POST['motdepasse']));
}
elseif(isset($_GET['evenement']) && isset($_SESSION['utilisateur']))
{
    if (isset($_POST['miseajour'])) {
        $_SESSION['Action'] = 'miseajour';
        $idEvenement = htmlspecialchars($_POST['evenement']);
        $controller->evenementController($idEvenement,'miseajour');
    }
    elseif (isset($_POST['recherche'])) {
        $controller->rechercheEvenement();
    }
    elseif (isset($_POST['tous'])) {
        $_SESSION['Action'] = 'tous';
        $controller->listeEvenement();
    }
    elseif (isset($_POST['archivage'])) {
        $controller->archivageEvenement(htmlspecialchars($_POST['datearchive']));
    }
    elseif (isset($_POST['creer'])) {
        $_SESSION['Action'] = 'creer';
        $idEvenement = htmlspecialchars($_POST['evenement']);
        $controller->evenementController($idEvenement,'ajout');
    }
}
elseif (isset($_GET['recherche']) && isset($_SESSION['utilisateur'])) {
    if (isset($_POST['rechercheevenement'])) {
        $nom_evenement = htmlspecialchars($_POST['nom_evenement']);
        $nom_organisme = htmlspecialchars($_POST['nom_organisme']);
        $date = htmlspecialchars($_POST['date']);
         $controller->rechercheEvenementUser($nom_evenement,$nom_organisme,$date);
    }
    elseif(isset($_POST['annuler'])) {
        $controller->listeEvenement();
    }
}
elseif(isset($_GET['AjoutEditionEvenement']) && isset($_SESSION['utilisateur']))
{
    if(isset($_POST['annuler'])) {
        $controller->listeEvenement();
    }
    elseif(isset($_POST['ok'])) {
    
        $idEvenement = htmlspecialchars($_POST['numerounique']);
        $titre = htmlspecialchars($_POST['titre']);
        $datedebut = htmlspecialchars($_POST['debut']);
        $datefin = htmlspecialchars($_POST['fin']);
        $organisme = htmlspecialchars($_POST['organisme']);
        $mntEven = htmlspecialchars($_POST['prix']);
        $bandeau = htmlspecialchars($_POST['bandeau']);
        $musique = htmlspecialchars($_POST['musique']);
        $question = htmlspecialchars($_POST['question']);
        $controller->miseAjourEventController($idEvenement,$titre,$datedebut,$datefin,$organisme,$mntEven,$bandeau,$musique,$question,$_SESSION['Action']);
    }
    elseif(isset($_POST['detailsquestion'])) {
    
        $idQuestion = htmlspecialchars($_POST['id_question']);
        $idEvenement = htmlspecialchars($_POST['numerounique']);
        $controller->questionController($idQuestion,$idEvenement);
    }
    
}
elseif(isset($_GET['deconnection']))
{
    session_destroy();
    $controller->homeController();
}
else{
    session_destroy();
    $controller->homeController();
}