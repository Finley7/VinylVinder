<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Comments Controller
 *
 * @property \App\Model\Table\CommentsTable $Comments
 */
class CommentsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => [
                'Threads',
                'Users'
            ]
        ];
        $comments = $this->paginate($this->Comments);

        $this->set(compact('comments'));
        $this->set('_serialize', ['comments']);
    }

    /**
     * View method
     *
     * @param string|null $id Comment id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {

        $comment = $this->Comments->get($id, [
            'contain' => [
                'Threads',
                'Users'
            ]
        ]);

        $this->set('comment', $comment);
        $this->set('_serialize', ['comment']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add($id = null)
    {
        $thread = $this->Threads->get($id);

        if ($thread->closed == true) {
            $this->Flash->error(__('Sorry, je kunt niet meer reageren op deze thread'));

            return $this->redirect([
                'action' => 'view',
                $thread->id
            ]);
        }

        $comment = $this->Comments->newEntity();
        if ($this->request->is('post')) {

            $this->request->data['thread_id'] = $thread->id;
            $this->request->data['author_id'] = $this->Auth->user('id');
            $this->request->data['body'] = h($this->request->data['body']);

            $comment = $this->Comments->patchEntity($comment, $this->request->data);

            if ($this->Comments->save($comment) && $this->Threads->touch($thread, 'Threads.replied')) {

                $thread->lastposter_id = $this->Auth->user('id');

                if ($this->Threads->save($thread)) {
                    $this->Flash->success(__('The comment has been saved.'));

                    return $this->redirect([
                        'controller' => 'Threads',
                        'action' => 'view',
                        $thread->id,
                        $thread->slug,
                        '?' => ['action' => 'lastpost']
                    ]);
                }
            }
            else {
                $this->Flash->error(__('The comment could not be saved. Please, try again.'));
            }
        }

        $this->set('page_parent', 'community');

        $this->set('thread', $thread);
        $this->set(compact('comment'));
        $this->set('_serialize', ['comment']);
    }

    public function quote($comment_id = null)
    {
        $old_comment = $this->Comments->get($comment_id, ['contain' => ['Users']]);
        $thread = $this->Threads->get($old_comment->thread_id);

        if($old_comment->deleted) {
            $this->Flash->error(__('Deze reactie is niet meer beschikbaar!'));
            return $this->redirect(['controller' => 'Threads', 'action' => 'view', $old_comment->thread->id]);
        }

        $comment = $this->Comments->newEntity();
        if ($this->request->is('post')) {

            $this->request->data['thread_id'] = $thread->id;
            $this->request->data['author_id'] = $this->Auth->user('id');
            $this->request->data['body'] = h($this->request->data['body']);

            $comment = $this->Comments->patchEntity($comment, $this->request->data);

            if ($this->Comments->save($comment) && $this->Threads->touch($thread, 'Threads.replied')) {

                $thread->lastposter_id = $this->Auth->user('id');

                if ($this->Threads->save($thread)) {
                    $this->Flash->success(__('The comment has been saved.'));

                    return $this->redirect([
                        'controller' => 'Threads',
                        'action' => 'view',
                        $thread->id,
                        $thread->slug,
                        '?' => ['action' => 'lastpost']
                    ]);
                }
            }
            else {
                $this->Flash->error(__('The comment could not be saved. Please, try again.'));
            }
        }

        $this->set(compact('old_comment', 'thread', 'comment'));
        $this->set('page_parent', 'community');
    }

    /**
     * Edit method
     *
     * @param string|null $id Comment id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $comment = $this->Comments->get($id, [
            'contain' => []
        ]);
        if ($this->request->is([
            'patch',
            'post',
            'put'
        ])
        ) {
            $comment = $this->Comments->patchEntity($comment, $this->request->data);
            if ($this->Comments->save($comment)) {
                $this->Flash->success(__('The comment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            else {
                $this->Flash->error(__('The comment could not be saved. Please, try again.'));
            }
        }
        $threads = $this->Comments->Threads->find('list', ['limit' => 200]);
        $users = $this->Comments->Users->find('list', ['limit' => 200]);
        $this->set(compact('comment', 'threads', 'users'));
        $this->set('_serialize', ['comment']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Comment id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod([
            'post',
            'delete'
        ]);
        $comment = $this->Comments->get($id);
        if ($this->Comments->delete($comment)) {
            $this->Flash->success(__('The comment has been deleted.'));
        }
        else {
            $this->Flash->error(__('The comment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}