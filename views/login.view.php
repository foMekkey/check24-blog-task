<?php
require_once VIEWS . "/templates/header.php";
?>

<body class="is-boxed has-animations">
    <div class="body-wrap boxed-container">
        <header>
            <div class="">
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
                    <div class="features-inner section-inner has-bottom-divider">
                        <?php show_flash_message(); ?>
                        <div class="features-wrap">
                            <form action="<?php echo CURRENT_PATH; ?>/login" method="POST"
                                enctype="multipart/form-data">
                                <p>
                                    email :
                                    <input type="email" name="email" id="email" placeholder="type your email" />
                                </p>
                                <p>
                                    password :
                                    <input type="password" name="password" id="password"
                                        placeholder="type your password" />
                                </p>
                                <p>
                                    <input type="submit" value="login">
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