<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>List evenements</title>
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
  #err{
    font-style: italic;
    font-weight: bold;
    color: red;
    size: 300px;
    position: relative;
    left: 510px;
    top: 146px;
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
<?php
    if ($run  == 'yes' && isset($_SESSION['Action']) && $_SESSION['Action'] == 'miseajour') {
        ?>
        <script>
	        alert("L'évènement a été mis à jour avec succès");
        </script>
        <?php
        unset($_SESSION['Action']);
    }
    elseif ($run  == 'yes' && isset($_SESSION['Action']) && $_SESSION['Action'] == 'creer') {
        ?>
        <script>
	        alert("L'évènement a été créé avec succès");
        </script>
        <?php
        unset($_SESSION['Action']);
    }
    elseif ($run == 'archive') {
        ?><script>
	        alert("Les évènements ont été archivé avec succès");
        </script><?php
    }
    ?>
<form method='post' action='index.php?evenement'>
<div class="box22">
  <select name="evenement">
  
    <?php 
    foreach ($evenement as $evenement) {
        $id_evenement = $evenement['ID_EVENEMENT'];
        $evenement = $evenement['ID_EVENEMENT']. '  ' . $evenement['TITRE_EVE'] . '  '. $evenement['DATE_HEURE_DEBUT_EVE'];
    ?>
    <option value="<?php echo $id_evenement?>"><?php echo $evenement;?></option>
    <?php } ?>
    <?php 
    foreach ($evenementArchive as $evenementArchive) {
        $id_evenement = $evenementArchive['ID_EVENEMENT'];
        $evenement = $evenementArchive['ID_EVENEMENT']. '  ' . $evenementArchive['TITRE_EVE'] . '  '. $evenementArchive['DATE_HEURE_DEBUT_EVE'];
    ?>
    <option value="<?php echo $id_evenement?>"><?php echo $evenement;?></option>
    <?php } ?>
  </select>
</div id="button2">
<?php if (isset($_SESSION['utilisateur']) && ($_SESSION['utilisateur'] == 'Administrateur' || $_SESSION['utilisateur'] == 'Client')) {
        ?>
        <button class="btn2 info" name='creer' type="submit">Créer</button>
        <?php
    } ?>
    <button class="btn2 success" name='miseajour' type="submit">Mettre à jour</button>
    <button class="btn2 warning" name='recherche' type="submit">Rechercher</button>
    <?php
        if ($run  != 'tous') {
            ?>
                <button class="btn2 danger" name='tous' type="submit">Tous</button>
            <?php
            if (isset($_SESSION['Action'])) {
                unset($_SESSION['Action']);
            }
        }
    ?>
    <?php if (isset($_SESSION['utilisateur']) && $_SESSION['utilisateur'] == 'Administrateur') {
        ?>
        <button class="btn2 default" name='archivage' type="submit">Archiver événements</button>
        <input type="date" class="btn2 default" name='datearchive' placeholder="Date d'archivage"/>
        <p id="err"><?php echo $error; ?></p>
        <?php
    } ?>
  </div>
  
</form>

  
<footer><?php include('pied_de_page.php'); ?></footer>
</body>
</html>
