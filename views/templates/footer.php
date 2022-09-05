<footer class="site-footer text-light" style="margin-top: 80px;">
    <div class="container">
        <div class="site-footer-inner">
            <div class="brand footer-brand">
                <a href="#">
                    <svg width="32" height="32" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                        <title>
                            <?php echo env('APP_NAME'); ?>
                        </title>
                        <defs>
                            <path d="M32 16H16v16H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h28a2 2 0 0 1 2 2v14z"
                                id="logo-gradient-footer-a" />
                            <linearGradient x1="50%" y1="50%" y2="100%" id="logo-gradient-footer-b">
                                <stop stop-color="#FFF" stop-opacity="0" offset="0%" />
                                <stop stop-color="#FFF" offset="100%" />
                            </linearGradient>
                        </defs>
                        <g fill="none" fill-rule="evenodd">
                            <mask id="logo-gradient-footer-c" fill="#fff">
                                <use xlink:href="#logo-gradient-footer-a" />
                            </mask>
                            <use fill-opacity=".32" fill="#FFF" xlink:href="#logo-gradient-footer-a" />
                            <path fill="url(#logo-gradient-footer-b)" mask="url(#logo-gradient-footer-c)"
                                d="M-16-16h32v32h-32z" />
                        </g>
                    </svg>

                </a>
            </div>
            <div class="footer-copyright">&copy;
                <?php echo date("Y") . " " . env('APP_NAME'); ?>
            </div>
        </div>
    </div>
</footer>
</div>

<script src="https://demos.onepagelove.com/html/ava/dist/js/main.min.js"></script>
</body>

</html>