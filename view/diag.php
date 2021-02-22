<body>
    <?php
        $req=$bdd->prepare('SELECT * FROM diag WHERE id_diag= ?');
        $req->execute(array(htmlspecialchars($_GET['d'])));
        $resultat = $req->fetch();
        $_SESSION['id_user']=1;
        $user=(isset($_SESSION['id_user'])?$_SESSION['id_user']:0);
        $perm=canSee($_GET['d'],$resultat['vis_diag'],$resultat['team_affili'],$user,$resultat["id_creator"],$bdd);
    ?>
    <div class="container">
        <?php
            echo "<h2 id='diagTitle'>".$resultat["name_diag"]."</h2>";
        ?>
        <div class="row">
            <div class="col-6 col-md-3 order-1 order-md-1" id="avacanvas">
                <?php showAvatar($resultat["id_creator"]); ?>
            </div>
            <div class="col-md-6 order-3 order-md-2">
                <?php
                    echo "<strong>".DIAG["objectives"]."</strong>";
                    echo "<br><p id='descDiag'>".nl2br($resultat["desc_diag"])."</p>";
                ?>
            </div>
            <!-- Menu button + menu modals -->
            <div class="col-6 col-md-3 order-2 order-md-3" style="display: flex;align-items: center;">
                <?php
                    menuButton($resultat['id_creator'],$user,$resultat['team_affili'],$resultat['vis_diag'],$bdd);
                ?>
            </div>
        </div>
        <div id="diagcont">
            <div class="row" id="diag">
            <?php
                displayDiag($_GET['d'],$perm,$bdd); 
                if (isset($_SESSION['id_user'])) addView($_GET['d'],$_SESSION['id_user'], $bdd);
            ?>
            </div>
        </div>
    </div>
</body>
<input type="hidden" id="dico" name="dico" text1="<?php echo DIAG['newtask'] ?>" text2="<?php echo DIAG['newstack']?>">
<script>var user=<?php echo $user;?>;
var team=<?php echo $resultat['team_affili'];?> </script>
<?php if ($perm==2) echo "<script src='./public/js/jquery-3.5.1.js'></script>
<script src='https://code.jquery.com/ui/1.12.1/jquery-ui.js'></script>
<script src='./public/js/diag.js'></script>
<script src='./public/js/html2canvas.js'></script>"; ?>
