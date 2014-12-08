#Craft Command Line Installer

Manage Craft from the command line with composer. This tool is heavily inspired by the [Laravel Installer](http://laravel.com/docs/4.2/installation#install-laravel).

### Requirements

- [Composer](https://getcomposer.org)

### Installation

1. Ensure that the `~/.composer/vendor/bin` is available in your terminal PATH.

	**Note**: my [Oh My ZSH](http://ohmyz.sh) profile has this line:

	`export PATH="/usr/local/bin:/usr/bin:/bin:/usr/sbin:/sbin:/Users/username/.composer/vendor/bin"`

	**Note**: make sure you change `username` above

2. Require `craft` globally by using this command:

	`composer global require "themccallister/craft=dev-master"`

3. Change to a new directory, such as `~/Sites`, and run `craft install mywebsite.com`.

### Contributing

Pull requests, contributions, issues and feature requests are always welcome... Although I would prefer a pull request for new features... ;)
