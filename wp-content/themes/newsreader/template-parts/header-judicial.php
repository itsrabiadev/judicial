
<!-- Header -->
<link rel='stylesheet' href='https://use.fontawesome.com/releases/v6.5.2/css/all.css' media='all'  integrity="sha384-PPIZEGYM1v8zp5Py7UjFb79S58UeqCL9pYVnVPURKEqvioPROaVAJKKLzvH2rDnI" crossorigin="anonymous"/>
<link rel='stylesheet' id='b0d964cd1539ac560c5efa149f4392fe-css'
      href='https://fonts.googleapis.com/css?family=Inter%3A400%2C700%2C800%2C500&#038;subset=latin%2Clatin-ext%2Ccyrillic%2Ccyrillic-ext%2Cvietnamese&#038;display=swap&#038;ver=1.0.3'
      media='all'/>
<link rel='stylesheet' id='4a08c24c79a2483725ac09cf0f0deba9-css'
      href='https://fonts.googleapis.com/css?family=DM+Sans%3A&#038;subset=latin%2Clatin-ext%2Ccyrillic%2Ccyrillic-ext%2Cvietnamese&#038;display=swap&#038;ver=1.0.3'
      media='all'/>
<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>

<link rel='stylesheet' id='csco-styles-css' href='<?php echo get_template_directory_uri(); ?>/assets/assets/css/style.css?v=<?php echo file_exists( get_template_directory() . '/assets/assets/css/style.css' ) ? filemtime( get_template_directory() . '/assets/assets/css/style.css' ) : '1022583989'; ?>'
      media='all'/>
<?php
$jw_layout_css = get_template_directory() . '/assets/css/no-sidebar-layout.css';

// Skip homepage — it is Elementor-built and uses its own full-width layout.
if (
	is_singular()
	&& ! is_front_page()
	&& function_exists( 'csco_get_page_sidebar' )
	&& 'disabled' === csco_get_page_sidebar()
	&& file_exists( $jw_layout_css )
) :
	?>
<link rel='stylesheet' id='jw-no-sidebar-layout-css' href='<?php echo esc_url( get_template_directory_uri() . '/assets/css/no-sidebar-layout.css?v=' . filemtime( $jw_layout_css ) ); ?>'
      media='all'/>
<?php endif; ?>
<style id='cs-theme-typography'>:root{--cs-font-base-family:DM Sans;--cs-font-base-size:1rem;--cs-font-base-weight:400;--cs-font-base-style:normal;--cs-font-base-letter-spacing:normal;--cs-font-base-line-height:1.5;--cs-font-primary-family:DM Sans;--cs-font-primary-size:0.75rem;--cs-font-primary-weight:700;--cs-font-primary-style:normal;--cs-font-primary-letter-spacing:normal;--cs-font-primary-text-transform:uppercase;--cs-font-primary-line-height:1.2;--cs-font-secondary-family:DM Sans;--cs-font-secondary-size:0.75rem;--cs-font-secondary-weight:400;--cs-font-secondary-style:normal;--cs-font-secondary-letter-spacing:normal;--cs-font-secondary-text-transform:none;--cs-font-secondary-line-height:1.1;--cs-font-section-headings-family:Sora;--cs-font-section-headings-size:1.125rem;--cs-font-section-headings-weight:600;--cs-font-section-headings-style:normal;--cs-font-section-headings-letter-spacing:-0.02em;--cs-font-section-headings-text-transform:none;--cs-font-section-headings-line-height:1.1;--cs-font-post-title-family:Sora;--cs-font-post-title-weight:600;--cs-font-post-title-size:2.875rem;--cs-font-post-title-letter-spacing:-0.04em;--cs-font-post-title-line-height:1.1;--cs-font-post-subtitle-family:DM Sans;--cs-font-post-subtitle-weight:400;--cs-font-post-subtitle-size:1.25rem;--cs-font-post-subtitle-letter-spacing:normal;--cs-font-post-subtitle-line-height:1.4;--cs-font-category-family:DM Sans;--cs-font-category-size:0.5625rem;--cs-font-category-weight:700;--cs-font-category-style:normal;--cs-font-category-letter-spacing:0.02em;--cs-font-category-text-transform:uppercase;--cs-font-category-line-height:1.1;--cs-font-post-meta-family:DM Sans;--cs-font-post-meta-size:0.75rem;--cs-font-post-meta-weight:400;--cs-font-post-meta-style:normal;--cs-font-post-meta-letter-spacing:normal;--cs-font-post-meta-text-transform:none;--cs-font-post-meta-line-height:1.1;--cs-font-post-content-family:DM Sans;--cs-font-post-content-weight:400;--cs-font-post-content-size:1.125rem;--cs-font-post-content-letter-spacing:normal;--cs-font-post-content-line-height:1.6;--cs-font-input-family:DM Sans;--cs-font-input-size:0.875rem;--cs-font-input-weight:400;--cs-font-input-style:normal;--cs-font-input-line-height:1.3;--cs-font-input-letter-spacing:normal;--cs-font-input-text-transform:none;--cs-font-entry-title-family:Sora;--cs-font-entry-title-weight:600;--cs-font-entry-title-letter-spacing:-0.04em;--cs-font-entry-title-line-height:1.1;--cs-font-entry-excerpt-family:DM Sans;--cs-font-entry-excerpt-weight:400;--cs-font-entry-excerpt-size:1rem;--cs-font-entry-excerpt-letter-spacing:normal;--cs-font-entry-excerpt-line-height:normal;--cs-font-main-logo-family:DM Sans;--cs-font-main-logo-size:1.375rem;--cs-font-main-logo-weight:700;--cs-font-main-logo-style:normal;--cs-font-main-logo-letter-spacing:-0.02em;--cs-font-main-logo-text-transform:none;--cs-font-mobile-logo-family:DM Sans;--cs-font-mobile-logo-size:1.375rem;--cs-font-mobile-logo-weight:700;--cs-font-mobile-logo-style:normal;--cs-font-mobile-logo-letter-spacing:-0.02em;--cs-font-mobile-logo-text-transform:none;--cs-font-footer-logo-family:DM Sans;--cs-font-footer-logo-size:1.375rem;--cs-font-footer-logo-weight:700;--cs-font-footer-logo-style:normal;--cs-font-footer-logo-letter-spacing:-0.02em;--cs-font-footer-logo-text-transform:none;--cs-font-headings-family:Sora;--cs-font-headings-weight:600;--cs-font-headings-style:normal;--cs-font-headings-line-height:1.1;--cs-font-headings-letter-spacing:-0.04em;--cs-font-headings-text-transform:none;--cs-font-menu-family:DM Sans;--cs-font-menu-size:0.875rem;--cs-font-menu-weight:700;--cs-font-menu-style:normal;--cs-font-menu-letter-spacing:normal;--cs-font-menu-text-transform:none;--cs-font-menu-line-height:1.3;--cs-font-submenu-family:DM Sans;--cs-font-submenu-size:0.75rem;--cs-font-submenu-weight:400;--cs-font-submenu-style:normal;--cs-font-submenu-letter-spacing:normal;--cs-font-submenu-text-transform:none;--cs-font-submenu-line-height:1.3;--cs-font-footer-submenu-family:DM Sans;--cs-font-footer-submenu-weight:700;--cs-font-footer-submenu-style:normal;--cs-font-footer-submenu-letter-spacing:normal;--cs-font-footer-submenu-text-transform:none;--cs-font-footer-submenu-line-height:1.1;--cs-font-bottombar-menu-family:DM Sans;--cs-font-bottombar-menu-size:0.75rem;--cs-font-bottombar-menu-weight:700;--cs-font-bottombar-menu-style:normal;--cs-font-bottombar-menu-letter-spacing:normal;--cs-font-bottombar-menu-text-transform:none;--cs-font-bottombar-menu-line-height:1.3}</style>



<div class="cs-wrapper">
    <div class="cs-site-overlay"></div>
    <div class="cs-offcanvas" data-scheme="light">
        <div class="cs-offcanvas__header">
            <div class="cs-logo cs-logo-mobile">
                <a class="cs-header__logo cs-header__logo-mobile cs-logo-default"
                   href="<?php echo home_url(); ?>">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/assets/uploads/2024/05/judicial-watch-logo3.jpg"
                         alt="Judicial Watch" width="321.63265306122" height="80">
                </a>

                <a class="cs-header__logo cs-logo-dark" href="<?php echo home_url(); ?>">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/assets/uploads/2024/05/judicial-watch-logo3.jpg"
                         alt="Judicial Watch" width="321.63265306122" height="80">
                </a>
            </div>


            <nav class="cs-offcanvas__nav">
				<span class="cs-offcanvas__toggle" role="button" aria-label="Close mobile menu button">
					<i class="cs-icon cs-icon-x"></i>
				</span>
            </nav>

        </div>

        <div class="cs-offcanvas__search cs-container">

            <form role="search" method="get" class="cs-search__form" action="<?php echo home_url(); ?>">
                <div class="cs-search__group" data-scheme="light">
                    <input required class="cs-search__input" type="search" value="" name="s" placeholder="Search..."
                           role="searchbox">

                    <button class="cs-search__submit" aria-label="Search" type="submit">
                        Search
                    </button>
                </div>
            </form>
        </div>

        <?php get_template_part( 'template-parts/headers/header', 'mobile' ); ?>

    </div>

    <div id="page">
        <div class="cs-site-inner">
            <?php get_template_part( 'template-parts/headers/header', 'top-bar' ); ?>

            <div class="cs-header-before"></div>

            <header class="cs-header cs-header-two cs-header-stretch" data-scheme="light">
                <?php get_template_part( 'template-parts/headers/header', 'inner' ); ?>

                <div class="cs-header-overlay"></div>

                <?php get_template_part( 'template-parts/headers/header', 'bottom-bar' ); ?>
                <div class="cs-search">
                    <div class="cs-search__inner">
                        <div class="cs-search__form-container">
                            <form role="search" method="get" class="cs-search__form" action="/">
                                <div class="cs-search__group" data-scheme="light">
                                    <input required class="cs-search__input" type="search" value="" name="s"
                                           placeholder="Search..." role="searchbox">
                                    <button class="cs-search__submit" aria-label="Search" type="submit">
                                        Search
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </header>
        </div>
    </div>
