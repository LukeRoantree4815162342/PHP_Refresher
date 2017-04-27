<?php

namespace HackTheHub\Layouts;

use Rhubarb\Patterns\Layouts\BaseLayout;

class BootstrappedLayout extends BaseLayout
{
    protected function printHead()
    {
        parent::printHead();

        ?>
        <link rel="stylesheet" href="/static/css/bootstrap.min.css">
        <?php
    }

}