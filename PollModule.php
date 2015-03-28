<?php

/**
 * PollModule class file.
 *
 * @author Matt Kelliher
 * @license New BSD License
 * @version 0.9.2b
 */

/**
 * The Poll extension allows you to create polls for users to vote on.
 * Votes can be restricted by user ID, as well as by IP address.
 *
 * Installation:
 *   In order for this to work properly, you must have a User class
 *   where Yii::app()->user->id returns an integer id for the user.
 *   Also, you must configure/install the schema file located in:
 *     /data/poll.sql
 *   and adjust the tables & PollVote user_id foreign key as needed.
 *
 * Configuration:
 * <pre>
 * return array(
 *    ...
 *    'import' => array(
 *      'application.modules.poll.models.*',
 *      'application.modules.poll.components.*',
 *    ),
 *    'modules' => array(
 *      'poll' => array(
 *        // Force users to vote before seeing results
 *        'forceVote' => TRUE,
 *        // Restrict anonymous votes by IP address,
 *        // otherwise it's tied only to user_id 
 *        'ipRestrict' => TRUE,
 *        // Allow guests to cancel their votes
 *        // if ipRestrict is enabled
 *        'allowGuestCancel' => FALSE,
 *      ),
 *    ),
 * );
 * </pre>
 *
 * Usage:
 *
 * The Poll extension has the basic Gii-created CRUD functionality,
 * as well as a portlet to load elsewhere.
 *
 * To load the latest poll:
 * <pre>
 * $this->widget('EPoll');
 * </pre>
 *
 * To load a specific poll:
 * <pre>
 * $this->widget('EPoll', array('poll_id' => 1));
 * </pre>
 */
use yupe\components\WebModule;

class PollModule extends WebModule
{
	const VERSION = '0.1';

	public $defaultController = 'poll';

	/**
	 * @property boolean Force users to vote before seeing results.
	 */
	public $forceVote = true;

	/**
	 * @property boolean Restrict anonymous votes by IP address,
	 * otherwise it's tied only to the user's ID.
	 */
	public $ipRestrict = true;

	/**
	 * @property boolean Allow guests to cancel their votes
	 * if $ipRestrict is enabled.
	 */
	public $allowGuestCancel = false;
	
	public function getVersion()
	{
		return self::VERSION;
	}

	public function getDependencies()
	{
		return [
			'user',
		];
	}

	public function getCategory()
	{
		return Yii::t('PollModule.poll', 'Users');
	}

	public function getName()
	{
		return Yii::t('PollModule.poll', 'Poll');
	}

	public function getDescription()
	{
		return Yii::t('PollModule.poll', 'Voting module users');
	}

	public function getAuthor()
	{
		return Yii::t('PollModule.poll', 'UnnamedTeam');
	}

	public function getAuthorEmail()
	{
		return Yii::t('PollModule.poll', 'max100491@mail.ru');
	}

	public function getAdminPageLink()
	{
		return '/poll/pollBackend/index';
	}

	public function getIcon()
	{
		return "glyphicon glyphicon-check";
	}

	public function getEditableParams()
	{
		return [
			"defaultController",
			"forceVote",
			"ipRestrict",
			"allowGuestCancel",
		];
	}

	public function getNavigation()
	{
		return [
			['label' => Yii::t('PollModule.poll', 'Poll')],
			[
				'icon'  => 'glyphicon glyphicon-align-justify',
				'label' => Yii::t('PollModule.poll', 'Poll'),
				'url'   => ['/pull/pollBackend/index']
			],
			[
				'icon'  => 'glyphicon glyphicon-check',
				'label' => Yii::t('Poll choice', 'Poll choice'),
				'url'   => ['/poll/pollChoiceBackend/index']
			],
			[
				'icon'  => 'glyphicon glyphicon-comment',
				'label' => Yii::t('PollModule.poll', 'Poll vote'),
				'url'   => ['/poll/pollVoteBackend/index']
			],
		];
	}

	public function init()
	{
		$this->setImport(array(
			'poll.components.*',
			'poll.models.*',
		));

		// $assetsFolder = Yii::app()->assetManager->publish(
		// 	Yii::getPathOfAlias('application.modules.poll.assets')
		// );
		// Yii::app()->clientScript->registerCssFile($assetsFolder .'/poll.css');
		
		parent::init();
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
