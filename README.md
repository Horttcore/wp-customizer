# WordPress Customizer Composer Package

A helper package for working with the WordPress Customizer

## Installation

`composer require horttcore/wp-customizer`

## Usage

### Basics

```php
use Horttcore\Customizer\Manager;

(new Manager)
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
            ->textarea( 'my-textarea', 'Textare' )
            ->url( 'my-url', 'Url' )
```

## Changelog

### v1.0.0

* Initial release