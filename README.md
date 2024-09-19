## Support us

Support Opscale

At Opscale, we’re committed to delivering top-notch open-source solutions that empower your business to scale efficiently. If you’ve found our tools helpful, here are a few ways you can show your support:

⭐ **Star this repository** to help others discover our work and be part of our growing community. Every star makes a difference!

💬 **Share your experience** by leaving a review on [Trustpilot](https://www.trustpilot.com/review/opscale.co) or sharing your thoughts on social media. Your feedback helps us improve and grow!

📧 **Send us feedback** on what we can improve at [development@opscale.co](mailto:development@opscale.co). We value your input to make our tools even better for everyone.

🙏 **Get involved** by actively contributing to our open-source repositories. Your participation benefits the entire community and helps push the boundaries of what’s possible.

Thanks for helping Opscale continue to grow! 🚀



# Description

[![Latest Version on Packagist](https://img.shields.io/packagist/v/opscale-co/nova-catalogs.svg?style=flat-square)](https://packagist.org/packages/opscale-co/nova-catalogs)

A simple repository for managing reusable data for a Nova app

You can test a live demo in our [playground](https://playground.opscale.co)

TODO: Add a screenshot of the tool here.

## Installation

You can install the package in to a Laravel app that uses [Nova](https://nova.laravel.com) via composer:

```bash

composer require opscale-co/nova-catalogs

```

Next up, you must register the tool with Nova. This is typically done in the `tools` method of the `NovaServiceProvider`.

```php

// in app/Providers/NovaServiceProvider.php
// ...
public function tools()
{
    return [
        // ...
        new \Opscale\NovaCatalogs\NovaCatalogsTool(),
    ];
}

```

## Usage

Simply add the reference of the Catalog resource wherever you think is useful for managing the content.

Then you can use the data in Select fields, tags, autocompletion, etc:

``` php

use Opscale\NovaCatalogs\Models\Catalog;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;

...

Select::make('Label', 'field')
    ->options(Catalog::optionsFromSlug('your-slug'))
    ->displayUsingLabels(),

Text::make('Label', 'field')->required()
    ->suggestions(Catalog::optionsFromSlug('your-slug')),

```

## Testing

``` bash

composer test

```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email development@opscale.co instead of using the issue tracker.

## Credits

- [Opscale](https://github.com/opscale-co)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.