<body>
    <div class="container">
        <?php 
            prePageBuilder($_GET['d'],$user,$resultat,$perm,$bdd);
        ?>
    </div>
</body>
<input type="hidden" id="dico" name="dico" text1="<?php echo DIAG['newtask'] ?>" text2="<?php echo DIAG['newstack']?>">
<script>var user=<?php echo $user;?>;
var team=<?php echo $resultat['team_affili'];?></script>
<script src='./public/js/jquery-3.5.1.js'></script>
<script> $(document).prop('title', 'Cardly - '+$('#diagTitle').text());</script>
<?php if ($perm==2) echo "
<script src='https://code.jquery.com/ui/1.12.1/jquery-ui.js'></script>
<script src='./public/js/diag.js'></script>
<script src='./public/js/html2canvas.js'></script>"; ?>
