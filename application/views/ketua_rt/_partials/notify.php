<?php if ($this->session->flashdata('msg') == 'success') : ?>
  <script type="text/javascript">
    new PNotify({
      title  : 'Success',
      text   : 'Proses berhasil!',
      type   : 'success',
      styling: 'bootstrap3'
    });
  </script>
<?php elseif ($this->session->flashdata('msg') == 'success-edit') : ?>
  <script type="text/javascript">
    new PNotify({
      title  : 'Success',
      text   : 'Data berhasil diubah!',
      type   : 'success',
      styling: 'bootstrap3'
    });
  </script>
<?php elseif ($this->session->flashdata('msg') == 'success-hapus') : ?>
  <script type="text/javascript">
    new PNotify({
      title  : 'Success',
      text   : 'Data berhasil dihapus!',
      type   : 'success',
      styling: 'bootstrap3'
    });
  </script>
<?php elseif ($this->session->flashdata('msg') == 'error-maxsize') : ?>
  <script type="text/javascript">
    new PNotify({
      title  : 'Upload Gagal',
      text   : 'Ukuran file yang diupload maksimal <b>3072 KB</b> atau <b>3 MB</b>!',
      type   : 'error',
      styling: 'bootstrap3'
    });
  </script>
<?php elseif ($this->session->flashdata('msg') == 'error-upload') : ?>
  <script type="text/javascript">
    new PNotify({
      title  : 'Upload Gagal',
      text   : 'Terjadi kesalahan saat menghapus file!',
      type   : 'error',
      styling: 'bootstrap3'
    });
  </script>
<?php elseif ($this->session->flashdata('msg') == 'error-belum-upload') : ?>
  <script type="text/javascript">
    new PNotify({
      title  : 'Upload Gagal',
      text   : 'Terdapat file yang belumd diunggah!',
      type   : 'error',
      styling: 'bootstrap3'
    });
  </script>
<?php elseif ($this->session->flashdata('msg') == 'error-other') : ?>
  <script type="text/javascript">
    new PNotify({
      title  : 'Upload Gagal',
      text   : 'Terjadi kesalahan!',
      type   : 'error',
      styling: 'bootstrap3'
    });
  </script>
<?php elseif ($this->session->flashdata('msg') != '') : ?>
  <script type="text/javascript">
    new PNotify({
      title  : 'Error',
      text   : '<?php echo $this->session->flashdata('msg'); ?>',
      type   : 'error',
      styling: 'bootstrap3'
    });
  </script>
<?php endif; ?>
<?php $this->session->mark_as_temp('msg', 10);  ?>