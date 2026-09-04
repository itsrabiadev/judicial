<?php

$menu_manager = new MainMenuManager();
$mainMenu = $menu_manager->get_main_menu_items_array();
$defaultImage = get_theme_file_uri('assets/images/logo-361x85.png');
?>
<div class="cs-header__outer">
    <div class="cs-container">
        <div class="cs-header__inner cs-header__inner-desktop">
            <div class="cs-header__col cs-col-left">
									<span class="cs-header__burger-toggle " role="button"
                                          aria-label="Burger menu button">
					<i class="cs-icon cs-icon-menu"></i>
					<i class="cs-icon cs-icon-x"></i>
				</span>
                <span class="cs-header__offcanvas-toggle " role="button"
                      aria-label="Mobile menu button">
					<i class="cs-icon cs-icon-menu"></i>
				</span>
                <nav class="cs-header__nav">
                    <ul id="menu-primary" class="cs-header__nav-inner">
                        <?php foreach ($mainMenu as $menuItem): ?>
                            <?php
                            if (in_array($menuItem['title'], ['Read Now', 'Watch Now', 'Podcasts', 'Documents'])):
                                $updatedTitle = $menuItem['title'];
                                if ($updatedTitle == 'Read Now') $updatedTitle = 'News';
                                elseif ($updatedTitle == 'Watch Now') $updatedTitle = 'Videos';
                                ?>

                                <?php if (!empty($menuItem['submenuExists'])): ?>
                                <li id="menu-item-<?= esc_attr($menuItem['id']) ?>" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-has-children menu-item-<?= esc_attr($menuItem['id']) ?> csco-menu-item-style-none cs-mega-menu cs-mega-menu-terms cs-sm-position-right">
                                    <a href="javascript:void(0)">
                    <span><span style="<?= in_array($updatedTitle, ['Podcasts', 'About', 'Take Action']) ? 'background:none !important;' : '' ?>">
                        <?= esc_html($updatedTitle) ?>
                    </span></span>
                                    </a>

                                    <?php if ($menuItem['submenu']['layout'] == 'submenu_tabs'): ?>
                                        <div class="sub-menu cs-sm-position-init" data-scheme="inverse">
                                            <div class="cs-container">
                                                <div class="cs-mm__content">
                                                    <ul class="cs-mm__categories">
                                                        <?php foreach ($menuItem['submenu']['tabs'] as $index => $tabItem): ?>
                                                            <?php
                                                            $isActive = $index === 0 ? 'cs-active-item' : '';
                                                            $hasPosts = !empty($tabItem['posts']);
                                                            ?>
                                                            <li class="<?= $isActive ?> menu-item menu-item-type-taxonomy menu-item-object-category menu-item-<?= esc_attr($tabItem['id'] ?? $index) ?> csco-menu-item-style-none cs-mega-menu-child-term cs-mega-menu-child loaded">
                                                                <a href="<?= $hasPosts ? 'javascript:void(0)' : esc_url($tabItem['url']) ?>" data-term="<?= $index + 1 ?>" data-numberposts="7">
                                                                    <?= strtoupper(esc_html($tabItem['title'])) ?>
                                                                </a>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>

                                                    <div class="cs-mm__posts-container cs-has-spinner">
                                                        <?php foreach ($menuItem['submenu']['tabs'] as $index => $tabPaneItem): ?>
                                                            <div class="cs-mm__posts <?= $index === 0 ? 'cs-active-item' : '' ?> loaded" data-term="<?= $index + 1 ?>">
                                                                <div class="cs-mm__posts-mixed">
                                                                    <?php foreach ($tabPaneItem['posts'] as $i => $tabPanePost): ?>
                                                                        <?php if ($i === 0): ?>
                                                                            <div class="cs-mm__posts-mixed-trending">
                                                                                <h3 class="cs-mm__posts-mixed-title">Latest</h3>
                                                                                <div class="cs-mm__posts-mixed-list">
                                                                                    <article class="mega-menu-item menu-post-item menu-post-item-tile post-<?= esc_attr($tabPanePost->id ?? '') ?> post type-post status-publish format-standard has-post-thumbnail cs-entry cs-video-wrap">

                                                                                        <div class="cs-entry__outer cs-entry__overlay cs-overlay-ratio cs-ratio-landscape" data-scheme="inverse">
                                                                                            <div class="cs-entry__inner cs-entry__thumbnail">
                                                                                                <?php $imageSrc = $tabPanePost['thumbnails']['medium_large']['src'] ?? $defaultImage; ?>

                                                                                                <div class="cs-overlay-background">
                                                                                                    <img src="<?= esc_url($imageSrc) ?>"
                                                                                                         alt="<?= esc_attr($tabPanePost->title ?? '') ?>"
                                                                                                         class="post-thumbnail"
                                                                                                         loading="lazy"
                                                                                                         width="768"
                                                                                                         height="384"
                                                                                                         sizes="(max-width: 100%)" />
                                                                                                </div>

                                                                                            </div>
                                                                                            <div class="cs-entry__inner cs-entry__content cs-overlay-content">
                                                                                                <h2 class="cs-entry__title"><?= esc_html(wp_trim_words($tabPanePost['title'], 7)) ?></h2>
                                                                                            </div>
                                                                                            <a class="cs-overlay-link" href="<?= esc_url($tabPanePost['link']) ?>" title="<?= esc_attr($tabPanePost['title']) ?>"></a>
                                                                                        </div>
                                                                                    </article>
                                                                                </div>
                                                                            </div>
                                                                        <?php else: ?>
                                                                            <?php if ($i == 1): ?>
                                                                                <div class="cs-mm__posts-mixed-popular">
                                                                                <h3 class="cs-mm__posts-mixed-title">Recent</h3>
                                                                                <div class="cs-mm__posts-mixed-list">
                                                                            <?php endif; ?>
                                                                            <article class="mega-menu-item menu-post-item menu-post-item-horizontal post-<?= esc_attr($tabPanePost->id ?? '') ?> cs-entry cs-video-wrap">

                                                                            <div class="cs-entry__outer">
                                                                                    <div class="cs-entry__inner cs-entry__overlay cs-entry__thumbnail cs-overlay-ratio cs-ratio-square">
                                                                                        <div class="cs-overlay-background">
                                                                                            <img src="<?= esc_url($tabPanePost['thumbnails']['medium_large']['src'] ?? $defaultImage) ?>"
                                                                                                 alt="<?= esc_attr($tabPanePost['title']) ?>"
                                                                                                 class="attachment-csco-small size-csco-small wp-post-image"
                                                                                                 loading="lazy" decoding="async"
                                                                                                 sizes="auto, (max-width: 72px) 100vw, 72px" />
                                                                                        </div>
                                                                                        <a href="<?= esc_url($tabPanePost['link']) ?>" class="cs-overlay-link"></a>
                                                                                    </div>
                                                                                    <div class="cs-entry__inner cs-entry__content">
                                                                                        <h2 class="cs-entry__title">
                                                                                            <a href="<?= esc_url($tabPanePost['link']) ?>"><?= esc_html(wp_trim_words($tabPanePost['title'], 7)) ?></a>
                                                                                        </h2>
                                                                                    </div>
                                                                                </div>
                                                                            </article>
                                                                            <?php if ($i === count($tabPaneItem['posts']) - 1): ?>
                                                                                </div>
                                                                                <?php if (!empty($tabPaneItem['categoryUrl'])): ?>
                                                                                    <div class="column column-category-read-more">
                                                                                        <div class="view-all-new">
                                                                                            <a href="<?= esc_url($tabPaneItem['categoryUrl']) ?>" class="button button-primary is-inverted">
                                                                                                View All
                                                                                            </a>
                                                                                        </div>
                                                                                    </div>
                                                                                <?php endif; ?>
                                                                                </div>
                                                                            <?php endif; ?>
                                                                        <?php endif; ?>
                                                                    <?php endforeach; ?>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($menuItem['submenu']['layout'] == 'submenu_links'): ?>
                                        <div class="sub-menu" data-scheme="light">
                                            <div class="cs-container">
                                                <div class="cs-mm__content">
                                                    <div class="cs-mm__posts-container cs-has-spinner">
                                                        <div class="cs-mm__posts loaded cs-active-item" style="justify-content: center;display:flex;" data-term="21">
                                                            <div class="cs-mm__posts-mixed">
                                                                <?php foreach ($menuItem['submenu']['posts'] as $tabPaneItem): ?>
                                                                    <div class="column column-card">
                                                                        <a href="<?= esc_url($tabPaneItem['link']) ?>"
                                                                            <?= ($tabPaneItem['target'] ?? '') === '_blank' ? 'target="_blank"' : '' ?>
                                                                           class="component-card-post">
                                                                            <div class="submenu-post-image<?= !empty($tabPaneItem['thumbnails']['medium_large']['src']) ? '' : ' background-image-missing' ?>"
                                                                                 style="<?= !empty($tabPaneItem['thumbnails']['medium_large']['src']) ? 'background-image:url(' . esc_url($tabPaneItem['thumbnails']['medium_large']['src']) . ')' : '' ?>">
                                                                            </div>
                                                                            <span class="title"><?= esc_html(strlen($tabPaneItem['title']) > 75 ? substr($tabPaneItem['title'], 0, 75) . '...' : strtoupper($tabPaneItem['title'])) ?></span>
                                                                        </a>
                                                                    </div>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </li>

                            <?php else: ?>
                                <li id="menu-item-<?= esc_attr($menuItem['id']) ?>" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-<?= esc_attr($menuItem['id']) ?> csco-menu-item-style-none">
                                    <a href="<?= esc_url($menuItem['url']) ?>"><span><span><?= esc_html($updatedTitle) ?></span></span></a>
                                </li>
                            <?php endif; ?>
                            <?php endif; endforeach; ?>
                    </ul>

                </nav>
            </div>
            <div class="cs-header__col cs-col-center">
                <div class="cs-logo cs-logo-desktop">
                    <a class="cs-header__logo cs-logo-default " href="<?php echo home_url(); ?>">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/assets/uploads/2024/05/judicial-watch-logo3.jpg"
                        alt="Judicial Watch" width="321.63265306122" height="80" loading="eager" class="skip-lazy"> </a>

                    </a>

                </div>
                <div class="cs-logo cs-logo-mobile">
                    <a class="cs-header__logo cs-header__logo-mobile cs-logo-once"
                       href="<?php echo home_url(); ?>">
                        Judicial Watch </a>

                </div>
            </div>
            <div class="cs-header__col cs-col-right">
                <nav class="cs-header__nav">
                    <ul id="menu-primary" class="cs-header__nav-inner">

                        <li id="menu-item-73"
                            class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-has-children menu-item-73 csco-menu-item-style-none cs-mega-menu cs-mega-menu-terms cs-sm-position-right">
                            <a href="javascript:void(0)"><span><span
                                        style="background:none !important;">About</span></span></a>


                            <div class="sub-menu" data-scheme="light">
                                <div class="cs-container">
                                    <div class="cs-mm__content">
                                        <div class="cs-mm__posts-container cs-has-spinner">
                                            <div class="cs-mm__posts loaded cs-active-item"
                                                 style="justify-content: center;display:flex;"
                                                 data-term="21">
                                                <div class="cs-mm__posts-mixed">
                                                    <div class="column column-card">
                                                        <a href="/about#mission"
                                                           class="component-card-post">
                                                            <div class="submenu-post-image lazyload"
                                                                 style="background-image:inherit"
                                                                 data-bg-image="url(&#039;https://www.judicialwatch.org/wp-content/uploads/2019/05/whitehouse.jpg&#039;)"></div>
                                                            <span class="title">    MISSION</span>
                                                        </a>
                                                    </div>
                                                    <div class="column column-card">
                                                        <a href="/about#legal"
                                                           class="component-card-post">
                                                            <div class="submenu-post-image lazyload"
                                                                 style="background-image:inherit"
                                                                 data-bg-image="url(&#039;https://www.judicialwatch.org/wp-content/uploads/2019/05/gavel-dramatic.jpg&#039;)"></div>
                                                            <span class="title">    LEGAL</span>
                                                        </a>
                                                    </div>
                                                    <div class="column column-card">
                                                        <a href="/about#staff"
                                                           class="component-card-post">
                                                            <div class="submenu-post-image lazyload"
                                                                 style="background-image:inherit"
                                                                 data-bg-image="url(&#039;https://www.judicialwatch.org/wp-content/uploads/2017/01/staff-photo.jpg&#039;)"></div>
                                                            <span class="title">    TEAM</span>
                                                        </a>
                                                    </div>
                                                    <div class="column column-card">
                                                        <a href="/about#careers"
                                                           class="component-card-post">
                                                            <div class="submenu-post-image lazyload"
                                                                 style="background-image:inherit"
                                                                 data-bg-image="url(&#039;https://www.judicialwatch.org/wp-content/uploads/2019/05/0905-Congress_Returns.2.jpg&#039;)"></div>
                                                            <span class="title">    CAREERS</span>
                                                        </a>
                                                    </div>
                                                    <div class="column column-card">
                                                        <a href="/contact"
                                                           class="component-card-post">
                                                            <div class="submenu-post-image lazyload"
                                                                 style="background-image:inherit"
                                                                 data-bg-image="url(&#039;https://www.judicialwatch.org/wp-content/uploads/2019/05/Capitol-DramaticSmall-768x432.jpg&#039;)"></div>
                                                            <span class="title">    CONTACT</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li id="menu-item-116502"
                            class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-has-children menu-item-116502 csco-menu-item-style-none cs-mega-menu cs-mega-menu-terms cs-sm-position-right">
                            <a href="javascript:void(0)"><span><span
                                        style="background:none !important;">Take Action</span></span></a>


                            <div class="sub-menu" data-scheme="light">
                                <div class="cs-container">
                                    <div class="cs-mm__content">
                                        <div class="cs-mm__posts-container cs-has-spinner">
                                            <div class="cs-mm__posts loaded cs-active-item"
                                                 style="justify-content: center;display:flex;"
                                                 data-term="21">
                                                <div class="cs-mm__posts-mixed">
                                                    <div class="column column-card">
                                                        <a href="/donate/make-a-contribution-2/"
                                                           class="component-card-post">
                                                            <div class="submenu-post-image lazyload"
                                                                 style="background-image:inherit"
                                                                 data-bg-image="url(&#039;https://www.judicialwatch.org/wp-content/uploads/2019/05/donate_btn.jpg&#039;)"></div>
                                                            <span class="title">    DONATE</span>
                                                        </a>
                                                    </div>
                                                    <div class="column column-card">
                                                        <a href="https://shopjw.org/?utm_source=Primary_JW_Website&amp;utm_content=Top_Header_Button"
                                                           target="_blank"
                                                           class="component-card-post">
                                                            <div class="submenu-post-image lazyload"
                                                                 style="background-image:inherit"
                                                                 data-bg-image="url(&#039;https://www.judicialwatch.org/wp-content/uploads/2019/05/shop_btn.jpg&#039;)"></div>
                                                            <span class="title">    SHOP</span>
                                                        </a>
                                                    </div>
                                                    <div class="column column-card">
                                                        <a href="/donate/the-verdict/"
                                                           class="component-card-post">
                                                            <div class="submenu-post-image lazyload"
                                                                 style="background-image:inherit"
                                                                 data-bg-image="url(&#039;https://www.judicialwatch.org/wp-content/uploads/2019/05/Judicial_FB_TheVerdict_300x169_v1.1-2.jpg&#039;)"></div>
                                                            <span class="title">    THE VERDICT</span>
                                                        </a>
                                                    </div>
                                                    <div class="column column-card">
                                                        <a href="/petitions/"
                                                           class="component-card-post">
                                                            <div class="submenu-post-image lazyload"
                                                                 style="background-image:inherit"
                                                                 data-bg-image="url(&#039;https://www.judicialwatch.org/wp-content/uploads/2019/11/petitions.jpg&#039;)"></div>
                                                            <span class="title">    SIGN NOW</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>

                    </ul>
                </nav>
                <div class="cs-header__col cs-header-justify-inherit">
                    <div class="cs-header__toggles ">
								<span class="cs-header__search-toggle" role="button" aria-label="Search">
			<i class="cs-icon cs-icon-search"></i>
		</span>
                    </div>
                    <a class="cs-button cs-header__custom-button"
                       href="<?php echo home_url(); ?>/donate/make-a-contribution-2/" target="_blank">
                        Donate </a>
                </div>
            </div>

        </div>


         <!-- Mobile Menu -->
        <div class="cs-header__inner cs-header__inner-mobile">
            <div class="cs-header__col cs-col-left">
						<span class="cs-header__burger-toggle " role="button" aria-label="Burger menu button">
					<i class="cs-icon cs-icon-menu"></i>
					<i class="cs-icon cs-icon-x"></i>
				</span>
                <span class="cs-header__offcanvas-toggle " role="button"
                      aria-label="Mobile menu button">
					<i class="cs-icon cs-icon-menu"></i>
				</span>

               <a href="<?php echo home_url(); ?>">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/assets/uploads/2024/05/judicial-watch-logo3.jpg"
                     alt="Judicial Watch">
                     </a>

            </div>
            <div class="cs-header__col cs-col-right">
				<span class="cs-header__search-toggle" role="button" aria-label="Search">
			<i class="cs-icon cs-icon-search"></i>
		</span>
                <a class="cs-button cs-header__custom-button cs-header__custom-button-mobile" href="<?php echo home_url(); ?>/donate/make-a-contribution-2/" target="_blank">
                    Donate </a>
            </div>
        </div>
         <!-- Mobile Menu -->


        <div class="cs-burger-menu">
            <div class="cs-container">
                <div class="cs-burger-menu__inner">
                    <div class="cs-burger-menu__nav">
                        <ul id="menu-burger-menu-1" class="cs-burger-menu__nav-menu ">
                            <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-145218 csco-menu-item-style-none">
                                EXPLORE NEWS
                                <ul class="sub-menu">
                                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-145631 csco-menu-item-style-none">
                                        <a href="<?php echo home_url(); ?>/tom-fittons-weekly-update/">TOM
                                            FITTON&#8217;S WEEKLY UPDATE</a></li>
                                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-145224 csco-menu-item-style-none">
                                        <a href="<?php echo home_url(); ?>/press-releases/">PRESS
                                            RELEASES</a></li>
                                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-145632 csco-menu-item-style-none">
                                        <a href="<?php echo home_url(); ?>/corruption-chronicles/">CORRUPTION
                                            CHRONICLES</a></li>
                                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-145633 csco-menu-item-style-none">
                                        <a href="<?php echo home_url(); ?>/in-the-news/">IN THE NEWS</a>
                                    </li>
                                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-145634 csco-menu-item-style-none">
                                        <a href="<?php echo home_url(); ?>/investigative-bulletin/">INVESTIGATIVE
                                            BULLETIN</a></li>
                                </ul>
                            </li>
                            <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-145630 csco-menu-item-style-none">
                                MEDIA &#038; RESOURCES
                                <ul class="sub-menu">
                                    <li class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-145202 csco-menu-item-style-none">
                                        <a href="<?php echo home_url(); ?>/jwtv/">VIDEOS</a></li>
                                    <li class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-145192 csco-menu-item-style-none">
                                        <a href="<?php echo home_url(); ?>/listennow/">PODCASTS</a>
                                    </li>
                                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-145219 csco-menu-item-style-none">
                                        <a href="<?php echo home_url(); ?>/documents/">DOCUMENTS</a>
                                    </li>
                                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-145219 csco-menu-item-style-none">
                                        <a href="<?php echo home_url(); ?>/map/">ELECTION INTEGRITY MAP</a></li>
                                </ul>
                            </li>
                            <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-145216 csco-menu-item-style-none">
                                TAKE ACTION &#038; GET INVOLVED
                                <ul class="sub-menu">
                                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-145220 csco-menu-item-style-none">
                                        <a href="<?php echo home_url(); ?>/donate/make-a-contribution-2/">DONATE</a>
                                    </li>
                                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-145217 csco-menu-item-style-none">
                                        <a href="<?php echo home_url(); ?>/petitions/">PETITIONS</a>
                                    </li>
                                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-145217 csco-menu-item-style-none">
                                        <a href="https://shopjw.org/">SHOP</a></li>
                                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-145222 csco-menu-item-style-none">
                                        <a href="<?php echo home_url(); ?>/petitions/thank-you/">GET OUR
                                            TEXT ALERTS</a></li>
                                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-145221 csco-menu-item-style-none">
                                        <a href="<?php echo home_url(); ?>/donate/the-verdict/">THE
                                            VERDICT</a></li>
                                </ul>
                            </li>
                            <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-145340 csco-menu-item-style-none">
                                ABOUT
                                <ul class="sub-menu">
                                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-145341 csco-menu-item-style-none">
                                        <a href="<?php echo home_url(); ?>/about#mission">MISSION</a>
                                    </li>
                                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-145341 csco-menu-item-style-none">
                                        <a href="<?php echo home_url(); ?>/about#legal">LEGAL</a></li>
                                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-145341 csco-menu-item-style-none">
                                        <a href="<?php echo home_url(); ?>/about#staff">TEAM</a></li>
                                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-145344 csco-menu-item-style-none">
                                        <a href="<?php echo home_url(); ?>/about#careers">CAREERS</a>
                                    </li>
                                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-145345 csco-menu-item-style-none">
                                        <a href="<?php echo home_url(); ?>/contact/">CONTACT</a></li>
                                </ul>
                            </li>
                            <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-145347 csco-menu-item-style-none">
                                INFORMATION
                                <ul class="sub-menu">
                                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-145346 csco-menu-item-style-none">
                                        <a href="<?php echo home_url(); ?>/amicus-briefs/">LAWSUITS
                                            &#038; LEGAL ACTIONS</a></li>
                                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-145349 csco-menu-item-style-none">
                                        <a href="<?php echo home_url(); ?>/open-records-laws-and-resources/">OPEN
                                            RECORDS LAW RESOURCES</a></li>
                                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-145350 csco-menu-item-style-none">
                                        <a href="<?php echo home_url(); ?>/public-education-the-international-program/">THE
                                            INTERNATIONAL PROGRAM</a></li>
                                </ul>
                            </li>

                        </ul>
                    </div>
                </div>

                <div class="cs-burger-menu__bottombar">
                    <div class="cs-social">
                    </div>
                    <div class="cs-burger-menu__bottombar-menu">
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
