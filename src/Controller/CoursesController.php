<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
/**
 * Courses Controller
 *
 * @property \App\Model\Table\CoursesTable $Courses
 */
class CoursesController extends AppController
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
        $query = $this->Courses->find('all');
        $courses = $this->paginate($query);

        $this->set(compact('courses'));
        $this->set('_serialize', ['courses']);
    }

    /**
     * add method
     *
     */
    public function add(){
        $course = $this->Courses->newEntity();
        if ($this->request->is('post')) {
            $course = $this->Courses->patchEntity($course, $this->request->data);
            if ($this->Courses->save($course,['atomic' => false])) {
                $this->Flash->success(__('The course has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The course could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('course'));
        $this->set('_serialize', ['course']);
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
        $course = $this->Courses->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $course = $this->Courses->patchEntity($course, $this->request->data);
            if ($this->Courses->save($course)) {
                $this->Flash->success(__('The course has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The course could not be saved. Please, try again.'));
            }
        }

        $this->set(compact('course'));
        $this->set('_serialize', ['course']);
    }
}