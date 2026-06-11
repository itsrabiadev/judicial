<?php
/**
 * The template for displaying the footer layout
 *
 * @package Newsreader
 */


$top_header_link = get_top_header_link();
?>
<style>#gform_fields_6 { padding:0 !important;}.cs-site {margin-bottom: 0 !important;}</style>



<section class="component-daily-update-sticky no-printme">
    <div class="container section-content-container">
       <!-- <img src="/wp-content/themes/judicial-watch/assets/images/daily-update-logo.png" class="daily-update-logo">-->
        <label>Sign up <u>FREE</u> for the latest news and updates from America's #1 news source</label>
        <form class="field has-addons js-clonedNewsletterForm">
            <div class="control">
                <div class="validation-message"></div>
                <input class="input input-newsletter" type="email" placeholder="Email Address">
            </div>
            <div class="control">
                <button type="submit" class="button is-danger button-sub">
                    Subscribe
                </button>
            </div>
        </form>
        <!-- <div class="col-exit-component">
            <div class="exit-component">
                <span class="far fa-times"></span>
            </div>
        </div> -->
    </div>
</section>


<section class="footer no-printme">
    <div class="container section-content-container footer-container">
        <div class="columns is-multiline">
            <div class="column column-logo">
                <a href="/" title="Judicial Watch">
                    <img src="/wp-content/themes/judicial-watch/assets/images/logo-white.png"/>
                </a>
				<div class="column column-social social-footer">
					<a title="Twitter" href="https://twitter.com/JudicialWatch" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512" style="fill: #ffffff;">
                            <path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/>
                        </svg>
                    </a>
					<a title="Facebook" href="https://www.facebook.com/JudicialWatch" target="_blank">
						<i class="fa-brands fa-facebook"></i>
					</a>
					<a title="Youtube" href="https://www.youtube.com/user/JudicialWatch" target="_blank">
						<span class="fab fa-youtube"></span>
					</a>
					<a title="Instagram" href="https://www.instagram.com/judicialwatch" target="_blank">
						<span class="fab fa-instagram"></span>
					</a>
					
					<a title="Telegram" href="https://t.me/JudicialWatch" target="_blank">
						<span class="fab fa-telegram"></span> 
					</a>
					<a title="Gettr" href="https://www.gettr.com/user/JudicialWatch" target="_blank">
						<img src="/wp-content/themes/judicial-watch/assets/images/Gettr-icon.png"/>
					</a>
					
					<a title="Instagram" href="https://rumble.com/c/JudicialWatch" target="_blank">
						<img src="/wp-content/themes/judicial-watch/assets/images/Rumble-icon.png"/>
					</a><a title="Truth Social" href="https://truthsocial.com/@JudicialWatch" target="_blank">
						<img src="/wp-content/themes/judicial-watch/assets/images/Truth-icon.png"/> 
					</a>
				</div> 
            </div>
            <div class="column column-nav">
                <div class="link-list">
                    <?php  $menuItems = wp_get_nav_menu_items('footer');?>
                    <?php foreach($menuItems as $menuItem) : ?>
                
                        <a href="<?= $menuItem->url??'' ?>" class="link-list-item" title="<?= $menuItem->title??'' ?>">
                           <?= $menuItem->title??'' ?>
                        </a>
                   <?php endforeach?>
                </div>
                <div class="footnote">
                    <p>&copy; <?= date('Y')?> Judicial Watch, Inc.</p>
					<p style="padding: 10px 0;">
                        By providing your phone number, you are consenting to receive calls and recurring SMS/MMS messages, including autodialed and automated calls and texts, to that number from the Judicial Watch. Msg&amp;data rates may apply. Reply HELP for help, STOP to end. Terms &amp; conditions/<a href="https://tandcs.us/jwi" target="_blank" style="color: #ffffff;">privacy policy apply. </a>

                    </p>
                    <p>
                        Judicial Watch is a 501(c)(3) nonprofit organization. Contributions are received from
                        individuals,
                        foundations, and corporations and are tax-deductible to the extent allowed by law.
                    </p>
                </div>
            </div>
            <div class="column column-buttons">
                <a href="https://shopjw.org" class="button button-primary is-inverted" title="Shop JW">Shop</a>
                <a href="/donate/make-a-contribution-2/" class="button button-primary is-inverted">Donate</a>
            
            </div>
        </div>
    </div>
</section>


<nav class="component-mobile-footer-nav no-printme">
    <div class="columns is-0 is-mobile">
        <a href="/" class="column nav-item">
            <span class="fa fa-home"></span>
            Home
        </a>
        <a href="/?taxonomy=category" class="column nav-item">
            <span class="fa fa-newspaper"></span>
            News
        </a>
        <a href="/jwtv" class="column nav-item">
            <span class="fa fa-tv"></span>
            JWTV
        </a>
        <a href="https://shopjw.org/" class="column nav-item">
            <span class="fa fa-shopping-cart"></span>
            Store
        </a>
        <a href="/donate/make-a-contribution-2/" class="column nav-item">
            <span class="fa fa-credit-card"></span>
            Donate
        </a>
    </div>
</nav>


<div class="visually-hidden component-newsletterForm no-printme" style="display:none">
   <?php 
   $html = gravity_form(
            // ID
            6,
            // Show title
            false,
            // Show description
            false,
            // Display inactive
            false,
            // Field values
            null,
            // Is Ajax
            true,
            // Tab index
            50,
            // Echo
            false
        );
   ?>
   <?php echo $html?>
</div>


