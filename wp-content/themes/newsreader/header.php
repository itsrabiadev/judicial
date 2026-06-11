<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "cs-site" div.
 *
 * @package Newsreader
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta name="facebook-domain-verification" content="zo38yzhfkkihsrm9a2s3b4gf6piltr" />
	<meta charset="<?php bloginfo('charset'); ?>" />
	 <meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<!-- Google Tag Manager -->
	<script>(function (w, d, s, l, i) {
			w[l] = w[l] || []; w[l].push({
				'gtm.start':
					new Date().getTime(), event: 'gtm.js'
			}); var f = d.getElementsByTagName(s)[0],
				j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src =
					'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f);
		})(window, document, 'script', 'dataLayer', 'GTM-TZW2BDR');</script>
	<!-- End Google Tag Manager -->

	<!-- Global site tag (gtag.js) - Google Ads: 967049505 -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=AW-967049505"></script>
	<script> window.dataLayer = window.dataLayer || []; function gtag() { dataLayer.push(arguments); } gtag('js', new Date()); gtag('config', 'AW-967049505');

	</script>
	<!-- Google Tag Manager SuccessDonation page -->
	<script>
		if (window.location.pathname == '/thanks-for-your-donation/') {
			gtag('event', 'conversion', { 'send_to': 'AW-967049505/1eVGCLfO-mQQoYKQzQM' });
		}
	</script>
	<!-- End Google Tag Manager tag -->

	<!-- standard GA code -->
	<script>
		(function (i, s, o, g, r, a, m) {
			i['GoogleAnalyticsObject'] = r; i[r] = i[r] || function () {
				(i[r].q = i[r].q || []).push(arguments)
			}, i[r].l = 1 * new Date(); a = s.createElement(o),
				m = s.getElementsByTagName(o)[0]; a.async = 1; a.src = g; m.parentNode.insertBefore(a, m)
		})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

		ga('create', 'UA-3032650-3', 'auto');
		ga('send', 'pageview');
	</script>

	<!-- GA Ecommerce tracking script code -->

	<script>
		if (window.location.pathname == '/thanks-for-your-donation/') {

			// enable the ecommerce features
			ga('require', 'ecommerce');

			var donationData = localStorage.getItem('donationResponseData');
			donationData = JSON.parse(donationData);

			// start the transaction

			ga('ecommerce:addTransaction', {
				'id': donationData.trans_id,
				'affiliation': 'Donation',
				'revenue': donationData.amount,
				'shipping': '0.00',
				'tax': '0.00'
			});

			// add item

			ga('ecommerce:addItem', {
				'id': donationData['trans_id'],
				'name': 'Judicial Watch',
				'sku': donationData.trans_id,
				'category': 'donation',
				'price': donationData.amount,
				'quantity': '1'
			});

			// send transaction

			ga('ecommerce:send');

			// clear ecommercce data

			ga('ecommerce:clear');

			localStorage.removeItem('donationResponseData');

		}
	</script>

	
	<?php wp_head(); ?>


</head>

<body <?php body_class(); ?> <?php csco_site_scheme(); ?>>

<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TZW2BDR"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
	<?php if (is_page('jwtv') || is_singular('videos')): ?>
		<div class="page-jwtv-bg lazyloaded"></div>
	<?php endif; ?>
	<div class="cs-wrapper">

		<?php
		if (function_exists('wp_body_open')) {
			wp_body_open();
		}
		?>

		<?php
		/**
		 * The csco_site_before hook.
		 *
		 * @since 1.0.0
		 */
		do_action('csco_site_before');
		?>

		<div id="page" class=""><!-- cs-site -->

			<?php
			/**
			 * The csco_site_start hook.
			 *
			 * @since 1.0.0
			 */
			do_action('csco_site_start');
			?>

			<div class="cs-site-inner">

				<?php
				/**
				 * The csco_header_before hook.
				 *
				 * @since 1.0.0
				 */
				do_action('csco_header_before');
				?>

				<?php get_template_part('template-parts/header'); ?>

				<?php
				/**
				 * The csco_header_after hook.
				 *
				 * @since 1.0.0
				 */
				do_action('csco_header_after');
				?>

				<main id="main" class="cs-site-primary <?php echo is_page('jwtv') ? 'page-jwtv-index' : '' ?>">

					<?php get_template_part('template-parts/partials/banner') ?>
					<?php if (is_page('jwtv')): ?>
						<div class="modal modal-video">
							<div class="modal-background"></div>
							<div class="modal-content">
								<iframe src="" frameborder="0" allow="autoplay; encrypted-media"
									class="js-play-featured-video" allowfullscreen></iframe>
							</div>
							<button class="modal-close is-large" aria-label="close"></button>
						</div>
					<?php endif; ?>
					<?php
					/**
					 * The csco_site_content_before hook.
					 *
					 * @since 1.0.0
					 */
					do_action('csco_site_content_before');
					?>

					<div <?php csco_site_content_class(); ?>>

						<?php
						/**
						 * The csco_site_content_start hook.
						 *
						 * @since 1.0.0
						 */
						do_action('csco_site_content_start');
						?>

						<div class="cs-container">

							<?php
							/**
							 * The csco_main_content_before hook.
							 *
							 * @since 1.0.0
							 */
							do_action('csco_main_content_before');
							?>

							<div id="content" class="cs-main-content">

								<?php
								/**
								 * The csco_main_content_start hook.
								 *
								 * @since 1.0.0
								 */
								do_action('csco_main_content_start');
								?>