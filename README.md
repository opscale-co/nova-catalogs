## Support us

Support Opscale

At Opscale, we’re committed to delivering top-notch open-source solutions that empower your business to scale efficiently. If you’ve found our tools helpful, here are a few ways you can show your support:

⭐ **Star this repository** to help others discover our work and be part of our growing community. Every star makes a difference!

💬 **Share your experience** by leaving a review on [Trustpilot](https://www.trustpilot.com/review/opscale.co) or sharing your thoughts on social media. Your feedback helps us improve and grow!

📧 **Send us feedback** on what we can improve at [development@opscale.co](mailto:development@opscale.co). We value your input to make our tools even better for everyone.

🙏 **Get involved** by actively contributing to our open-source repositories. Your participation benefits the entire community and helps push the boundaries of what’s possible.

Thanks for helping Opscale continue to grow! 🚀

<!--delete-->

## Using this skeleton (remove this section after you have completed these steps)

This repo can be used to scaffold a Laravel package. Follow these steps to get started:

1. Press the "Use this template" button at the top of this repo to create a new repo with the contents of this skeleton.

2. Run "php ./configure.php" to run a script that will replace all placeholders throughout all the files.

3. Check the GitHub Actions workflows you want to keep

4. Keep in mind the template is configured with [Duster](https://github.com/tighten/duster) and [Commitlint](https://commitlint.js.org/) 

5. Have fun creating your package

6. If you need a deeper how-to, consider checking our <a  href="https://loom.com/share/folder/00f6ef4e555c47e39df796340298e113">Loom videos</a>.

---

To use your customized package in a Nova app, add this line in the `require` section of the `composer.json` file:

```

":vendor/:package_name": "*",

```

In the same `composer.json` file add a `repositiories` section with the path to your package repo:

```

"repositories": [
{
    "type": "path",
    "url": "../:package_name"
},

```

Now you're ready to develop your package inside a Nova app.

**When you are done with the steps above delete everything above!**

<!--/delete-->

# :package_description

[![Latest Version on Packagist](https://img.shields.io/packagist/v/:vendor/:package_name.svg?style=flat-square)](https://packagist.org/packages/:vendor/:package_name)

This is where your description should go. Try and limit it to a paragraph or two.

Add a screenshot of the tool here.

## Installation

You can install the package in to a Laravel app that uses [Nova](https://nova.laravel.com) via composer:

```bash

composer require :vendor/:package_name

```

Next up, you must register the tool with Nova. This is typically done in the `tools` method of the `NovaServiceProvider`.

```php

// in app/Providers/NovaServiceProvider.php
// ...
public function tools()
{
    return [
        // ...
        new \:namespace_vendor\:namespace_tool_name\:namespace_tool_nameTool(),
    ];
}

```

## Usage

Click on the ":package_name" menu item in your Nova app to see the tool provided by this package.

## Testing

``` bash

composer test

```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email :author_email instead of using the issue tracker.

## Credits

- [:author_name](https://github.com/:author_username)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.