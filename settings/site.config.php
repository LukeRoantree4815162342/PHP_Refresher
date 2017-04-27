<?php

namespace HackTheHub;

use Rhubarb\Crown\Exceptions\Handlers\ExceptionHandler;
use Rhubarb\Crown\Logging\Log;
use Rhubarb\Crown\Logging\PhpLog;
use Rhubarb\Stem\StemSettings;


$dbSettings = StemSettings::singleton();
$dbSettings->host = "localhost";
$dbSettings->username = "root";
$dbSettings->password = "";
$dbSettings->database = "vagrant";

// Add a PHP logger
Log::attachLog( new PhpLog( Log::ERROR_LEVEL ) );

// Switch off exception trapping. You should have this on in the production environment.
ExceptionHandler::disableExceptionTrapping();