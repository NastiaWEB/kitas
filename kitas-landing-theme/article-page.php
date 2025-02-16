<?php
/**
 * Template name: Article Page
 */

 get_header();

 ?>
<body>

<?php
  $current_post_id = get_the_ID(); // Get the ID of the current post

  $args = array(
      'numberposts' => 2,
      'post__not_in' => array($current_post_id) // Exclude the current post
  );
  
  $listLatestPosts = get_posts($args);

//   Custom breadcrumbs

  function custom_breadcrumbs() {
    $delimiter = ' » '; // Delimiter between breadcrumbs
    $home = 'Home'; // Home text
    $before = '<span class="current">'; // Tag before the current crumb
    $after = '</span>'; // Tag after the current crumb

    echo '<a href="' . home_url() . '">' . $home . '</a>' . $delimiter; // Home link


    if (is_single()) {
        echo $before . get_the_title() . $after; // Current post title
    } 
}

//Custom Table of Contents

function generate_table_of_contents() {
    global $post;

    $content = $post->post_content;
    $pattern = '/<h2[^>]*>(.*?)<\/h2>/';
    preg_match_all($pattern, $content, $matches);

    if ($matches && isset($matches[1])) {
        echo '<ul class="toc-lists">';
        foreach ($matches[1] as $match) {
            // Use the heading text directly as the ID for the anchor link
            $id = strtolower(str_replace(' ', '-', $match)); // Convert spaces to hyphens
            echo '<li class="table-of-content-lists"><a href="#' . $id . '">' . $match . '</a></li>';
        }
        echo '</ul>';
    }
}

function add_ids_to_headings($content) {
    return preg_replace_callback('/<h[2-4][^>]*>(.*?)<\/h[2-4]>/s', function($matches) {
        $heading_content = $matches[1];
        // Generate ID using sanitize_title
        $id = sanitize_title($heading_content);
        return '<h2 id="' . $id . '">' . $heading_content . '</h2>';
    }, $content);
}


?>

<main>
   <?php while( have_posts() ): ?>
        <?php the_post(); ?>
    
        <div class="main-container with-sidebar">       
            <div class="sidebar">
                    
            </div>
            
            <div class="main-content main-content-article-page">
                <div class="breadcrumbs">
                    <?php
                        custom_breadcrumbs();
                    ?>
                </div>

                <div class="article-main-info">
                    <div class="main-article-heading">
                        <?php the_title(); ?>                        
                    </div>

                    <?php
                        $article_description = get_the_excerpt($post);
                            if ($article_description) {
                                echo '<div class="meta-description">' . $article_description;
                                echo '</div>';
                            }
                    ?>

                    <div class="article-data-author-info">
                        <div class="article-author-info">
                            <?php 
                                $author_id = get_post_field( 'post_author', $post );
                                $author_name = get_the_author_meta( 'display_name', $author_id );
                                $author_avatar = get_avatar_url( $author_id, array( 'size' => 26 ) );
                            ?>
                            <img class="avatar" src="<?php echo $author_avatar; ?>" alt="<?php echo $author_name; ?>">
                                <p class="author-name-article">
                                <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
                            <?php echo $author_name; ?></a></p>
                        </div>
    
                        <div class="article-page-data-info">
                            <?php
                                $post_date = get_the_date('j M, Y', $post);
                                echo '<p>' . $post_date . '</p>';
                            ?>
                        </div>
                    </div>
                </div>

                <div class="featured-image">
                    <?php
                        if (has_post_thumbnail($post)) {
                            echo '<img class="post-featured-image post-images" src="' . get_the_post_thumbnail_url($post) . '" alt="">';
                        }
                    ?>
                </div>

                <div class="table-of-content">
                    <div class="table-of-content-header">
                        <h2 class="table-of-content-heading">Contents</h2>
                        <div class="table-of-content-arrow" onclick="myFunction()">
                        </div>
                    </div>

                    <div class="tableOfContent-content show" id="tableOfContent-popup">   
                        <?php generate_table_of_contents(); ?>
                    </div>
                </div>

                <div class="article-content">
                <?php
                    // Get the post content
                    $content = apply_filters('the_content', get_the_content());

                    // Add classes to paragraphs
                    $content = str_replace('<p>', '<p class="article-paragraph">', $content);

                    // Add IDs to headings and preserve custom classes
                    $content = preg_replace_callback('/<h2 class="wp-block-heading">(.*?)<\/h2>/s', function($matches) {
                        $heading_content = $matches[1];
                        $id = strtolower(str_replace(' ', '-', $heading_content));
                        return '<h2 class="h2-article-content" id="' . $id . '">' . $heading_content . '</h2>';
                    }, $content);

                    $content = preg_replace_callback('/<h3 class="wp-block-heading">(.*?)<\/h3>/s', function($matches) {
                        $heading_content = $matches[1];
                        $id = strtolower(str_replace(' ', '-', $heading_content));
                        return '<h3 class="h3-article-content" id="' . $id . '">' . $heading_content . '</h3>';
                    }, $content);

                    $content = preg_replace_callback('/<h4 class="wp-block-heading">(.*?)<\/h4>/s', function($matches) {
                        $heading_content = $matches[1];
                        $id = strtolower(str_replace(' ', '-', $heading_content));
                        return '<h4 class="h4-article-content" id="' . $id . '">' . $heading_content . '</h4>';
                    }, $content);

                    // Add classes to images and captions
                    $content = str_replace('<div class="wp-block-image">', '<div class="post-image-content">', $content);
                    $content = str_replace('<figcaption', '<figcaption class="image-caption"', $content);

                    // Apply the_content filter
                    $content = apply_filters('the_content', $content);

                    echo $content
        ?>
                </div>

                <div class="article-tags">
                    <?php
                        $post_categories = get_the_category($post);
                            if ($post_categories) {
                                foreach ($post_categories as $categories) {
                                        echo '<div class="top-tag color-light-blue">';
                                        echo '<a href="' . esc_url(get_category_link($categories->term_id)) . '" class="text-color-teal">' . $categories->name . '</a>';
                                        echo '</div>';
                                }
                            }
                    ?>
                </div>

                <div class="recommendation-section">
                    <h2 class="h2-article-content">Recommended by Carejobs</h2>
                    <div class="article-columns article-columns-inside-post">
                        <?php
                        foreach ($listLatestPosts as $post) {
                            ?>
                            <div class="article-column">
                                <div class="column-article-pic">
                                    <?php
                                    $imageColumnLink = get_permalink($post);
                                        if ($imageColumnLink) {
                                            echo '<a href="' . $imageColumnLink . '">';
                                        }

                                        if (has_post_thumbnail($post)) {
                                                echo '<img class="article-pic-column" src="' . get_the_post_thumbnail_url($post) . '" alt="">';
                                        }

                                        if($imageColumnLink) {
                                            echo '</a>';
                                        }
                                    ?>
                                </div>
                                <div class="article-tags">
                                        <?php
                                            $post_categories = get_the_category($post);
                                                if ($post_categories) {
                                                foreach ($post_categories as $categories) {
                                                        echo '<div class="top-tag color-light-blue">';
                                                        echo '<a href="' . esc_url(get_category_link($categories->term_id)) . '" class="text-color-teal">' . $categories->name . '</a>';
                                                        echo '</div>';
                                                    }
                                                }
                                        ?>
                                    </div>
                                    <div class="article-info">
                                        <div class="article-title">
                                        <h1 class="heading-for-article-column">
                                        <?php 
                                            $titleColumnLink = get_permalink($post);
                                            if ($titleColumnLink) {
                                                echo '<a href="' . $titleColumnLink . '">';
                                            }
                                            echo get_the_title($post); 
                                            if ($titleColumnLink) {
                                                echo '</a>';
                                            }
                                        ?>
                                            </h1>
                                        </div>

                                        <div class="article-description">
                                            <?php
                                                $article_description = get_the_excerpt($post);
                                                $article_descriptionLink = get_permalink($post);

                                                if ($article_descriptionLink) {
                                                    echo '<a href="' . $article_descriptionLink . '">';
                                                }

                                                if ($article_description) {
                                                    echo '<div class="article-description">';
                                                    echo '<p class="text-description">' . $article_description;
                                                    echo '</p></div>';
                                                }

                                                if ($article_description) {
                                                    echo '</a>';
                                                }
                                            ?>                            
                                        </div>

                                        <?php 
                                            $article_read_more = get_permalink($post);
                                            if ($article_read_more) {
                                                echo '<p class="article-read-more">' ;
                                                echo '<a href="' . $article_read_more . '">Read more</a>';
                                                echo '</p>';
                                            }
                                        ?>
                                        
                                        <div class="article-data-author-info">
                                            <div class="article-author-info">
                                                <?php 
                                                    $author_id = get_post_field( 'post_author', $post );
                                                    $author_name = get_the_author_meta( 'display_name', $author_id );
                                                    $author_avatar = get_avatar_url( $author_id, array( 'size' => 20 ) );
                                                ?>
                                                <img src="<?php echo $author_avatar; ?>" alt="<?php echo $author_name; ?>">
                                                <p class="author-name">
                                                <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>">
                                                <?php echo $author_name; ?></a></p>
                                            </div>

                                            <div class="article-data-info">
                                                <?php
                                                    $post_date = get_the_date('j M, Y', $post);
                                                    echo '<p>' . $post_date . '</p>';
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php
                        }      
                    ?>
                    </div>
                    <button class="button-see-all-articles light-blue">
                    <a class="button-link" href="http://104.131.170.77/blog/">See all articles</a>
                    </button> 
                </div>
            </div>
            
        </div>

        
    <?php endwhile; ?>
</main>
<?php
get_footer();
?>
<div class="modal" id="applicationModal">
    <div class="modal-content" id="applicationForm">
        <div class="modal-header">
            <h2>
                <?php echo get_field('application_form_title', 'options'); ?>
            </h2>
            <span class="close">&times;</span>
        </div>
        <?php
        if (is_user_logged_in()) {
            echo do_shortcode('[cf7form cf7key="apply" form destination-email=""]');
        } else {
            echo do_shortcode('[login-with-ajax registration="1"]');
        }
        ?>
    </div>
</div>