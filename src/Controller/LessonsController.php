<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
/**
 * Lessons Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class LessonsController extends AppController
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
        if(!in_array($this->Auth->user('role'), [2, 3]) ){
            {
                $this->Flash->error(__(INVALID_LOGIN));
                return $this->redirect(['controller' => 'users', 'action' => 'index']);
            }
        }
        else if($this->Auth->user('role') == 2){
            if (in_array($this->request->params['action'], ['download'])){
                $this->Flash->error(__(INVALID_LOGIN));
                return $this->redirect(['controller' => 'lessons', 'action' => 'index']);
            }

        }
        else if($this->Auth->user('role') == 3){
            if (in_array($this->request->params['action'], ['index', 'upload'])){
                $this->Flash->error(__(INVALID_LOGIN));
                return $this->redirect(['controller' => 'lessons', 'action' => 'download']);
            }

        }
        // $this->Auth->allow();//['login', 'logout']
    }

    /**
     * index method
     *
     */
    public function index(){
        $query = $this->Lessons
                        ->find('all')
                        ->where(['user_id' => $this->Auth->user('id')])
                        ->order(['created' => 'DESC']);
        $lessons = $this->paginate($query);

        $lessons_path = SITE_URL . DS . 'files' . DS . 'lessons' . DS;

        $this->set(compact('lessons', 'lessons_path'));
        $this->set('_serialize', ['lessons', 'lessons_path']);
    }

    /**
     * upload method
     *
     */
    public function upload(){
        $this->loadModel('Departments');
        $this->loadModel('Courses');
        $this->loadModel('Subjects');

        $departments = $this->Departments->find('list')->where(['id in' => explode(',', $this->Auth->user('departments')) ]);
        $courses     = $this->Courses->find('list')->where(['id in' => explode(',', $this->Auth->user('courses')) ]);
        $subjects    = $this->Subjects->find('list')->where(['id in' => explode(',', $this->Auth->user('subjects')) ]);

        $lesson = $this->Lessons->newEntity();
        if ($this->request->is('post')) {
            $lesson = $this->Lessons->patchEntity($lesson, $this->request->data);
            if ($this->Lessons->save($lesson,['atomic' => false])) {
                $this->Flash->success(__('The lesson has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The lesson could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('lesson', 'departments', 'courses', 'subjects'));
        $this->set('_serialize', ['lesson', 'departments', 'courses', 'subjects']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Lesson id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function download()
    {
        $this->loadModel('Departments');
        $this->loadModel('Courses');
        $this->loadModel('Subjects');
        $this->loadModel('Users');

        $departments = $this->Departments->find('list');
        $courses     = $this->Courses->find('list');
        $subjects    = $this->Subjects->find('list');
        $teachers = $this->Users
                    ->find('list', [
                        'keyField' => 'id',
                        'valueField' => function ($e) {
                            return $e->last_name . ', ' . $e->first_name;
                        }
                    ])
                    ->where(['role' => 2]);

        $this->set(compact('departments', 'courses', 'subjects', 'teachers'));
        $this->set('_serialize', ['departments', 'courses', 'subjects', 'teachers']);
    }

    public function filter(){

        $this->viewBuilder()->layout('ajax');

        $data = $_GET;

        $condition = [];

        if(isset($data['course_id']))
            $condition['course_id'] = $data['courseid'];

        if(isset($data['department_id']))
            $condition['department_id'] = $data['department_id'];

        if(isset($data['subject_id']))
            $condition['subject_id'] = $data['subject_id'];

        if(isset($data['teacher_id']))
            $condition['user_id'] = $data['teacher_id'];

        $lessons = $this->Lessons->find('all')->where($condition)->order(['created' => 'DESC'])->toArray();

        foreach ($lessons as $key => $lesson) {
            $lessons[$key]['dl'] = SITE_URL . DS . 'files' . DS . 'lessons' . DS . $lesson['filename'];
            $t = strtotime($lesson['created']);
            $lessons[$key]['created'] = date('n/j/y, g:i a',$t);
        }

        $this->set('params', ['response' => 'success', 'lessons' => $lessons, 'data' => $data]);
    }

    public function files(){
        $this->viewBuilder()->layout('ajax');

        $files = $_FILES;//->form['file'];
        $params = $this->request->query;

        $department_id = $params['department_id'];
        $course_id     = $params['course_id'];
        $subject_id    = $params['subject_id'];
        $user_id       = $this->Auth->user('id');
        $file_name     = $files['file']['name'];

        // $this->set('params', ['SUCCESS' => $params, 'user_id' => $user_id]);

        if (!empty($files)) {

            $filename = 'upload_'.
                    date('mdYHis').
                    $user_id .
                    $department_id .
                    $course_id .
                    $subject_id .
                    '_' .
                    $file_name;

            $tempFile = $files['file']['tmp_name'];

            $targetPath = WWW_ROOT . DS . 'files' . DS . 'lessons' . DS ;

            $targetFile = $targetPath . $filename;

            $this->loadModel('Lessons');

            $lesson = $this->Lessons->newEntity();

            $new = [
                    'department_id' => $department_id,
                    'course_id'     => $course_id,
                    'subject_id'    => $subject_id,
                    'user_id'       => $user_id,
                    'name'          => $file_name,
                    'filename'      => $filename
                ];

            $lesson = $this->Lessons->patchEntity($lesson, $new);
            if ($this->Lessons->save($lesson)) {
                $this->set('params', ['response' => 'success', 'filename' => $file_name, 'files' => $files]);
                move_uploaded_file($tempFile, $targetFile);
            } else {
                $this->set('params', ['response' => 'error', 'filename' => $file_name, 'data' => $lesson , 'files' => $files]);
            }
        }
    }
}