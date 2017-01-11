<?php
namespace App\Bs\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use App\Utils\U;
use Cake\Event\Event;
use Cake\Network\Response;

/**
 *
 */
class BsTempsController extends AppController
{
    public function store() {
        $this->autoRender = false;
        debug($this->request->query);
    }
}
