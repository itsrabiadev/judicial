<?php
/**
 * Partial: Date and Source (Category + Date + Tags)
 *
 * Expects $args['post'] to contain category, date, and tagged properties.
 */

if (!isset($args['data'])) {
    return;
}

$data = $args['data'];

// ✅ Category
if (!empty($data['source'])) : ?>
    <a href="<?php echo esc_url($data['source']['link']); ?>">
        <?php echo esc_html($data['source']['name']); ?>
    </a>
    <span class="datesource-spacer">|</span>
<?php endif; ?>

<?php // ✅ Date ?>
<?php echo esc_html(get_the_date('', $data['postId'])); ?>

<?php
// ✅ Tags (already limited to 3 in controller)
if (!empty($data['tagged']) && is_iterable($data['tagged'])) : ?>
    <div class="post-tagged">
        <span class="post-tagged-label">Tagged:</span>
        <?php foreach ($data['tagged'] as $tagged) : ?>
            <a class="post-tagged-item" href="<?php echo get_term_link($tagged, 'document_tags') ?>">
                <?php echo esc_html($tagged->name); ?>
            </a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<hr class="m-b-10">
