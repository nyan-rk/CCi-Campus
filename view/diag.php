<body>
    <?php
        $req=$bdd->prepare('SELECT * FROM diag WHERE id_diag= ?');
        $req->execute(array(htmlspecialchars($_GET['d'])));
        $resultat = $req->fetch();
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
                    echo "<strong>".$diag["objectives"]."</strong>";
                    echo "<br><p id='descDiag'>".nl2br($resultat["desc_diag"])."</p>";
                ?>
            </div>
            <div class="col-6 col-md-3 order-2 order-md-3">
                <button>Bouton</button>
            </div>
        </div>
        <div id="diagcont">
            <div class="row" id="diag">
            <?php
                displayDiag($_GET['d'],$diag['newtask'],$diag['newstack'],$bdd);
            ?>
            <!--<div class='colo'><input type="text" class="newStack" placeholder="Nouvelle colonne..."></input></div>-->
            <div class='colo colnew' text1="<?php echo $diag['newtask']?>" text2="<?php echo $diag['newstack']?>"><svg id="newStackButton" width='100px' height='100px'><use href='./public/images/icons/plus.svg#plus'></use></svg></div>
            <?php //echo file_get_contents("./public/images/icons/plus - copie.svg"); ?>
            </div>
        </div>
    </div>
</body>
<script src="./public/js/jquery-3.5.1.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="./public/js/diag.js"></script>
<script src="./public/js/html2canvas.js"></script>