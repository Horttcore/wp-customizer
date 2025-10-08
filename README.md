# WordPress Customizer & Settings API Composer Package

A helper package for working with the WordPress Customizer and Settings API

## Installation

`composer require horttcore/wp-customizer`

## Usage

### Settings Page (Recommended)

The Settings Page approach uses the WordPress Settings API to create admin settings pages, which is the recommended approach as the WordPress Customizer may be deprecated in future versions.

#### Basic Usage

```php
<?php
use RalfHortt\Customize\SettingsPage;

(new SettingsPage)
    ->page('My Theme Settings')
    ->panel( __('My Panel', 'textdomain') )
        ->section( __('My Section', 'textdomain') )
            ->checkbox( 'my-checkbox', __('Checkbox', 'textdomain') )
            ->color( 'my-color', __('Color', 'textdomain') )
            ->file( 'my-file', __('File', 'textdomain') )
            ->image( 'my-image', __('Image', 'textdomain') )
            ->pageDropdown( 'my-page', __('Page', 'textdomain') )
            ->radio( 'my-radio', __('Radio', 'textdomain'), ['option1' => 'Option 1', 'option2' => 'Option 2'] )
            ->select( 'my-select', __('Select', 'textdomain'), ['option1' => 'Option 1', 'option2' => 'Option 2'] )
            ->text( 'my-text', __('Text', 'textdomain') )
            ->textarea( 'my-textarea', __('Textarea', 'textdomain') )
            ->url( 'my-url', __('Url', 'textdomain') )
    ->register();
```

#### Settings Page Configuration

```php
<?php
use RalfHortt\Customize\SettingsPage;

(new SettingsPage)
    ->page(
        'Theme Configuration', 
        'Theme Config',                    // menu title
        'my-theme-config',                // slug
        'edit_theme_options',             // capability
        'options-general.php'             // parent (Settings menu)
    )
    ->panel('Design Settings')
        ->section('Colors')
            ->color('primary-color', 'Primary Color')
    ->register();
```

#### Top-Level Menu Page

```php
<?php
use RalfHortt\Customize\SettingsPage;

(new SettingsPage)
    ->page(
        'Brand Manager',        // title
        null,                   // menu title (defaults to title)
        null,                   // slug (auto-generated)
        'manage_options',       // capability
        null,                   // parent (null = top-level menu)
        'dashicons-art',        // icon
        25                      // position
    )
    ->panel('Brand Assets')
        ->section('Logos')
            ->image('main-logo', 'Main Logo')
    ->register();
```

#### Available Parent Menus

- `'themes.php'` - Appearance menu (default)
- `'options-general.php'` - Settings menu  
- `'tools.php'` - Tools menu
- `null` - Top-level menu (requires icon and position)
- Custom parent slug for submenus

### WordPress Customizer (Legacy)

The original Customizer approach is still available but may be deprecated in future WordPress versions.

#### Basic Usage

```php
<?php
use RalfHortt\Customize\Customize;

(new Customize)
    ->panel( __('My Panel', 'textdomain') )
        ->section( __('My Section', 'textdomain') )
            ->checkbox( 'my-checkbox', __('Checkbox', 'textdomain') )
            ->color( 'my-color', __('Color', 'textdomain') )
            ->file( 'my-file', __('File', 'textdomain') )
            ->image( 'my-image', __('Image', 'textdomain') )
            ->page( 'my-page', __('Page', 'textdomain') )
            ->radio( 'my-radio', __('Radio', 'textdomain'), ['option1' => 'Option 1', 'option2' => 'Option 2'] )
            ->select( 'my-select', __('Select', 'textdomain'), ['option1' => 'Option 1', 'option2' => 'Option 2'] )
            ->text( 'my-text', __('Text', 'textdomain') )
            ->textarea( 'my-textarea', __('Textarea', 'textdomain') )
            ->url( 'my-url', __('Url', 'textdomain') )
    ->register();
```

## Advanced Usage

### Settings Page Advanced Features

#### Save as option instead of theme_mod

```php
<?php
use RalfHortt\Customize\SettingsPage;

(new SettingsPage)
    ->page('My Settings')
    ->panel( __('My Panel', 'textdomain')  )
        ->section( __('My Section', 'textdomain') )
            ->text( 
                'my-text',                    // identifier
                __('My Text', 'textdomain'),  // label
                '',                           // default value
                'option'                      // type (option instead of theme_mod)
            )
    ->register();
```

#### Check for a capability

```php
<?php
use RalfHortt\Customize\SettingsPage;

(new SettingsPage)
    ->page('My Settings')
    ->panel( 'My Panel' )
        ->section( __('My Section', 'textdomain') )
            ->text( 
                'my-text',                    // identifier
                __('My Text', 'textdomain'),  // label
                '',                           // default value
                'theme_mod',                  // type
                'edit_posts'                  // capability
            )
    ->register();
```

#### Add a description

```php
<?php
use RalfHortt\Customize\SettingsPage;

(new SettingsPage)
    ->page('My Settings')
    ->panel( 'My Panel' )
        ->section( 'My Section' )
            ->text( 
                'my-text',                               // identifier
                'Text',                                  // label
                '',                                      // default value
                'theme_mod',                             // type
                '',                                      // capability
                __('This is awesome', 'textdomain')     // description
            )
    ->register();
```

#### Retrieving data

```php
<?php
// Works the same for both Settings Page and Customizer
$mod = get_theme_mod('my-text'); // For theme_mod type (default)
$option = get_option('my-text'); // For option type
```

### Customizer Advanced Features (Legacy)

#### Save as option instead of theme_mod

```php
<?php
use RalfHortt\Customize\Customize;

(new Customize)
    ->panel( __('My Panel', 'textdomain')  )
        ->section( __('My Section', 'textdomain') )
            ->text( 'my-text', __('My Text', 'textdomain'), ['type' => 'option'] )
    ->register();
```

#### Check for a capability

```php
<?php
use RalfHortt\Customize\Customize;

(new Customize)
    ->panel( 'My Panel' )
        ->section( __('My Section', 'textdomain') )
            ->text( 'my-text', __('My Text', 'textdomain'), ['capability' => 'edit_posts'] )
    ->register();
```

#### Add a description

```php
<?php
use RalfHortt\Customize\Customize;

(new Customize)
    ->panel( 'My Panel' )
        ->section( 'My Section' )
            ->text( 'my-text', 'Text', [], ['description' => __('This is awesome', 'textdomain')] )
    ->register();
```

#### Adding a setting in an existing panel

```php
<?php
(new Customize)
    ->image( 'mobile logo', __('Mobile Logo', 'textdomain'), [], [
        'section' => 'title_tagline',
        'priority' => 1
    ] )
    ->register();
```

## Changelog

### v2.1.0

-   Adding support for including elements in existing panels

### v2.0.0

-   Rename `Manager` to `Customize`

### v1.0.0

-   Initial release
