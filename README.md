## Support us

At Opscale, we’re passionate about contributing to the open-source community by providing solutions that help businesses scale efficiently. If you’ve found our tools helpful, here are a few ways you can show your support:

⭐ **Star this repository** to help others discover our work and be part of our growing community. Every star makes a difference!

💬 **Share your experience** by leaving a review on [Trustpilot](https://www.trustpilot.com/review/opscale.co) or sharing your thoughts on social media. Your feedback helps us improve and grow!

📧 **Send us feedback** on what we can improve at [feedback@opscale.co](mailto:feedback@opscale.co). We value your input to make our tools even better for everyone.

🙏 **Get involved** by actively contributing to our open-source repositories. Your participation benefits the entire community and helps push the boundaries of what’s possible.

💼 **Hire us** if you need custom dashboards, admin panels, internal tools or MVPs tailored to your business. With our expertise, we can help you systematize operations or enhance your existing product. Contact us at hire@opscale.co to discuss your project needs.

Thanks for helping Opscale continue to scale! 🚀

## Description

A simple repository for managing catalogs in your Nova app.

Every app needs a set of options for fields in forms. Instead of define these options in code, allow users to dinamically manage them easily.

![Catalog demo](https://raw.githubusercontent.com/opscale-co/nova-catalogs/refs/heads/main/screenshots/nova-catalogs.gif)

## Installation

[![Latest Version on Packagist](https://img.shields.io/packagist/v/opscale-co/nova-catalogs.svg?style=flat-square)](https://packagist.org/packages/opscale-co/nova-catalogs)

You can install the package in to a Laravel app that uses [Nova](https://nova.laravel.com) via composer:

```bash

composer require opscale-co/nova-catalogs

```

## Usage

### Via UI

A "Catalogs" menu item is available by default. Use the Nova interface to create and manage catalogs and their items.

### Via Code

Use the `Catalogable` trait to parent catalogs to your models:

```php
use Opscale\NovaCatalogs\Concerns\Catalogable;

class Company extends Model
{
    use Catalogable;
}
```

Retrieve catalog options using `options()` or `filteredOptions()`. Both methods use cache for performance:

```php
use Opscale\NovaCatalogs\Models\Catalog;

// Get all options as key => name array
Catalog::options('countries');
```

Catalogs and catalog items have a `data` field for storing extra information. Use `filteredOptions()` to filter by data or other properties:

```php
// Filter options using a callback (e.g., by data)
Catalog::filteredOptions('countries', fn ($item) => $item->data['continent'] === 'europe');
```

Use with Nova Select fields:

```php
Select::make('Country')
    ->options(Catalog::options('countries'))
    ->displayUsingLabels();
```

## Testing

``` bash

npm run test

```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/opscale-co/.github/blob/main/CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email development@opscale.co instead of using the issue tracker.

## Credits

- [Opscale](https://github.com/opscale-co)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.