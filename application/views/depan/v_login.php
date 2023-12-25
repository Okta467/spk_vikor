<!DOCTYPE html>
<html lang="en">

<head>
  <title><?= "Login - {$this->config->config["webTitle"]}" ?></title>

  <?php $this->load->view('admin/_partials/head') ?>
  <?php $this->load->view('admin/_partials/script') ?>
</head>

<body class="login">
  <div class="login_wrapper">
    <section class="login_content">
      <form action="<?= site_url('auth/login') ?>" method="post">
        <h1>Login Form</h1>

        <div class="form-group">
          <input type="text" name="xusername" class="form-control" placeholder="Username" required="required">
        </div>

        <div class="form-group">
          <input type="password" name="xpassword" class="form-control" placeholder="Password" autocomplete="current-password" required="required">
        </div>

        <div class="form-group">
          <button class="btn btn-round btn-primary font-weight-bold" style="width: 100%;">Masuk</button>
        </div>

        <div class="clearfix"></div>

        <div class="separator">
          <p>Copyright © 2016 SPK Vikor</p>
        </div>
      </form>
    </section>
  </div>


  <!-- PAGE SCRIPT -->
  <script>
    $(document).ready(function() {
      <?php if ($this->session->flashdata('message_login_error')) : ?>

        Swal.fire({
          title: "Gagal",
          text: "<?= $this->session->flashdata('message_login_error') ?>",
          icon: "error"
        });

        <?= $this->session->mark_as_temp('message_login_error', 2); ?>
      <?php endif; ?>
    });
  </script>
</body>

</html>