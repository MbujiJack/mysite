<?php
    $idEvenement = '';
    $titre = '';
    $organisme = '';
    $date_debut = '';
    $date_fin = '';
    $prix = '';
    $bandeau = '';
    foreach ($evenement as $evenement) {
        $idEvenement =$evenement['ID_EVENEMENT'];
        $titre = $evenement['TITRE_EVE'];
        $organisme = $evenement['NOM_ORGANISME'];
        $date_debut = $evenement['DATE_HEURE_DEBUT_EVE'];
        $date_fin = $evenement['DATE_HEURE_FIN_EVE'];
        $prix = $evenement['MNT_PRIX_EVE'];
        $bandeau = $evenement['BANDEAU_PC_EVE'];

    }
?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Evenement</title>
  <link rel="stylesheet" href="">
  <style>
    #foot {
  position: fixed;
  left: 0;
  bottom: 0;
  width: 100%;
  background-color: #9f6b49;
  color: white;
  text-align: center;
}
#foot ul {
    display: inline-grid;
    grid-auto-flow: row;
    grid-gap: 24px;
    justify-items: center;
    margin: auto;
  }
  
  @media (min-width: 500px) {
    #foot ul {
      grid-auto-flow: column;
    }
  }
  
  #foot a {
    color: white;
    text-decoration: none;
    box-shadow: inset 0 -1px 0 hsla(0, 0%, 100%, 0.4);
  }
  
  #foot a:hover {
    box-shadow: inset 0 -1.2em 0 hsla(0, 0%, 100%, 0.4);
  }
  
  #foot li:last-child {
    grid-column: 1 / 2;
    grid-row: 1 / 2;
  }
  
  #foot li:hover ~ li p {
    animation: wave-animation 0.3s infinite;
  }






  * {box-sizing: border-box;}

input[type=text], select, textarea {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  margin-top: 6px;
  margin-bottom: 16px;
  resize: vertical;
}

input[type=submit] {
  background-color: #04AA6D;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #45a049;
}

.container {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
  position: relative;
  width: 50%;
  left: 23%;
  top: 120px;
  margin-bottom: 25px;
  
}






.btn2 {
  
  background-color: white;
  color: black;
  padding: 14px 28px;
  position: relative;
        top: 250px;
        left: 25%;
        
  font-size: 16px;
  
}

/* Green */
.success {
  
  color: green;
}

.success:hover {
  background-color: #04AA6D;
  color: white;
}

/* Blue */
.info {
  
  color: dodgerblue;
}

.info:hover {
  background: #2196F3;
  color: white;
}


.warning:hover {
  background: #ff9800;
  color: white;
}

/* Red */
.danger {
  border-color: #f44336;
  color: red;
}
a { text-decoration: none; }
.danger:hover {
  background: #f44336;
  color: white;
}

/* Gray */
.default {
  border-color: #e7e7e7;
  color: black;
}

.default:hover {
  background: #e7e7e7;
}

.box22 {
    position: fixed;
    top: 20%;
    left: 40%;
    
  }
  #error{
    color: red;
  }
  .box22 select {
    background-color: #0563af;
    color: white;
    
    padding: 12px;
    width: 250px;
    border: none;
    font-size: 20px;
    box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);
    -webkit-appearance: button;
    appearance: button;
    outline: none;
  }
  
  
  /* below is just for demo styling */
  
  
  
  @keyframes wave-animation {
    0%,
    100% {
      transform: rotate(0deg);
    }
    25% {
      transform: rotate(20deg);
    }
    75% {
      transform: rotate(-15deg);
    }


  }
  
    </style>
</head>
<header>
<?php include('connexion_etat.php'); ?>
</header>
<body>
<div class="container">
    <?php 
        if ($action == 'miseajour') {
            ?><h3>Mise à jour événement</h3><?php
            $imageBandeau = $bandeau;
            include('bandeau.php');
        }
        else{
            ?><h3>Ajout événement</h3><?php
        }
    ?>
  <form method='post' action="index.php?AjoutEditionEvenement">
    <label for="fname">Numéro unique</label>
    <input type="text" id="fname" name="numerounique" value="<?php echo $idEvenement; ?>" readonly>

    <label for="lname">Titre </label>
    <input type="text" id="lname" name="titre" value="<?php echo $titre; ?>">

    <?php 
        if ($_SESSION['utilisateur'] == 'Client' || $_SESSION['utilisateur'] == 'Préposé') {
            ?>
            <label for="country">Organisme </label>
            <select id="country" name="organisme" disabled>
                <option value="<?php echo $_SESSION['NOM_ORGANISME']; ?>"><?php echo $_SESSION['NOM_ORGANISME']; ?></option>
            </select>
            <?php
        }
        else{
           
            ?>
            <label for="country">Organisme </label>
            <select id="country" name="organisme">
            <?php
            foreach($organismes as $organismes){
                $organisme = $organismes['NOM_ORGANISME'];
                ?>
                    <option value="<?php echo $organisme; ?>"><?php echo $organisme; ?></option>
                <?php

            }
            ?>
            </select>
            <?php
        }
     ?>

    <label for="lname">Début </label>
    <input type="text" id="lname" name="debut" value="<?php echo $date_debut; ?>">

    <label for="lname">Fin </label>
    <input type="text" id="lname" name="fin" value="<?php echo $date_fin; ?>">
    
    <?php 
        if ($_SESSION['utilisateur'] == 'Client' || $_SESSION['utilisateur'] == 'Préposé') {
            if($prix == '' || $prix == NULL){
                $prix = 0;
            }
            ?>
            <label for="lname">Coût  </label>
            <input type="text" id="lname" name="prix" value="<?php echo $prix; ?>" readonly>
            <?php
        }
        else{
            ?>
            <label for="lname">Coût  </label>
            <input type="text" id="lname" name="prix" value="<?php echo $prix; ?>">
            <?php
        }
     ?>

    <label for="lname">Bandeau ordinateur </label>
    <input type="text" id="lname" name="bandeau" value="<?php echo $bandeau; ?>">

    <?php 
        if ($action == 'miseajour') {

            ?>
            <label for="country">Musique </label>
            <select id="country" name="musique" >
            <?php
            foreach($musique as $musique){
                $morceau = $musique['NOM_FICHIER_MUS'];
                $numeroMusique = $musique['NO_MUSIQUE'];
                ?>
                    <option value="<?php echo $numeroMusique; ?>"><?php echo $morceau; ?></option>
                <?php

            }
            ?>
            </select>

            <label for="country">Question </label>
            <select id="country" name="id_question">
            <?php
            foreach($question as $question){
                $no_order = $question['NO_ORDRE_QUESTION'];
                $idQuestion = $question['ID_QUESTION'];
                $codeQuestion = $question['CODE_TYPE_QUESTION'];
                $textQuestion = $question['TEXTE_QUE'];

                $details_question = $idQuestion.' '. $no_order. ' '. $codeQuestion . ' ' .substr($textQuestion,0,50);
                ?>
                    <option value="<?php echo $idQuestion; ?>"><?php echo $details_question; ?></option>
                <?php

            }
            ?>
            </select>
            <?php
            
        }
        else{
            ?>
            <label for="country">Musique </label>
            <select id="country" name="musique">
              <option value="<?php echo 'Test'; ?>"></option>
            </select>

            <label for="country">Question </label>
            <select id="country" name="question">
            <option value="<?php echo 'Test'; ?>"></option>
            </select>
            <?php
        }
    ?>

    <p id="error"><?php echo $retour; ?></p>
    <input type="submit" name="detailsquestion" value="Détails question">
    <input type="submit" name="ok" value="Ok">
    <input type="submit" name="annuler" value="Annuler"><br><br>
  </form>
</div>

  
<footer><?php include('pied_de_page.php'); ?></footer>
</body>
</html>
