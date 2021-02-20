        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
        <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script> -->
        <footer>
                <div class="container">
                        <div class="row" style="position:relative;justify-content: center;">
                                <svg id="logo_footer" width='70px' height='70px'><use href='./public/images/logofooter.svg#logo'></use></svg>
                                <div>
                                        <?php echo "<div class='row'>".$footer['copyright']."</div>" ?>
                                        <br>
                                        <div class="row" style="justify-content: space-between;">
                                                <?php echo "<a href='legal.php'>".$footer['legal']."</a>
                                                 <a href='contact.php'>".$footer['contact']."</a>" ?>
                                        </div>
                                </div>
                        </div>
                </div>
        </footer>
</html>