<?php
require('../commons/base.inc.php');
$FOGPageManager = FOGCore::getClass('FOGPageManager');
if (isset($_SESSION['delitems']) && !in_array($sub,array('deletemulti','deleteconf'))) unset($_SESSION['delitems']);
$currentUser =  FOGCore::getClass('User',(int)$_SESSION['FOG_USER']);
if ($currentUser->isValid()) $currentUser->isLoggedIn();
FOGCore::getClass('ProcessLogin')->processMainLogin();
$Page = FOGCore::getClass('Page');
if (!in_array($_REQUEST['node'],array('schemaupdater','client')) && ($node == 'logout' || !$currentUser->isValid())) {
    $currentUser->logout();
    $Page->setTitle($foglang['Login']);
    $Page->setSecTitle($foglang['ManagementLogin']);
    $Page->startBody();
    FOGCore::getClass('ProcessLogin')->mainLoginForm();
    $Page->endBody();
    $Page->render();
} else {
    $_SESSION['AllowAJAXTasks'] = true;
    if (FOGCore::$ajax) {
        $FOGPageManager->render();
        exit;
    }
    $Page->startBody();
    $FOGPageManager->render();
    $Page->setTitle($FOGPageManager->getFOGPageTitle());
    $Page->setSecTitle($FOGPageManager->getFOGPageName());
    $Page->endBody();
    $Page->render();
}
