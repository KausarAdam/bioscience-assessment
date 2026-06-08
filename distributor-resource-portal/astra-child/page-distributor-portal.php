<?php
/* Template Name: Distributor Resource Portal */
get_header();

if (post_password_required()) {
    echo get_the_password_form();
    get_footer();
    return;
}
?>

<div class="resource-portal" style="padding:40px; max-width:1200px;">

    <?php
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => -1
    );

    $query = new WP_Query($args);

    $grouped = [];

    if ($query->have_posts()):
        while ($query->have_posts()):
            $query->the_post();

            $file_url = get_field('file_url');

            if (empty($file_url)) {
                continue;
            }

            $categories = get_the_category();
            $cat_name = !empty($categories) ? $categories[0]->name : 'Uncategorized';

            $grouped[$cat_name][] = array(
                'title' => get_the_title(),
                'url' => $file_url
            );

        endwhile;
        wp_reset_postdata();
    endif;

    if (!empty($grouped)):

        foreach ($grouped as $category => $items):
            ?>

            <div class="category-section" style="margin-bottom:40px;">

                <h2 style="font-size:22px; margin-bottom:15px; border-left:4px solid #333; padding-left:10px;">
                    <?php echo esc_html($category); ?>
                </h2>

                <div style="display:flex; flex-direction:column; gap:12px;">

                    <?php foreach ($items as $item): ?>

                        <div class="resource-card"
                            style="border:1px solid #e5e5e5; border-radius:10px; padding:20px; background:#fff; transition:0.2s ease;">

                            <h3 style="font-size:16px; margin-bottom:10px;">
                                <?php echo esc_html($item['title']); ?>
                            </h3>

                            <a href="<?php echo esc_url($item['url']); ?>" target="_blank" class="download-btn"
                                style="display:inline-block; padding:8px 12px; background:#111; color:#fff; border-radius:6px; text-decoration:none;">
                                Download
                            </a>

                        </div>

                    <?php endforeach; ?>

                </div>
            </div>

            <?php
        endforeach;

    else:
        echo "<p>No resources found.</p>";
    endif;
    ?>

</div>

<?php get_footer(); ?>