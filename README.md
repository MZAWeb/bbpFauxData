bbpFauxData
===========

Quick and dirty plugin to help you populate a bbPress instance with faux data to test performance

It uses https://github.com/fzaninotto/Faker to generate data that seems real.

Example
======

Once you install and activate this plugin, you can do:

```php
ini_set( 'max_execution_time', 30000 );
ini_set( 'memory_limit', '1024M' );

$bfd = new bbpFauxData();

const USERS   = 50;
const FORUMS  = 5;
const TOPICS  = 100;
const REPLIES = 1000;

for ( $i = 0; $i < USERS; $i++ ) {
	$bfd->generate_user();
}

for ( $i = 0; $i < FORUMS; $i++ ) {
	$bfd->generate_forum();
}

for ( $i = 0; $i < TOPICS; $i++ ) {
	$bfd->generate_topic();
}

for ( $i = 0; $i < REPLIES; $i++ ) {
	$bfd->generate_reply();
}
```
