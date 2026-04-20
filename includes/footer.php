<?php
// includes/footer.php
if (!isset($base)) {
    $base = '';
}
?>
    <!-- jQuery y Bootstrap -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="<?php echo $base; ?>bootstrap/js/bootstrap.min.js"></script>
    
    <!-- Scripts personalizados SIGEP -->
    <script src="<?php echo $base; ?>js/sigep.js"></script>
    <script src="<?php echo $base; ?>js/sigep-ui.js"></script>
</body>
</html>