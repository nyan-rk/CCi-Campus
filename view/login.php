<?php
//check if user exist
if (isset($_SESSION['id_user'])) {
    header('Location : ../dashboard.php');
    exit();
};

?>

<body>
    <div id="back_ground" class="mt-5 rounded">
        <div class="card-login">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs pull-right" id="connecPanel" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="connexion-tab" data-toggle="tab" href="#connexion" role="tab" aria-controls="connexion" aria-selected="true">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="inscription-tab" data-toggle="tab" href="#inscription" role="tab" aria-controls="inscription" aria-selected="false">Inscription</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="connecPanelContent">
                    <div class="tab-pane fade" id="connexion" role="tabpanel" aria-labelledby="connexion-tab">
                        <form action="controller/login.php" method="post">
                            <div class="container">
                                <label for="email"><b>Email</b></label>
                                <input type="email" name="email" required>
                                <label for="password"><b>Mot de passe</b></label>
                                <input type="password" name="password" required>
                                <button id="connexion_color" type="submit">Se connecter</button>
                            </div>
                            <div class="container" style="background-color:#f1f1f1">
                                <span class="password"><a href="forgot_password.php">Mot de passe oublié ?</a></span>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade show active" id="inscription" role="tabpanel" aria-labelledby="inscription-tab">
                        <form action="controller/register.php" method="POST">
                            <div class="container">
                                <label for="nickname"><b>Identifiant</b></label>
                                <input id="nickname" type="text" name="nickname" required>
                                <label for="email"><b>Email</b></label>
                                <input type="email" name="email" required>
                                <label for="password"><b>Mot de passe</b></label>
                                <input type="password" name="password">
                                <button id="inscription_color" type="submit">S'inscrire</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
<script src="../public/js/jquery-3.5.1.js">
</script>