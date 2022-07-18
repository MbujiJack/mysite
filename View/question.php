<?php
    $idQuestion = '';
    $numeroOrder = '';
    $texteQuestion = '';
    $instructionQuestion = '';
    $activeQuestion = '';
    $delaiQuestion = '';
    $resultatQuestion = '';
    $typeQuestion = '';
    
    foreach ($question as $question) {
        $idQuestion = $question['ID_QUESTION'];
        $numeroOrder = $question['NO_ORDRE_QUESTION'];
        $texteQuestion = $question['TEXTE_QUE'];
        $instructionQuestion = $question['INSTRUCTION_QUE'];
        $activeQuestion = $question['EST_ACTIVE_QUE'];
        $delaiQuestion = $question['DELAI_QUE'];
        $resultatQuestion = $question['BOOL_RESULTATS_CONFIDENTIELS_QUE'];
        $typeQuestion = $question['DESC_TYPE_QUE'];

    }

?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Question</title>
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

input[type=text], select, textarea,input[type=checkbox] {
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
        ?><h3>Details Question</h3><?php
        $imageBandeau = $bandeau;
        include('bandeau.php');
    ?>
  <form method='post' action="index.php?evenement">
  
    <label for="fname">ID EVENEMENT</label>
    <input type="text" id="fname" name="evenement" value="<?php echo $idEvenement; ?>" readonly>

    <label for="fname">ID QUESTION</label>
    <input type="text" id="fname" name="numerounique" value="<?php echo $idQuestion; ?>" readonly>

    <label for="lname">NO_ORDRE_QUESTION </label>
    <input type="text" id="lname" name="titre" value="<?php echo $numeroOrder; ?>" readonly>

    <label for="lname">TEXTE QUESTION </label>
    <input type="text" id="lname" name="debut" value="<?php echo $texteQuestion; ?>" readonly>

    <label for="lname">INSTRUCTION_QUE </label>
    <input type="text" id="lname" name="fin" value="<?php echo $instructionQuestion; ?>" readonly>

    <?php
    if ($activeQuestion == 1) {
            ?>
            <label for="country">QUESTION ACTIVE </label>
            <select id="country" name="choix" disabled readonly>
                <option value="<?php echo $idChoix; ?>">OUI</option>
            </select>
            <?php 
        }
        else{
            ?>
            <label for="country">QUESTION ACTIVE </label>
            <select id="country" name="choix" disabled readonly>
                <option value="<?php echo $idChoix; ?>">NON</option>
            </select>
            <?php 
        }?>

    <label for="lname">QUESTION DELAI </label>
    <input type="text" id="lname" name="bandeau" value="<?php echo $delaiQuestion; ?>" readonly>

    <?php if ($resultatQuestion == 1) {
            ?>
            <label for="country">QUESTION RESULTATS CONFIDENTIELS </label>
            <select id="country" name="choix" disabled readonly>
                <option value="<?php echo $idChoix; ?>">OUI</option>
            </select>
            <?php 
        }
        else{
            ?>
            <label for="country">QUESTION RESULTATS CONFIDENTIELS </label>
            <select id="country" name="choix" disabled readonly>
                <option value="<?php echo $idChoix; ?>">NON</option>
            </select>
            <?php 
        }?>

    <label for="lname">TYPE QUESTION  </label>
    <input type="text" id="lname" name="bandeau" value="<?php echo $typeQuestion; ?>" readonly>

            <label for="country">CHOIX </label>
            <select id="country" name="choix" readonly>
            <?php
            foreach($choix as $choix){
                $idChoix = $choix['ID_CHOIX'];
                $numeroChoix = $choix['NO_ORDRE_CHOIX'];
                $texteChoix = $choix['TEXTE_CHO'];
                $choix = $idChoix.' '.$numeroChoix.' '. substr($texteChoix,0,50);
                ?>
                    <option value="<?php echo $idChoix; ?>"><?php echo $choix; ?></option>
                <?php

            }
            ?>
            </select>
    <input type="submit" name="miseajour" value="Revenir a l'evenement">
  </form>
</div>

  
<footer><?php include('pied_de_page.php'); ?></footer>
</body>
</html>
