<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
/**
 * Departments Controller
 *
 * @property \App\Model\Table\UsersTable $departments
 */
class DepartmentsController extends AppController
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
        $query = $this->Departments->find('all');
        $departments = $this->paginate($query);

        $this->set(compact('departments'));
        $this->set('_serialize', ['departments']);
    }

    /**
     * add method
     *
     */
    public function add(){
        $department = $this->Departments->newEntity();
        if ($this->request->is('post')) {
            $department = $this->Departments->patchEntity($department, $this->request->data);
            if ($this->Departments->save($department,['atomic' => false])) {
                $this->Flash->success(__('The department has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The department could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('department'));
        $this->set('_serialize', ['department']);
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
        $department = $this->Departments->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $department = $this->Departments->patchEntity($department, $this->request->data);
            if ($this->Departments->save($department)) {
                $this->Flash->success(__('The department has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The department could not be saved. Please, try again.'));
            }
        }

        $this->set(compact('department'));
        $this->set('_serialize', ['department']);
    }
}