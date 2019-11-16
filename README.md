# WordPress Customizer Composer Package

A helper package for working with the WordPress Customizer

## Installation

`composer require horttcore/wp-customizer`

## Usage

### Basics

```php
<?php
use Horttcore\Customizer\Customize;

(new Customize)
    ->panel( __('My Panel', 'textdomain') )
        ->section( __('My Section', 'textdomain') )
            ->checkbox( 'my-checkbox', __('Checkbox', 'textdomain') )
            ->color( 'my-color', __('Color', 'textdomain') )
            ->file( 'my-file', __('File', 'textdomain') )
            ->image( 'my-image', __('Image', 'textdomain') )
            ->page( 'my-page', __('Page', 'textdomain') )
            ->radio( 'my-radio', __('Radio', 'textdomain'), ['option1' => 'Option 1', 'option2' => 'Option 2'] );
            ->select( 'my-select', __('Select', 'textdomain'), ['option1' => 'Option 1', 'option2' => 'Option 2'] );
            ->text( 'my-text', __('Text', 'textdomain') )
            ->textarea( 'my-textarea', __('Textarea', 'textdomain') )
            ->url( 'my-url', __('Url', 'textdomain') )
    ->register();
```

### Advanced

#### Save as option instead of theme_mod

```php
<?php
use Horttcore\Customizer\Customize;

(new Customize)
    ->panel( __('My Panel', 'textdomain')  )
        ->section( __('My Section', 'textdomain') )
            ->text( 'my-text', __('My Text', 'textdomain'), ['type' => 'option'] )
            ->register();
```

#### Check for a capability

```php
<?php
use Horttcore\Customizer\Customize;

(new Customize)
    ->panel( 'My Panel' )
        ->section( __('My Section', 'textdomain') )
            ->text( 'my-text', __('My Text', 'textdomain'), ['capability' => 'edit_posts'] )
            ->register();
```

#### Add a description

```php
<?php
use Horttcore\Customizer\Customize;

(new Customize)
    ->panel( 'My Panel' )
        ->section( 'My Section' )
            ->text( 'my-text', 'Text', [], ['description' => __('This is awesome', 'textdomain')] )
            ->register();
```

#### Retrieving data

```php
<?php
$mod = get_theme_mod('my-text');
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
