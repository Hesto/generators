<?php

/**
 * This file is part of Hesto Generators.
 *
 * @license MIT
 * @package Hesto\Generators
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Default view layout
    |--------------------------------------------------------------------------
    |
    | This is the layout for which the template will be generated.
    |
    |
    */
    'default_layout' => 'admin',

    /*
    |--------------------------------------------------------------------------
    | MAKE:VIEW SECTION
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | Default view template
    |--------------------------------------------------------------------------
    |
    | This is the name of template which is generated during view:make command.
    |
    */
    'default_view_template' => 'default',

    /*
    |--------------------------------------------------------------------------
    | Turn on custom templates for views
    |--------------------------------------------------------------------------
    |
    | Turning on custom templates stored locally in project.
    | the role if it is in a different namespace.
    |
    */
    'custom_view_templates' => false,

    /*
    |--------------------------------------------------------------------------
    | Custom templates path
    |--------------------------------------------------------------------------
    |
    | This is the Role model used by Rbac to create correct relations.  Update
    | the role if it is in a different namespace.
    |
    */
    'custom_view_templates_path' => base_path('/resources/templates/views/'),

    /*
    |--------------------------------------------------------------------------
    | MAKE:VIEW END SECTION
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MAKE:CONTROLLER:TEMPLATE SECTION
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | Default view template
    |--------------------------------------------------------------------------
    |
    | This is the name of template which is generated during view:make command.
    |
    */
    'default_controller_template' => 'default',

    /*
    |--------------------------------------------------------------------------
    | Turn on custom templates for views
    |--------------------------------------------------------------------------
    |
    | Turning on custom templates stored locally in project.
    | the role if it is in a different namespace.
    |
    */
    'custom_controller_templates' => false,

    /*
    |--------------------------------------------------------------------------
    | Turn on custom templates for views
    |--------------------------------------------------------------------------
    |
    | Turning on custom templates stored locally in project.
    | the role if it is in a different namespace.
    |
    */
    'controller_namespace' => '',

    /*
    |--------------------------------------------------------------------------
    | Custom templates path
    |--------------------------------------------------------------------------
    |
    | This is the Role model used by Rbac to create correct relations.  Update
    | the role if it is in a different namespace.
    |
    */
    'custom_controller_templates_path' => base_path('/resources/templates/controllers/'),

    /*
    |--------------------------------------------------------------------------
    | MAKE:CONTROLLER:TEMPLATE END SECTION
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MAKE:TAB:TABLE SECTION
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | Turn on custom templates for views
    |--------------------------------------------------------------------------
    |
    | Turning on custom templates stored locally in project.
    | the role if it is in a different namespace.
    |
    */
    'custom_tab_table_templates' => false,

    /*
    |--------------------------------------------------------------------------
    | Custom templates path
    |--------------------------------------------------------------------------
    |
    | This is the Role model used by Rbac to create correct relations.  Update
    | the role if it is in a different namespace.
    |
    */
    'custom_tab_table_templates_path' => base_path('/resources/templates/tabs/'),

    /*
    |--------------------------------------------------------------------------
    | MAKE:TAB:TABLE END SECTION
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MAKE:CONTROLLER:ROUTE SECTION
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | Turn on custom templates for views
    |--------------------------------------------------------------------------
    |
    | Turning on custom templates stored locally in project.
    | the role if it is in a different namespace.
    |
    */
    'default_controller_guard' => 'admin',

    /*
    |--------------------------------------------------------------------------
    | MAKE:CONTROLLER:ROUTE END SECTION
    |--------------------------------------------------------------------------
    */

];
