<!--   Core JS Files   -->

<script src="<?php echo e(base_url()); ?>/assets/js/core/jquery.3.2.1.min.js"></script>
<script src="<?php echo e(base_url()); ?>/assets/js/core/popper.min.js"></script>
<script src="<?php echo e(base_url()); ?>/assets/js/core/bootstrap.min.js"></script>

<!-- jQuery UI -->
<script src="<?php echo e(base_url()); ?>/assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
<script src="<?php echo e(base_url()); ?>/assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>

<!-- jQuery Scrollbar -->
<script src="<?php echo e(base_url()); ?>/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

<!-- Moment JS -->
<script src="<?php echo e(base_url()); ?>/assets/js/plugin/moment/moment.min.js"></script>

<!-- Chart JS -->
<script src="<?php echo e(base_url()); ?>/assets/js/plugin/chart.js/chart.min.js"></script>

<!-- jQuery Sparkline -->
<script src="<?php echo e(base_url()); ?>/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

<!-- Chart Circle -->
<script src="<?php echo e(base_url()); ?>/assets/js/plugin/chart-circle/circles.min.js"></script>

<!-- Datatables -->
<script src="<?php echo e(base_url()); ?>/assets/js/plugin/datatables/datatables.min.js"></script>

<!-- Bootstrap Notify -->
<script src="<?php echo e(base_url()); ?>/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

<!-- Bootstrap Toggle -->
<script src="<?php echo e(base_url()); ?>/assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js"></script>

<!-- jQuery Vector Maps -->
<script src="<?php echo e(base_url()); ?>/assets/js/plugin/jqvmap/jquery.vmap.min.js"></script>
<script src="<?php echo e(base_url()); ?>/assets/js/plugin/jqvmap/maps/jquery.vmap.world.js"></script>

<!-- Google Maps Plugin -->
<script src="<?php echo e(base_url()); ?>/assets/js/plugin/gmaps/gmaps.js"></script>

<!-- Sweet Alert -->
<script src="<?php echo e(base_url()); ?>/assets/js/plugin/sweetalert/sweetalert.min.js"></script>
<script src="<?php echo e(base_url()); ?>/assets/js/photoviewer.js"></script>
<!-- Azzara JS -->
<script src="<?php echo e(base_url()); ?>/assets/js/ready.min.js"></script>
<script src="https://www.jquery-az.com/boots/js/bootstrap-imageupload/bootstrap-imageupload.js"></script>
<script>
  var link = "<?= base_url('admin/Admin/'.$planet['link'])?>";
</script>
<script src="<?php echo e(base_url()); ?>/assets/js/required/coreadmin.js"></script>
<script src="<?php echo e(base_url()); ?>/assets/js/bootstrap-select.js"></script>
<script>
  // initialize manually with a list of links
  $('[data-gallery=photoviewer]').click(function (e) {

    e.preventDefault();

    var items = [],
      options = {
        index: $(this).index(),
      };

    $('[data-gallery=photoviewer]').each(function () {
      items.push({
        src: $(this).attr('href'),
        title: $(this).attr('data-title')
      });
    });

    new PhotoViewer(items, options);

  });
</script>

<?php
error_reporting(0);
?>
<?php echo e($_SESSION['success']); ?>

</body>

</html><?php /**PATH /home/eclipse/Documents/PROJ/demo/application/views/template/footerAdmin.blade.php ENDPATH**/ ?>