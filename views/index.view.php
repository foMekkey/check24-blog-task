<?php
require_once VIEWS . "/templates/header.php";
?>

<body class="is-boxed has-animations">
    <div class="body-wrap boxed-container">
        <a href="<?php echo CURRENT_PATH; ?>" style='width:128px;'><img src="<?php echo env('APP_LOGO'); ?>" width="128"
                style='padding:25px;'></a>
        <ul style="list-style-type: none;">
            <li><a href="<?php echo CURRENT_PATH; ?>">Home</a></li>
            <?php if (!sessions()->has('userId')) { ?>
            <li><a href="<?php echo CURRENT_PATH; ?>/login">Login</a></li>
            <li><a href="<?php echo CURRENT_PATH; ?>/register">Register</a></li>
            <?php } else { ?>
            <li><a href="<?php echo CURRENT_PATH; ?>/logout">logout</a></li>
            <li><a href="<?php echo CURRENT_PATH; ?>/article">add article</a></li>
            <?php } ?>
        </ul>
        <main>
            <?php
            if ($articlesList['status'] === 200) {
                foreach ($articlesList['data']['articles'] as $key => $value) {
                    $articleId = $value['articleId'];
            ?>
            <p class="features section text-center">
            <div class="container">
                <div class="features-inner section-inner has-bottom-divider">
                    <div class="features-wrap">
                        <a href="<?php echo CURRENT_PATH . "/article/$articleId"; ?>">
                            <div class="feature is-revealing">
                                <div class="feature-inner">
                                    <?php echo "written by " . $value['author'] . " about " . get_time_diff($value['creationdate']); ?>
                                    <h3 class="feature-title"><?php echo $value['articleSubject']; ?></h3>
                                    <p class="text-center">
                                        <img src="<?php echo $value['articleImage']; ?>" width="350"
                                            class="img img-rounded text-center">
                                    </p>
                                    <p class="text-sm">
                                        <?php echo strlen($value['articleContent']) > MAX_TEXT_LENGTH ? substr($value['articleContent'], 0, MAX_TEXT_LENGTH) . "... <a href='" . CURRENT_PATH . "/article/'" . $value['articleId'] . ">More</a>" : $value['articleContent']; ?>
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            </p>
            <ul>
                <?php paginator_links($articlesList['data']['paginator']['total_pages'], $start); ?>
            </ul>
            <?php } ?>
            <?php } else {
                echo "<p class='text-center' style='color:red;'>no data to display </p>";
            } ?>
        </main>
    </div>

    <?php
    require_once VIEWS . "/templates/footer.php";
    ?>