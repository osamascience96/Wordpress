<!-- Setting Finance Menu -->
<div class="panel panel-default">
    <div class="panel-head">
        <div class="panel-title">
            <i class="icon-settings panel-head-icon"></i>
            <span class="panel-title-text">All Email Template</span>
        </div>
    </div>
    <div class="panel-body">
        <div class="v-menu pt-0 pb-0">
            <?php foreach ($template_menu as $key => $value) { ?>
            <li id="<?php echo $value['template'] ?>" class="nav-link"><a href="<?php echo URL_ADMIN.DIR_ROUTE; ?>emailtemplate&for=<?php echo $value['template'] ?>"><span><?php echo $value['name']; ?></span></a></li>
            <?php } ?>
        </div>
    </div>
</div>
<script>$('#<?php echo $result['template']; ?> a').addClass('active');</script>