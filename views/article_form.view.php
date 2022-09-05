<?php
require_once VIEWS . "/templates/header.php";
?>

<body class="is-boxed has-animations">
    <div class="body-wrap boxed-container">
        <header>
            <div class="body-wrap boxed-container">
                <a href="<?php echo CURRENT_PATH; ?>" style='width:128px;'><img src="<?php echo env('APP_LOGO'); ?>"
                        width="128" style='padding:25px;'></a>
                <ul style="list-style-type: none;">
                    <li><a href="<?php echo CURRENT_PATH; ?>">Home</a></li>
                    <?php if (!sessions()->has('userId')) { ?>
                    <li><a href="<?php echo CURRENT_PATH; ?>/register">Register</a></li>
                    <?php } else { ?>
                    <li><a href="<?php echo CURRENT_PATH; ?>/logout">logout</a></li>
                    <?php } ?>
                </ul>
            </div>
        </header>
        <main>
            <section class="features section text-center">
                <div class="container">
                    <?php show_flash_message(); ?>
                    <div class="features-inner section-inner has-bottom-divider">
                        <div class="features-wrap">
                            <form action="<?php echo CURRENT_PATH; ?>/article" method="POST"
                                enctype="multipart/form-data">
                                <p>
                                    subject :
                                    <input type="hidden" name="redirect" id="redirect"
                                        value="<?php echo CURRENT_PATH_FULL; ?>" />
                                    <input name="subject" id="subject" placeholder="subject" />
                                </p>
                                <p>
                                    content :
                                    <textarea name="content" id="content" cols="50" rows="5"
                                        placeholder="content"></textarea>
                                </p>
                                <p>
                                    image :
                                    <input name="article_image" id="article_image" placeholder="article image" />
                                </p>
                                <p>
                                    <input type="submit" value="save article">
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <?php
        require_once VIEWS . "/templates/footer.php";
        ?>