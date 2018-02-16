<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class SectionsController extends AppController
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
    }

    /**
     * index method
     *
     */
    public function index(){
        $query = $this->Sections->find('all');
        $sections = $this->paginate($query);

        $this->set(compact('sections'));
        $this->set('_serialize', ['sections']);
    }

    /**
     * add method
     *
     */
    public function add(){
        $section = $this->Sections->newEntity();
        if ($this->request->is('post')) {
            $section = $this->Sections->patchEntity($section, $this->request->data);
            if ($this->Sections->save($section,['atomic' => false])) {
                $this->Flash->success(__('The section has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The section could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('section'));
        $this->set('_serialize', ['section']);
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
        $section = $this->Sections->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $section = $this->Sections->patchEntity($section, $this->request->data);
            if ($this->Sections->save($section)) {
                $this->Flash->success(__('The section has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The section could not be saved. Please, try again.'));
            }
        }

        $this->set(compact('section'));
        $this->set('_serialize', ['section']);
    }
}