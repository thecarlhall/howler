<?php

namespace Model;

class Entry extends \Orm\Model
{
	protected static $_table_name = 'entries';

	protected static $_properties = array('id',
		'path' => array('validation' => array('required')),
		'artist',
		'album',
		'title',
		'genre',
		'size' => array('data_type' => 'int'),
		'track' => array('data_type' => 'int'),
		'created_at',
		'updated_at');

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array('before_insert'),
		'Orm\Observer_UpdatedAt' => array('before_save'),
	);
}
