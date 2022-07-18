<?php
/**
 * Created by Chadrack Tshinkobo Mbuyi.
 * Date: 02/07/2022
 */

require ('Model/Model.php');


//Le controlleur
class Controller{

    //La page de connxion

    public function homeController()
    {   $return = '';
        include('View/connexion.php');
    }
    public function connexionController($utilisateur,$motdepasse){
        $Model = new Model();
        $infoUser = $Model->Connexion($utilisateur,$motdepasse);
        if (!empty($infoUser)) {
            foreach ($infoUser as $infoUser) {
                $userType = $infoUser['TYPE_USA'];
                $loginUser = $infoUser['LOGIN_USAGER'];
                $userOrganisme = $infoUser['NOM_ORGANISME'];
                break;
            }
            $_SESSION['LOGIN_USAGER'] = $loginUser;
            $_SESSION['NOM_ORGANISME'] = $userOrganisme;
            $_SESSION['utilisateur'] = $userType;

            $evenement = $Model->evenementListNoArchive($_SESSION['utilisateur']);
            $evenementArchive = $Model->evenementListArchive($_SESSION['utilisateur']);
            $run = '';
            $error = "";
            include('View/evenement_liste.php');
        }
        else{
            $return = 'Nom ou Mot de passe incorrect';
            include('View/connexion.php');
        }
    }
    public function miseAjourEventController($idEvenement,$titre,$datedebut,$datefin,$organisme,$mntEven,$bandeau,$musique,$question,$action){
        $Model = new Model();
        if ($action == 'miseajour') {
            if ((empty($titre) || empty($idEvenement) || empty($datedebut) || empty($datefin) || empty($organisme)
            || empty($bandeau))) {
                $evenement = $Model->evenementAEditer($idEvenement);
                $organismes = $Model->lesOrganisme();
                $musique = $Model->musiqueAEditer($idEvenement);
                $question = $Model->questionAEditer($idEvenement);
                $retour = 'Prière de remplir tous les champs du formulaire';
                $action = 'miseajour';
                include('View/evenement.php');
            }
            else{

                $Model->AjoutEditionEvent($idEvenement,$titre,$datedebut,$datefin,$organisme,$mntEven,$bandeau,$musique,$question,$action);
                $evenement = $Model->evenementListNoArchive($_SESSION['utilisateur']);
                $evenementArchive = $Model->evenementListArchive($_SESSION['utilisateur']);
                $run = 'yes';
                $error = "";
                include('View/evenement_liste.php');
            }
        }
        else{
            
            if ((empty($titre) || empty($datedebut) || empty($datefin) || empty($organisme)
            || empty($bandeau))) {
                $evenement = '';
                $organismes = $Model->lesOrganisme();
                $retour = 'Prière de remplir tous les champs obligatoires du formulaire';
                $action = 'ajout';
                $musique ='';
                $question = '';
                include('View/evenement.php');
            }
            else{

                $Model->AjoutEditionEvent($idEvenement,$titre,$datedebut,$datefin,$organisme,$mntEven,$bandeau,$musique,$question,$action);
                $evenement = $Model->evenementListNoArchive($_SESSION['utilisateur']);
                $evenementArchive = $Model->evenementListArchive($_SESSION['utilisateur']);
                $run = 'yes';
                $error = "";
                include('View/evenement_liste.php');
            }

        }
        
    }
    public function listeEvenement(){
        $Model = new Model();
        $evenement = $Model->evenementListNoArchive($_SESSION['utilisateur']);
        $evenementArchive = $Model->evenementListArchive($_SESSION['utilisateur']);
        $run = 'no';
        $error = "";
        if (isset($_SESSION['Action']) && $_SESSION['Action'] == 'tous') {
            $run = 'tous';
        }
        
        include('View/evenement_liste.php');
    }

    public function evenementController($idEvenement,$action){
        $Model = new Model();
        $evenement = '';
        $question = '';
        $musique = '';
        if ($action == 'miseajour') {
            $evenement = $Model->evenementAEditer($idEvenement);
            $question = $Model->questionAEditer($idEvenement);
            $musique = $Model->musiqueAEditer($idEvenement);

        }
        $organismes = $Model->lesOrganisme();
        $retour = $Model->ajoutMAJevenement($idEvenement,$action);
        include('View/evenement.php');
    }
    public function archivageEvenement($dateArchivage){
        $Model = new Model();
        $error = "";
        if (!empty($dateArchivage)) {
            $dateArchivage = date_create($dateArchivage);
            $currentDate = date_create(date("Y-m-d"));
            $diff = date_diff($dateArchivage, $currentDate);
            $diff = $diff->format("%R%a");
            if( $diff >= 730){

                //Appler la procedure
                $error = "";
                $evenement = $Model->evenementListNoArchive($_SESSION['utilisateur']);
                $evenementArchive = $Model->evenementListArchive($_SESSION['utilisateur']);
                $run = 'archive';
                include('View/evenement_liste.php');

            } else{
                $error = "Le champ date est invalide, la date doit être antérieure à la date du jour moins 2 ans";
                $evenement = $Model->evenementListNoArchive($_SESSION['utilisateur']);
                $evenementArchive = $Model->evenementListArchive($_SESSION['utilisateur']);
                $run = '';
                include('View/evenement_liste.php');
            }
        }
        else{
            $error = "Le champ date est vide, impossible de lancer l'archivage";
            $evenement = $Model->evenementListNoArchive($_SESSION['utilisateur']);
            $evenementArchive = $Model->evenementListArchive($_SESSION['utilisateur']);
            $run = '';
            include('View/evenement_liste.php');

        }
    }
    public function rechercheEvenementUser($nom_evenement,$nom_organisme,$date){
        if (!empty($nom_evenement) || !empty($nom_organisme) || !empty($date)) {

            $searchEvent = '';
            $searchOrgan = '';
            $searchDate = '';
            if (!empty($nom_evenement)) {
                $searchEvent = 'AND TITRE_EVE = :titre';
            }
            if(!empty($nom_organisme)) {
                $searchOrgan = 'AND NOM_ORGANISME = :organisme';
            }
            if (!empty($date)) {
                $searchDate = 'AND DATE_HEURE_DEBUT_EVE <= :dateevent AND DATE_HEURE_FIN_EVE >= :dateevent';
            }
            $error = '';
            $run = '';
            $Model = new Model();
            $evenement = $Model->evenementSearchNoArchive($nom_evenement,$nom_organisme,$date,$searchEvent,$searchOrgan,$searchDate);
            $evenementArchive = $Model->evenementSearchArchive($nom_evenement,$nom_organisme,$date,$searchEvent,$searchOrgan,$searchDate);
            include('View/evenement_liste.php');
        }
        else {
            $retour = "Remplissez au moins un champ afin d'effectuer une recherche";
            include('View/evenement_rechercher.php');
        }
    }
    public function questionController($idQuestion,$idEvenement){
        $Model = new Model();
        $question = $Model->questionDetail($idQuestion,$idEvenement);
        $bandeau = $Model->evenementBandeau($idEvenement);
        $choix = $Model->listechoixQuestion($idQuestion);
        include('View/question.php');
    }
    public function rechercheEvenement(){
        $retour = '';
        include('View/evenement_rechercher.php');
    }
}