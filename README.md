# WordPress Customizer Composer Package

A helper package for working with the WordPress Customizer

## Installation

`composer require horttcore/wp-customizer`

## Usage

### Basics

```php
use Horttcore\Customizer\Manager;

(new Manager)
    ->panel( $panelLabel )
        ->section( $sectionLabel )
            ->checkbox( $optionLabel, $optionName )
            ->color( $optionLabel, $optionName )
            ->file( $optionLabel, $optionName )
            ->image( $optionLabel, $optionName )
            ->page( $optionLabel, $optionName )
            ->radio( $optionLabel, $optionName, ['option1' => 'Option 1', 'option2' => 'Option 2'] );
            ->select( $optionLabel, $optionName, ['option1' => 'Option 1', 'option2' => 'Option 2'] );
            ->text( $optionLabel, $optionName )
            ->textarea( $optionLabel, $optionName )
            ->url( $optionLabel, $optionName )
    ->init(); // Required
```

## Changelog

### v1.0.0

* Initial release