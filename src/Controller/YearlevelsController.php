<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
/**
 * Yearlevels Controller
 *
 * @property \App\Model\Table\UsersTable $Yearlevels
 */
class YearlevelsController extends AppController
{
	/**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * @return void
     */
    public function initialize(){
        parent::initialize();
        if($this->Auth->user('role') !== 1){
            $this->Flash->error(__(INVALID_LOGIN));
            return $this->redirect('/');
        }
        // $this->Auth->allow();//['login', 'logout']
    }

    /**
     * index method
     *
     */
    public function index(){
        $query = $this->Yearlevels->find('all');
        $yearlevels = $this->paginate($query);

        $this->set(compact('yearlevels'));
        $this->set('_serialize', ['yearlevels']);
    }

    /**
     * add method
     *
     */
    public function add(){
        $yearlevel = $this->Yearlevels->newEntity();
        if ($this->request->is('post')) {
            $yearlevel = $this->Yearlevels->patchEntity($yearlevel, $this->request->data);
            if ($this->Yearlevels->save($yearlevel,['atomic' => false])) {
                $this->Flash->success(__('The year level has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The year level could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('yearlevel'));
        $this->set('_serialize', ['yearlevel']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Subject id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $yearlevel = $this->Yearlevels->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $yearlevel = $this->Yearlevels->patchEntity($yearlevel, $this->request->data);
            if ($this->Yearlevels->save($yearlevel)) {
                $this->Flash->success(__('The yearlevel has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The yearlevel could not be saved. Please, try again.'));
            }
        }

        $this->set(compact('yearlevel'));
        $this->set('_serialize', ['yearlevel']);
    }
}