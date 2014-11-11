<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Dall Construções',
    // preloading 'log' component
    'preload' => array('log'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.models.enum.*',
        'application.components.*',
        'application.helpers.*',
        'ext.giix-components.*', // giix components
        'ext.yii-mail.YiiMailMessage',
    ),
    'modules' => array(
        // uncomment the following to enable the Gii tool

        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'admin',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            //'ipFilters'=>array('127.0.0.1','::1'),
            'generatorPaths' => array(
                'ext.giix-core', // giix generators
            ),
        ),
    ),
    // application components
    'components' => array(
        'user' => array(
            // enable cookie-based authentication
            'class' => 'WebUser',
            'allowAutoLogin' => true,
        ),
//        'coreMessages'=>array(
//            'basePath'=>null,
//        ),
        // uncomment the following to enable URLs in path-format
        /*
          'urlManager'=>array(
          'urlFormat'=>'path',
          'rules'=>array(
          '<controller:\w+>/<id:\d+>'=>'<controller>/view',
          '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
          '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
          ),
          ),
         */

        //*******************************************
        //*******************************************
        //             DESENVOLVIMENTO
        //*******************************************
        //*******************************************
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=dallNew',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ),
        //*******************************************
        //*******************************************
        //               STAGING
        //*******************************************
//        //*******************************************
//        'db' => array(
//            'connectionString' => 'mysql:host=mysql.dallconstrucoes.com.br;dbname=dallconstrucoe03',
//            'emulatePrepare' => true,
//            'username' => 'dallconstrucoe03',
//            'password' => 'dallhomo2014',
//            'charset' => 'utf8',
//        ),
        //*******************************************
        //*******************************************
        //             PRODUÇÃO
        //*******************************************
        //*******************************************
//        'db' => array(
//            'connectionString' => 'mysql:host=mysql.dallconstrucoes.com.br;dbname=dallconstrucoe04',
//            'emulatePrepare' => true,
//            'username' => 'dallconstrucoe04',
//            'password' => 'dall2014',
//            'charset' => 'utf8',
//        ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            // uncomment the following to show log messages on web pages
            /*
              array(
              'class'=>'CWebLogRoute',
              ),
             */
            ),
        ),
        'mail' => array(
            'class' => 'ext.yii-mail.YiiMail',
            'transportType' => 'smtp',
            'transportOptions' => array(
                'host' => 'smtp.dallconstrucoes.com.br',
                'username' => 'contato@dallconstrucoes.com.br',
                'password' => 'dall2013',
                'port' => '587',
            ),
            'viewPath' => 'application.views.mail',
        ),
    ),
    'language' => 'pt_br',
    'sourceLanguage' => 'en',
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'kalvinduh@gmail.com',
    ),
);
