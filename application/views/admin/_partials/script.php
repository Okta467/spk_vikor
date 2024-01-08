<!-- jQuery -->
<script src="<?= base_url("vendors/jquery/dist/jquery.min.js") ?>"></script>

<!-- Bootstrap -->
<script src="<?= base_url("vendors/bootstrap/dist/js/bootstrap.min.js") ?>"></script>

<!-- FastClick -->
<script src="<?= base_url("vendors/fastclick/lib/fastclick.js") ?>"></script>

<!-- NProgress -->
<script src="<?= base_url("vendors/nprogress/nprogress.js") ?>"></script>

<!-- Chart.js -->
<script src="<?= base_url("vendors/Chart.js/dist/Chart.min.js") ?>"></script>

<!-- gauge.js -->
<script src="<?= base_url("vendors/gauge.js/dist/gauge.min.js") ?>"></script>

<!-- bootstrap-progressbar -->
<script src="<?= base_url("vendors/bootstrap-progressbar/bootstrap-progressbar.min.js") ?>"></script>

<!-- iCheck -->
<script src="<?= base_url("vendors/iCheck/icheck.min.js") ?>"></script>

<!-- Switchery -->
<script src="<?= base_url("vendors/switchery/dist/switchery.min.js") ?>"></script>

<!-- Select2 -->
<script src="<?= base_url("vendors/select2/dist/js/select2.full.min.js") ?>"></script>

<!-- DateJS -->
<script src="<?= base_url("vendors/DateJS/build/date.js") ?>"></script>

<!-- bootstrap-daterangepicker -->
<script src="<?= base_url("vendors/moment/min/moment.min.js") ?>"></script>
<script src="<?= base_url("vendors/bootstrap-daterangepicker/daterangepicker.js") ?>"></script>

<!-- jQuery custom content scroller -->
<script src="<?= base_url("vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js") ?>"></script>

<!-- Datatables -->
<script src="<?= base_url("vendors/datatables.net/js/jquery.dataTables.min.js") ?>"></script>
<script src="<?= base_url("vendors/datatables.net-bs/js/dataTables.bootstrap.min.js") ?>"></script>
<script src="<?= base_url("vendors/datatables.net-buttons/js/dataTables.buttons.min.js") ?>"></script>
<script src="<?= base_url("vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js") ?>"></script>
<script src="<?= base_url("vendors/datatables.net-buttons/js/buttons.flash.min.js") ?>"></script>
<script src="<?= base_url("vendors/datatables.net-buttons/js/buttons.html5.min.js") ?>"></script>
<script src="<?= base_url("vendors/datatables.net-buttons/js/buttons.print.min.js") ?>"></script>
<script src="<?= base_url("vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js") ?>"></script>
<script src="<?= base_url("vendors/datatables.net-keytable/js/dataTables.keyTable.min.js") ?>"></script>
<script src="<?= base_url("vendors/datatables.net-responsive/js/dataTables.responsive.min.js") ?>"></script>
<script src="<?= base_url("vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js") ?>"></script>
<script src="<?= base_url("vendors/datatables.net-scroller/js/dataTables.scroller.min.js") ?>"></script>
<script src="<?= base_url("vendors/jszip/dist/jszip.min.js") ?>"></script>
<script src="<?= base_url("vendors/pdfmake/build/pdfmake.min.js") ?>"></script>
<script src="<?= base_url("vendors/pdfmake/build/vfs_fonts.js") ?>"></script>

<!-- PNotify -->
<script src="<?= base_url("vendors/pnotify/dist/pnotify.js") ?>"></script>
<script src="<?= base_url("vendors/pnotify/dist/pnotify.buttons.js") ?>"></script>
<script src="<?= base_url("vendors/pnotify/dist/pnotify.nonblock.js") ?>"></script>

<!-- SweetAlert2 -->
<script src="<?= base_url("vendors/MY_Vendor/sweetalert2/dist/sweetalert2.all.min.js") ?>"></script>

<!-- Custom Theme Scripts -->
<script src="<?= base_url("build/js/custom.min.js") ?>"></script>


<!-- Toggle Fullscreen on Sidebar Button -->
<script>
  const vh = Math.max(document.documentElement.clientHeight || 0, window.innerHeight || 0)

  var pageContent = document.querySelector('.nav-md .container.body .right_col');

  // Fix gantellela content-height bug with many data (row) in datatables
  document.addEventListener("DOMContentLoaded", function() {
    pageContent.style.cssText = `min-height: ${vh}px !important`;
    console.log(`min-height: ${vh}px !important`)
  });
  
  
  document.getElementById('toggle_fullscreen').addEventListener('click', function() {
    toggle_fullscreen();
  });

  function toggle_fullscreen() {
    var doc = window.document;
    var docEl = doc.documentElement;

    var requestFullScreen = docEl.requestFullscreen || docEl.mozRequestFullScreen || docEl.webkitRequestFullScreen || docEl.msRequestFullscreen;
    var exitFullScreen = doc.exitFullscreen || doc.mozCancelFullScreen || doc.webkitExitFullscreen || doc.msExitFullscreen;

    if (!doc.fullscreenElement && !doc.mozFullScreenElement && !doc.webkitFullscreenElement && !doc.msFullscreenElement) {
      // Enter fullscreen mode
      if (requestFullScreen) {
        requestFullScreen.call(docEl);
      }
    } else {
      // Exit fullscreen mode
      if (exitFullScreen) {
        exitFullScreen.call(doc);
      }
    }
  }
</script>