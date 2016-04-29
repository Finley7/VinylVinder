<?php
namespace App\Model\Table;

use App\Model\Entity\Subforum;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Subforums Model
 *
 * @property \Cake\ORM\Association\HasMany $Threads
 */
class SubforumsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('subforums');
        $this->displayField('title');
        $this->primaryKey('id');

        $this->hasMany('Threads', [
            'foreignKey' => 'subforum_id'
        ]);
        $this->belongsTo('Forums', [
            'foreignKey' => 'id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->integer('parent_forum')
            ->requirePresence('parent_forum', 'create')
            ->notEmpty('parent_forum');

        $validator
            ->integer('min_role')
            ->requirePresence('min_role', 'create')
            ->notEmpty('min_role');

        $validator
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->requirePresence('description', 'create')
            ->notEmpty('description');

        $validator
            ->dateTime('created_at')
            ->requirePresence('created_at', 'create')
            ->notEmpty('created_at');

        $validator
            ->dateTime('updated_at')
            ->allowEmpty('updated_at');

        return $validator;
    }
}
