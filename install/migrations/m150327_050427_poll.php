<?php

class m150327_050427_poll extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('{{poll_poll}}', [
			'id'          => "pk",
			'title'       => "string NOT NULL",
			'description' => "text",
			'status'      => "boolean NOT NULL DEFAULT '1'",
		], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

		$this->createTable('{{poll_choice}}',[
			'id'         => "pk",
			'poll_id'    => "integer NOT NULL",
			'label'      => "string NOT NULL DEFAULT ''",
			'votes'      => "integer NOT NULL DEFAULT '0'",
			'weight'     => "integer NOT NULL DEFAULT '0'",
		], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
		$this->addForeignKey("fk_{{poll_choice}}_poll", "{{poll_choice}}", "poll_id", "{{poll_poll}}", "id", 'CASCADE', 'CASCADE');

		$this->createTable('{{poll_vote}}',[
			'id'         => "pk",
			'choice_id'  => "integer NOT NULL",
			'poll_id'    => "integer NOT NULL",
			'user_id'    => "integer NOT NULL DEFAULT '0'",
			'ip_address' => "varchar(16) NOT NULL DEFAULT ''",
			'timestamp'  => "integer NOT NULL DEFAULT '0'",
		], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

		$this->addForeignKey("fk_{{poll_vote}}_poll", "{{poll_vote}}", "poll_id", "{{poll_poll}}", "id", 'CASCADE', 'CASCADE');
		$this->addForeignKey("fk_{{poll_vote}}_poll_choice", "{{poll_vote}}", "choice_id", "{{poll_choice}}", "id", 'CASCADE', 'CASCADE');
		// $this->addForeignKey("fk_{{poll_vote}}_user_user", "{{poll_vote}}", "user_id", "{{user_user}}", "id", 'CASCADE', 'CASCADE');
	}

	public function safeDown()
	{
		$this->dropForeignKey("fk_{{poll_choice}}_poll", "{{poll_choice}}");
		$this->dropForeignKey("fk_{{poll_vote}}_poll_choice", "{{poll_vote}}");
		$this->dropForeignKey("fk_{{poll_vote}}_poll", "{{poll_vote}}");
		// $this->dropForeignKey("fk_{{poll_vote}}_user_user", "{{poll_vote}}");

		$this->dropTable('{{poll_poll}}');
		$this->dropTable('{{poll_choice}}');
		$this->dropTable('{{poll_vote}}');
	}
}