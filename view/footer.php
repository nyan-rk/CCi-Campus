<footer>
    <div class="container">
        <div class="row" style="position:relative;justify-content: center;">
            <svg id="logo_footer" width='70px' height='70px'>
                <use href='./public/images/logofooter.svg#logo'></use>
            </svg>
            <div>
                <?php echo "<div class='row'>" . $footer['copyright'] . "</div>" ?>
                <br>
                <div class="row" style="justify-content: space-between;">
                    <?php echo "<a href='legal.php'>" . $footer['legal'] . "</a>
                                                 <a href='contact.php'>" . $footer['contact'] . "</a>" ?>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

</html>