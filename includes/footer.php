<?php
// includes/footer.php
if (!isset($base)) {
    $base = '';
}
?>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="<?php echo $base; ?>bootstrap/js/bootstrap.min.js"></script>
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    
    <!-- Scripts personalizados SIGEP -->
    <script src="<?php echo $base; ?>js/utilidades.js"></script>
    <script src="<?php echo $base; ?>js/general.js"></script>
    <script src="<?php echo $base; ?>js/sigep.js"></script>
    <script src="<?php echo $base; ?>js/sigep-ui.js"></script>
</body>
</html>