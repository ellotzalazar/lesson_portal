<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\Mailer\Email;
use Cake\I18n\Time;

/**
 * Index Controller
 *
 */
class IndexController extends AppController
{
   // public $components = [
   //      'Captcha' => [
   //          'className' => 'Captcha.Captcha'
   //      ]
   //  ];

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->LoadModel('Users');
        $this->set('arrRoles', $this->arrRoles);
        $this->Auth->allow();
    }

    /**
     * Index method
     *
     * @return void
     */

    public function login(){
        $continue = false;

        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if($user){
                debug($user);
                if($user['activated'] == 1){
                    $user = $this->Users->get($user['id']);
                    $user['log_type'] = 'user';
                    $this->Auth->setUser($user);
                     //save IP and last_login
                    $user_save = $this->Users->get($user['id']);
                    $user_save['ip'] = $_SERVER['REMOTE_ADDR'];
                    $user_save['last_login'] = Time::now();

                    $continue = true;
                    $this->Flash->default(__('Access Granted'));
                } else {
                    $this->Flash->error(__('User is deactivated'));
                }

            } else {
                $this->Flash->error(__('Invalid Login'));
            }

        } else if($this->Auth->user('role')){
            $continue = true;
            $user['role'] = $this->Auth->user('role');

            debug('here');
        } else {
            $continue = false;
        }

        if($continue){

            if ($this->Auth->redirectUrl() === '/users/add'){
                if($user['role'] == 1)
                    return $this->redirect(['controller' => 'users', 'action' => 'index']);
                else if($user['role'] == 2)
                    return $this->redirect(['controller' => 'lessons', 'action' => 'index']);
                else if($user['role'] == 3)
                    return $this->redirect(['controller' => 'lessons', 'action' => 'download']);
            } else if ($this->Auth->redirectUrl() === '/') {
                if($user['role'] == 1)
                    return $this->redirect(['controller' => 'users', 'action' => 'index']);
                else if($user['role'] == 2)
                    return $this->redirect(['controller' => 'lessons', 'action' => 'index']);
                else if($user['role'] == 3)
                    return $this->redirect(['controller' => 'lessons', 'action' => 'download']);
            } else {
                return $this->redirect($this->Auth->redirectUrl());
            }
        }
    }

    /**
     * Register method
     *
     * @return void
     */

    public function register(){
        $user = $this->Users->newEntity();
        if($this->request->is(['post'])){
            $this->request->data['activate'] = 1;
            $this->request->data['hash']     = randomString();
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user))
            {
                $this->Flash->success(__('Registration Successful!'));
                return $this->redirect('/');
            }
            else
            {
                $this->Flash->error(__('Regsitration Failed!'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }


    /**
     * Logout method
     *
     * @return void
     */

    public function logout(){
        $this->Auth->logout();
        return $this->redirect('/');
    }


}