<?php
// config/packages/framework.php-fpm
use Symfony\Config\FrameworkConfig;

return static function (FrameworkConfig $framework) {
$framework->form()->legacyErrorMessages(false);
};
