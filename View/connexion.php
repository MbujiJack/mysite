<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Connexion</title>
  <link rel="stylesheet" href="public/connexionpage.css">
</head>
<body>

<div id="bg" style="color:blue; font-size:14px;"></div>

<form method='post' action='index.php?connexion'>
  <div class="form-field">
    <input type="text" name='utilisateur' placeholder="Nom Utilisateur" required/>
  </div>
  <div class="form-field">
    <input type="text" name='motdepasse' placeholder="Mot de passe" required/>                         
  </div>
    <?php if ($return) {
    ?>
    <div class="form-field">
      <p id="error"><?php echo $return; ?></p>
    </div>
    <?php
  } ?>
    <div class="form-field">
    <button class="btn" name='submit' type="submit">Se connecter</button>
  </div>
  
</form>

</body>

</html>
