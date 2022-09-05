<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?php echo env('APP_NAME'); ?>
    </title>
    <link href="https://fonts.googleapis.com/css?family=Lato:400,400i|Roboto:500" rel="stylesheet">
    <link rel="stylesheet" href="https://demos.onepagelove.com/html/ava/dist/css/style.css">
    <script src="https://unpkg.com/scrollreveal@4.0.0/dist/scrollreveal.min.js"></script>
    <style type="text/css">
    ul li:not(img) {
        display: inline;
        margin-right: 12px;
        border: 2px silver solid;
    }

    li a,
    span {
        padding: 20px;
        text-decoration: none;
    }

    .selected {
        color: blue;
        background-color: skyblue;
    }

    .features::before {
        z-index: -1 !important;
    }

    .features-wrap {
        display: flex;
        flex-wrap: wrap;
        justify-content: stretch !important;
        margin-right: -12px;
        margin-left: -12px;
    }

    .feature {
        padding: 8px 12px;
        width: 100% !important;
        max-width: 100% !important;
        flex-grow: 1;
    }

    .img-small {
        margin-right: 10px;
        cursor: pointer;
    }
    </style>
</head>