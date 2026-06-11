<?php
// Deployer Gravity Forms integration for Newsreader theme

require_once get_theme_file_path('/inc/services/DeployerServiceProvider.php');

add_action('gform_after_submission', 'jw_push_gform_submission_to_deployer', 10, 2);
