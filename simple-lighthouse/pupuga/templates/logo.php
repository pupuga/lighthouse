<div class="<?php echo $params['class'] ?>">
    <a href="<?php echo home_url() . '/' ?>">
        <?php if ($logo = get_theme_mod('custom_logo')) : ?>
            <?php echo wp_get_attachment_image($logo, 'full') ?>
        <?php endif ?>
    </a>
</div>