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

$dd = new DummyData();

const USERS   = 50;
const FORUMS  = 5;
const TOPICS  = 100;
const REPLIES = 1000;

for ( $i = 0; $i < USERS; $i++ ) {
  $dd->generate_user();
}

for ( $i = 0; $i < FORUMS; $i++ ) {
	$dd->generate_forum();
}

for ( $i = 0; $i < TOPICS; $i++ ) {
	$dd->generate_topic();
}

for ( $i = 0; $i < REPLIES; $i++ ) {
	$dd->generate_reply();
}
```
