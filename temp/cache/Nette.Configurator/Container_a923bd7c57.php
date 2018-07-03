<?php
// source: D:\WWW\web-portal-slozeny\app/config/config.neon 
// source: D:\WWW\web-portal-slozeny\app/config/config.local.neon 

class Container_a923bd7c57 extends Nette\DI\Container
{
	protected $meta = [
		'types' => [
			'Nette\Application\Application' => [1 => ['application.application']],
			'Nette\Application\IPresenterFactory' => [1 => ['application.presenterFactory']],
			'Nette\Application\LinkGenerator' => [1 => ['application.linkGenerator']],
			'Nette\Caching\Storages\IJournal' => [1 => ['cache.journal']],
			'Nette\Caching\IStorage' => [1 => ['cache.storage']],
			'Nette\Database\Connection' => [1 => ['database.default.connection']],
			'Nette\Database\IStructure' => [1 => ['database.default.structure']],
			'Nette\Database\Structure' => [1 => ['database.default.structure']],
			'Nette\Database\IConventions' => [1 => ['database.default.conventions']],
			'Nette\Database\Conventions\DiscoveredConventions' => [1 => ['database.default.conventions']],
			'Nette\Database\Context' => [1 => ['database.default.context']],
			'Nette\Http\RequestFactory' => [1 => ['http.requestFactory']],
			'Nette\Http\IRequest' => [1 => ['http.request']],
			'Nette\Http\Request' => [1 => ['http.request']],
			'Nette\Http\IResponse' => [1 => ['http.response']],
			'Nette\Http\Response' => [1 => ['http.response']],
			'Nette\Http\Context' => [1 => ['http.context']],
			'Nette\Bridges\ApplicationLatte\ILatteFactory' => [1 => ['latte.latteFactory']],
			'Nette\Application\UI\ITemplateFactory' => [1 => ['latte.templateFactory']],
			'Nette\Mail\IMailer' => [1 => ['mail.mailer']],
			'Nette\Application\IRouter' => [1 => ['routing.router']],
			'Nette\Security\IUserStorage' => [1 => ['security.userStorage']],
			'Nette\Security\User' => [1 => ['security.user']],
			'Nette\Security\IAuthorizator' => [1 => ['security.authorizator']],
			'Nette\Http\Session' => [1 => ['session.session']],
			'Tracy\ILogger' => [1 => ['tracy.logger']],
			'Tracy\BlueScreen' => [1 => ['tracy.blueScreen']],
			'Tracy\Bar' => [1 => ['tracy.bar']],
			'App\Model\BaseManager' => [
				1 => [
					'25_App_Model_AnswerManager',
					'26_App_Model_CategoryManager',
					'27_App_Model_CommentManager',
					'28_App_Model_ConditionManager',
					'29_App_Model_ExerciseManager',
					'30_App_Model_ExerciseResultManager',
					'31_App_Model_ForumManager',
					'32_App_Model_LevelManager',
					'33_App_Model_PostManager',
					'34_App_Model_ProfileManager',
					'35_App_Model_QuestionManager',
					'36_App_Model_SectionManager',
					'37_App_Model_TestManager',
					'38_App_Model_TextManager',
					'39_App_Model_ThreadManager',
					'40_App_Model_TutorialManager',
					'47_App_Model_ResultManager',
					'authenticator',
				],
			],
			'Nette\Object' => [
				1 => [
					'25_App_Model_AnswerManager',
					'26_App_Model_CategoryManager',
					'27_App_Model_CommentManager',
					'28_App_Model_ConditionManager',
					'29_App_Model_ExerciseManager',
					'30_App_Model_ExerciseResultManager',
					'31_App_Model_ForumManager',
					'32_App_Model_LevelManager',
					'33_App_Model_PostManager',
					'34_App_Model_ProfileManager',
					'35_App_Model_QuestionManager',
					'36_App_Model_SectionManager',
					'37_App_Model_TestManager',
					'38_App_Model_TextManager',
					'39_App_Model_ThreadManager',
					'40_App_Model_TutorialManager',
					'47_App_Model_ResultManager',
					'authenticator',
				],
			],
			'App\Model\AnswerManager' => [1 => ['25_App_Model_AnswerManager']],
			'App\Model\CategoryManager' => [1 => ['26_App_Model_CategoryManager']],
			'App\Model\CommentManager' => [1 => ['27_App_Model_CommentManager']],
			'App\Model\ConditionManager' => [1 => ['28_App_Model_ConditionManager']],
			'App\Model\ExerciseManager' => [1 => ['29_App_Model_ExerciseManager']],
			'App\Model\ExerciseResultManager' => [1 => ['30_App_Model_ExerciseResultManager']],
			'App\Model\ForumManager' => [1 => ['31_App_Model_ForumManager']],
			'App\Model\LevelManager' => [1 => ['32_App_Model_LevelManager']],
			'App\Model\PostManager' => [1 => ['33_App_Model_PostManager']],
			'App\Model\ProfileManager' => [1 => ['34_App_Model_ProfileManager']],
			'App\Model\QuestionManager' => [1 => ['35_App_Model_QuestionManager']],
			'App\Model\SectionManager' => [1 => ['36_App_Model_SectionManager']],
			'App\Model\TestManager' => [1 => ['37_App_Model_TestManager']],
			'App\Model\TextManager' => [1 => ['38_App_Model_TextManager']],
			'App\Model\ThreadManager' => [1 => ['39_App_Model_ThreadManager']],
			'App\Model\TutorialManager' => [1 => ['40_App_Model_TutorialManager']],
			'App\RouterFactory' => [1 => ['41_App_RouterFactory']],
			'App\Components\IMenuControlFactory' => [1 => ['menuControlFactory']],
			'App\Components\IPictureControlFactory' => [1 => ['pictureControlFactory']],
			'App\Components\IPaginationControlFactory' => [1 => ['paginationControlFactory']],
			'App\Components\IUserControlFactory' => [1 => ['userControlFactory']],
			'App\Model\PictureManager' => [1 => ['46_App_Model_PictureManager']],
			'App\Model\ResultManager' => [1 => ['47_App_Model_ResultManager']],
			'Nette\Security\IAuthenticator' => [1 => ['authenticator']],
			'App\Model\UserManager' => [1 => ['authenticator']],
			'AdminModule\ManagePresenter' => [
				1 => [
					'application.1',
					'application.2',
					'application.4',
					'application.7',
					'application.9',
					'application.12',
					'application.14',
					'application.16',
					'application.17',
				],
			],
			'AdminModule\BasePresenter' => [
				1 => [
					'application.1',
					'application.2',
					'application.3',
					'application.4',
					'application.5',
					'application.6',
					'application.7',
					'application.8',
					'application.9',
					'application.10',
					'application.11',
					'application.12',
					'application.13',
					'application.14',
					'application.15',
					'application.16',
					'application.17',
				],
			],
			'Nette\Application\UI\Presenter' => [
				[
					'application.1',
					'application.2',
					'application.3',
					'application.4',
					'application.5',
					'application.6',
					'application.7',
					'application.8',
					'application.9',
					'application.10',
					'application.11',
					'application.12',
					'application.13',
					'application.14',
					'application.15',
					'application.16',
					'application.17',
					'application.18',
					'application.20',
					'application.21',
					'application.22',
					'application.23',
					'application.24',
					'application.25',
					'application.26',
					'application.27',
					'application.28',
				],
			],
			'Nette\Application\UI\Control' => [
				[
					'application.1',
					'application.2',
					'application.3',
					'application.4',
					'application.5',
					'application.6',
					'application.7',
					'application.8',
					'application.9',
					'application.10',
					'application.11',
					'application.12',
					'application.13',
					'application.14',
					'application.15',
					'application.16',
					'application.17',
					'application.18',
					'application.20',
					'application.21',
					'application.22',
					'application.23',
					'application.24',
					'application.25',
					'application.26',
					'application.27',
					'application.28',
				],
			],
			'Nette\Application\UI\Component' => [
				[
					'application.1',
					'application.2',
					'application.3',
					'application.4',
					'application.5',
					'application.6',
					'application.7',
					'application.8',
					'application.9',
					'application.10',
					'application.11',
					'application.12',
					'application.13',
					'application.14',
					'application.15',
					'application.16',
					'application.17',
					'application.18',
					'application.20',
					'application.21',
					'application.22',
					'application.23',
					'application.24',
					'application.25',
					'application.26',
					'application.27',
					'application.28',
				],
			],
			'Nette\ComponentModel\Container' => [
				[
					'application.1',
					'application.2',
					'application.3',
					'application.4',
					'application.5',
					'application.6',
					'application.7',
					'application.8',
					'application.9',
					'application.10',
					'application.11',
					'application.12',
					'application.13',
					'application.14',
					'application.15',
					'application.16',
					'application.17',
					'application.18',
					'application.20',
					'application.21',
					'application.22',
					'application.23',
					'application.24',
					'application.25',
					'application.26',
					'application.27',
					'application.28',
				],
			],
			'Nette\ComponentModel\Component' => [
				[
					'application.1',
					'application.2',
					'application.3',
					'application.4',
					'application.5',
					'application.6',
					'application.7',
					'application.8',
					'application.9',
					'application.10',
					'application.11',
					'application.12',
					'application.13',
					'application.14',
					'application.15',
					'application.16',
					'application.17',
					'application.18',
					'application.20',
					'application.21',
					'application.22',
					'application.23',
					'application.24',
					'application.25',
					'application.26',
					'application.27',
					'application.28',
				],
			],
			'Nette\Application\IPresenter' => [
				[
					'application.1',
					'application.2',
					'application.3',
					'application.4',
					'application.5',
					'application.6',
					'application.7',
					'application.8',
					'application.9',
					'application.10',
					'application.11',
					'application.12',
					'application.13',
					'application.14',
					'application.15',
					'application.16',
					'application.17',
					'application.18',
					'application.19',
					'application.20',
					'application.21',
					'application.22',
					'application.23',
					'application.24',
					'application.25',
					'application.26',
					'application.27',
					'application.28',
					'application.29',
					'application.30',
				],
			],
			'ArrayAccess' => [
				[
					'application.1',
					'application.2',
					'application.3',
					'application.4',
					'application.5',
					'application.6',
					'application.7',
					'application.8',
					'application.9',
					'application.10',
					'application.11',
					'application.12',
					'application.13',
					'application.14',
					'application.15',
					'application.16',
					'application.17',
					'application.18',
					'application.20',
					'application.21',
					'application.22',
					'application.23',
					'application.24',
					'application.25',
					'application.26',
					'application.27',
					'application.28',
				],
			],
			'Nette\Application\UI\IStatePersistent' => [
				[
					'application.1',
					'application.2',
					'application.3',
					'application.4',
					'application.5',
					'application.6',
					'application.7',
					'application.8',
					'application.9',
					'application.10',
					'application.11',
					'application.12',
					'application.13',
					'application.14',
					'application.15',
					'application.16',
					'application.17',
					'application.18',
					'application.20',
					'application.21',
					'application.22',
					'application.23',
					'application.24',
					'application.25',
					'application.26',
					'application.27',
					'application.28',
				],
			],
			'Nette\Application\UI\ISignalReceiver' => [
				[
					'application.1',
					'application.2',
					'application.3',
					'application.4',
					'application.5',
					'application.6',
					'application.7',
					'application.8',
					'application.9',
					'application.10',
					'application.11',
					'application.12',
					'application.13',
					'application.14',
					'application.15',
					'application.16',
					'application.17',
					'application.18',
					'application.20',
					'application.21',
					'application.22',
					'application.23',
					'application.24',
					'application.25',
					'application.26',
					'application.27',
					'application.28',
				],
			],
			'Nette\ComponentModel\IComponent' => [
				[
					'application.1',
					'application.2',
					'application.3',
					'application.4',
					'application.5',
					'application.6',
					'application.7',
					'application.8',
					'application.9',
					'application.10',
					'application.11',
					'application.12',
					'application.13',
					'application.14',
					'application.15',
					'application.16',
					'application.17',
					'application.18',
					'application.20',
					'application.21',
					'application.22',
					'application.23',
					'application.24',
					'application.25',
					'application.26',
					'application.27',
					'application.28',
				],
			],
			'Nette\ComponentModel\IContainer' => [
				[
					'application.1',
					'application.2',
					'application.3',
					'application.4',
					'application.5',
					'application.6',
					'application.7',
					'application.8',
					'application.9',
					'application.10',
					'application.11',
					'application.12',
					'application.13',
					'application.14',
					'application.15',
					'application.16',
					'application.17',
					'application.18',
					'application.20',
					'application.21',
					'application.22',
					'application.23',
					'application.24',
					'application.25',
					'application.26',
					'application.27',
					'application.28',
				],
			],
			'Nette\Application\UI\IRenderable' => [
				[
					'application.1',
					'application.2',
					'application.3',
					'application.4',
					'application.5',
					'application.6',
					'application.7',
					'application.8',
					'application.9',
					'application.10',
					'application.11',
					'application.12',
					'application.13',
					'application.14',
					'application.15',
					'application.16',
					'application.17',
					'application.18',
					'application.20',
					'application.21',
					'application.22',
					'application.23',
					'application.24',
					'application.25',
					'application.26',
					'application.27',
					'application.28',
				],
			],
			'AdminModule\CategoriesPresenter' => [1 => ['application.1']],
			'AdminModule\CommentsPresenter' => [1 => ['application.2']],
			'AdminModule\ContentPresenter' => [1 => ['application.3', 'application.11', 'application.15']],
			'AdminModule\ExercisePresenter' => [1 => ['application.3']],
			'AdminModule\ExercisesPresenter' => [1 => ['application.4']],
			'AdminModule\HomepagePresenter' => [1 => ['application.5']],
			'AdminModule\LevelPresenter' => [1 => ['application.6']],
			'AdminModule\MenuPresenter' => [1 => ['application.8']],
			'AdminModule\PostsPresenter' => [1 => ['application.9']],
			'AdminModule\SectionsPresenter' => [1 => ['application.10']],
			'AdminModule\TestPresenter' => [1 => ['application.11']],
			'AdminModule\TestsPresenter' => [1 => ['application.12']],
			'AdminModule\TextPresenter' => [1 => ['application.13']],
			'AdminModule\ThreadsPresenter' => [1 => ['application.14']],
			'AdminModule\TutorialPresenter' => [1 => ['application.15']],
			'AdminModule\TutorialsPresenter' => [1 => ['application.16']],
			'AdminModule\UsersPresenter' => [1 => ['application.17']],
			'FrontModule\BasePresenter' => [
				1 => [
					'application.18',
					'application.20',
					'application.21',
					'application.22',
					'application.23',
					'application.24',
					'application.25',
					'application.26',
					'application.27',
					'application.28',
				],
			],
			'FrontModule\Error4xxPresenter' => [1 => ['application.18']],
			'FrontModule\ErrorPresenter' => [1 => ['application.19']],
			'FrontModule\ExercisePresenter' => [1 => ['application.20']],
			'FrontModule\ContentPresenter' => [1 => ['application.21', 'application.28']],
			'FrontModule\ForumPresenter' => [1 => ['application.21']],
			'FrontModule\HomepagePresenter' => [1 => ['application.22']],
			'FrontModule\ProfilePresenter' => [1 => ['application.23']],
			'FrontModule\RankPresenter' => [1 => ['application.24']],
			'FrontModule\SectionPresenter' => [1 => ['application.25']],
			'FrontModule\SignPresenter' => [1 => ['application.26']],
			'FrontModule\TestPresenter' => [1 => ['application.27']],
			'FrontModule\TutorialPresenter' => [1 => ['application.28']],
			'NetteModule\ErrorPresenter' => [1 => ['application.29']],
			'NetteModule\MicroPresenter' => [1 => ['application.30']],
			'Nette\DI\Container' => [1 => ['container']],
		],
		'services' => [
			'25_App_Model_AnswerManager' => 'App\Model\AnswerManager',
			'26_App_Model_CategoryManager' => 'App\Model\CategoryManager',
			'27_App_Model_CommentManager' => 'App\Model\CommentManager',
			'28_App_Model_ConditionManager' => 'App\Model\ConditionManager',
			'29_App_Model_ExerciseManager' => 'App\Model\ExerciseManager',
			'30_App_Model_ExerciseResultManager' => 'App\Model\ExerciseResultManager',
			'31_App_Model_ForumManager' => 'App\Model\ForumManager',
			'32_App_Model_LevelManager' => 'App\Model\LevelManager',
			'33_App_Model_PostManager' => 'App\Model\PostManager',
			'34_App_Model_ProfileManager' => 'App\Model\ProfileManager',
			'35_App_Model_QuestionManager' => 'App\Model\QuestionManager',
			'36_App_Model_SectionManager' => 'App\Model\SectionManager',
			'37_App_Model_TestManager' => 'App\Model\TestManager',
			'38_App_Model_TextManager' => 'App\Model\TextManager',
			'39_App_Model_ThreadManager' => 'App\Model\ThreadManager',
			'40_App_Model_TutorialManager' => 'App\Model\TutorialManager',
			'41_App_RouterFactory' => 'App\RouterFactory',
			'46_App_Model_PictureManager' => 'App\Model\PictureManager',
			'47_App_Model_ResultManager' => 'App\Model\ResultManager',
			'application.1' => 'AdminModule\CategoriesPresenter',
			'application.10' => 'AdminModule\SectionsPresenter',
			'application.11' => 'AdminModule\TestPresenter',
			'application.12' => 'AdminModule\TestsPresenter',
			'application.13' => 'AdminModule\TextPresenter',
			'application.14' => 'AdminModule\ThreadsPresenter',
			'application.15' => 'AdminModule\TutorialPresenter',
			'application.16' => 'AdminModule\TutorialsPresenter',
			'application.17' => 'AdminModule\UsersPresenter',
			'application.18' => 'FrontModule\Error4xxPresenter',
			'application.19' => 'FrontModule\ErrorPresenter',
			'application.2' => 'AdminModule\CommentsPresenter',
			'application.20' => 'FrontModule\ExercisePresenter',
			'application.21' => 'FrontModule\ForumPresenter',
			'application.22' => 'FrontModule\HomepagePresenter',
			'application.23' => 'FrontModule\ProfilePresenter',
			'application.24' => 'FrontModule\RankPresenter',
			'application.25' => 'FrontModule\SectionPresenter',
			'application.26' => 'FrontModule\SignPresenter',
			'application.27' => 'FrontModule\TestPresenter',
			'application.28' => 'FrontModule\TutorialPresenter',
			'application.29' => 'NetteModule\ErrorPresenter',
			'application.3' => 'AdminModule\ExercisePresenter',
			'application.30' => 'NetteModule\MicroPresenter',
			'application.4' => 'AdminModule\ExercisesPresenter',
			'application.5' => 'AdminModule\HomepagePresenter',
			'application.6' => 'AdminModule\LevelPresenter',
			'application.7' => 'AdminModule\ManagePresenter',
			'application.8' => 'AdminModule\MenuPresenter',
			'application.9' => 'AdminModule\PostsPresenter',
			'application.application' => 'Nette\Application\Application',
			'application.linkGenerator' => 'Nette\Application\LinkGenerator',
			'application.presenterFactory' => 'Nette\Application\IPresenterFactory',
			'authenticator' => 'App\Model\UserManager',
			'cache.journal' => 'Nette\Caching\Storages\IJournal',
			'cache.storage' => 'Nette\Caching\IStorage',
			'container' => 'Nette\DI\Container',
			'database.default.connection' => 'Nette\Database\Connection',
			'database.default.context' => 'Nette\Database\Context',
			'database.default.conventions' => 'Nette\Database\Conventions\DiscoveredConventions',
			'database.default.structure' => 'Nette\Database\Structure',
			'http.context' => 'Nette\Http\Context',
			'http.request' => 'Nette\Http\Request',
			'http.requestFactory' => 'Nette\Http\RequestFactory',
			'http.response' => 'Nette\Http\Response',
			'latte.latteFactory' => 'Latte\Engine',
			'latte.templateFactory' => 'Nette\Application\UI\ITemplateFactory',
			'mail.mailer' => 'Nette\Mail\IMailer',
			'menuControlFactory' => 'App\Components\MenuControl',
			'paginationControlFactory' => 'App\Components\PaginationControl',
			'pictureControlFactory' => 'App\Components\PictureControl',
			'routing.router' => 'Nette\Application\IRouter',
			'security.authorizator' => 'Nette\Security\IAuthorizator',
			'security.user' => 'Nette\Security\User',
			'security.userStorage' => 'Nette\Security\IUserStorage',
			'session.session' => 'Nette\Http\Session',
			'tracy.bar' => 'Tracy\Bar',
			'tracy.blueScreen' => 'Tracy\BlueScreen',
			'tracy.logger' => 'Tracy\ILogger',
			'userControlFactory' => 'App\Components\UserControl',
		],
		'tags' => [
			'inject' => [
				'application.1' => TRUE,
				'application.10' => TRUE,
				'application.11' => TRUE,
				'application.12' => TRUE,
				'application.13' => TRUE,
				'application.14' => TRUE,
				'application.15' => TRUE,
				'application.16' => TRUE,
				'application.17' => TRUE,
				'application.18' => TRUE,
				'application.19' => TRUE,
				'application.2' => TRUE,
				'application.20' => TRUE,
				'application.21' => TRUE,
				'application.22' => TRUE,
				'application.23' => TRUE,
				'application.24' => TRUE,
				'application.25' => TRUE,
				'application.26' => TRUE,
				'application.27' => TRUE,
				'application.28' => TRUE,
				'application.29' => TRUE,
				'application.3' => TRUE,
				'application.30' => TRUE,
				'application.4' => TRUE,
				'application.5' => TRUE,
				'application.6' => TRUE,
				'application.7' => TRUE,
				'application.8' => TRUE,
				'application.9' => TRUE,
			],
			'nette.presenter' => [
				'application.1' => 'AdminModule\CategoriesPresenter',
				'application.10' => 'AdminModule\SectionsPresenter',
				'application.11' => 'AdminModule\TestPresenter',
				'application.12' => 'AdminModule\TestsPresenter',
				'application.13' => 'AdminModule\TextPresenter',
				'application.14' => 'AdminModule\ThreadsPresenter',
				'application.15' => 'AdminModule\TutorialPresenter',
				'application.16' => 'AdminModule\TutorialsPresenter',
				'application.17' => 'AdminModule\UsersPresenter',
				'application.18' => 'FrontModule\Error4xxPresenter',
				'application.19' => 'FrontModule\ErrorPresenter',
				'application.2' => 'AdminModule\CommentsPresenter',
				'application.20' => 'FrontModule\ExercisePresenter',
				'application.21' => 'FrontModule\ForumPresenter',
				'application.22' => 'FrontModule\HomepagePresenter',
				'application.23' => 'FrontModule\ProfilePresenter',
				'application.24' => 'FrontModule\RankPresenter',
				'application.25' => 'FrontModule\SectionPresenter',
				'application.26' => 'FrontModule\SignPresenter',
				'application.27' => 'FrontModule\TestPresenter',
				'application.28' => 'FrontModule\TutorialPresenter',
				'application.29' => 'NetteModule\ErrorPresenter',
				'application.3' => 'AdminModule\ExercisePresenter',
				'application.30' => 'NetteModule\MicroPresenter',
				'application.4' => 'AdminModule\ExercisesPresenter',
				'application.5' => 'AdminModule\HomepagePresenter',
				'application.6' => 'AdminModule\LevelPresenter',
				'application.7' => 'AdminModule\ManagePresenter',
				'application.8' => 'AdminModule\MenuPresenter',
				'application.9' => 'AdminModule\PostsPresenter',
			],
		],
		'aliases' => [
			'application' => 'application.application',
			'cacheStorage' => 'cache.storage',
			'database.default' => 'database.default.connection',
			'httpRequest' => 'http.request',
			'httpResponse' => 'http.response',
			'nette.authorizator' => 'security.authorizator',
			'nette.cacheJournal' => 'cache.journal',
			'nette.database.default' => 'database.default',
			'nette.database.default.context' => 'database.default.context',
			'nette.httpContext' => 'http.context',
			'nette.httpRequestFactory' => 'http.requestFactory',
			'nette.latteFactory' => 'latte.latteFactory',
			'nette.mailer' => 'mail.mailer',
			'nette.presenterFactory' => 'application.presenterFactory',
			'nette.templateFactory' => 'latte.templateFactory',
			'nette.userStorage' => 'security.userStorage',
			'router' => 'routing.router',
			'session' => 'session.session',
			'user' => 'security.user',
		],
	];


	public function __construct(array $params = [])
	{
		$this->parameters = $params;
		$this->parameters += [
			'appDir' => 'D:\WWW\web-portal-slozeny\app',
			'wwwDir' => 'D:\WWW\web-portal-slozeny\www',
			'debugMode' => TRUE,
			'productionMode' => FALSE,
			'consoleMode' => FALSE,
			'tempDir' => 'D:\WWW\web-portal-slozeny\app/../temp',
			'email' => 'administrator@uc-se-web.cz',
			'emailText' => "Z va\xc5\xa1eho \xc3\xba\xc4\x8dtu na serveru U\xc4\x8d-se-web.cz byla odesl\xc3\xa1na \xc5\xbe\xc3\xa1dost o resetov\xc3\xa1n\xc3\xad hesla.\nV p\xc5\x99\xc3\xadpad\xc4\x9b \xc5\xbee chcete heslo resetovat, klikn\xc4\x9bte na odkaz n\xc3\xad\xc5\xbee. ",
			'maxFileSize' => 256,
			'imageSize' => [160, 160],
			'questionImageSize' => [500, 300],
			'questionMaxFileSize' => 512,
			'exerciseImageSize' => [500, 300],
			'exerciseMaxFileSize' => 512,
			'passwordLength' => 7,
			'testRewrite' => 90,
			'tokenValidity' => 1,
		];
	}


	public function createService__25_App_Model_AnswerManager(): App\Model\AnswerManager
	{
		$service = new App\Model\AnswerManager($this->getService('database.default.context'),
			$this->getService('46_App_Model_PictureManager'));
		return $service;
	}


	public function createService__26_App_Model_CategoryManager(): App\Model\CategoryManager
	{
		$service = new App\Model\CategoryManager($this->getService('database.default.context'),
			$this->getService('46_App_Model_PictureManager'));
		return $service;
	}


	public function createService__27_App_Model_CommentManager(): App\Model\CommentManager
	{
		$service = new App\Model\CommentManager($this->getService('database.default.context'),
			$this->getService('46_App_Model_PictureManager'));
		return $service;
	}


	public function createService__28_App_Model_ConditionManager(): App\Model\ConditionManager
	{
		$service = new App\Model\ConditionManager($this->getService('database.default.context'),
			$this->getService('46_App_Model_PictureManager'));
		return $service;
	}


	public function createService__29_App_Model_ExerciseManager(): App\Model\ExerciseManager
	{
		$service = new App\Model\ExerciseManager($this->getService('database.default.context'),
			$this->getService('46_App_Model_PictureManager'), $this->getService('28_App_Model_ConditionManager'));
		return $service;
	}


	public function createService__30_App_Model_ExerciseResultManager(): App\Model\ExerciseResultManager
	{
		$service = new App\Model\ExerciseResultManager($this->getService('database.default.context'),
			$this->getService('46_App_Model_PictureManager'), $this->getService('authenticator'));
		return $service;
	}


	public function createService__31_App_Model_ForumManager(): App\Model\ForumManager
	{
		$service = new App\Model\ForumManager($this->getService('database.default.context'),
			$this->getService('46_App_Model_PictureManager'));
		return $service;
	}


	public function createService__32_App_Model_LevelManager(): App\Model\LevelManager
	{
		$service = new App\Model\LevelManager($this->getService('database.default.context'),
			$this->getService('46_App_Model_PictureManager'));
		return $service;
	}


	public function createService__33_App_Model_PostManager(): App\Model\PostManager
	{
		$service = new App\Model\PostManager($this->getService('database.default.context'),
			$this->getService('46_App_Model_PictureManager'));
		return $service;
	}


	public function createService__34_App_Model_ProfileManager(): App\Model\ProfileManager
	{
		$service = new App\Model\ProfileManager($this->getService('database.default.context'),
			$this->getService('46_App_Model_PictureManager'));
		return $service;
	}


	public function createService__35_App_Model_QuestionManager(): App\Model\QuestionManager
	{
		$service = new App\Model\QuestionManager($this->getService('database.default.context'),
			$this->getService('46_App_Model_PictureManager'), $this->getService('25_App_Model_AnswerManager'));
		return $service;
	}


	public function createService__36_App_Model_SectionManager(): App\Model\SectionManager
	{
		$service = new App\Model\SectionManager($this->getService('database.default.context'),
			$this->getService('46_App_Model_PictureManager'));
		return $service;
	}


	public function createService__37_App_Model_TestManager(): App\Model\TestManager
	{
		$service = new App\Model\TestManager($this->getService('database.default.context'),
			$this->getService('46_App_Model_PictureManager'), $this->getService('35_App_Model_QuestionManager'),
			$this->getService('25_App_Model_AnswerManager'), $this->getService('47_App_Model_ResultManager'));
		return $service;
	}


	public function createService__38_App_Model_TextManager(): App\Model\TextManager
	{
		$service = new App\Model\TextManager($this->getService('database.default.context'),
			$this->getService('46_App_Model_PictureManager'));
		return $service;
	}


	public function createService__39_App_Model_ThreadManager(): App\Model\ThreadManager
	{
		$service = new App\Model\ThreadManager($this->getService('database.default.context'),
			$this->getService('46_App_Model_PictureManager'));
		return $service;
	}


	public function createService__40_App_Model_TutorialManager(): App\Model\TutorialManager
	{
		$service = new App\Model\TutorialManager($this->getService('database.default.context'),
			$this->getService('46_App_Model_PictureManager'));
		return $service;
	}


	public function createService__41_App_RouterFactory(): App\RouterFactory
	{
		$service = new App\RouterFactory;
		return $service;
	}


	public function createService__46_App_Model_PictureManager(): App\Model\PictureManager
	{
		$service = new App\Model\PictureManager(256, [160, 160], [500, 300], 512, [500, 300],
			512, $this->getService('database.default.context'));
		return $service;
	}


	public function createService__47_App_Model_ResultManager(): App\Model\ResultManager
	{
		$service = new App\Model\ResultManager(90, $this->getService('database.default.context'),
			$this->getService('46_App_Model_PictureManager'), $this->getService('authenticator'));
		return $service;
	}


	public function createServiceApplication__1(): AdminModule\CategoriesPresenter
	{
		$service = new AdminModule\CategoriesPresenter($this->getService('26_App_Model_CategoryManager'),
			$this->getService('36_App_Model_SectionManager'), $this->getService('46_App_Model_PictureManager'),
			$this->getService('38_App_Model_TextManager'), $this->getService('31_App_Model_ForumManager'),
			$this->getService('paginationControlFactory'), $this->getService('pictureControlFactory'),
			$this->getService('menuControlFactory'), $this->getService('userControlFactory'));
		$service->injectPrimary($this, $this->getService('application.presenterFactory'),
			$this->getService('routing.router'), $this->getService('http.request'),
			$this->getService('http.response'), $this->getService('session.session'),
			$this->getService('security.user'), $this->getService('latte.templateFactory'));
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__10(): AdminModule\SectionsPresenter
	{
		$service = new AdminModule\SectionsPresenter($this->getService('26_App_Model_CategoryManager'),
			$this->getService('36_App_Model_SectionManager'), $this->getService('46_App_Model_PictureManager'),
			$this->getService('38_App_Model_TextManager'), $this->getService('paginationControlFactory'),
			$this->getService('pictureControlFactory'), $this->getService('menuControlFactory'),
			$this->getService('userControlFactory'));
		$service->injectPrimary($this, $this->getService('application.presenterFactory'),
			$this->getService('routing.router'), $this->getService('http.request'),
			$this->getService('http.response'), $this->getService('session.session'),
			$this->getService('security.user'), $this->getService('latte.templateFactory'));
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__11(): AdminModule\TestPresenter
	{
		$service = new AdminModule\TestPresenter($this->getService('26_App_Model_CategoryManager'),
			$this->getService('36_App_Model_SectionManager'), $this->getService('46_App_Model_PictureManager'),
			$this->getService('38_App_Model_TextManager'), $this->getService('37_App_Model_TestManager'),
			$this->getService('paginationControlFactory'), $this->getService('pictureControlFactory'),
			$this->getService('menuControlFactory'), $this->getService('userControlFactory'));
		$service->injectPrimary($this, $this->getService('application.presenterFactory'),
			$this->getService('routing.router'), $this->getService('http.request'),
			$this->getService('http.response'), $this->getService('session.session'),
			$this->getService('security.user'), $this->getService('latte.templateFactory'));
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__12(): AdminModule\TestsPresenter
	{
		$service = new AdminModule\TestsPresenter($this->getService('26_App_Model_CategoryManager'),
			$this->getService('36_App_Model_SectionManager'), $this->getService('46_App_Model_PictureManager'),
			$this->getService('38_App_Model_TextManager'), $this->getService('37_App_Model_TestManager'),
			$this->getService('paginationControlFactory'), $this->getService('pictureControlFactory'),
			$this->getService('menuControlFactory'), $this->getService('userControlFactory'));
		$service->injectPrimary($this, $this->getService('application.presenterFactory'),
			$this->getService('routing.router'), $this->getService('http.request'),
			$this->getService('http.response'), $this->getService('session.session'),
			$this->getService('security.user'), $this->getService('latte.templateFactory'));
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__13(): AdminModule\TextPresenter
	{
		$service = new AdminModule\TextPresenter($this->getService('26_App_Model_CategoryManager'),
			$this->getService('36_App_Model_SectionManager'), $this->getService('46_App_Model_PictureManager'),
			$this->getService('38_App_Model_TextManager'), $this->getService('paginationControlFactory'),
			$this->getService('pictureControlFactory'), $this->getService('menuControlFactory'),
			$this->getService('userControlFactory'));
		$service->injectPrimary($this, $this->getService('application.presenterFactory'),
			$this->getService('routing.router'), $this->getService('http.request'),
			$this->getService('http.response'), $this->getService('session.session'),
			$this->getService('security.user'), $this->getService('latte.templateFactory'));
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__14(): AdminModule\ThreadsPresenter
	{
		$service = new AdminModule\ThreadsPresenter($this->getService('26_App_Model_CategoryManager'),
			$this->getService('36_App_Model_SectionManager'), $this->getService('46_App_Model_PictureManager'),
			$this->getService('38_App_Model_TextManager'), $this->getService('39_App_Model_ThreadManager'),
			$this->getService('31_App_Model_ForumManager'), $this->getService('paginationControlFactory'),
			$this->getService('pictureControlFactory'), $this->getService('menuControlFactory'),
			$this->getService('userControlFactory'));
		$service->injectPrimary($this, $this->getService('application.presenterFactory'),
			$this->getService('routing.router'), $this->getService('http.request'),
			$this->getService('http.response'), $this->getService('session.session'),
			$this->getService('security.user'), $this->getService('latte.templateFactory'));
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__15(): AdminModule\TutorialPresenter
	{
		$service = new AdminModule\TutorialPresenter($this->getService('26_App_Model_CategoryManager'),
			$this->getService('36_App_Model_SectionManager'), $this->getService('46_App_Model_PictureManager'),
			$this->getService('38_App_Model_TextManager'), $this->getService('40_App_Model_TutorialManager'),
			$this->getService('paginationControlFactory'), $this->getService('pictureControlFactory'),
			$this->getService('menuControlFactory'), $this->getService('userControlFactory'));
		$service->injectPrimary($this, $this->getService('application.presenterFactory'),
			$this->getService('routing.router'), $this->getService('http.request'),
			$this->getService('http.response'), $this->getService('session.session'),
			$this->getService('security.user'), $this->getService('latte.templateFactory'));
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__16(): AdminModule\TutorialsPresenter
	{
		$service = new AdminModule\TutorialsPresenter($this->getService('26_App_Model_CategoryManager'),
			$this->getService('36_App_Model_SectionManager'), $this->getService('46_App_Model_PictureManager'),
			$this->getService('38_App_Model_TextManager'), $this->getService('40_App_Model_TutorialManager'),
			$this->getService('paginationControlFactory'), $this->getService('pictureControlFactory'),
			$this->getService('menuControlFactory'), $this->getService('userControlFactory'));
		$service->injectPrimary($this, $this->getService('application.presenterFactory'),
			$this->getService('routing.router'), $this->getService('http.request'),
			$this->getService('http.response'), $this->getService('session.session'),
			$this->getService('security.user'), $this->getService('latte.templateFactory'));
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__17(): AdminModule\UsersPresenter
	{
		$service = new AdminModule\UsersPresenter($this->getService('26_App_Model_CategoryManager'),
			$this->getService('36_App_Model_SectionManager'), $this->getService('46_App_Model_PictureManager'),
			$this->getService('38_App_Model_TextManager'), $this->getService('authenticator'),
			$this->getService('paginationControlFactory'), $this->getService('pictureControlFactory'),
			$this->getService('menuControlFactory'), $this->getService('userControlFactory'));
		$service->injectPrimary($this, $this->getService('application.presenterFactory'),
			$this->getService('routing.router'), $this->getService('http.request'),
			$this->getService('http.response'), $this->getService('session.session'),
			$this->getService('security.user'), $this->getService('latte.templateFactory'));
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__18(): FrontModule\Error4xxPresenter
	{
		$service = new FrontModule\Error4xxPresenter($this->getService('26_App_Model_CategoryManager'),
			$this->getService('36_App_Model_SectionManager'), $this->getService('46_App_Model_PictureManager'),
			$this->getService('38_App_Model_TextManager'), $this->getService('paginationControlFactory'),
			$this->getService('pictureControlFactory'), $this->getService('menuControlFactory'),
			$this->getService('userControlFactory'));
		$service->injectPrimary($this, $this->getService('application.presenterFactory'),
			$this->getService('routing.router'), $this->getService('http.request'),
			$this->getService('http.response'), $this->getService('session.session'),
			$this->getService('security.user'), $this->getService('latte.templateFactory'));
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__19(): FrontModule\ErrorPresenter
	{
		$service = new FrontModule\ErrorPresenter($this->getService('tracy.logger'));
		return $service;
	}


	public function createServiceApplication__2(): AdminModule\CommentsPresenter
	{
		$service = new AdminModule\CommentsPresenter($this->getService('26_App_Model_CategoryManager'),
			$this->getService('36_App_Model_SectionManager'), $this->getService('46_App_Model_PictureManager'),
			$this->getService('38_App_Model_TextManager'), $this->getService('27_App_Model_CommentManager'),
			$this->getService('40_App_Model_TutorialManager'), $this->getService('paginationControlFactory'),
			$this->getService('pictureControlFactory'), $this->getService('menuControlFactory'),
			$this->getService('userControlFactory'));
		$service->injectPrimary($this, $this->getService('application.presenterFactory'),
			$this->getService('routing.router'), $this->getService('http.request'),
			$this->getService('http.response'), $this->getService('session.session'),
			$this->getService('security.user'), $this->getService('latte.templateFactory'));
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__20(): FrontModule\ExercisePresenter
	{
		$service = new FrontModule\ExercisePresenter($this->getService('26_App_Model_CategoryManager'),
			$this->getService('36_App_Model_SectionManager'), $this->getService('46_App_Model_PictureManager'),
			$this->getService('38_App_Model_TextManager'), $this->getService('29_App_Model_ExerciseManager'),
			$this->getService('30_App_Model_ExerciseResultManager'), $this->getService('paginationControlFactory'),
			$this->getService('pictureControlFactory'), $this->getService('menuControlFactory'),
			$this->getService('userControlFactory'));
		$service->injectPrimary($this, $this->getService('application.presenterFactory'),
			$this->getService('routing.router'), $this->getService('http.request'),
			$this->getService('http.response'), $this->getService('session.session'),
			$this->getService('security.user'), $this->getService('latte.templateFactory'));
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__21(): FrontModule\ForumPresenter
	{
		$service = new FrontModule\ForumPresenter($this->getService('26_App_Model_CategoryManager'),
			$this->getService('36_App_Model_SectionManager'), $this->getService('46_App_Model_PictureManager'),
			$this->getService('38_App_Model_TextManager'), $this->getService('31_App_Model_ForumManager'),
			$this->getService('39_App_Model_ThreadManager'), $this->getService('33_App_Model_PostManager'),
			$this->getService('paginationControlFactory'), $this->getService('pictureControlFactory'),
			$this->getService('menuControlFactory'), $this->getService('userControlFactory'));
		$service->injectPrimary($this, $this->getService('application.presenterFactory'),
			$this->getService('routing.router'), $this->getService('http.request'),
			$this->getService('http.response'), $this->getService('session.session'),
			$this->getService('security.user'), $this->getService('latte.templateFactory'));
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__22(): FrontModule\HomepagePresenter
	{
		$service = new FrontModule\HomepagePresenter($this->getService('26_App_Model_CategoryManager'),
			$this->getService('36_App_Model_SectionManager'), $this->getService('46_App_Model_PictureManager'),
			$this->getService('38_App_Model_TextManager'), $this->getService('paginationControlFactory'),
			$this->getService('pictureControlFactory'), $this->getService('menuControlFactory'),
			$this->getService('userControlFactory'));
		$service->injectPrimary($this, $this->getService('application.presenterFactory'),
			$this->getService('routing.router'), $this->getService('http.request'),
			$this->getService('http.response'), $this->getService('session.session'),
			$this->getService('security.user'), $this->getService('latte.templateFactory'));
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__23(): FrontModule\ProfilePresenter
	{
		$service = new FrontModule\ProfilePresenter($this->getService('26_App_Model_CategoryManager'),
			$this->getService('36_App_Model_SectionManager'), $this->getService('46_App_Model_PictureManager'),
			$this->getService('38_App_Model_TextManager'), $this->getService('34_App_Model_ProfileManager'),
			$this->getService('47_App_Model_ResultManager'), $this->getService('30_App_Model_ExerciseResultManager'),
			$this->getService('authenticator'), $this->getService('32_App_Model_LevelManager'),
			$this->getService('paginationControlFactory'), $this->getService('pictureControlFactory'),
			$this->getService('menuControlFactory'), $this->getService('userControlFactory'));
		$service->injectPrimary($this, $this->getService('application.presenterFactory'),
			$this->getService('routing.router'), $this->getService('http.request'),
			$this->getService('http.response'), $this->getService('session.session'),
			$this->getService('security.user'), $this->getService('latte.templateFactory'));
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__24(): FrontModule\RankPresenter
	{
		$service = new FrontModule\RankPresenter($this->getService('26_App_Model_CategoryManager'),
			$this->getService('36_App_Model_SectionManager'), $this->getService('46_App_Model_PictureManager'),
			$this->getService('38_App_Model_TextManager'), $this->getService('authenticator'),
			$this->getService('paginationControlFactory'), $this->getService('pictureControlFactory'),
			$this->getService('menuControlFactory'), $this->getService('userControlFactory'));
		$service->injectPrimary($this, $this->getService('application.presenterFactory'),
			$this->getService('routing.router'), $this->getService('http.request'),
			$this->getService('http.response'), $this->getService('session.session'),
			$this->getService('security.user'), $this->getService('latte.templateFactory'));
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__25(): FrontModule\SectionPresenter
	{
		$service = new FrontModule\SectionPresenter($this->getService('26_App_Model_CategoryManager'),
			$this->getService('36_App_Model_SectionManager'), $this->getService('46_App_Model_PictureManager'),
			$this->getService('38_App_Model_TextManager'), $this->getService('40_App_Model_TutorialManager'),
			$this->getService('29_App_Model_ExerciseManager'), $this->getService('37_App_Model_TestManager'),
			$this->getService('paginationControlFactory'), $this->getService('pictureControlFactory'),
			$this->getService('menuControlFactory'), $this->getService('userControlFactory'));
		$service->injectPrimary($this, $this->getService('application.presenterFactory'),
			$this->getService('routing.router'), $this->getService('http.request'),
			$this->getService('http.response'), $this->getService('session.session'),
			$this->getService('security.user'), $this->getService('latte.templateFactory'));
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__26(): FrontModule\SignPresenter
	{
		$service = new FrontModule\SignPresenter($this->getService('26_App_Model_CategoryManager'),
			$this->getService('36_App_Model_SectionManager'), $this->getService('46_App_Model_PictureManager'),
			$this->getService('38_App_Model_TextManager'), $this->getService('authenticator'),
			$this->getService('34_App_Model_ProfileManager'), $this->getService('paginationControlFactory'),
			$this->getService('pictureControlFactory'), $this->getService('menuControlFactory'),
			$this->getService('userControlFactory'));
		$service->injectPrimary($this, $this->getService('application.presenterFactory'),
			$this->getService('routing.router'), $this->getService('http.request'),
			$this->getService('http.response'), $this->getService('session.session'),
			$this->getService('security.user'), $this->getService('latte.templateFactory'));
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__27(): FrontModule\TestPresenter
	{
		$service = new FrontModule\TestPresenter($this->getService('26_App_Model_CategoryManager'),
			$this->getService('36_App_Model_SectionManager'), $this->getService('46_App_Model_PictureManager'),
			$this->getService('38_App_Model_TextManager'), $this->getService('37_App_Model_TestManager'),
			$this->getService('paginationControlFactory'), $this->getService('pictureControlFactory'),
			$this->getService('menuControlFactory'), $this->getService('userControlFactory'));
		$service->injectPrimary($this, $this->getService('application.presenterFactory'),
			$this->getService('routing.router'), $this->getService('http.request'),
			$this->getService('http.response'), $this->getService('session.session'),
			$this->getService('security.user'), $this->getService('latte.templateFactory'));
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__28(): FrontModule\TutorialPresenter
	{
		$service = new FrontModule\TutorialPresenter($this->getService('26_App_Model_CategoryManager'),
			$this->getService('36_App_Model_SectionManager'), $this->getService('46_App_Model_PictureManager'),
			$this->getService('38_App_Model_TextManager'), $this->getService('40_App_Model_TutorialManager'),
			$this->getService('27_App_Model_CommentManager'), $this->getService('paginationControlFactory'),
			$this->getService('pictureControlFactory'), $this->getService('menuControlFactory'),
			$this->getService('userControlFactory'));
		$service->injectPrimary($this, $this->getService('application.presenterFactory'),
			$this->getService('routing.router'), $this->getService('http.request'),
			$this->getService('http.response'), $this->getService('session.session'),
			$this->getService('security.user'), $this->getService('latte.templateFactory'));
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__29(): NetteModule\ErrorPresenter
	{
		$service = new NetteModule\ErrorPresenter($this->getService('tracy.logger'));
		return $service;
	}


	public function createServiceApplication__3(): AdminModule\ExercisePresenter
	{
		$service = new AdminModule\ExercisePresenter($this->getService('26_App_Model_CategoryManager'),
			$this->getService('36_App_Model_SectionManager'), $this->getService('46_App_Model_PictureManager'),
			$this->getService('38_App_Model_TextManager'), $this->getService('29_App_Model_ExerciseManager'),
			$this->getService('paginationControlFactory'), $this->getService('pictureControlFactory'),
			$this->getService('menuControlFactory'), $this->getService('userControlFactory'));
		$service->injectPrimary($this, $this->getService('application.presenterFactory'),
			$this->getService('routing.router'), $this->getService('http.request'),
			$this->getService('http.response'), $this->getService('session.session'),
			$this->getService('security.user'), $this->getService('latte.templateFactory'));
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__30(): NetteModule\MicroPresenter
	{
		$service = new NetteModule\MicroPresenter($this, $this->getService('http.request'),
			$this->getService('routing.router'));
		return $service;
	}


	public function createServiceApplication__4(): AdminModule\ExercisesPresenter
	{
		$service = new AdminModule\ExercisesPresenter($this->getService('26_App_Model_CategoryManager'),
			$this->getService('36_App_Model_SectionManager'), $this->getService('46_App_Model_PictureManager'),
			$this->getService('38_App_Model_TextManager'), $this->getService('29_App_Model_ExerciseManager'),
			$this->getService('paginationControlFactory'), $this->getService('pictureControlFactory'),
			$this->getService('menuControlFactory'), $this->getService('userControlFactory'));
		$service->injectPrimary($this, $this->getService('application.presenterFactory'),
			$this->getService('routing.router'), $this->getService('http.request'),
			$this->getService('http.response'), $this->getService('session.session'),
			$this->getService('security.user'), $this->getService('latte.templateFactory'));
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__5(): AdminModule\HomepagePresenter
	{
		$service = new AdminModule\HomepagePresenter($this->getService('26_App_Model_CategoryManager'),
			$this->getService('36_App_Model_SectionManager'), $this->getService('46_App_Model_PictureManager'),
			$this->getService('38_App_Model_TextManager'), $this->getService('paginationControlFactory'),
			$this->getService('pictureControlFactory'), $this->getService('menuControlFactory'),
			$this->getService('userControlFactory'));
		$service->injectPrimary($this, $this->getService('application.presenterFactory'),
			$this->getService('routing.router'), $this->getService('http.request'),
			$this->getService('http.response'), $this->getService('session.session'),
			$this->getService('security.user'), $this->getService('latte.templateFactory'));
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__6(): AdminModule\LevelPresenter
	{
		$service = new AdminModule\LevelPresenter($this->getService('26_App_Model_CategoryManager'),
			$this->getService('36_App_Model_SectionManager'), $this->getService('46_App_Model_PictureManager'),
			$this->getService('38_App_Model_TextManager'), $this->getService('32_App_Model_LevelManager'),
			$this->getService('authenticator'), $this->getService('paginationControlFactory'),
			$this->getService('pictureControlFactory'), $this->getService('menuControlFactory'),
			$this->getService('userControlFactory'));
		$service->injectPrimary($this, $this->getService('application.presenterFactory'),
			$this->getService('routing.router'), $this->getService('http.request'),
			$this->getService('http.response'), $this->getService('session.session'),
			$this->getService('security.user'), $this->getService('latte.templateFactory'));
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__7(): AdminModule\ManagePresenter
	{
		$service = new AdminModule\ManagePresenter($this->getService('26_App_Model_CategoryManager'),
			$this->getService('36_App_Model_SectionManager'), $this->getService('46_App_Model_PictureManager'),
			$this->getService('38_App_Model_TextManager'), $this->getService('paginationControlFactory'),
			$this->getService('pictureControlFactory'), $this->getService('menuControlFactory'),
			$this->getService('userControlFactory'));
		$service->injectPrimary($this, $this->getService('application.presenterFactory'),
			$this->getService('routing.router'), $this->getService('http.request'),
			$this->getService('http.response'), $this->getService('session.session'),
			$this->getService('security.user'), $this->getService('latte.templateFactory'));
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__8(): AdminModule\MenuPresenter
	{
		$service = new AdminModule\MenuPresenter($this->getService('26_App_Model_CategoryManager'),
			$this->getService('36_App_Model_SectionManager'), $this->getService('46_App_Model_PictureManager'),
			$this->getService('38_App_Model_TextManager'), $this->getService('paginationControlFactory'),
			$this->getService('pictureControlFactory'), $this->getService('menuControlFactory'),
			$this->getService('userControlFactory'));
		$service->injectPrimary($this, $this->getService('application.presenterFactory'),
			$this->getService('routing.router'), $this->getService('http.request'),
			$this->getService('http.response'), $this->getService('session.session'),
			$this->getService('security.user'), $this->getService('latte.templateFactory'));
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__9(): AdminModule\PostsPresenter
	{
		$service = new AdminModule\PostsPresenter($this->getService('26_App_Model_CategoryManager'),
			$this->getService('36_App_Model_SectionManager'), $this->getService('46_App_Model_PictureManager'),
			$this->getService('38_App_Model_TextManager'), $this->getService('33_App_Model_PostManager'),
			$this->getService('39_App_Model_ThreadManager'), $this->getService('31_App_Model_ForumManager'),
			$this->getService('paginationControlFactory'), $this->getService('pictureControlFactory'),
			$this->getService('menuControlFactory'), $this->getService('userControlFactory'));
		$service->injectPrimary($this, $this->getService('application.presenterFactory'),
			$this->getService('routing.router'), $this->getService('http.request'),
			$this->getService('http.response'), $this->getService('session.session'),
			$this->getService('security.user'), $this->getService('latte.templateFactory'));
		$service->invalidLinkMode = 5;
		return $service;
	}


	public function createServiceApplication__application(): Nette\Application\Application
	{
		$service = new Nette\Application\Application($this->getService('application.presenterFactory'),
			$this->getService('routing.router'), $this->getService('http.request'),
			$this->getService('http.response'));
		$service->catchExceptions = FALSE;
		$service->errorPresenter = 'Front:Error';
		Nette\Bridges\ApplicationTracy\RoutingPanel::initializePanel($service);
		$this->getService('tracy.bar')->addPanel(new Nette\Bridges\ApplicationTracy\RoutingPanel($this->getService('routing.router'),
			$this->getService('http.request'), $this->getService('application.presenterFactory')));
		return $service;
	}


	public function createServiceApplication__linkGenerator(): Nette\Application\LinkGenerator
	{
		$service = new Nette\Application\LinkGenerator($this->getService('routing.router'),
			$this->getService('http.request')->getUrl(), $this->getService('application.presenterFactory'));
		return $service;
	}


	public function createServiceApplication__presenterFactory(): Nette\Application\IPresenterFactory
	{
		$service = new Nette\Application\PresenterFactory(new Nette\Bridges\ApplicationDI\PresenterFactoryCallback($this, 5, 'D:\WWW\web-portal-slozeny\app/../temp/cache/Nette%5CBridges%5CApplicationDI%5CApplicationExtension'));
		$service->setMapping(['*' => '*Module\*Presenter']);
		return $service;
	}


	public function createServiceAuthenticator(): App\Model\UserManager
	{
		$service = new App\Model\UserManager('administrator@uc-se-web.cz', 1, 7, "Z va\xc5\xa1eho \xc3\xba\xc4\x8dtu na serveru U\xc4\x8d-se-web.cz byla odesl\xc3\xa1na \xc5\xbe\xc3\xa1dost o resetov\xc3\xa1n\xc3\xad hesla.\nV p\xc5\x99\xc3\xadpad\xc4\x9b \xc5\xbee chcete heslo resetovat, klikn\xc4\x9bte na odkaz n\xc3\xad\xc5\xbee. ",
			$this->getService('database.default.context'), $this->getService('46_App_Model_PictureManager'),
			$this->getService('34_App_Model_ProfileManager'), $this->getService('32_App_Model_LevelManager'));
		return $service;
	}


	public function createServiceCache__journal(): Nette\Caching\Storages\IJournal
	{
		$service = new Nette\Caching\Storages\SQLiteJournal('D:\WWW\web-portal-slozeny\app/../temp/cache/journal.s3db');
		return $service;
	}


	public function createServiceCache__storage(): Nette\Caching\IStorage
	{
		$service = new Nette\Caching\Storages\FileStorage('D:\WWW\web-portal-slozeny\app/../temp/cache',
			$this->getService('cache.journal'));
		return $service;
	}


	public function createServiceContainer(): Nette\DI\Container
	{
		return $this;
	}


	public function createServiceDatabase__default__connection(): Nette\Database\Connection
	{
		$service = new Nette\Database\Connection('mysql:host=127.0.0.1;dbname=web-portal-pracovni',
			'root', NULL, ['lazy' => TRUE]);
		$this->getService('tracy.blueScreen')->addPanel('Nette\Bridges\DatabaseTracy\ConnectionPanel::renderException');
		Nette\Database\Helpers::createDebugPanel($service, TRUE, 'default');
		return $service;
	}


	public function createServiceDatabase__default__context(): Nette\Database\Context
	{
		$service = new Nette\Database\Context($this->getService('database.default.connection'),
			$this->getService('database.default.structure'), $this->getService('database.default.conventions'),
			$this->getService('cache.storage'));
		return $service;
	}


	public function createServiceDatabase__default__conventions(): Nette\Database\Conventions\DiscoveredConventions
	{
		$service = new Nette\Database\Conventions\DiscoveredConventions($this->getService('database.default.structure'));
		return $service;
	}


	public function createServiceDatabase__default__structure(): Nette\Database\Structure
	{
		$service = new Nette\Database\Structure($this->getService('database.default.connection'),
			$this->getService('cache.storage'));
		return $service;
	}


	public function createServiceHttp__context(): Nette\Http\Context
	{
		$service = new Nette\Http\Context($this->getService('http.request'), $this->getService('http.response'));
		trigger_error('Service http.context is deprecated.', 16384);
		return $service;
	}


	public function createServiceHttp__request(): Nette\Http\Request
	{
		$service = $this->getService('http.requestFactory')->createHttpRequest();
		return $service;
	}


	public function createServiceHttp__requestFactory(): Nette\Http\RequestFactory
	{
		$service = new Nette\Http\RequestFactory;
		$service->setProxy([]);
		return $service;
	}


	public function createServiceHttp__response(): Nette\Http\Response
	{
		$service = new Nette\Http\Response;
		return $service;
	}


	public function createServiceLatte__latteFactory(): Nette\Bridges\ApplicationLatte\ILatteFactory
	{
		return new class ($this) implements Nette\Bridges\ApplicationLatte\ILatteFactory {
			private $container;


			public function __construct(Container_a923bd7c57 $container)
			{
				$this->container = $container;
			}


			public function create(): Latte\Engine
			{
				$service = new Latte\Engine;
				$service->setTempDirectory('D:\WWW\web-portal-slozeny\app/../temp/cache/latte');
				$service->setAutoRefresh(TRUE);
				$service->setContentType('html');
				Nette\Utils\Html::$xhtml = FALSE;
				return $service;
			}

		};
	}


	public function createServiceLatte__templateFactory(): Nette\Application\UI\ITemplateFactory
	{
		$service = new Nette\Bridges\ApplicationLatte\TemplateFactory($this->getService('latte.latteFactory'),
			$this->getService('http.request'), $this->getService('security.user'),
			$this->getService('cache.storage'), NULL);
		return $service;
	}


	public function createServiceMail__mailer(): Nette\Mail\IMailer
	{
		$service = new Nette\Mail\SendmailMailer;
		return $service;
	}


	public function createServiceMenuControlFactory(): App\Components\IMenuControlFactory
	{
		return new class ($this) implements App\Components\IMenuControlFactory {
			private $container;


			public function __construct(Container_a923bd7c57 $container)
			{
				$this->container = $container;
			}


			public function create(): App\Components\MenuControl
			{
				$service = new App\Components\MenuControl($this->container->getService('26_App_Model_CategoryManager'));
				return $service;
			}

		};
	}


	public function createServicePaginationControlFactory(): App\Components\IPaginationControlFactory
	{
		return new class ($this) implements App\Components\IPaginationControlFactory {
			private $container;


			public function __construct(Container_a923bd7c57 $container)
			{
				$this->container = $container;
			}


			public function create($type): App\Components\PaginationControl
			{
				$service = new App\Components\PaginationControl($type, $this->container->getService('http.request'));
				$service->setRadius(5);
				$service->setItemsPerPage(3);
				return $service;
			}

		};
	}


	public function createServicePictureControlFactory(): App\Components\IPictureControlFactory
	{
		return new class ($this) implements App\Components\IPictureControlFactory {
			private $container;


			public function __construct(Container_a923bd7c57 $container)
			{
				$this->container = $container;
			}


			public function create(): App\Components\PictureControl
			{
				$service = new App\Components\PictureControl($this->container->getService('46_App_Model_PictureManager'));
				return $service;
			}

		};
	}


	public function createServiceRouting__router(): Nette\Application\IRouter
	{
		$service = $this->getService('41_App_RouterFactory')->createRouter();
		return $service;
	}


	public function createServiceSecurity__authorizator(): Nette\Security\IAuthorizator
	{
		$service = new Nette\Security\Permission;
		$service->addRole('guest', NULL);
		$service->addRole('member', ['guest']);
		$service->addRole('editor', ['member']);
		$service->addRole('admin', ['editor']);
		$service->addResource('Admin:Homepage');
		$service->addResource('Admin:Tutorial');
		$service->addResource('Admin:Tutorials');
		$service->addResource('Admin:Exercise', 'Admin:Tutorial');
		$service->addResource('Admin:Test', 'Admin:Tutorial');
		$service->addResource('Admin:Exercises', 'Admin:Tutorials');
		$service->addResource('Admin:Tests', 'Admin:Tutorials');
		$service->addResource('Admin:Profile');
		$service->addResource('Admin:Sign');
		$service->addResource('Admin:Text');
		$service->addResource('Admin:Menu', 'Admin:Text');
		$service->addResource('Admin:Sections', 'Admin:Text');
		$service->addResource('Admin:Users', 'Admin:Text');
		$service->addResource('Admin:Categories', 'Admin:Text');
		$service->addResource('Admin:Threads', 'Admin:Text');
		$service->addResource('Admin:Posts', 'Admin:Text');
		$service->addResource('Admin:Comments', 'Admin:Text');
		$service->addResource('Admin:Level', 'Admin:Text');
		$service->allow('editor', 'Admin:Homepage');
		$service->allow('editor', 'Admin:Tutorial');
		$service->allow('editor', 'Admin:Tutorials');
		$service->allow('admin', 'Admin:Text');
		return $service;
	}


	public function createServiceSecurity__user(): Nette\Security\User
	{
		$service = new Nette\Security\User($this->getService('security.userStorage'), $this->getService('authenticator'),
			$this->getService('security.authorizator'));
		$this->getService('tracy.bar')->addPanel(new Nette\Bridges\SecurityTracy\UserPanel($service));
		return $service;
	}


	public function createServiceSecurity__userStorage(): Nette\Security\IUserStorage
	{
		$service = new Nette\Http\UserStorage($this->getService('session.session'));
		return $service;
	}


	public function createServiceSession__session(): Nette\Http\Session
	{
		$service = new Nette\Http\Session($this->getService('http.request'), $this->getService('http.response'));
		return $service;
	}


	public function createServiceTracy__bar(): Tracy\Bar
	{
		$service = Tracy\Debugger::getBar();
		return $service;
	}


	public function createServiceTracy__blueScreen(): Tracy\BlueScreen
	{
		$service = Tracy\Debugger::getBlueScreen();
		return $service;
	}


	public function createServiceTracy__logger(): Tracy\ILogger
	{
		$service = Tracy\Debugger::getLogger();
		return $service;
	}


	public function createServiceUserControlFactory(): App\Components\IUserControlFactory
	{
		return new class ($this) implements App\Components\IUserControlFactory {
			private $container;


			public function __construct(Container_a923bd7c57 $container)
			{
				$this->container = $container;
			}


			public function create(): App\Components\UserControl
			{
				$service = new App\Components\UserControl($this->container->getService('security.user'));
				$service->setAdminEmail('administrator@uc-se-web.cz');
				return $service;
			}

		};
	}


	public function initialize()
	{
		$this->getService('tracy.bar')->addPanel(new Nette\Bridges\DITracy\ContainerPanel($this));
		$this->getService('http.response')->setHeader('X-Powered-By', 'Nette Framework');
		$this->getService('http.response')->setHeader('Content-Type', 'text/html; charset=utf-8');
		$this->getService('http.response')->setHeader('X-Frame-Options', 'SAMEORIGIN');
		$this->getService('session.session')->exists() && $this->getService('session.session')->start();
		Tracy\Debugger::$editorMapping = [];
		Tracy\Debugger::setLogger($this->getService('tracy.logger'));
		if ($tmp = $this->getByType("Nette\Http\Session", FALSE)) { $tmp->start(); Tracy\Debugger::dispatch(); };
	}

}
