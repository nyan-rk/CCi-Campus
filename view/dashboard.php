<body>
    <?php 
        //$_SESSION['id_user']=(isset($_SESSION['id_user'])?$_SESSION['id_user']:1);
        //$_SESSION['is_connected']=(isset($_SESSION['is_connected'])?$_SESSION['is_connected']:true);
        if ((isset($_SESSION['id_user'])!=true)OR((isset($_SESSION['is_connected']))!=true))
		{
			header('Location: ../index.php');
            exit();
		}
        $gums=0;?>
    <div class="container">
        <!-- Carroussel of last 3 tables seen -->
        <section>
            <div class="col" style="text-align:center">
                <?php echo "<h2>".$dash['intro1']."</h2>".$dash['intro2'] ?>
            </div>
            <?php  
                showCaroussel($_SESSION['id_user'],$bdd);
            ?>
        </section>

        <!-- Personal tables -->
        <section id="personalTables">
            <?php  
                showPersonalDiag($_SESSION['id_user'],$dash['personal'],$dash['personalsub'],$dash['nopersonal'],$bdd,$gums);
            ?>
        </section>

        <!-- Team tables -->
        <section id="teamTables">
            <?php
                showTeamDiag($_SESSION['id_user'],$dash['team'],$dash['teamsub'],$dash['noteam'],$dash['nothisteam'],$bdd,$gums);
            ?>
        </section>

        <!-- Create parts -->
        <section style="background-color:#ECECEC;position:relative">
            <?php 
                showCreatePart($_SESSION['id_user'],$dash['createintro'],$dash['createintrosub'],$dash['newproject'],$dash['newteam'],$dash['createbutton'],$bdd);
            ?>
        </section>
    </div>
</body>
<script>var user=<?php echo $_SESSION['id_user'];?>; </script>
<script src="./public/js/jquery-3.5.1.js"></script>
<!--<script src="./public/js/carousel.js"></script>-->
<script src="./public/js/splide.js"></script>
<script src="./public/js/dashboard.js"></script>