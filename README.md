# fanpresscm3
FanPress CM News System version 3
The FanPress CM News System version 3 is a lightwight but powerfull content
management system for small and mide size websites, started as replacement
for the Cutenews CMS in 2011.

Including FanPress CM depend an how you use the system on your site.

An assistent for integration is provided by the "FanPress CM Integration" Modul which can be found in module manage. If you do it manually, here are further information:

## php include

When using php include, fist include the api file and create a new API object.

```php
<?php include_once 'fanpress/fpcmapi.php'; ?>
<?php $api = new fpcmAPI(); ?>
```

Now you can use the API functions:

```php
$api->showArticles() to display active articles, a single article or the article archive in front end. (fulfils task of shownews.php from FanPress CM 1.x and 2.x)
$api->showLatestNews() to show recent news list.
$api->showPageNumber() displays current page number, accepts a parameter for page descriptions like "Page XYZ".
$api->showTitle() displayse the article title in HTML <title> , accepts a parameter for a seperator of your text in <title>.
```

You can use a couple of constants fpr further configuration of the output:

* FPCM_PUB_CATEGORY_LATEST
    * articles from category in $api->showLatestNews()
* FPCM_PUB_CATEGORY_LISTALL
    * articles from category in $api->showArticles()
* FPCM_PUB_LIMIT_LISTALL
    * amount of active articles in $api->showArticles()
* FPCM_PUB_LIMIT_ARCHIVE
    * amount of archived articles in $api->showArticles()
* FPCM_PUB_LIMIT_LATEST
    * amount of articles in $api->showLatestNews()
* FPCM_PUB_OUTPUT_UTF8
    * enable or disbale usage of UTF-8 charset in output of $api->showLatestNews(), $api->showArticles() and $api->showTitle(). Should only be used in case special signs as german umlauts are displayed incorrectly.

## iframes

In case your're using iframes you have to call the controllers manually.

* your-domain.xyz/fanpress/index.php?module=fpcm/list
    * show all active articles (fulfils task of shownews.php from FanPress CM 1.x and 2.x)
* your-domain.xyz/fanpress/index.php?module=fpcm/archive
    * show article archive (fulfils task of shownews.php from FanPress CM 1.x and 2.x)
* your-domain.xyz/fanpress/index.php?module=fpcm/article&&id=A_DIGIT
    * show a single article with given id including comments
* your-domain.xyz/fanpress/index.php?module=fpcm/latest
    * show latest news

## RSS Feed

If you want to provide the RSS feed for your visitors, just create a link to your-domain.xyz/fanpress/index.php?module=fpcm/feed. The link does not depend on the way you're using FanPress CM.