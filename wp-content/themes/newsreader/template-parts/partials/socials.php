<?php if ( is_singular() && !is_singular( array( 'donation_pages', 'petitions','page' ) ) ): ?>
    <div class="column-social-widget component-social-share-widget no-printme">
        <div class="component-title">Share:</div>
        <div class="social-links">
            <?php
            $share_url = urlencode(get_permalink());
            $share_title = urlencode(get_the_title());
            ?>
            <!-- Twitter -->
            <a target="_blank" class="social-link"
               href="https://twitter.com/intent/tweet?text=<?php echo $share_title; ?>&url=<?php echo $share_url; ?>">
                        <span class="twitter-social"><img
                                src="/wp-content/themes/judicial-watch/assets/images/twitter.png"></span>
            </a>

            <!-- Facebook -->
            <a target="_blank" class="social-link"
               href="https://facebook.com/sharer.php?u=<?php echo $share_url; ?>">
                        <span class="facebook-social"><img
                                src="/wp-content/themes/judicial-watch/assets/images/facebook.png"></span>
            </a>

            <!-- Reddit -->
            <a target="_blank" class="social-link"
               href="http://www.reddit.com/submit?url=<?php echo $share_url; ?>">
                        <span class="facebook-social"><img
                                src="/wp-content/themes/judicial-watch/assets/images/reddit.png"></span>
            </a>

            <!-- LinkedIn -->
            <a target="_blank" class="social-link"
               href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $share_url; ?>">
                        <span class="facebook-social"><img
                                src="/wp-content/themes/judicial-watch/assets/images/linkedin.png"></span>
            </a>

            <!-- Telegram -->
            <a target="_blank" class="social-link"
               href="https://telegram.me/share/url?url=<?php echo $share_url; ?>">
                        <span class="facebook-social"><img
                                src="/wp-content/themes/judicial-watch/assets/images/talegram-logo.png"></span>
            </a>

            <!-- Gettr -->
            <a target="_blank" class="social-link" href="https://gettr.com/share?url=<?php echo $share_url; ?>">
                        <span class="facebook-social"><img
                                src="/wp-content/themes/judicial-watch/assets/images/Gettr-logo.png"></span>
            </a>

            <!-- Gmail -->
            <a class="social-link"
               href="mailto:?subject=<?php echo str_replace('+', ' ', $share_title); ?>&body=<?php echo $share_url; ?>">
                <span class="gmail-social"><img src="/wp-content/themes/judicial-watch/assets/images/gmail.png"></span>
            </a>

            <!-- Print -->
            <a class="social-link" href="javascript:window.print()">
                <span class="print-social"><img src="/wp-content/themes/judicial-watch/assets/images/print.png"></span>
            </a>
        </div>
    </div>
<?php endif; ?>