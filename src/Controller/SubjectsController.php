<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class SubjectsController extends AppController
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
        $query = $this->Subjects->find('all');
        $subjects = $this->paginate($query);

        $this->set(compact('subjects'));
        $this->set('_serialize', ['subjects']);
    }

    /**
     * add method
     *
     */
    public function add(){
        $subject = $this->Subjects->newEntity();
        if ($this->request->is('post')) {
            $subject = $this->Subjects->patchEntity($subject, $this->request->data);
            if ($this->Subjects->save($subject,['atomic' => false])) {
                $this->Flash->success(__('The subject has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The subject could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('subject'));
        $this->set('_serialize', ['subject']);
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
        $subject = $this->Subjects->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $subject = $this->Subjects->patchEntity($subject, $this->request->data);
            if ($this->Subjects->save($subject)) {
                $this->Flash->success(__('The subject has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The subject could not be saved. Please, try again.'));
            }
        }

        $this->set(compact('subject'));
        $this->set('_serialize', ['subject']);
    }
}