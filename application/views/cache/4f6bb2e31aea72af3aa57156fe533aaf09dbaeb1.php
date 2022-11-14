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
<script src="<?php echo e(base_url()); ?>/assets/js/plugin/datetimepicker/datetimepicker.js"></script>
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
<script src="<?php echo e(base_url()); ?>/assets/js/plugin/bootstrap-imageupload/bootstrap-imageupload.js"></script>
<script src="<?php echo e(base_url()); ?>/assets/js/plugin/dataTables-responsive/dataTables.responsive.js"></script>
<script src="<?php echo e(base_url()); ?>/assets/js/plugin/jquery-validate/jquery.validate.min.js"></script>
<script>
  var link = "<?= base_url('buyer/Buyer/'.$planet['link'])?>";
</script>
<script src="<?php echo e(base_url()); ?>/assets/js/required/corebuyer.js"></script>
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

  jQuery.validator.addMethod("phone", function(value, element) {
  return this.optional( element ) || /^(\+62|62)?[\s-]?0?8[1-9]{1}\d{1}[\s-]?\d{4}[\s-]?\d{2,5}$/.test( value );
  }, 'Please enter a valid Phone.');
  $( "#myform" ).validate({
    rules: {
      email: {
        required: true,
        email: true
      },
      username: {
      required: true,
      minlength: 5
				},
      phone: {
      required: true,
      phone: true
				},
    },
    highlight: function(element) {
      $("#edit-profile").attr("disabled", true);
			},
    success: function(element) {
    $("#edit-profile").attr("disabled", false);
    $( ".error" ).text('');
    },
  });

  $('#datepicker').datetimepicker({
			format: 'YYYY-MM-DD',
		});
    $('#datepicker1').datetimepicker({
			format: 'YYYY-MM-DD',
		});
</script>
<?php
error_reporting(0);
?>
<?php echo e($_SESSION['success']); ?>

</body>

</html><?php /**PATH /home/eclipse/Documents/PROJ/demo/application/views/template/footerBuyer.blade.php ENDPATH**/ ?>