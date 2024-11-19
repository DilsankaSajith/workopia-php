<?php if (isset($_SESSION['flash_success_message'])): ?>
  <div class="message bg-green-100 my-3 p-3">
    <?= $_SESSION['flash_success_message'] ?>
  </div>
  <?php unset($_SESSION['flash_success_message']) ?>
<?php endif ?>

<?php if (isset($_SESSION['flash_error_message'])): ?>
  <div class="message bg-red-100 my-3 p-3">
    <?= $_SESSION['flash_error_message'] ?>
  </div>
  <?php unset($_SESSION['flash_error_message']) ?>
<?php endif ?>