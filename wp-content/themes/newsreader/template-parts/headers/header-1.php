<?php
/**
 * Overridden header.php - Newsreader Theme
 * Custom: uses legacy site header design
 *
 * @package Newsreader
 */

?><div class="cs-header-before"></div>

<header class="cs-header cs-header-stretch" <?php csco_header_attr(); ?>>
    <div class="cs-header__outer">
        <div class="cs-container">
            <?php include get_theme_file_path( 'template-parts/custom-old-header.php' ); ?>
        </div>
    </div>
    <div class="cs-header-overlay"></div>
</header>

<?php csco_component( 'header_bottombar' ); ?>
