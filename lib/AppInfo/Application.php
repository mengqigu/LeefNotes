<?php

namespace OCA\MGLeefNotes\AppInfo;

use \OCP\AppFramework\App;
use OCP\AppFramework\IAppContainer;

use OCA\MGLeefNotes\Controller\NoteController;
use OCA\MGLeefNotes\Db\NoteMapper;
use OCA\MGLeefNotes\Service\Environment;

class Application extends App {

  /**
   * Define your dependencies in here
   */
  public function __construct(array $urlParams=array()){
    parent::__construct('mgleefnotes', $urlParams);

    $container = $this->getContainer();

    // /**
    //  * Controllers
    //  */
    // $container->registerService(
    //      'PageController', function (IContainer $c) {
    //      return new PageController(
    //          $c->query('AppName'),
    //          $c->query('Request')
    //      );
    //  }
    // );
    //
    // $container->registerService('NoteController', function($c){
    //   return new NoteController(
    //     $c->query('Request'),
    //     $c->query('NoteMapper')
    //   );
    // });
    //
    // /**
    //  * Mappers
    //  */
    // $container->registerService('NoteMapper', function($c){
    //   return new NoteMapper(
    //     $c->query('ServerContainer')->getDb(),
    //     $c->query('OCP\AppFramework\Db\Mapper')
    //   );
    // });

    // $container->registerService(
    //     'Environment', function (IContainer $c) {
    //     return new Environment(
    //         // $c->query('AppName'),
    //         $c->query('UserId'),
    //         $c->query('UserFolder'),
    //         // $c->query('OCP\IUserManager'),
    //         // $c->query('OCP\Files\IRootFolder'),
    //         $c->query('Logger')
    //     );
    // }
    // );

    $container->registerService(
        'UserFolder', function (IAppContainer $c) {
        return $c->getServer()
                 ->getUserFolder($c->query('UserId'));
    }
    );
  }
}
