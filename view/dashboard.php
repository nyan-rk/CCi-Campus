<body>
    <div class="container">
        <!-- Carroussel of last 3 tables seen -->
        <section>
            <?php
                showCaroussel($_SESSION['id_user'],$bdd);
            ?>
        </section>

        <!-- Personal tables -->
        <section id="personalTables">
            <?php  
                showPersonalDiag($_SESSION['id_user'],$bdd,$gums);
            ?>
        </section>

        <!-- Team tables -->
        <section id="teamTables">
            <?php
                showTeamDiag($_SESSION['id_user'],$bdd,$gums);
                teamModals($bdd);
            ?>
        </section>

        <!-- Create parts -->
        <section style="background-color:#ECECEC;position:relative">
            <?php 
                showCreatePart($_SESSION['id_user'],$bdd);
            ?>
        </section>
    </div>
</body>
<input type="hidden" id="dico" name="dico" text1="<?php echo DASH['nopersonal'] ?>" text2="<?php echo DASH['noteam']?>" text3="<?php echo DASH['nothisteam'] ?>">
<script>var user=<?php echo $_SESSION['id_user'];?>; </script>
<script src="./public/js/jquery-3.5.1.js"></script>
<!--<script src="./public/js/carousel.js"></script>-->
<script src="./public/js/splide.js"></script>
<script src="./public/js/dashboard.js"></script>