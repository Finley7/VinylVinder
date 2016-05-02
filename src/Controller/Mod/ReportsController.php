<?php
namespace App\Controller\Mod;

use App\Controller\AppController;

/**
 * Reports Controller
 *
 * @property \App\Model\Table\ReportsTable $Reports
 */
class ReportsController extends AppController
{
    public function index()
    {
        $reports = $this->Reports->find('all')->contain([
            'Comments',
            'Threads',
            'Handler',
            'Reporter'
        ])->orderAsc('handled');
        $this->set(compact('reports'));
        $this->set('page_parent', 'mod');
    }
}
