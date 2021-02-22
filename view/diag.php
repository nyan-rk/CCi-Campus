<body>
    <?php
        $req=retrieveDiag(htmlspecialchars($_GET['d']),$bdd);
        $resultat = $req->fetch();
        $_SESSION['id_user']=1;
        $user=(isset($_SESSION['id_user'])?$_SESSION['id_user']:0);
        $perm=canSee($_GET['d'],$resultat['vis_diag'],$resultat['team_affili'],$user,$resultat["id_creator"],$bdd);
    ?>
    <div class="container">
        <?php 
        pageBuilder($_GET['d'],$user,$resultat,$perm,$bdd);
        ?>
    </div>
</body>
<input type="hidden" id="dico" name="dico" text1="<?php echo DIAG['newtask'] ?>" text2="<?php echo DIAG['newstack']?>">
<script>var user=<?php echo $user;?>;
var team=<?php echo $resultat['team_affili'];?> </script>
<?php if ($perm==2) echo "<script src='./public/js/jquery-3.5.1.js'></script>
<script src='https://code.jquery.com/ui/1.12.1/jquery-ui.js'></script>
<script src='./public/js/diag.js'></script>
<script src='./public/js/html2canvas.js'></script>"; ?>
