<body>

<?php
  // Recovers data of the logged-in user 
  //$_SESSION['id_user'] = 1;
  if ((isset($_SESSION['id_user'])!=true))
    {
        header('Location: ../index.php');
        exit();
    }
  $reponse = $bdd->prepare('SELECT * FROM user WHERE id_user=:USER');
  $reponse->execute(array('USER' => $_SESSION['id_user']));
  $donnees = $reponse->fetch();
?>
    
  <!--------------- Bottom part --------------->
  <div class="container my-5">
    <div class="row text-center">
      <div class="col">
        <img class="img" src="../public/images/profile/picto_user_comments.svg" alt="Card image cap">
      </div>
      <div class="col"></div>
      <div class="col"></div>
    </div>
  </div>

  <div id="border-bottom" class="container my-5">
    <h3>Informations sur l'utilisateur</h3>
  </div>

  <!--------------- Email part --------------->
  <div class="container"> 
    <div class="row text-center"> 
      <div id="gray" class="col-md py-5 mx-1 mt-3 rounded">
        <label for="name">Courriel </label>
        <br><br>
        <?php echo $donnees['mail_user'];?>
      </div>

      <!--------------- Nick name part --------------->
      <div id="pink" class="col-md py-5 mx-1 mt-3 rounded"> 
        <label for="name">Nom d'utilisateur </label>
        <br><br>
        <?php echo $donnees['nickname_user'];?>
      </div>

        <!--------------- Phone number part --------------->
        <div id="yellow" class="col-md py-5 mx-1 mt-3 rounded">
        <form method="post" action="../controller/profile.php">  
          <label for="phone_user">Numéro de téléphone </label>
            <br><br>
            <input class="form-control" value="<?php echo $donnees['phone_user'];?>" type ="tel" name="phone_user" minlength="10" maxlength="10" required/> 
        </div>
    </div>
  </div>

        <!--------------- Gender part --------------->
        <div class="container">
          <div class="row text-center">
            <div id="purple" class="col py-5 mt-3 mx-1 rounded">
              <label for="gender_user">Sexe </label>
              <br><br>
              <div class="form-group">
                <select name="gender_user" class="form-control">
                    <!-- Displays the gender according to the choice made -->
                    <option value="1" <?php if ($donnees['gender_user'] == 1) echo "selected"; ?>>Homme</option> 
                    <option value="2" <?php if ($donnees['gender_user'] == 2) echo "selected"; ?>>Femme</option>
                    <option value="3" <?php if ($donnees['gender_user'] == 3) echo "selected"; ?>>Autre</option>
                  </option>
                </select>
              </div>
            </div>

            <!--------------- Birthday part --------------->
            <div id="blue" class="col py-5 mt-3 mx-1 rounded">
              <label for="birth_user">Date de naissance </label>
              <br><br>
              <input class="form-control" type="date" name="birth_user" value="<?php echo $donnees['birth_user'];?>" min="1930-01-01" max="2022-01-01"/>
            </div>

          </div>
        </div>

        <!--------------- Biography part --------------->
        <div class="container text-center pb-5 px-1">
          <div id="green" class="col py-5 mt-3 px-3 rounded">
            <label for="biography_ser">Biographie </label>
            <br><br>
              <textarea class="form-control" name="biography_user" rows="2"><?php echo $donnees['biography_user'];?></textarea>
          </div>
        <br><br>
        <button type="submit" class="btn btn-dark col-md-4">Enregistrer les modifications</button>
        </div>
      </form>

<?php
$reponse->closeCursor();
?>
</body>
<script src='./public/js/jquery-3.5.1.js'></script>
<script src='./public/js/fiveohfix.js'></script>