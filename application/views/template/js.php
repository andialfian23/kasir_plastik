<!-- Bootstrap 4 -->
<script src="<?= base_url() ?>AdminLTE_3/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- DataTables  & Plugins -->
<?php foreach($template_js as $js){ echo '<script src="'.base_url().'AdminLTE_3/plugins/'.$js.'"></script>'; } ?>

<!-- AdminLTE App -->
<script src="<?= base_url() ?>AdminLTE_3/dist/js/adminlte.min.js"></script>

<!-- CUSTOM JS -->
<script src="<?= base_url() ?>SmartBrain/js/andi.js"></script>
<?= (!empty($custom_js))?'<script src="'.base_url().'SmartBrain/'.$custom_js.'"></script>':'' ?>