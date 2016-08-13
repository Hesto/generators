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
    | VIEW:MAKE SECTION
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
    | Default view layout
    |--------------------------------------------------------------------------
    |
    | This is the layout for which the template will be generated.
    |
    |
    */
    'default_view_layout' => 'admin',

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
    'custom_view_templates_path' => '/resources/templates/views/',

    /*
    |--------------------------------------------------------------------------
    | VIEW:MAKE END SECTION
    |--------------------------------------------------------------------------
    */

];
