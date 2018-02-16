<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Auth\DefaultPasswordHasher;
use Cake\I18n\Time;
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
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
        $this->set('arrRoles', $this->arrRoles);
        if ($this->request->params['action'] == 'edit'){
            if( $this->request->params['pass'][0] == $this->Auth->user('id')){
                $this->Auth->allow(['edit']);
            }
        } else if($this->Auth->user('role') !== 1){
            $this->Flash->error(__(INVALID_LOGIN));
            if($this->Auth->user('role') == 2)
                return $this->redirect(['controller' => 'lessons', 'action' => 'download']);
            else if($this->Auth->user('role') == 3)
                return $this->redirect(['controller' => 'lessons', 'action' => 'download']);
            else
                return $this->redirect('/');
        }
        // $this->Auth->allow();//['login', 'logout']
    }

	/**
     * index method
     *
     */
    public function index(){
        $query = $this->Users->find('all');
        $users = $this->paginate($query);

        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add(){
        if($this->Auth->user('role') !== 1){
            $this->Flash->error(__('The user is not authorized to add another user.'));
            return $this->redirect('/');
        }
        $user = $this->Users->newEntity();
        // debug($user);
        if ($this->request->is('post')) {
            $this->request->data['hash']      = randomString();
            $this->request->data['activated'] = 1;

            $user = $this->Users->patchEntity($user, $this->request->data);

            if ($this->Users->save($user)) {
                //check if logo is existing on data
                if (!empty($this->request->data['image']['name'])) {

                    //Delete previous image
                    // $_logo = $user->id;
                    // if($_logo != ""){
                    //     $_dest_filename = WWW_ROOT . 'img' . DS . 'users' . DS . $_logo;
                    //     //check if file exist and remove it to upload new file with same filename
                    //     if(file_exists($_dest_filename)) {
                    //         chmod($_dest_filename,0755); //Change the file permissions if allowed
                    //         unlink($_dest_filename); //remove the file
                    //     }
                    // }
                    //Delete previous image

                    $file = $this->request->data['image'];

                    $image_info = getimagesize($file['tmp_name']);

                    //if (($image_info[0] <= 200) && ($image_info[1] <= 200)){
                        $ext = substr(strtolower(strrchr($file['name'], '.')), 1);
                        $arr_ext = ['jpg', 'jpeg', 'gif', 'png'];
                        $setNewFileName = $user->id;//time() . "_" . rand(000000, 999999);

                        if (in_array($ext, $arr_ext)) {
                            $_dest_filename = WWW_ROOT . USER_IMAGE_PATH . $setNewFileName . '.' . $ext;// . $ext;

                            //prepare the filename for database entry
                            $imageFileName = $setNewFileName;//. $ext;

                            $user = $this->Users->patchEntity($user, ['image' => $imageFileName]);
                            // debug($district);
                            if ($this->Users->save($user)) {

                                //check if file exist and remove it to upload new file with same filename
                                if(file_exists($_dest_filename)) {
                                    chmod($_dest_filename,0755); //Change the file permissions if allowed
                                    unlink($_dest_filename); //remove the file
                                }

                                if(in_array($ext, ['jpeg', 'jpg', 'png'])){
                                    //resize image to jpeg
                                    $img = resize_image($file['tmp_name'],$file['type'], 200, 200, false);

                                    imagejpeg($img, $_dest_filename, 100);
                                } else {
                                    move_uploaded_file($file['tmp_name'], $_dest_filename);
                                }
                                // $this->Flash->success(__('Upload logo successful. '));
                            } else {
                                $this->Flash->error(__('Logo could not be save.'));
                            }
                        }
                    // } else {
                    //     $this->Flash->success(__('No Logo attached.'));
                    // }
                }
                $this->Flash->success(__('The user has been saved.'));
                $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }

        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * logout method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function edit($id){
        $user = $this->Users->get($id);
        $param = ($this->Auth->user('role') == 1) ? '' : 'profile';

        $this->LoadModel('Departments');
        $departments = $this->Departments
                    ->find('list', [
                        'keyField' => 'id',
                        'valueField' => function ($e) {
                            return $e->name;
                        }
                    ]);

        $this->LoadModel('Yearlevels');
        $yearlevels = $this->Yearlevels
                    ->find('list', [
                        'keyField' => 'id',
                        'valueField' => function ($e) {
                            return $e->name;
                        }
                    ]);


        $this->LoadModel('Sections');
        $sections = $this->Sections
                    ->find('list', [
                        'keyField' => 'id',
                        'valueField' => function ($e) {
                            return $e->name;
                        }
                    ]);

        $this->LoadModel('Courses');
        $courses = $this->Courses
                    ->find('list', [
                        'keyField' => 'id',
                        'valueField' => function ($e) {
                            return $e->name;
                        }
                    ]);

        $this->LoadModel('Subjects');
        $subjects = $this->Subjects
                    ->find('list', [
                        'keyField' => 'id',
                        'valueField' => function ($e) {
                            return $e->name;
                        }
                    ]);

        $assigments =
                    [
                        'departments' => explode(',', $user['departments']),
                        'yearlevels' => explode(',', $user['yearlevels']),
                        'sections' => explode(',', $user['sections']),
                        'courses' => explode(',', $user['courses']),
                        'subjects' => explode(',', $user['subjects'])
                    ];

        if ($this->request->is(['patch', 'post', 'put'])) {

            $ContSave = true;

            if ($user->id  == $this->Auth->user('id')){
                if (!empty($this->request->data['old_password']) &&
                    !empty($this->request->data['new_password']) &&
                    !empty($this->request->data['confirm_password'])){

                    $hasher = new DefaultPasswordHasher();
                    if (!$hasher->check($this->request->data['old_password'], $user->password)){
                        $this->Flash->error(__('Old password did not match to current password.'));
                        $ContSave = false;
                    } else if (($this->request->data['new_password'] !== $this->request->data['confirm_password'])){
                        $this->Flash->error(__('New password did not match to confirm password.'));
                        $ContSave = false;
                    } else {
                       $this->request->data['password'] = $this->request->data['new_password'];
                       $ContSave = true;
                    }

                }
            } else if($this->request->data['password'] == '') {
                unset($this->request->data['password']);
            }


            if ($ContSave){
                if($user->hash == '')
                    $this->request->data['hash']     = randomString();
                if (empty($this->request->data['image']['name']))
                    if (!isset($this->request->data['img_del']))
                        unset($this->request->data['image']);
                //countries adds
                if(isset($this->request->data['countries'])){

                    $this->LoadModel('Countries');

                    $countries = $this->Countries->find('all')->where(['user_id' => $user->id]);
                    foreach ($countries as $key => $value) {
                        $this->Countries->delete($value);
                    }

                    $countries = $this->request->data['countries'];
                    if (is_array($countries)){
                        $this->request->data['countries'] = [];
                        foreach ($countries as $key => $value) {
                            $this->request->data['countries'][] = ['country_code' => $value];
                        }
                    } else {
                        $value = $countries;
                        $this->request->data['countries'] = [];
                        $this->request->data['countries'][] = ['country_code' => $value];
                    }
                }


                if(isset($this->request->data['department'])){
                    $this->request->data['departments'] = join(',',$this->request->data['department']);
                    $this->request->data['yearlevels']  = join(',',$this->request->data['yearlevel']);
                    $this->request->data['sections']    = join(',',$this->request->data['section']);
                    $this->request->data['courses']     = join(',',$this->request->data['course']);
                    $this->request->data['subjects']    = join(',',$this->request->data['subject']);
                }


                $user = $this->Users->patchEntity($user, $this->request->data);

                if ($this->Users->save($user)) {

                    //check if logo is existing on data
                    if (!empty($this->request->data['image']['name'])) {

                        //Delete previous image
                        $_logo = $user->image;
                        if($_logo != ""){
                            $_dest_filename = WWW_ROOT . USER_IMAGE_PATH . $_logo;
                            //check if file exist and remove it to upload new file with same filename
                            if(file_exists($_dest_filename)) {
                                chmod($_dest_filename,0755); //Change the file permissions if allowed
                                unlink($_dest_filename); //remove the file
                            }
                        }
                        //Delete previous image

                        $file = $this->request->data['image'];

                        $image_info = getimagesize($file['tmp_name']);

                        //if (($image_info[0] <= 200) && ($image_info[1] <= 200)){
                            $ext = substr(strtolower(strrchr($file['name'], '.')), 1);
                            $arr_ext = ['jpg', 'jpeg', 'gif', 'png'];
                            $setNewFileName = $user->id;//time() . "_" . rand(000000, 999999);

                            if (in_array($ext, $arr_ext)) {
                                $_dest_filename = WWW_ROOT . USER_IMAGE_PATH . $setNewFileName . '.' . $ext;// . $ext;

                                //prepare the filename for database entry
                                $imageFileName = $setNewFileName;//. $ext;

                                $user = $this->Users->patchEntity($user, ['image' => $imageFileName]);
                                // debug($district);
                                if ($this->Users->save($user)) {

                                    //check if file exist and remove it to upload new file with same filename
                                    if(file_exists($_dest_filename)) {
                                        chmod($_dest_filename,0755); //Change the file permissions if allowed
                                        unlink($_dest_filename); //remove the file
                                    }

                                    if(in_array($ext, ['jpeg', 'jpg', 'png'])){
                                        //resize image to jpeg
                                        $img = resize_image($file['tmp_name'],$file['type'], 200, 200, false);

                                        imagejpeg($img, $_dest_filename, 100);
                                    } else {
                                        move_uploaded_file($file['tmp_name'], $_dest_filename);
                                    }
                                    // $this->Flash->success(__('Upload logo successful. '));
                                } else {
                                    $this->Flash->error(__('Image could not be save.'));
                                }
                            }
                        // } else {
                        //     $this->Flash->success(__('No Logo attached.'));
                        // }
                    }
                    if ($user->id == $this->Auth->user('id')){
                        $user['log_type'] = 'user';
                        $this->Auth->setUser($user);
                    }
                    if ($param == 'profile'){
                        $this->Flash->success(__('User\'s profile has been saved.'));
                        if($this->Auth->user('role') == 1 )
                            return $this->redirect(['controller' => 'users', 'action' => 'index']);
                        else if($this->Auth->user('role') == 2 )
                            return $this->redirect(['controller' => 'lessons', 'action' => 'index']);
                        else if($this->Auth->user('role') == 3 )
                            return $this->redirect(['controller' => 'lessons', 'action' => 'download']);
                            // return $this->redirect(['controller' => 'sponsors', 'action' => 'index']);
                    } else {
                        $this->Flash->success(__('The user has been saved.'));
                        return $this->redirect(['controller' => 'users', 'action' => 'index']);
                    }
                } else {
                    $this->Flash->error(__('The user could not be saved. Please, try again.'));
                }
            }

        }

        $image = SITE_URL . USER_IMAGE_PATH . (!empty($user->image) && !is_null($user->image)) ? $user->image : 'default-user.png'; //WWW_ROOT .

        $this->set(compact('user', 'image', 'departments', 'sections', 'yearlevels', 'courses', 'subjects', 'assigments'));
        $this->set('_serialize', ['user', 'image', 'departments', 'sections', 'yearlevels', 'courses', 'subjects', 'assigments']);
    }

    /**
     * deactivate method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function deactivate($id = null, $val){
        $user = $this->Users->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, ['activated' => $val, 'hash' => randomString()]);

            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been ' . ($val ? 'activated' : 'deactivated')));
                $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * login method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function login(){
        $continue = false;
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if($user){
                $user = $this->Users->get($user['id'], ['contain' =>['Countries']]);
                $user['log_type'] = 'user';
                $this->Auth->setUser($user);
                 //save IP and last_login
                $user_save = $this->Users->get($user['id']);
                $user_save['ip'] = $_SERVER['REMOTE_ADDR'];
                $user_save['last_login'] = Time::now();

                $continue = true;

            } else {
                $this->Flash->error(__('Invalid Login'));
            }

        } else if($this->Auth->user('role')){
            $continue = true;
            $user['role'] = $this->Auth->user('role');
        } else {
            $continue = false;
        }

        if($continue){
            if ($this->Auth->redirectUrl() === '/admin/users/add'){
                if($user['role'] == 1)
                    return $this->redirect($this->Auth->redirectUrl());
                else
                    return $this->redirect(['controller' => 'sponsors', 'action' => 'index']);
            } else if ($this->Auth->redirectUrl() === '/') {
                if($user['role'] == 1)
                    return $this->redirect(['controller' => 'users', 'action' => 'index']);
                else
                    return $this->redirect(['controller' => 'sponsors', 'action' => 'index']);
            } else {
                return $this->redirect($this->Auth->redirectUrl());
            }
        }
    }

    /**
     * logout method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function logout(){
        $this->Auth->logout();
        return $this->redirect('/login');
    }

    /**
     * teachers method
     *
     */
    public function teachers(){
        $query = $this->Users->find('all')->where(['role' => 2, 'activated' => 1]);
        $users = $this->paginate($query);

        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }

    /**
     * teacheredit method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function teacheredit($id){
        $user = $this->Users->get($id);
        $param = ($this->Auth->user('role') == 1) ? '' : 'profile';

        $this->LoadModel('Departments');
        $departments = $this->Departments
                    ->find('list', [
                        'keyField' => 'id',
                        'valueField' => function ($e) {
                            return $e->name;
                        }
                    ]);

        $this->LoadModel('Yearlevels');
        $yearlevels = $this->Yearlevels
                    ->find('list', [
                        'keyField' => 'id',
                        'valueField' => function ($e) {
                            return $e->name;
                        }
                    ]);


        $this->LoadModel('Sections');
        $sections = $this->Sections
                    ->find('list', [
                        'keyField' => 'id',
                        'valueField' => function ($e) {
                            return $e->name;
                        }
                    ]);

        $this->LoadModel('Courses');
        $courses = $this->Courses
                    ->find('list', [
                        'keyField' => 'id',
                        'valueField' => function ($e) {
                            return $e->name;
                        }
                    ]);

        $this->LoadModel('Subjects');
        $subjects = $this->Subjects
                    ->find('list', [
                        'keyField' => 'id',
                        'valueField' => function ($e) {
                            return $e->name;
                        }
                    ]);

        $assigments =
                    [
                        'departments' => explode(',', $user['departments']),
                        'yearlevels' => explode(',', $user['yearlevels']),
                        'sections' => explode(',', $user['sections']),
                        'courses' => explode(',', $user['courses']),
                        'subjects' => explode(',', $user['subjects'])
                    ];

        if ($this->request->is(['patch', 'post', 'put'])) {

            $assigment =
                    [
                        'departments' => join(',',$this->request->data['department']),
                        'yearlevels' => join(',',$this->request->data['yearlevel']),
                        'sections' => join(',',$this->request->data['section']),
                        'courses' => join(',',$this->request->data['course']),
                        'subjects' => join(',',$this->request->data['subject'])
                    ];

            $user = $this->Users->patchEntity($user, $assigment);

            if ($this->Users->save($user)) {
                $this->Flash->success(__('Teacher assigment successful.'));
                return $this->redirect(['controller' => 'users', 'action' => 'teachers']);
            } else {
                $this->Flash->error(__('The teacher could not be saved. Please, try again.'));
            }

        }

        $image = SITE_URL . USER_IMAGE_PATH . (!empty($user->image) && !is_null($user->image)) ? $user->image : 'default-user.png'; //WWW_ROOT .

        $this->set(compact('user', 'image', 'departments', 'yearlevels', 'sections', 'courses', 'subjects', 'assigments'));
        $this->set('_serialize', ['user', 'image', 'departments', 'yearlevels', 'sections', 'courses', 'subjects', 'assigments']);
    }
}

