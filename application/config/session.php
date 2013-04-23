<?php defined('SYSPATH') or die('No direct script access.');
/*
 * File: Session
 *
 * Options:
 *  driver         - Session driver name: 'cookie','database' or 'native'
 *  storage        - Session storage parameter, used by drivers
 *  name           - Default session name
 *  validate       - Session parameters to validate
 *  encryption     - Encryption key, set to FALSE to disable session encryption
 *  expiration     - Number of seconds that each session will last (set to 0 for session which expires on browser exit)
 *  regenerate     - Number of page loads before the session is regenerated (set to 0 for NO automatic regeneration)
 *  gc_probability - Percentage probability that garbage collection will be executed
 */
$config = array
(
	'driver'         => 'cookie',
	'storage'        => '',
	'name'           => 'baszczewski',
	'validate'       => array('user_agent'),
	'encryption'     => FALSE,
	'expiration'     => 7200,
	'regenerate'     => 3,
	'gc_probability' => 2
);