# Introduction

TwitterAppBundle at its core is just a simple proxy bundle between twitteroauth client and symfony2.
It is only meant to be used as a clientless app. If you want to add Twitter login/register/etc functionality to your app, please consider using FOS/TwitterBundle instead.

# Example usage
Example use-case for this bundle would be automated twitter messages (from your project account) about certain events in your system.


# Installation

#### With deps:
Add this bundle and Abraham Williams' Twitter library to your application:

    [twitteroauth]
        git=http://github.com/abraham/twitteroauth.git

    [InoriTwitterAppBundle]
        git=http://github.com/Inori/InoriTwitterAppBundle.git
        target=bundles/Inori/TwitterAppBundle

#### With composer:
Add this bundle to your composer.json:

    // composer.json
    {
        // ...
        require: {
            // ...
            "inori/twitter-app-bundle": "master"
        }
    }

Register the namespace `Inori` to your project's autoloader bootstrap script:

    //app/autoload.php
    $loader->registerNamespaces(array(
        // ...
        'Inori'    => __DIR__.'/../vendor/bundles',
        // ...
    ));

Add this bundle to your application's kernel:

    //app/AppKernel.php
    public function registerBundles()
    {
        return array(
            // ...
            new Inori\TwitterAppBundle\InoriTwitterAppBundle(),
        );
    }

Configure the `twitter_app` service in your YAML configuration:

    #app/config/config.yml
    inori_twitter_app:
        file: %kernel.root_dir%/../vendor/twitteroauth/twitteroauth/twitteroauth.php
        consumer_key: xxxxxx
        consumer_secret: xxxxxx
        oauth_token: xxxxxx
        oauth_token_secret: xxxxxx

**NB!** To learn how to get keys/tokens, take a look at [Twitter Developers documentation](https://dev.twitter.com/docs). For a quick walkthrough check below.

# Using TwitterApp

If the setup is done correctly, then you can start using TwitterApp like this:

    // ...
    $ta = $this->container->get('twitter_app');
    $messages = $ta->getDirectMessages();

TwitterApp comes with some basic methods for easier usage (tweet, follow),
but for most of the API features you should use twitteroauth via getApi() method like this:

    // ...
    $ta = $this->container->get('twitter_app');
    $trends = $ta->getApi()->get('trends');

# Getting Twitter API tokens
* Login at [Twitter Developers page](https://dev.twitter.com/user/login)
* [Create your application](https://dev.twitter.com/apps/new)
* Go to your app profile page via [My applications](https://dev.twitter.com/apps)
* There you will see *Consumer key* and *Consumer secret* under **OAuth settings**
* Under **Your access token** you should see *Access token* and *Access token secret*, if not then simply press "Recreate my access token"
* Make sure *Access level* is **Read, write, and direct messages**, if not then then go to *Settings* tab and under *Application Type -> Access* choose **Read, Write and Access direct messages**