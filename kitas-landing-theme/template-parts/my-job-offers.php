<?php
/**
 * Template name: My job offers
 */
get_header();

$current_tab = '';

switch ($path) {
    case '/my-job-offers/':
        $current_tab = 'my-job-offers';
        break;
    case '/applicants/':
        $current_tab = 'applicants';
        break;
    default:
        $current_tab = 'my-job-offers';
        break;
}

$tabs = [
    'my-job-offers' => ['name' => 'My job offers', 'url' => '/my-job-offers/'],
    'Applicants' => ['name' => 'Applicants', 'url' => '/applicants/'],
];



?>


<main id="primary" class="site-main">
    <div class="main-container my-job-offers">

        <div class="main-head-block">
            <div class="head-block-left-choice">
                <?php foreach ($tabs as $tab_key => $tab): 
                    $count_class = "count-$tab_key";?>
                    <a href="<?php echo $tab['url']; ?>"
                        class="choice-option <?php echo ($current_tab === $tab_key) ? 'active' : ''; ?>">
                        <span><?php echo $tab['name']; ?></span>
                        <span class="count-tab <?= $count_class ?>">0</span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
</main>


<?php
get_footer();
