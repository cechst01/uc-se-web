<?php

namespace App;

use Nette;
use Nette\Application\Routers\RouteList;
use Nette\Application\Routers\Route;

class RouterFactory
{   
	public function __construct(){         
            
        }

	/**
	 * @return Nette\Application\IRouter
	 */
	public function createRouter()
	{
		$router = new RouteList; 
                
                $admin = new RouteList('Admin');                           
		$admin[] = new Route('admin/<presenter>/<action>[/<id>]', 'Homepage:default');

		$front = new RouteList('Front');               
                                
                $front[] = new Route('tutorial/<tutorialId>', 'Tutorial:show');
                $front[] = new Route('tutorial/<action>/<tutorialId>', 'Tutorial:show');
                $front[] = new Route('cviceni/<exerciseId>', 'Exercise:show');
                $front[] = new Route('cviceni/<action>/<exerciseId>', 'Exercise:show');
                $front[] = new Route('test/<testId>', 'Test:show');
                $front[] = new Route('vysledek-testu/<testId>', 'Test:result'); 
                $front[] = new Route('test/<action>/<testId>', 'Test:show');               
                $front[] = new Route('sekce/<sectionId>', 'Section:show');
                $front[] = new Route('kategorie/<categoryId>', 'Section:default');
                $front[] = new Route('zmena-udaju/<userId>', 'Sign:manage');
                $front[] = new Route('uprava-profilu/<profileId>', 'Profile:manage'); 
                $front[] = new Route('profil/<profileId>', 'Profile:show');
                $front[] = new Route('editor', 'Tutorial:test');
                $front[] = new Route('forum/vlakno/<threadId>', 'Forum:posts');
                $front[] = new Route('forum/kategorie/<categoryId>', 'Forum:threads');
                $front[] = new Route('forum/kategorie', 'Forum:categories');
                $front[] = new Route('forum/uprava-vlakna/<categoryId>-<threadId>', 'Forum:manageThread');
                $front[] = new Route('forum/pridani-vlakna/<categoryId>', 'Forum:manageThread');
                $front[] = new Route('<action>',[
                                     'presenter'  => 'Sign',
                                     'action' => [
                                         Route::FILTER_TABLE => [
                                             'prihlaseni' => 'in',
                                             'registrace' => 'up',
                                             'obnova-hesla' => 'forgotten'
                                            ]
                                        ]
                                    ]);
		$front[] = new Route('<presenter>/<action>[/<id>]', 'Homepage:default');
                
            
		$router[] = $admin;
		$router[] = $front;
                

		$router[] = new Route('<presenter>/<action>[/<id>]', 'Homepage:default');

		return $router;
	}

}
