<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Entity\User;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Filesystem\File;
use Cake\I18n\Time;
use Cake\Network\Exception\BadRequestException;
use Cake\Network\Exception\MethodNotAllowedException;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use Cake\Utility\Text;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    public function beforeFilter(Event $event)
    {
        $this->Auth->allow([
            'add',
            'logout',
            'view'
        ]);
        if ($this->request->action == 'login' || $this->request->action == 'add' || $this->request->action == 'forgot') {
            if ($this->Auth->user()) {
                $this->Flash->error(__("You are already logged in."));

                return $this->redirect([
                    'controller' => 'Pages',
                    'action' => 'landing'
                ]);
            }
        }
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->redirect('/');
        $this->set('users', $this->paginate($this->Users));
        $this->set('_serialize', ['users']);
    }

    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);

                return $this->redirect('/');
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        }

        $this->set('title', 'Aanmelden');
        $this->set('page_parent', 'user');
    }

    public function settings()
    {
        $editUser = $this->Users->get($this->Auth->user('id'), ['contain' => ['UserPreferences']]);

        $this->set('editUser', $editUser);
        $this->set('title', 'Bewerk je instellingen');
        $this->set('page_parent', 'settings');
    }

    public function avatar()
    {
        $editUser = $this->Users->get($this->Auth->user('id'), ['contain' => ['UserPreferences']]);

        $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];

        if($this->request->is('post')){

            if(!@getimagesize($this->request->data['avatar']['tmp_name'])) {
                $this->Flash->error(__('Je hebt geen geldige avatar geselecteerd'));
                return $this->redirect(['view' => 'avatar']);
            }

            if(!in_array($this->request->data['avatar']['type'], $allowed_types)) {
                $this->Flash->error(__('Je hebt geen geldig formaat geupload'));
                return $this->redirect(['view' => 'avatar']);
            }

            if($this->request->data['avatar']['size'] > 2000000) {
                $this->Flash->error(__('Je hebt te grote avatar geupload!'));
                return $this->redirect(['view' => 'avatar']);
            }

            $ext = explode('/', $this->request->data['avatar']['type']);

            $avatar_url = 'avatar_' . Text::uuid() . '_' . $editUser->username . '.' . $ext[1];

            $editUser->avatar = $avatar_url;

            if($this->Users->save($editUser))
            {
                $image_info = file_get_contents($this->request->data['avatar']['tmp_name']);

                $avatar = new File('img/uploads/avatars/' . $avatar_url, true);
                $avatar->append($image_info);

                $avatar->create();

                $this->Auth->setUser($editUser->toArray());

                $this->Flash->success(__('Avatar geupload!'));
                return $this->redirect(['action' => 'settings']);
            }
            else
            {
                $this->Flash->error(__('Er is dus iets fout gegaan!'));
            }
        }

        $this->set('editUser', $editUser);

        $this->set('page_parent', 'settings');
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return Object Redirects on successful add, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    /*public function view($id = null)
    {
        $user = new User($this->Auth->user());
        $user = $this->Users->get($id, [
            'contain' => ['Blogs', 'Comments', 'ProfileMessages', 'Roles']
        ]);
        $profileMessageRegistry = TableRegistry::get('ProfileMessages');
        $profileMessage = $profileMessageRegistry->newEntity();
        $user->profileMessages = $profileMessageRegistry->findByProfileId($id)->contain(['Users'])->all()->sortBy('created_at');
        if($this->request->is('post')) {
            $this->request->data['profile_id'] = $user->id;
            $this->request->data['poster_id'] = $this->Auth->user('id');
            $profileMessage = $profileMessageRegistry->patchEntity($profileMessage, $this->request->data);
            if($profileMessageRegistry->save($profileMessage)) {
                $this->Flash->success(__('You comment has been placed!'));
                return $this->redirect(['action' => 'view', $user->id]);
            }
            else
            {
                $this->Flash->error(__('Something went wrong. Please, try again.'));
            }
        }
        $this->set('profile', $user);
        $this->set('profileMessage', $profileMessage);
        $this->set('_serialize', ['profile', 'profileMessage']);
    }
    /**
     * Add method
     *
     * @return  Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        if (!Configure::read('App.can_register')) {
            $this->Flash->error(__('You can not register at this time. Please try again later'));

            return $this->redirect(['action' => 'login']);
        }
        $user = $this->Users->newEntity([
            'associated' => [
                'Roles',
                'UserPreferences'
            ]
        ]);
        if ($this->request->is('post')) {
            $this->request->data['roles']['_ids'] = [1];
            $this->request->data['primary_role'] = 1;
            $this->request->data['user_preferences']['_dob'] = $this->request->data['dob'];
            $user = $this->Users->patchEntity($user, $this->request->data, [
                'associated' => [
                    'Roles',
                    'UserPreferences'
                ]
            ]);


            if ($this->Users->save($user, [
                'associated' => [
                    'Roles',
                    'UserPreferences'
                ]
            ])
            ) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect([
                    'controller' => 'users',
                    'action' => 'login'
                ]);
            }
            else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }

        $this->set('title', __('Create your account!'));
        $this->set('page_parent', 'add');
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    public function logout()
    {
        if ($this->request->is('post')) {
            if ($this->Auth->user()) {
                $this->redirect($this->Auth->logout());
            }
        }
    }
}