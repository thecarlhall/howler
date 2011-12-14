<?php

namespace Fuel\Migrations;

class Create_entries {

	public function up()
	{
		\DBUtil::create_table('entries', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true),
			'path' => array('constraint' => 500, 'type' => 'varchar'),
			'artist' => array('constraint' => 150, 'type' => 'varchar', 'null' => true),
			'album' => array('constraint' => 150, 'type' => 'varchar', 'null' => true),
			'title' => array('constraint' => 150, 'type' => 'varchar', 'null' => true),
			'genre' => array('constraint' => 150, 'type' => 'varchar', 'null' => true),
			'track' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'size' => array('constraint' => 11, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int'),
			'updated_at' => array('constraint' => 11, 'type' => 'int'),
		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('entries');
	}
}