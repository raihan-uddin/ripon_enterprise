<?php
if (YII_DEBUG) {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '0');
    ini_set('display_startup_errors', '0');
    error_reporting(0);
}
date_default_timezone_set('Asia/Dhaka');
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'theme' => 'erp',
    'name' => 'INVENTORY MANAGEMENT',
    'defaultController' => 'site',
    // preloading 'log' component
    'preload' => array('log'),
    'language' => 'en',
    'import' => array(
        'application.components.*',
        'application.components.Controller',
        'application.extensions.AmountInWord',
        // 'application.extensions.bootstrap.*', // Removed: EBootstrap extension deleted (Phase 0)
        'application.helpers.*',
        'application.models.*',
        'application.modules.accounting.models.*',
        'application.modules.inventory.models.*',
        'application.modules.rights.*',
        'application.modules.rights.components.*',
        'application.modules.rights.components.dataproviders.*',
        'application.modules.rights.models.*',
        'application.modules.user.components.*',
        'application.modules.user.models.*',
        'application.modules.commercial.models.*',
        'application.modules.commercial.components.*',
        'application.modules.sell.models.*',
        'ext.EExcelView.*',
    ),
    'modules' => array(
        'user' => array(
            'tableUsers' => 'users',
            'tableProfiles' => 'profiles',
            'tableProfileFields' => 'profiles_fields',
            # encrypting method (php hash function)
            'hash' => 'md5',
            # send activation email
            'sendActivationMail' => true,
            # allow access for non-activated users
            'loginNotActiv' => false,
            # activate user on registration (only sendActivationMail = false)
            'activeAfterRegister' => false,
            # automatically login from registration
            'autoLogin' => true,
            # registration path
            'registrationUrl' => array('/user/registration'),
            # recovery password path
            'recoveryUrl' => array('/user/recovery'),
            # login form path
            'loginUrl' => array('/user/login'),
            # page after login
            'returnUrl' => array('/user/profile'),
            # page after logout
            'returnLogoutUrl' => array('/user/login'),
        ),
        //Modules Rights
        'rights' => array(
            'superuserName' => 'Admin', // Name of the role with super user privileges.
            'authenticatedName' => 'Authenticated', // Name of the authenticated user role.
            'userIdColumn' => 'id', // Name of the user id column in the database.
            'userNameColumn' => 'username', // Name of the user name column in the database.
            'enableBizRule' => true, // Whether to enable authorization item business rules.
            'enableBizRuleData' => true, // Whether to enable data for business rules.
            'displayDescription' => true, // Whether to use item description instead of name.
            'flashSuccessKey' => 'RightsSuccess', // Key to use for setting success flash messages.
            'flashErrorKey' => 'RightsError', // Key to use for setting error flash messages.
            'baseUrl' => '/rights', // Base URL for Rights. Change if module is nested.
            'layout' => 'rights.views.layouts.main', // Layout to use for displaying Rights.
            'appLayout' => 'application.views.layouts.main', // Application layout.
            'cssFile' => false, // Disabled: Blueprint default.css removed (Phase 0)
            'install' => false, // Whether to enable installer.
            'debug' => false,
        ),
        'importcsv' => array(
            'path' => 'upload/importCsv/', // path to folder for saving csv file and file with import params
        ),
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'admin',
            'ipFilters' => array('127.0.0.1', '::1'),
        ),
        'accounting',
        'inventory',
        'commercial',
        'sell',
        'loan',
        'cal' => array('debug' => FALSE),
    ),
    // application components
    'components' => array(
        'clientScript' => array(
            'scriptMap' => array(
                'jquery.js' => '/themes/erp/vendor/jquery/jquery-3.7.1.min.js',
                'jquery.min.js' => '/themes/erp/vendor/jquery/jquery-3.7.1.min.js',
            ),
        ),
        'cache' => array(
            'class' => 'CDbCache',
            'connectionID' => 'db', // <<< THIS IS THE ISSUE
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
                array(
                    'class' => 'CProfileLogRoute',
                    'levels' => 'profile',
                    'enabled' => true,
                ),
            ),
        ),
        'session' => array(
            'class' => 'CHttpSession', // You can change this to CHttpSession if you prefer using file-based sessions
//            'connectionID' => 'db',
//            'autoCreateSessionTable' => true,
            'autoStart' => true, // Whether to automatically start the session when the application starts
            'timeout' => 1800, // 30 minutes
            'cookieMode' => 'only', // Set to 'only' to allow only cookies to store session IDs, 'allow' to allow both cookies and URL parameters, 'none' to disable session cookies
            'cookieParams' => array(
                'lifetime' => 1800, // 30 minutes
                'httpOnly' => true,
                'sameSite' => 'Lax',
            ),

        ),
        'user' => array(
            'class' => 'RWebUser',
            'authTimeout' => 1800, // 30 minutes
            'allowAutoLogin' => true,
//            'autoUpdateFlash' => true, // add this line to disable the flash counter
            'loginUrl' => array('/site/login'),
            'loginRequiredAjaxResponse' => 'Session timed out. Please login again to continue.',
            'autoRenewCookie' => true, // Whether to automatically renew the session cookie upon each user request

        ),
        'authManager' => array(
            'class' => 'RDbAuthManager',
        ),
        'urlManager' => require(dirname(__FILE__) . '/urlManager.php'),
        'db' => require(dirname(__FILE__) . '/db.php'),
        'errorHandler' => array(
            'errorAction' => 'site/error',
        ),
    ),
    'params' => require(dirname(__FILE__) . '/params.php'),
);
