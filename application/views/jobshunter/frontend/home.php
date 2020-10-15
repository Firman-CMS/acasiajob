<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo html_escape($title); ?> - <?php echo html_escape($settings->site_title); ?></title>
    <link rel="shortcut icon" type="image/png" href="<?php echo get_favicon($general_settings); ?>"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/main.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/main-tablet.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/main-mobile.css">
</head>
<body>
<div class="container">
    <div class="full-height">
        <div>
            
    <div class="app-name">
        jobshunter.co.id
    </div>
    <div class="google-play-img">
        <a href="https://play.google.com/store/apps/details?id=com.soutab.acasiajob" target="_blank">
            <img src="<?php echo base_url(); ?>assets/img/get-it-on-google-play.png" alt="Get in on Google Play">
        </a>
    </div>
    <div class="app-name">
        <!-- <h3><?php #echo html_escape($title); ?></h3> -->
    </div>
        </div>
    </div>
</div>
</body>
</html>
