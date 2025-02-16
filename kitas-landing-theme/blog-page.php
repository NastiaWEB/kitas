<?php
/**
 * Template name: Blog Page
 */

 get_header();
 ?>
 <?php

    // Latest Post
    $latestPosts = wp_get_recent_posts(['numberposts' => 1]);
    $latestPost = $latestPosts ? current($latestPosts) : null;

    // Get the ID of the post displayed in the "big-article" section
    $bigArticlePostID = $latestPost ? $latestPost['ID'] : null;

    // Previous Latest Posts excluding the post in the big-article section
    $listLatestPosts = get_posts(array(
        'numberposts' => 3,
        'exclude' => $bigArticlePostID // Exclude the post in the big-article section
    )); 

    // Other Posts
    $latestPostIds = wp_list_pluck($latestPosts, 'ID');
    $previousLatestPostIds = wp_list_pluck($listLatestPosts, 'ID');
    $excludeIds = array_merge($latestPostIds, $previousLatestPostIds);
    $otherPostsQuery = new WP_Query(array(
        'post__not_in' => $excludeIds,
        'posts_per_page' => 3 // Number of posts to display
    ));
 ?>
 <body>

 <main>
    <?php while( have_posts() ): ?>
            <?php the_post(); ?>

        <div class="main-container">
        <!-- <div class="sidebar"></div> -->
            <div class="main-content">
                <div class="start-of-section">
                    <div class="heading">
                        <h2 class="h2-blog-page">Blog</h2>
                    </div>
                    <div class="article-blog-category">
                        <ul class="blog-category">
                            <li>All articles</li>
                            <li>News</li>
                            <li>Education</li>
                            <li>Interviews</li>
                            <li>Salary</li>
                        </ul>
                    </div>
                </div>

                <!-- php code big article -->
                <div class="big-article">
                    
                    <div class="big-article-pic">

                        <?php 
                            $imageLink = get_permalink($latestPost['ID']);
                            if ($imageLink) {
                                echo '<a href="' . $imageLink . '">';
                            }

                            if (has_post_thumbnail($latestPost['ID'])) {
                                echo '<img class="article-pic" src="' . get_the_post_thumbnail_url($latestPost['ID']) . '" alt="">';
                            }

                            if ($imageLink) {
                                echo '</a>';
                            }
                        ?>
                    </div>

                    <div class="big-article-content">
                        <div class="article-tags">
                            <!-- category -->
                        <?php
                            $post_categories = get_the_category($latestPost['ID']);
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
                            <!-- title info -->
                            <?php
                                $article_title = get_the_title($latestPost['ID']);
                                $titleLink = get_permalink($latestPost['ID']);

                                if ($titleLink) {
                                    echo '<a href="' . $titleLink . '">';
                                }

                                if ($article_title) {
                                    echo '<div class="article-title">';
                                    echo '<h1 class="main-heading">' . $article_title;
                                    echo '</h1></div>';
                                }

                                if($titleLink) {
                                    echo '</a>';
                                }
                            ?>
                            <div class="post-preview">
                                <!-- description info -->
                                    <?php
                                        $article_description = get_the_excerpt($latestPost['ID']);
                                        $descriptionLink = get_permalink($latestPost['ID']);

                                        if ($descriptionLink) {
                                            echo '<a href="' . $descriptionLink . '">';
                                        }

                                        if ($article_description) {
                                            echo '<div class="article-description">';
                                            echo '<p class="text-description">' . $article_description;
                                            echo '</p></div>';
                                        }

                                        if($descriptionLink) {
                                            echo '</a>';
                                        }
                                    ?>

                                <div class="big-article-data-author-info">
                                    <!-- author info -->
                                    <div class="article-author-info">
                                    
                                        <?php 
                                            $author_id = get_post_field( 'post_author', $latestPost['ID'] );
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
                                            $post_date = get_the_date('j M, Y', $latestPost['ID']);
                                            echo '<p>' . $post_date . '</p>';
                                        ?>
                                    </div>
                                </div>
                            </div>
        
                        </div>
                    </div>

                </div>

                <div class="article-columns">
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

                                <div class="article-tags-info">
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

                                        <div class="post-preview">
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


                                            <div class="article-footer">
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
                                        </div>
                                    </div>
                                </div>
                            <?php
                        }      
                    ?>
                </div>

                
                <div class="discover-more-section">
                <h2 class="secondary-heading">Discover more</h2>
                    <div class="discover-more-articles">
                        <?php
                            while ($otherPostsQuery->have_posts()) {
                                $otherPostsQuery->the_post();
                        ?>
                         
                        <div class="row-article">
                            <div class="row-article-pic">
                                <?php
                                 $imageLink = get_permalink($post);
                                    if ($imageLink) {
                                        echo '<a href="' . $imageLink . '">';
                                    }

                                    if (has_post_thumbnail($post)) {
                                            echo '<img class="article-pic-small" src="' . get_the_post_thumbnail_url($post) . '" alt="">';
                                    }

                                    if ($imageLink) {
                                        echo '</a>';
                                    }
                                ?>
                            </div>
            
                            <div class="row-article-content">
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
                
                                <!-- <div class="article-info"> -->
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

                                    <div class="post-preview">
            
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
                                <!-- </div> -->

                            </div>   
                        </div>
                        <?php
                        }      
                    ?>
                    </div>

                    <div class="tags-section">
                        <p class="bold tags-section-heading">Discover more</p>

                        <div class="article-tags discover-more-tags">
                            <?php
                                $post_categories = get_categories($post);
                                    if ($post_categories) {
                                        foreach ($post_categories as $categories) {
                                                echo '<div class="top-tag color-light-blue">';
                                                echo '<a href="' . esc_url(get_category_link($categories->term_id)) . '" class="text-color-teal">' . $categories->name . '</a>';
                                                echo '</div>';
                                            }
                                    }
                            ?>
                        </div>
                    </div>
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



