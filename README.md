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
    ->panel( 'My Panel' )
        ->section( 'My Section' )
            ->checkbox( 'my-checkbox', 'Checkbox' )
            ->color( 'my-color', 'Color' )
            ->file( 'my-file', 'File' )
            ->image( 'my-image', 'Image' )
            ->page( 'my-page', 'Page' )
            ->radio( 'my-radio', 'Radio', ['option1' => 'Option 1', 'option2' => 'Option 2'] );
            ->select( 'my-select', 'Select', ['option1' => 'Option 1', 'option2' => 'Option 2'] );
            ->text( 'my-text', 'Text' )
            ->textarea( 'my-textarea', 'Textarea' )
            ->url( 'my-url', 'Url' );
```

### Advanced

#### Save as option instead of theme_mod

```php
<?php
use Horttcore\Customizer\Customize;

(new Customize)
    ->panel( 'My Panel' )
        ->section( 'My Section' )
            ->text( 'my-text', 'Text', ['type' => 'option'] )
```

#### Check for a capability

```php
<?php
use Horttcore\Customizer\Customize;

(new Customize)
    ->panel( 'My Panel' )
        ->section( 'My Section' )
            ->text( 'my-text', 'Text', ['capability' => 'edit_posts'] )
```

#### Retrieving data

```php
<?php
get_theme_mod('my-color)
```

## Changelog

### v2.0.0

-   Rename `Manager` to `Customize`

### v1.0.0

-   Initial release
