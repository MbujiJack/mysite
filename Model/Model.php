<?php

/**
 * Created by Chadrack Tshinkobo Mbuyi.
 * Date: 02/07/2022
 */

class Model
{
    public function getDatatabaseConnect()
    {
        try
        {
            $mysqlConnection = new PDO(
                'mysql:host=localhost;dbname=mysite;charset=utf8',
                'root',
                'root'
            );
        }
        catch (Exception $e)
        {
                die('Erreur : ' . $e->getMessage());
        }        
        return $mysqlConnection;
    }
    public function Connexion($nomUsager,$motDePasse){
        $db = self::getDatatabaseConnect();
        $sqlQuery = 'SELECT TYPE_USA,LOGIN_USAGER,NOM_ORGANISME FROM TP2_USAGER WHERE LOGIN_USAGER = :id AND MOT_DE_PASSE_USA = :motdepasse';
        $getuser = $db->prepare($sqlQuery);
        $getuser->execute([
            'id' => $nomUsager,
            'motdepasse' => $motDePasse,
        ]);
        $data = $getuser->fetchAll();
        return $data;
    }
    public function evenementListNoArchive($utilisateur){
        $db = self::getDatatabaseConnect();
        if ($utilisateur == 'Administrateur') {
            
            $sqlQuery = 'SELECT ID_EVENEMENT,TITRE_EVE,DATE_HEURE_DEBUT_EVE FROM TP2_EVENEMENT WHERE ID_EVENEMENT NOT IN (SELECT ID_EVENEMENT FROM TP2_EVENEMENT_ARCHIVE)';
            $getuser = $db->prepare($sqlQuery);
            $getuser->execute([]);
            $data = $getuser->fetchAll();
        }
        else{
            $sqlQuery = 'SELECT ID_EVENEMENT,TITRE_EVE,DATE_HEURE_DEBUT_EVE FROM TP2_EVENEMENT WHERE NOM_ORGANISME = :organisme AND ID_EVENEMENT NOT IN (SELECT ID_EVENEMENT FROM TP2_EVENEMENT_ARCHIVE)';
            $getuser = $db->prepare($sqlQuery);
            $getuser->execute([
                'organisme' => $_SESSION['NOM_ORGANISME']
            ]);
            $data = $getuser->fetchAll();
        }
        return $data;
    }
    public function evenementListArchive($utilisateur){
        $data = '';
        if ($utilisateur == 'Administrateur') {
            $db = self::getDatatabaseConnect();
            $sqlQuery = 'SELECT ID_EVENEMENT,TITRE_EVE,DATE_HEURE_DEBUT_EVE FROM TP2_EVENEMENT WHERE ID_EVENEMENT IN (SELECT ID_EVENEMENT FROM TP2_EVENEMENT_ARCHIVE)';
            $getuser = $db->prepare($sqlQuery);
            $getuser->execute([]);
            $data = $getuser->fetchAll();
        }
        return $data;
    }
    public function evenementAEditer($id_evenement){
        $data = '';
        
            $db = self::getDatatabaseConnect();
            $sqlQuery = 'SELECT ID_EVENEMENT,TITRE_EVE,DATE_HEURE_DEBUT_EVE,NOM_ORGANISME,DATE_HEURE_FIN_EVE,MNT_PRIX_EVE,
            BANDEAU_PC_EVE FROM TP2_EVENEMENT WHERE ID_EVENEMENT = :idevenement';
            $getEvent = $db->prepare($sqlQuery);
            $getEvent->execute([
                'idevenement' => $id_evenement
            ]);
            $data = $getEvent->fetchAll();
       
        return $data;
    }
    public function musiqueAEditer($id_evenement){
        $data = '';
        
            $db = self::getDatatabaseConnect();
            $sqlQuery = 'SELECT NO_MUSIQUE,NOM_FICHIER_MUS FROM TP2_EVENEMENT_MUSIQUE WHERE ID_EVENEMENT = :idevenement';
            $getEvent = $db->prepare($sqlQuery);
            $getEvent->execute([
                'idevenement' => $id_evenement
            ]);
            $data = $getEvent->fetchAll();
       
        return $data;
    }
    public function questionAEditer($id_evenement){
        $data = '';
        
            $db = self::getDatatabaseConnect();
            $sqlQuery = 'SELECT ID_QUESTION,NO_ORDRE_QUESTION,CODE_TYPE_QUESTION,TEXTE_QUE 
                FROM TP2_QUESTION 
                WHERE ID_EVENEMENT = :idevenement';
            $getEvent = $db->prepare($sqlQuery);
            $getEvent->execute([
                'idevenement' => $id_evenement
            ]);
            $data = $getEvent->fetchAll();
       
        return $data;
    }
    public function lesOrganisme(){
        $db = self::getDatatabaseConnect();
        $sqlQuery = 'SELECT NOM_ORGANISME FROM TP2_ORGANISME';
        $getOrganisme = $db->prepare($sqlQuery);
        $getOrganisme->execute([]);
        $organisme = $getOrganisme->fetchAll();
        return $organisme;
    }
    public function AjoutEditionEvent($id_evenement,$titre,$datedebut,$datefin,$organisme,$mntEven,$bandeau,$musique,$question,$action){
        $db = self::getDatatabaseConnect();
        if ($action == 'creer') {
            $sqlQuery = 'INSERT INTO TP2_EVENEMENT(ID_EVENEMENT,TITRE_EVE,DATE_HEURE_DEBUT_EVE,NOM_ORGANISME,DATE_HEURE_FIN_EVE,MNT_PRIX_EVE,
            BANDEAU_PC_EVE) VALUES (:idEvenement, :titre, :debut, :organisme, :fin, :prix, :bandeau)';
            $getEvent = $db->prepare($sqlQuery);
            $getEvent->execute([
                'idEvenement' => 'DB3412KKKKK',
                'titre' => $titre,
                'debut' => date($datedebut),
                'organisme' => $organisme,
                'fin' => date($datefin),
                'prix' => $mntEven,
                'bandeau' => $bandeau
            ]);
        }
        else {
            
            $sqlQuery = 'UPDATE TP2_EVENEMENT SET TITRE_EVE = :titre,DATE_HEURE_DEBUT_EVE = :debut,NOM_ORGANISME = :organisme,
            DATE_HEURE_FIN_EVE = :fin,MNT_PRIX_EVE = :prix, BANDEAU_PC_EVE = :bandeau 
            WHERE ID_EVENEMENT = :idEvenement';
            $getEvent = $db->prepare($sqlQuery);
            $getEvent->execute([
                'titre' => $titre,
                'debut' => $datedebut,
                'fin' => $datefin,
                'prix' => $mntEven,
                'bandeau' => $bandeau,
                'organisme' => $organisme,
                'idEvenement' => $id_evenement
            ]);
        }
    }

    //A voir
    public function ajoutMAJevenement($id_evenement,$action){
        if ($action == 'miseajour') {
            
        }
        else if($action == 'creer'){

        }
    }
    public function evenementSearchNoArchive($nom_evenement,$nom_organisme,$date,$searchEvent,$searchOrgan,$searchDate){
        $db = self::getDatatabaseConnect();
        if ($_SESSION['utilisateur'] == 'Administrateur') {

            if (!empty($date)) {
                $sqlQuery = 'SELECT ID_EVENEMENT,TITRE_EVE,DATE_HEURE_DEBUT_EVE 
                FROM TP2_EVENEMENT 
                WHERE ID_EVENEMENT NOT IN (SELECT ID_EVENEMENT FROM TP2_EVENEMENT_ARCHIVE) 
                AND (NOM_ORGANISME = :organisme OR 
                TITRE_EVE = :titreEvenement OR 
                (DATE_HEURE_DEBUT_EVE <= :dateUser AND DATE_HEURE_FIN_EVE >= :dateUser))';
                $getuser = $db->prepare($sqlQuery);
                $getuser->execute([
                    'organisme' => $nom_organisme,
                    'titreEvenement' => $nom_evenement,
                    'dateUser' => date($date)
                ]);
               
            }else{
                $sqlQuery = 'SELECT ID_EVENEMENT,TITRE_EVE,DATE_HEURE_DEBUT_EVE 
                FROM TP2_EVENEMENT 
                WHERE ID_EVENEMENT NOT IN (SELECT ID_EVENEMENT FROM TP2_EVENEMENT_ARCHIVE) 
                AND (NOM_ORGANISME = :organisme OR 
                TITRE_EVE = :titreEvenement)';
                $getuser = $db->prepare($sqlQuery);
                $getuser->execute([
                    'organisme' => $nom_organisme,
                    'titreEvenement' => $nom_evenement
                ]);
            }
            $data = $getuser->fetchAll();
        }
        else{
            if (!empty($date)) {
                $sqlQuery = 'SELECT ID_EVENEMENT,TITRE_EVE,DATE_HEURE_DEBUT_EVE 
                FROM TP2_EVENEMENT 
                WHERE ID_EVENEMENT NOT IN (SELECT ID_EVENEMENT FROM TP2_EVENEMENT_ARCHIVE) 
                AND (NOM_ORGANISME = :organisme OR 
                TITRE_EVE = :titreEvenement OR 
                (DATE_HEURE_DEBUT_EVE =< :dateUser AND DATE_HEURE_FIN_EVE >= :dateUser) AND NOM_ORGANISME = :organisme)';
                $getuser = $db->prepare($sqlQuery);
                $getuser->execute([
                    'organisme' => $nom_organisme,
                    'titreEvenement' => $nom_evenement,
                    'dateUser' => date(date),
                    'organismeUser' => $_SESSION['NOM_ORGANISME']
                ]);
               
            }else{
                $sqlQuery = 'SELECT ID_EVENEMENT,TITRE_EVE,DATE_HEURE_DEBUT_EVE 
                FROM TP2_EVENEMENT 
                WHERE ID_EVENEMENT NOT IN (SELECT ID_EVENEMENT FROM TP2_EVENEMENT_ARCHIVE) 
                AND (NOM_ORGANISME = :organisme OR 
                TITRE_EVE = :titreEvenement 
                AND NOM_ORGANISME = :organismeUser)';
                $getuser = $db->prepare($sqlQuery);
                $getuser->execute([
                    'organisme' => $nom_organisme,
                    'titreEvenement' => $nom_evenement,
                    'organismeUser' => $_SESSION['NOM_ORGANISME']
                ]);
            }
            $data = $getuser->fetchAll();
        }
        return $data;
    }
    public function evenementSearchArchive($nom_evenement,$nom_organisme,$date,$searchEvent,$searchOrgan,$searchDate){
        $db = self::getDatatabaseConnect();
        if ($_SESSION['utilisateur'] == 'Administrateur') {

            if (!empty($date)) {
                $sqlQuery = 'SELECT ID_EVENEMENT,TITRE_EVE,DATE_HEURE_DEBUT_EVE 
                FROM TP2_EVENEMENT 
                WHERE ID_EVENEMENT IN (SELECT ID_EVENEMENT FROM TP2_EVENEMENT_ARCHIVE) 
                AND (NOM_ORGANISME = :organisme OR 
                TITRE_EVE = :titreEvenement OR 
                (DATE_HEURE_DEBUT_EVE <= :dateUser AND DATE_HEURE_FIN_EVE >= :dateUser))';
                $getuser = $db->prepare($sqlQuery);
                $getuser->execute([
                    'organisme' => $nom_organisme,
                    'titreEvenement' => $nom_evenement,
                    'dateUser' => date($date)
                ]);
               
            }else{
                $sqlQuery = 'SELECT ID_EVENEMENT,TITRE_EVE,DATE_HEURE_DEBUT_EVE 
                FROM TP2_EVENEMENT 
                WHERE ID_EVENEMENT IN (SELECT ID_EVENEMENT FROM TP2_EVENEMENT_ARCHIVE) 
                AND (NOM_ORGANISME = :organisme OR 
                TITRE_EVE = :titreEvenement)';
                $getuser = $db->prepare($sqlQuery);
                $getuser->execute([
                    'organisme' => $nom_organisme,
                    'titreEvenement' => $nom_evenement
                ]);
            }
            $data = $getuser->fetchAll();
        }
        else{
            if (!empty($date)) {
                $sqlQuery = 'SELECT ID_EVENEMENT,TITRE_EVE,DATE_HEURE_DEBUT_EVE 
                FROM TP2_EVENEMENT 
                WHERE ID_EVENEMENT IN (SELECT ID_EVENEMENT FROM TP2_EVENEMENT_ARCHIVE) 
                AND (NOM_ORGANISME = :organisme OR 
                TITRE_EVE = :titreEvenement OR 
                (DATE_HEURE_DEBUT_EVE =< :dateUser AND DATE_HEURE_FIN_EVE >= :dateUser) AND NOM_ORGANISME = :organisme)';
                $getuser = $db->prepare($sqlQuery);
                $getuser->execute([
                    'organisme' => $nom_organisme,
                    'titreEvenement' => $nom_evenement,
                    'dateUser' => date(date),
                    'organismeUser' => $_SESSION['NOM_ORGANISME']
                ]);
               
            }else{
                $sqlQuery = 'SELECT ID_EVENEMENT,TITRE_EVE,DATE_HEURE_DEBUT_EVE 
                FROM TP2_EVENEMENT 
                WHERE ID_EVENEMENT IN (SELECT ID_EVENEMENT FROM TP2_EVENEMENT_ARCHIVE) 
                AND (NOM_ORGANISME = :organisme OR 
                TITRE_EVE = :titreEvenement 
                AND NOM_ORGANISME = :organismeUser)';
                $getuser = $db->prepare($sqlQuery);
                $getuser->execute([
                    'organisme' => $nom_organisme,
                    'titreEvenement' => $nom_evenement,
                    'organismeUser' => $_SESSION['NOM_ORGANISME']
                ]);
            }
            $data = $getuser->fetchAll();
        }
        return $data;
    }
    public function questionDetail($idQuestion,$idEvenement){
        $db = self::getDatatabaseConnect();
            $sqlQuery = 'SELECT ID_QUESTION,NO_ORDRE_QUESTION,TEXTE_QUE,INSTRUCTION_QUE,EST_ACTIVE_QUE,DELAI_QUE,BOOL_RESULTATS_CONFIDENTIELS_QUE,
            DESC_TYPE_QUE 
            FROM TP2_QUESTION
            JOIN TP2_QUESTION_TYPE
            ON TP2_QUESTION.CODE_TYPE_QUESTION = TP2_QUESTION_TYPE.CODE_TYPE_QUESTION  
            WHERE ID_QUESTION = :idQuestion';
            $getuser = $db->prepare($sqlQuery);
            $getuser->execute([
                'idQuestion' => $idQuestion
            ]);
            $data = $getuser->fetchAll();
            return $data;
    }
    public function evenementBandeau($id){
        $db = self::getDatatabaseConnect();
            $sqlQuery = 'SELECT BANDEAU_PC_EVE FROM TP2_EVENEMENT WHERE ID_EVENEMENT = :idEvenement';
            $getuser = $db->prepare($sqlQuery);
            $getuser->execute([
                'idEvenement' => $id
            ]);
            $data = $getuser->fetchAll();
            $image = '';
            foreach ($data as $data) {
                $image = $data['BANDEAU_PC_EVE'];
            }
            return $image;
    }
    public function listechoixQuestion($idQuestion){
        $db = self::getDatatabaseConnect();
            $sqlQuery = 'SELECT ID_CHOIX,NO_ORDRE_CHOIX,TEXTE_CHO FROM TP2_CHOIX WHERE ID_QUESTION = :idQuestion';
            $getuser = $db->prepare($sqlQuery);
            $getuser->execute([
                'idQuestion' => $idQuestion
            ]);
            $data = $getuser->fetchAll();
            return $data;
    }

}