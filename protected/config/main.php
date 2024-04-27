<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
// Yii::setPathOfAlias('local','path/to/local-folder');
date_default_timezone_set('Asia/Dhaka');
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'theme' => 'erp',
    'name' => 'INVENTORY ERP',
    'defaultController' => 'site',
// preloading 'log' component
    'preload' => array('log'),
    'language' => 'en',
    'import' => array(
        'application.components.*',
        'application.components.Controller',
        'application.extensions.AmountInWord',
        'application.extensions.bootstrap.*',
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
        'application.modules.crm.models.*',
        'application.modules.crm.components.*',
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
//            'registrationUrl' => array('/user/registration'),
            # recovery password path
//            'recoveryUrl' => array('/user/recovery'),
            # login form path
//            'loginUrl' => array('/user/login'),
            # page after login
//            'returnUrl' => array('/user/profile'),
            # page after logout
//            'returnLogoutUrl' => array('/user/login'),
        ),
        //Modules Rights
        'rights' => array(
            'superuserName' => 'Admin', // Name of the role with super user privileges.
            'authenticatedName' => 'Authenticated', // Name of the authenticated user role.
            'userIdColumn' => 'id', // Name of the user id column in the database.
            'userNameColumn' => 'username', // Name of the user name column in the database.
            'enableBizRule' => false, // Whether to enable authorization item business rules.
            'enableBizRuleData' => false, // Whether to enable data for business rules.
            'displayDescription' => true, // Whether to use item description instead of name.
            'flashSuccessKey' => 'RightsSuccess', // Key to use for setting success flash messages.
            'flashErrorKey' => 'RightsError', // Key to use for setting error flash messages.
            'baseUrl' => '/rights', // Base URL for Rights. Change if module is nested.
            'layout' => 'rights.views.layouts.main', // Layout to use for displaying Rights.
            'appLayout' => 'application.views.layouts.main', // Application layout.
            'cssFile' => '/css/default.css', // Style sheet file to use for Rights.
            'install' => false, // Whether to enable installer.
            'debug' => false,
        ),
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'admin',
        ),
        'accounting',
        'inventory',
        'crm',
        'commercial',
        'sell',
        'cal' => array('debug' => true),
    ),
// application components
    'components' => array(
        'ePdf' => array(
            'class' => 'ext.yii-pdf.EYiiPdf',
            'params' => array(
                'HTML2PDF' => array(
                    'librarySourcePath' => 'application.vendors.html2pdf.*',
                    'classFile' => 'html2pdf.class.php', // For adding to Yii::$classMap
                    'defaultParams' => array(// More info: http://wiki.spipu.net/doku.php?id=html2pdf:en:v4:accueil
                        'unicode' => true, // TRUE means clustering the input text IS unicode (default = true)
                        'encoding' => 'UTF-8', // charset encoding; Default is UTF-8
                    )
                )
            ),
        ),
        'image' => array(
            'class' => 'application.extensions.image.CImageComponent',
            'driver' => 'GD',
            'params' => array('directory' => '/opt/local/bin'),
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
                    'levels' => 'trace, info, error, warning, vardump',
                ),
                array(
                    'class' => 'CProfileLogRoute',
                    'levels' => 'profile',
                    'enabled' => true,
                ),
                // uncomment the following to show log messages on web pages
                array(
                    'class' => 'CWebLogRoute',
                    'enabled' => YII_DEBUG,
                    'levels' => 'error, warning, trace, notice',
                    'categories' => 'application',
                    'showInFireBug' => false,
                ),
            ),
        ),

        'session' => array(
            'timeout' => 99999999, //3 hours
            'cookieParams' => array(
                'lifetime' => 99999999, //hours
            ),
        ),
        'user' => array(
            'class' => 'RWebUser',
            'authTimeout' => 99999999, // auto-logout after 3 hours  (value in seconds)
            'allowAutoLogin' => true,
            'autoUpdateFlash' => true, // add this line to disable the flash counter
            'loginUrl' => array('/site/login'),
            'loginRequiredAjaxResponse' => 'Session timed out. Please login again to continue.',
        ),
        'authManager' => array(
            'class' => 'RDbAuthManager',
            'connectionID'=>'db',
            'itemTable'=>'AuthItem',
            'itemChildTable'=>'AuthItemChild',
            'assignmentTable'=>'AuthAssignment',
            'rightsTable'=>'rights',

        ),
        'urlManager' => require(dirname(__FILE__) . '/urlManager.php'),
        'db' => require(dirname(__FILE__) . '/db.php'),
        'errorHandler' => array(
            'errorAction' => 'site/error',
        ),
    ),
    'params' => require(dirname(__FILE__) . '/params.php'),
);
