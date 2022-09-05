<?php
require_once VIEWS . "/templates/header.php";
?>

<body class="is-boxed has-animations">
    <div class="body-wrap boxed-container">
        <ul style="list-style-type: none;">
            <a href="<?php echo CURRENT_PATH; ?>" style='width:128px;'><img src="<?php echo env('APP_LOGO'); ?>"
                    width="128" style='padding:25px;'></a>
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
            <?php show_flash_message(); ?>
            <?php if ($articleData['status'] === 200) { ?>
            <p class="features section">
            <div class="container">
                <div class="features-inner section-inner has-bottom-divider">
                    <div class="features-wrap">
                        <div class="text-left">Written by <?php echo $articleData['data']['article']['author']; ?>
                            about <?php echo get_time_diff($articleData['data']['article']['creationdate']); ?>
                        </div>
                        <div class="feature is-revealing">
                            <div class="feature-inner">
                                <h3 class="feature-title">
                                    <?php echo $articleData['data']['article']['articleSubject']; ?></h3>
                                <p class="text-center">
                                    <img src="<?php echo $articleData['data']['article']['articleImage']; ?>"
                                        width="350" class="img img-rounded text-center">
                                </p>
                                <p class="text-sm"><?php echo $articleData['data']['article']['articleContent']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container" style="margin-left: 5%">Comments</div>
            <?php
                if (count($articleData['data']['comments']) > 0) {
                    foreach ($articleData['data']['comments'] as $key => $value) {
                ?>
            <div class="container" style="margin-left: 10%">
                <div class="features-inner section-inner has-bottom-divider">
                    <div class="features-wrap">
                        <div class="text-left">Written by
                            <?php echo $value['authorName'] . " about " . get_time_diff($value['creationdate']); ?>
                            &nbsp;
                            <?php if (sessions()->has('userId') && (int) sessions()->get('userId') === $value['author']) { ?>
                            <a href="<?php echo CURRENT_PATH . "/delete-comment/" . $value['id']; ?>">
                                <img src="https://cdn-icons-png.flaticon.com/512/6861/6861362.png" width="16"
                                    height="16" alt="delete" title="delete" class="img-small text-right"
                                    style="float: right;">
                            </a>
                            <a
                                href="<?php echo CURRENT_PATH . "/comment/" . $value['id'] . "/" . $articleData['data']['article']['articleId'] ?>">
                                <img src="https://cdn-icons-png.flaticon.com/512/420/420140.png" width="16" height="16"
                                    alt="edit" title="edit" class="img-small text-right" style="float: right;">
                            </a>
                            <?php } ?>
                        </div>
                        <div class="feature is-revealing">
                            <div class="feature-inner">
                                <p class="text-sm"><?php echo $value['comment']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                    }
                }
                ?>
            <?php if (sessions()->has('userId')) { ?>
            <div class="text-center">
                <form action="<?php echo CURRENT_PATH; ?>/comment" method="POST" enctype="multipart/form-data">
                    <p>
                        <input type="hidden" name="article_id" id="article_id"
                            value="<?php echo $articleData['data']['article']['articleId']; ?>" />
                        <input type="hidden" name="redirect" id="redirect" value="<?php echo CURRENT_PATH_FULL; ?>" />
                        <textarea name="comment" id="comment" cols="50" rows="5" placeholder="leave comment"></textarea>
                    </p>
                    <p>
                        <input type="submit" value="save comment">
                    </p>
                </form>
            </div>
            <?php } ?>
            <?php } else { ?>
            <p class="alert alert-danger text-center">no data to display</p>
            <?php } ?>
        </main>

        <?php
        require_once VIEWS . "/templates/footer.php";
        ?>