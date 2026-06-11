
<?php
/**
 * Newsreader functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Newsreader
 */

use Engage\JudicialWatch\Containers\JWPost;

if (!class_exists('Newsreader')) {
    /**
     * Main Core Class
     */
    class Newsreader
    {

        /**
         * __construct
         *
         * This function will initialize the initialize
         */
        public function __construct()
        {
            $this->init();
            $this->theme_files();
        }

        /**
         * Init
         */
        public function init()
        {
            add_action('after_setup_theme', array($this, 'theme_setup'));
        }

        /**
         * Theme support
         */
        public function theme_support()
        {
            add_theme_support('wp-block-styles');
            add_theme_support('custom-logo');
            add_theme_support('custom-header');
            add_theme_support('custom-background');
            add_editor_style();
        }
        

        /**
         * Sets up theme defaults and registers support for various WordPress features.
         *
         * Note that this function is hooked into the after_setup_theme hook, which
         * runs before the init hook. The init hook is too late for some features, such
         * as indicating support for post thumbnails.
         */
        public function theme_setup()
        {
            /*
             * Make theme available for translation.
             * Translations can be filed in the /languages/ directory.
             * If you're building a theme based on Newsreader, use a find and replace
             * to change 'newsreader' to the name of your theme in all the template files.
             */
            load_theme_textdomain('newsreader', get_template_directory() . '/languages');

            // Add default posts and comments RSS feed links to head.
            add_theme_support('automatic-feed-links');

            /*
             * Let WordPress manage the document title.
             * By adding theme support, we declare that this theme does not use a
             * hard-coded <title> tag in the document head, and expect WordPress to
             * provide it for us.
             */
            add_theme_support('title-tag');

            // This theme uses wp_nav_menu() in one location.
            register_nav_menus(
                array(
                    'primary' => esc_html__('Primary', 'newsreader'),
                    'bottombar' => esc_html__('Header Bottombar', 'newsreader'),
                    'mobile' => esc_html__('Mobile', 'newsreader'),
                    'mobile_bottom' => esc_html__('Mobile Secondary', 'newsreader'),
                    'burger' => esc_html__('Burger Menu', 'newsreader'),
                    'burger_bottom' => esc_html__('Burger Secondary', 'newsreader'),
                    'footer_columns' => esc_html__('Footer Columns', 'newsreader'),
                    'footer' => esc_html__('Footer', 'newsreader'),
                )
            );

            /*
             * Switch default core markup for search form, comment form, comments, etc.
             * to output valid HTML5.
             */
            add_theme_support(
                'html5',
                array(
                    'search-form',
                    'comment-form',
                    'comment-list',
                    'gallery',
                    'caption',
                    'script',
                    'style',
                )
            );

            // Supported Appearance Tools.
            add_theme_support('custom-line-height');
            add_theme_support('custom-spacing');
            add_theme_support('custom-units');
            add_theme_support('appearance-tools');
            add_theme_support('border');
            add_theme_support('link-color');

            // Add support for responsive embeds.
            add_theme_support('responsive-embeds');

            // Supported Formats.
            add_theme_support('post-formats', array('gallery', 'video', 'audio'));

            // Add theme support for selective refresh for widgets.
            add_theme_support('customize-selective-refresh-widgets');

            // Add support for full and wide align images.
            add_theme_support('align-wide');

            /*
             * Enable support for Post Thumbnails on posts and pages.
             *
             * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
             */
            add_theme_support('post-thumbnails');

            // Register custom thumbnail sizes.
            add_image_size('csco-small', 72, 72, true);
            add_image_size('csco-small-2x', 144, 144, true);

            add_image_size('csco-thumbnail', 332, 186, true);
            add_image_size('csco-thumbnail-2x', 664, 372, true);
            add_image_size('csco-thumbnail-uncropped', 332, 0, false);
            add_image_size('csco-thumbnail-uncropped-2x', 664, 0, false);

            add_image_size('csco-medium', 688, 387, true);
            add_image_size('csco-medium-2x', 1376, 774, true);
            add_image_size('csco-medium-uncropped', 688, 0, false);

            add_image_size('csco-large', 1044, 587, true);
            add_image_size('csco-large-2x', 2088, 1174, true);
            add_image_size('csco-large-uncropped', 1044, 0, false);

            add_image_size('csco-extra-large', 1400, 650, true);
            add_image_size('csco-extra-large-2x', 2800, 1300, true);
            add_image_size('csco-extra-large-uncropped', 1400, 0, false);

            add_image_size('csco-fullwidth', 1920, 520, true);
            add_image_size('csco-fullwidth-2x', 3840, 1040, true);
            add_image_size('csco-fullwidth-uncropped', 1920, 0, false);
        }

        /**
         * Include theme files
         */
        public function theme_files()
        {
            require_once get_theme_file_path('/inc/deprecated.php');
            require_once get_theme_file_path('/inc/elementor.php');
            require_once get_theme_file_path('/inc/theme-setup.php');
            require_once get_theme_file_path('/core/theme-dashboard/class-theme-dashboard.php');
            require_once get_theme_file_path('/core/theme-demos/class-theme-demos.php');
            require_once get_theme_file_path('/core/customizer/class-customizer.php');
            require_once get_theme_file_path('/core/promo-banner/class-promo-banner.php');
            require_once get_theme_file_path('/inc/assets.php');
            require_once get_theme_file_path('/inc/widgets-init.php');
            require_once get_theme_file_path('/inc/theme-functions.php');
            require_once get_theme_file_path('/inc/theme-demos.php');
            require_once get_theme_file_path('/inc/theme-mods.php');
            require_once get_theme_file_path('/inc/filters.php');
            require_once get_theme_file_path('/inc/gutenberg.php');
            require_once get_theme_file_path('/inc/actions.php');
            require_once get_theme_file_path('/inc/partials.php');
            require_once get_theme_file_path('/inc/theme-tags.php');
            require_once get_theme_file_path('/inc/post-meta.php');
            require_once get_theme_file_path('/inc/load-more.php');
            require_once get_theme_file_path('/inc/load-nextpost.php');
            require_once get_theme_file_path('/inc/mega-menu.php');
            require_once get_theme_file_path('/inc/custom-menu.php');
            require_once get_theme_file_path('/inc/custom-content.php');
            require_once get_theme_file_path('/inc/metabox.php');
            require_once get_theme_file_path('/inc/acf-global-options.php');
            require_once get_theme_file_path('/inc/MainMenuItem.php');
            require_once get_theme_file_path('/inc/services/AuthorizeNetService.php');
            require_once get_theme_file_path('/inc/services/DeployerServiceProvider.php');
            require_once get_theme_file_path('/inc/helpers.php');
            require_once get_theme_file_path('/inc/petition-helpers.php');
            // Integrate Deployer with Gravity Forms
           // require_once get_theme_file_path('/inc/deployer-gravityforms.php');

        }
    }

    // Initialize.
    new Newsreader();
}

//JW Custom Option
add_action('acf/init', 'register_jw_settings_options_page');

function register_jw_settings_options_page()
{
    if (function_exists('acf_add_options_sub_page')) {
        acf_add_options_sub_page(array(
            'page_title' => 'JW Settings',
            'menu_title' => 'JW Settings',
            'parent_slug' => 'options-general.php',
            'menu_slug' => 'jw-settings',
            'capability' => 'manage_options',
            'redirect' => false
        ));
    }
}

// Custom log function for donation events
function jw_donation_log($message) {
    $log_file = ABSPATH . 'donation.log';
    $date = date('Y-m-d H:i:s');
    file_put_contents($log_file, "[$date] $message\n", FILE_APPEND);
}

//removing lazyloading from logo
function remove_lazy_loading_for_logo($content)
{
    if (is_front_page()) {
        // Remove lazy loading only for the logo image
        $content = preg_replace('/<img(.*?)loading="lazy"(.*?)>/', '<img$1loading="eager"$2>', $content);
    }
    return $content;
}
add_filter('the_content', 'remove_lazy_loading_for_logo', 10, 1);


/**
 * Resolve the petition/page context for a Gravity Forms submission.
 *
 * @param array $entry
 * @return WP_Post|null
 */
function jw_get_post_from_gform_entry($entry) {
    global $post;

    if ($post instanceof WP_Post) {
        return $post;
    }

    $source_url = rgar($entry, 'source_url');
    if (!$source_url) {
        return null;
    }

    $post_id = url_to_postid($source_url);
    if (!$post_id) {
        return null;
    }

    return get_post($post_id);
}

/**
 * Add Deployer metadata to Gravity Forms submissions before they are processed.
 */
add_action('gform_pre_submission', 'jw_gform_pre_submission_add_deployer_metadata', 10, 1);

function jw_gform_pre_submission_add_deployer_metadata($form) {
    global $post;

    if (!$post instanceof WP_Post) {
        $uri = isset($_SERVER['REQUEST_URI']) ? wp_unslash($_SERVER['REQUEST_URI']) : '';
        if ($uri) {
            $post_id = url_to_postid(home_url($uri));
            if ($post_id) {
                $post = get_post($post_id);
            }
        }
    }

    $_POST['SourceID'] = isset($_GET['source'])
        ? (int) sanitize_text_field(wp_unslash($_GET['source']))
        : 34;

    if (isset($_GET['clk'])) {
        $_POST['click_id'] = (int) sanitize_text_field(wp_unslash($_GET['clk']));
    }

    $int_code = isset($_GET['int_code']) ? sanitize_text_field(wp_unslash($_GET['int_code'])) : '';
    if (!$int_code && $post instanceof WP_Post) {
        $int_code = (string) get_field('int_code', $post->ID);
    }
    if ($int_code) {
        $_POST['int_code'] = $int_code;
    }

    if ($post instanceof WP_Post) {
        $_POST['Page Title'] = $post->post_title;
    }

    $_POST['Submission URL'] = sprintf(
        '%s%s',
        isset($_SERVER['HTTP_HOST']) ? sanitize_text_field(wp_unslash($_SERVER['HTTP_HOST'])) : '',
        isset($_SERVER['REQUEST_URI']) ? sanitize_text_field(wp_unslash($_SERVER['REQUEST_URI'])) : ''
    );
}

/**
 * Push Gravity Forms submissions to Deployer CRM.
 */
add_action('gform_after_submission', 'jw_push_gform_submission_to_deployer', 10, 2);

function jw_push_gform_submission_to_deployer($entry, $form) {
    if (!class_exists('DeployerServiceProvider')) {
        return;
    }

    $email_field = null;
    foreach ($form['fields'] as $field) {
        if ('GF_Field_Email' === get_class($field)) {
            $email_field = $field;
            break;
        }
    }

    if (!$email_field) {
        return;
    }

    $user_email = rgar($entry, (string) $email_field->id);
    if (!$user_email) {
        return;
    }

    $context_post = jw_get_post_from_gform_entry($entry);
    $source_url   = rgar($entry, 'source_url');
    $int_code     = isset($_POST['int_code']) ? $_POST['int_code'] : '';
    $page_title   = isset($_POST['Page Title']) ? $_POST['Page Title'] : '';
    $submission_url = isset($_POST['Submission URL']) ? $_POST['Submission URL'] : '';

    if ($context_post) {
        if (!$page_title) {
            $page_title = $context_post->post_title;
        }
        if ('petitions' === $context_post->post_type && !$int_code) {
            $int_code = (string) get_field('int_code', $context_post->ID);
        }
    }

    if (!$submission_url && $source_url) {
        $parsed = wp_parse_url($source_url);
        $submission_url = ($parsed['host'] ?? '') . ($parsed['path'] ?? '');
        if (!empty($parsed['query'])) {
            $submission_url .= '?' . $parsed['query'];
        }
    }

    try {
        $deployer_service = new DeployerServiceProvider();
        $post_request = $deployer_service->buildPostRequestFromEntry($entry, $form, [
            'SourceID'       => isset($_POST['SourceID']) ? $_POST['SourceID'] : 34,
            'click_id'       => isset($_POST['click_id']) ? $_POST['click_id'] : '',
            'int_code'       => $int_code,
            'Page Title'     => $page_title,
            'Submission URL' => $submission_url,
        ]);
        $fields = $deployer_service->getDeployerFieldsFromGformSubmission($post_request);
        $response = $deployer_service->addOrUpdateSubscriber($user_email, $fields);

        $log_file = WP_CONTENT_DIR . '/deployer_push.log';
        $date = date('Y-m-d H:i:s');
        $log_message = "[$date] Email: $user_email | Form: {$form['id']} | Response: ";
        if (is_object($response) && method_exists($response, 'getBody')) {
            $log_message .= $response->getBody();
        } else {
            $log_message .= print_r($response, true);
        }
        file_put_contents($log_file, $log_message . "\n", FILE_APPEND);
    } catch (\Exception $e) {
        $log_file = WP_CONTENT_DIR . '/deployer_push.log';
        $date = date('Y-m-d H:i:s');
        file_put_contents(
            $log_file,
            "[$date] ERROR pushing $user_email (form {$form['id']}): " . $e->getMessage() . "\n",
            FILE_APPEND
        );
    }
}

function donateWithAuthorizenet()
{

    ini_set('display_errors', 1);
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://jw.deployer.email/wta/xml.php',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '<?xml version="1.0" encoding="UTF-8"?>
            <xmlrequest>
                <username>judicialwatch</username>
                <usertoken>453e5318ec0a29f3ec52c27207cae995c11ae694</usertoken>
                <requesttype>subscribers</requesttype>
                <requestmethod>AddOrUpdateSubscriber</requestmethod>
                <details>
                <emailaddress>' . (isset($_POST['person']['email']) ? sanitize_text_field($_POST['person']['email']) : '') . '</emailaddress>
                    <listgroupid>17</listgroupid>
                    <format>html</format>
                    <confirmed>yes</confirmed>
                    <customfields>
                        <item>
                            <fieldid>2</fieldid>
                            <value>' . (isset($_POST['person']['name']['first']) ? sanitize_text_field($_POST['person']['name']['first']) : '') . '</value>
                        </item>
                        <item>
                            <fieldid>3</fieldid>
                            <value>' . (isset($_POST['person']['name']['last']) ? sanitize_text_field($_POST['person']['name']['last']) : '') . '</value>
                        </item>
                        <item>
                            <fieldid>16</fieldid>
                            <value>' . (isset($_POST['person']['address']['street']) ? sanitize_text_field($_POST['person']['address']['street']) : '') . '</value>
                        </item>
                        <item>
                            <fieldid>19</fieldid>
                            <value>' . (isset($_POST['person']['address']['street_2']) ? sanitize_text_field($_POST['person']['address']['street_2']) : '') . '</value>
                        </item>
                        <item>
                            <fieldid>8</fieldid>
                            <value>' . (isset($_POST['person']['address']['city']) ? sanitize_text_field($_POST['person']['address']['city']) : '') . '</value>
                        </item>
                        <item>
                            <fieldid>9</fieldid>
                            <value>' . (isset($_POST['person']['address']['state']) ? sanitize_text_field($_POST['person']['address']['state']) : '') . '</value>
                        </item>
                        <item>
                            <fieldid>12</fieldid>
                            <value>' . (isset($_POST['person']['address']['zipcode']) ? sanitize_text_field($_POST['person']['address']['zipcode']) : '') . '</value>
                        </item>
                        <item>
                            <fieldid>15</fieldid>
                            <value>34</value>
                        </item>
                        <item>
                            <fieldid>18</fieldid>
                            <value>A20II1ARP</value>
                        </item>
                        <item>
                            <fieldid>2070</fieldid>
                            <value>A20II1ARP</value>
                        </item>
                        <item>
                            <fieldid>51</fieldid>
                            <value>NATIONAL+IMPACT+SURVEY+OF+ILLEGAL+IMMIGRATION+ON+TAXPAYERS+AND+VOTERS+-+AR</value>
                        </item>
                        <item>
                            <fieldid>50</fieldid>
                            <value>judicialwatchx.wpengine.com/donate/make-a-contribution-2/</value>
                        </item>
                        <item>
                            <fieldid>5</fieldid>
                            <value>' . (isset($_POST['person']['phone']) ? sanitize_text_field($_POST['person']['phone']) : '') . '</value>
                        </item>
                    </customfields>
                    <opt_in>' . (isset($_POST['is_mobile_attached']) && $_POST['is_mobile_attached'] === 'true' ? 1 : 0) . '</opt_in>
<sms_mobile>' . (isset($_POST['is_mobile_attached'], $_POST['person']['phone']) && $_POST['is_mobile_attached'] === 'true'
            ? sanitize_text_field($_POST['person']['phone'])
            : ''
        ) . '</sms_mobile>

                </details>
            </xmlrequest>',
        CURLOPT_HTTPHEADER => array('Content-Type: application/xml'),
    ));
    $response = curl_exec($curl);
    curl_close($curl);


    try {
        $authorizenetService = new AuthorizeNetService;

        if (!session_id()) {
            session_start();
        }

        $intCode = isset($_SESSION['int_code']) ? sanitize_text_field($_SESSION['int_code']) : '';
        if ($intCode) {
            $_POST['int_code'] = $intCode;
        }

        $isSubscription = isset($_POST['isMonthlyDonation']) ? sanitize_text_field($_POST['isMonthlyDonation']) : '';
        if ($isSubscription === 'true') {
            $transactionResponse = $authorizenetService->createMonthlySubscriptionFromPostRequest($_POST);
        } else {
            $transactionResponse = $authorizenetService->createTransactionFromPostRequest($_POST);
        }

        // ---- Replace collect() + data_get() ----
        $messages = method_exists($transactionResponse, 'getMessages') ? $transactionResponse->getMessages() : [];

        if (!empty($messages)) {
            // normalize to array
            if (!is_array($messages)) {
                $messages = [$messages];
            }

            $firstMsg = reset($messages); // first element

            if ($firstMsg === 'Error' || (is_object($firstMsg) && property_exists($firstMsg, 'resultCode') && $firstMsg->getResultCode() === 'Error')) {
                jw_donation_log('donateWithAuthorizenet ERROR: Transaction error in messages.');
                wp_send_json([
                    'success' => false,
                    'message' => 'Sorry, we were unable to process this transaction.'
                ]);
            }
        }

        if (CreateTransactionResponse::class === get_class($transactionResponse)) {
            $tresponseObj = $transactionResponse->getTransactionResponse();
            $errors = isset($tresponseObj->errors) ? $tresponseObj->errors : [];

            if (!empty($errors)) {
                jw_donation_log('donateWithAuthorizenet ERROR: Transaction response errors.');
                wp_send_json([
                    'success' => false,
                    'message' => 'Sorry, we were unable to process this transaction.'
                ]);
            }
        } else {
            $resultCode = '';

            if (!empty($messages)) {
                $firstMsg = reset($messages);
                if (is_object($firstMsg) && property_exists($firstMsg, 'resultCode')) {
                    $resultCode = $firstMsg->getResultCode();
                }
            }

            if (empty($messages) || $resultCode !== 'Ok') {
                jw_donation_log('donateWithAuthorizenet ERROR: Empty messages or resultCode not Ok.');
                wp_send_json([
                    'success' => false,
                    'message' => 'Sorry, we were unable to process this transaction.'
                ]);
            }
        }

        if (isset($_SESSION['int_code'])) {
            unset($_SESSION['int_code']);
        }

        $tresponse = $transactionResponse->getTransactionResponse();

        if ($tresponse !== null && $tresponse->getResponseCode() == "1") {
            $transId = $tresponse->getTransId();
            $amount = isset($_POST['transaction_amount']) ? sanitize_text_field($_POST['transaction_amount']) : '';
            jw_donation_log('donateWithAuthorizenet SUCCESS: Donation processed. TransId: ' . $transId . ', Amount: ' . $amount);
            wp_send_json([
                'success' => true,
                'trans_id' => $transId,
                'amount' => $amount,
                'message' => 'Your donation has been processed - thanks!'
            ]);
        } else {
            jw_donation_log('donateWithAuthorizenet SUCCESS: Donation processed, no transaction response object.');
            wp_send_json([
                'success' => true,
                'message' => 'Your donation has been processed - thanks!'
            ]);
        }

    } catch (HookException $e) {
        jw_donation_log('donateWithAuthorizenet ERROR: HookException - ' . $e->getMessage());
        wp_send_json([
            'success' => true,
            'message' => 'Your donation has been processed - thanks!'
        ]);
    } catch (Exception $e) {
        jw_donation_log('donateWithAuthorizenet ERROR: Exception - ' . $e->getMessage());
        wp_send_json([
            'success' => false,
            'message' => 'Sorry, we were unable to process this transaction.'
        ]);
    }
}
add_action('admin_post_donate_authorizenet', 'donateWithAuthorizenet');
add_action('admin_post_nopriv_donate_authorizenet', 'donateWithAuthorizenet');


add_filter('template_include', function ($template) {
    // For searches specifically targeting documents
    if (is_search() && get_query_var('post_type') === 'documents') {
        $custom = locate_template('archive-documents.php');
        if ($custom) {
            return $custom;
        }
    }
    return $template;
});

add_filter('wpseo_title', function ($title) {
    if (is_post_type_archive()) {
        $post_type = get_query_var('post_type');
        if (is_array($post_type)) {
            $post_type = reset($post_type);
        }
        $obj = get_post_type_object($post_type);
        if ($obj) {
            return sprintf('%s Archives - %s', $obj->labels->name, get_bloginfo('name'));
        }
    }

    if (is_search()) {
        $search_query = get_search_query();
        $post_type = get_query_var('post_type');
        if ($post_type && $post_type !== 'any') {
            $obj = get_post_type_object($post_type);

            if (is_array($post_type)) {
                $post_type_str = reset($post_type);
            } else {
                $post_type_str = $post_type;
            }
            $label = $obj ? $obj->labels->name : ucfirst($post_type_str);
            return $search_query
                ? sprintf('Search "%s" in %s - %s', $search_query, $label, get_bloginfo('name'))
                : sprintf('Search in %s - %s', $label, get_bloginfo('name'));
        }
        return $search_query
            ? sprintf('Search "%s" - %s', $search_query, get_bloginfo('name'))
            : 'Search Results - ' . get_bloginfo('name');
    }

    return $title;
});

add_action('pre_get_posts', function ($query) {
    // Only change the main query on the front end
    if (!is_admin() && $query->is_main_query()) {

        // Force search queries to only look in documents
        if ($query->is_search() && isset($_GET['post_type']) && $_GET['post_type'] === 'documents') {
            $query->set('post_type', 'documents');
        }

        // Respect year + monthnum from form
        if ($query->is_search() && isset($_GET['post_type']) && $_GET['post_type'] === 'documents') {
            if (!empty($_GET['year'])) {
                $query->set('year', (int) $_GET['year']);
            }
            if (!empty($_GET['monthnum'])) {
                $query->set('monthnum', (int) $_GET['monthnum']);
            }
        }
    }
});

add_action('wp_ajax_jwtalk_loadmore', 'jwtalk_loadmore_ajax');
add_action('wp_ajax_nopriv_jwtalk_loadmore', 'jwtalk_loadmore_ajax');
function jwtalk_loadmore_ajax()
{
    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;
    $exclude = [];

    // Get featured post to exclude
    $featuredQuery = new WP_Query([
        'post_type' => 'podcasts',
        'post_status' => 'publish',
        'posts_per_page' => 1,
    ]);
    if ($featuredQuery->have_posts()) {
        $exclude[] = $featuredQuery->posts[0]->ID;
    }

    $query = new WP_Query([
        'post_type' => 'podcasts',
        'post_status' => 'publish',
        'posts_per_page' => 6,
        'post__not_in' => $exclude,
        'paged' => $paged,
    ]);
    $options = function_exists('csco_get_archive_options') ? csco_get_archive_options() : [
        'location' => 'archive',
        'layout' => 'grid',
    ];
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            set_query_var('options', $options);
            if ('full' === $options['layout']) {
                get_template_part('template-parts/archive/content-full');
            } else {
                get_template_part('template-parts/archive/entry');
            }
        }
        wp_reset_postdata();
    }
    wp_die();
}
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);
add_filter('comments_array', '__return_empty_array', 10, 2);

function custom_widgets_init()
{

    register_sidebar(array(
        'name' => 'Read Now Sidebar',
        'id' => 'read_now',
        'before_widget' => '<div>',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="rounded">',
        'after_title' => '</h2>',
    ));

    register_sidebar(array(
        'name' => 'Cases Sidebar',
        'id' => 'cases',
        'before_widget' => '<div>',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="rounded">',
        'after_title' => '</h2>',
    ));

}
add_action('widgets_init', 'custom_widgets_init');

function mytheme_enqueue_slick_cdn()
{
    // Slick CSS
    wp_enqueue_style(
        'slick-css',
        'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css',
        array(),
        '1.8.1'
    );

    wp_enqueue_style(
        'slick-theme-css',
        'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css',
        array('slick-css'),
        '1.8.1'
    );

    // Slick JS
    wp_enqueue_script(
        'slick-js',
        'https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js',
        array('jquery'),
        '1.8.1',
        true
    );



}
add_action('wp_enqueue_scripts', 'mytheme_enqueue_slick_cdn');

function jwtv_slider_scripts()
{
    if (is_page('jwtv')) {
        // About page slider
        wp_add_inline_script('slick-js', "
            jQuery(document).ready(function($) {
            $('.jwtv-slides').not('.slick-initialized').slick({
                arrows: true,
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: false,
                draggable: true,
                variableWidth: false, 
                prevArrow: '<button type=\"button\" class=\"slick-prev\"><span class=\"fas fa-chevron-left\"></span></button>',
                nextArrow: '<button type=\"button\" class=\"slick-next\"><span class=\"fas fa-chevron-right\"></span></button>',
                 waitForAnimate: false,
                 responsive: [
                    {
                        breakpoint: 768,
                        settings: 'unslick'
                    },
                    {
                        breakpoint: 1024,
                        settings: {
                            arrows: false,
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 1025,
                        settings: {
                            arrows: false,
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                ]
            });
        });

        ");
    } elseif (is_singular('videos')) {
        // Contact page slider
        wp_add_inline_script('slick-js', "
           jQuery(document).ready(function($) {
  $('.jwtv-slides').not('.slick-initialized').slick({
    arrows: true,
    slidesToShow: 3,
    slidesToScroll: 1,
    infinite: false,
    draggable: true,
    variableWidth: false,        
    prevArrow: '<button type=\"button\" class=\"slick-prev\"><span class=\"fas fa-chevron-left\"></span></button>',
    nextArrow: '<button type=\"button\" class=\"slick-next\"><span class=\"fas fa-chevron-right\"></span></button>',
    waitForAnimate: false,

    responsive: [
      {
        breakpoint: 1024,         
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3,
          arrows: false
        }
      },
      {
        breakpoint: 1025,         
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3,
          arrows: false
        }
      },
      {
        breakpoint: 768,         
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          arrows: false
        }
      }
    ]
  });
});

    ");
    }

}
add_action('wp_enqueue_scripts', 'jwtv_slider_scripts', 20);



function csco_get_document_image_url( $post_id ) {
    $defaultImage = '';

    $pdfImage   = get_post_meta( $post_id, '_document_cover_image' );
    $coverImage = get_field( 'document_image', $post_id );

    if ( is_array( $coverImage ) && ! empty( $coverImage['url'] ) ) {
        return $coverImage['url'];
    } elseif ( is_countable( $pdfImage ) && count( $pdfImage ) && ! empty( $pdfImage[0] ) ) {
        return $pdfImage[0];
    }

    return $defaultImage;
}

function load_webvizio_script_in_head() {
    if (
        is_front_page() ||     // Homepage
        is_home() ||           // Blog posts index
        is_archive() ||        // Post archives
        is_single() ||         // Single post
        is_page() || // Any Page (page.php)
        is_post_type_archive( 'documents' )    ||         
        is_post_type_archive( 'cases' )    ||         
        is_singular( 'cases' )    ||         
        is_singular( 'donation_pages' )    ||         
        is_singular( 'petitions' )           
    ) {
        ?>
        <script type="text/javascript">
            if (window.self !== window.top || ~location.href.indexOf("wv_task=")) {
                var s = document.createElement("script");
                s.type = "text/javascript";
                s.src = "https://app.webvizio.com/js/webvizio.js";
                s.id = "webvizio_script";
                document.head.append(s);
            }
        </script>
        <?php
    }
}
//add_action('wp_head', 'load_webvizio_script_in_head', 5);


// Change posts per page on archive pages to 12 and force newest-first ordering
add_action('pre_get_posts', function($query) {
    if (!is_admin() && $query->is_main_query()) {
        if (is_archive() || is_search()) {
            $query->set('posts_per_page', 12);
        }
    }
});

function global_short_post_titles_char( $title, $id = null ) {

    // Do not modify titles in admin
    if ( is_admin() ) {
        return $title;
    }

    // Do NOT shorten title on single post page
    if ( is_singular('post') ) {
        return $title;
    }

    // Do NOT shorten title if NOT front page AND page slug is 'home-clone'
    if ( ! is_front_page() && is_page( 'home-clone' ) ) {
        return $title;
    }

    // Character limit
    $limit = 100;

    if ( mb_strlen( $title ) > $limit ) {
        $title = mb_substr( $title, 0, $limit ) . '...';
    }

    return $title;
}

add_filter( 'the_title', 'global_short_post_titles_char', 10, 2 );

/**
 * Attach the built-in Tags taxonomy to the Videos custom post type.
 * Priority 11 ensures this runs after the video plugin registers 'videos' on init.
 */
add_action( 'init', function() {
    register_taxonomy_for_object_type( 'post_tag', 'videos' );
}, 11 );

add_filter('acf/load_field/name=petition_gravity_form', 'populate_petition_gravity_forms');

function populate_petition_gravity_forms($field) {

    $field['choices'] = [];

    if (!class_exists('GFAPI')) {
        return $field;
    }

    $forms = GFAPI::get_forms(true, false);

    if (empty($forms)) {
        return $field;
    }

    foreach ($forms as $form) {
        $title = trim((string) ($form['title'] ?? ''));

        if ($title === '') {
            $title = sprintf(__('Form #%d', 'newsreader'), (int) $form['id']);
        }

        $field['choices'][(string) $form['id']] = $title;
    }

    if (!empty($field['choices'])) {
        natcasesort($field['choices']);
    }

    // Keep the saved form visible even if it is inactive or missing from the list.
    $selected = $field['value'] ?? null;
    if ($selected !== null && $selected !== '' && !isset($field['choices'][(string) $selected])) {
        $selected_form = GFAPI::get_form($selected);
        if (!is_wp_error($selected_form) && !empty($selected_form['title'])) {
            $field['choices'][(string) $selected] = $selected_form['title'];
        }
    }

    return $field;
}

/**
 * Resolve the donation page permalink from a petition's ACF relationship field.
 */
function jw_get_petition_donation_page_url( $petition_id ) {
    $donation_page = get_field( 'donation_page', $petition_id );

    if ( empty( $donation_page ) ) {
        return '';
    }

    if ( is_numeric( $donation_page ) ) {
        return get_permalink( (int) $donation_page ) ?: '';
    }

    if ( $donation_page instanceof WP_Post ) {
        return get_permalink( $donation_page->ID ) ?: '';
    }

    if ( is_array( $donation_page ) ) {
        $first = reset( $donation_page );
        if ( $first instanceof WP_Post ) {
            return get_permalink( $first->ID ) ?: '';
        }
        if ( is_numeric( $first ) ) {
            return get_permalink( (int) $first ) ?: '';
        }
    }

    return '';
}

/**
 * After a petition form is submitted, redirect to the selected donation page.
 */
add_action( 'gform_after_submission', 'jw_redirect_petition_to_donation_page', 20, 2 );

function jw_redirect_petition_to_donation_page( $entry, $form ) {
    global $post;

    if ( ! $post || 'petitions' !== $post->post_type ) {
        return;
    }

    $petition_form_id = (int) get_field( 'petition_gravity_form', $post->ID );
    if ( $petition_form_id && (int) $form['id'] !== $petition_form_id ) {
        return;
    }

    if ( ! session_id() ) {
        session_start();
    }

    $_SESSION['petition_successful_submission'] = 1;

    $click_id = isset( $_GET['clk'] ) ? sanitize_text_field( wp_unslash( $_GET['clk'] ) ) : '';
    if ( ! $click_id && isset( $_POST['click_id'] ) ) {
        $click_id = sanitize_text_field( wp_unslash( $_POST['click_id'] ) );
    }
    if ( $click_id ) {
        $_SESSION['click_id'] = $click_id;
    }

    $int_code = isset( $_GET['int_code'] ) ? sanitize_text_field( wp_unslash( $_GET['int_code'] ) ) : '';
    if ( ! $int_code ) {
        $int_code = (string) get_field( 'int_code', $post->ID );
    }
    if ( $int_code ) {
        $_SESSION['int_code'] = $int_code;
    }

    $redirect_url = jw_get_petition_donation_page_url( $post->ID );
    if ( ! $redirect_url ) {
        return;
    }

    $event = 'existing_lead';
    $email_field = null;
    foreach ( $form['fields'] as $field ) {
        if ( 'GF_Field_Email' === get_class( $field ) ) {
            $email_field = $field;
            break;
        }
    }

    if ( $email_field ) {
        $user_email = rgar( $entry, (string) $email_field->id );
        if ( $user_email && class_exists( 'DeployerServiceProvider' ) ) {
            $deployer = new DeployerServiceProvider();
            if ( $deployer->checkUniqueLead( $user_email ) ) {
                $event = 'new_lead';
            }
        }
    }

    wp_safe_redirect( add_query_arg( 'event', $event, $redirect_url ) );
    exit;
}