<?php
require_once $global['systemRootPath'] . 'objects/configuration.php';
$config = new Configuration();
?>
<hr>
<footer>
<<<<<<< HEAD
    <p>Powered by <a href="https://www.sfrancis.ca" class="external btn btn-outline btn-primary" target="_blank">Sfrancis.ca </a> &copy; 2017</p>
=======
    <p>Powered by <a href="https://www.sfrancis.ca" class="external btn btn-outline btn-primary" target="_blank">Sfrancis v<?php echo $config->getVersion(); ?></a> &copy; 2017</p>
>>>>>>> 8dca74e970f77e361d8013399b5e3bcb836817b4
</footer>
<script>
$(function() {
    <?php 
    if(!empty($_GET['error'])){
    ?>
    swal({title:"Sorry!", text: "<?php echo $_GET['error']; ?>", type:"error",  html:true});
    <?php
    }
    ?>
});
</script>
<script src="<?php echo $global['webSiteRootURL']; ?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo $global['webSiteRootURL']; ?>js/seetalert/sweetalert.min.js" type="text/javascript"></script>
<script src="<?php echo $global['webSiteRootURL']; ?>js/bootpag/jquery.bootpag.min.js" type="text/javascript"></script>
<script src="<?php echo $global['webSiteRootURL']; ?>js/bootgrid/jquery.bootgrid.min.js" type="text/javascript"></script>
<script src="<?php echo $global['webSiteRootURL']; ?>bootstrap/bootstrapSelectPicker/js/bootstrap-select.min.js" type="text/javascript"></script>
<script src="<?php echo $global['webSiteRootURL']; ?>js/script.js" type="text/javascript"></script>
