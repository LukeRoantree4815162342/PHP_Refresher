<?php

namespace HackTheHub\Layouts;

use Rhubarb\Patterns\Layouts\BaseLayout;

class DefaultLayout extends BaseLayout
{
    protected function printHead()
    {
        parent::printHead();

        ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/css/swiper.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/css/swiper.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/js/swiper.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/js/swiper.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/js/swiper.jquery.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/js/swiper.jquery.min.js"></script>
        <link rel="stylesheet" href="/static/css/style.css">
        <link rel="stylesheet" href="/static/css/welcomescreen.css">
        <script src="/static/js/slideout.min.js"></script>
        <script src="static/js/welcomescreen.js"></script>
        <script src="static/js/main.js"></script>
        <?php
    }

}