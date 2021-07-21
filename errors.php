<?php if(count($errors) > 0):  ?>
<div class="alert alert-danger" role="alert" style="width:80%;">
  <?php foreach( $errors as $error): ?>
  <p><?php echo $error; ?> </p>
  <?php endforeach ?>
  </div>
 
  <?php endif ?>
