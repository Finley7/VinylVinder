<?php
namespace App\Model\Table;

use App\Model\Entity\User;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \Cake\ORM\Association\HasMany $UserPreferences
 * @property \Cake\ORM\Association\BelongsToMany $Roles
 */
class UsersTable extends Table
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

        $this->table('users');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->hasMany('UserPreferences', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Warnings', [
            'foreignKey' => 'warned_user'
        ]);
        $this->belongsToMany('Roles', [
                'joinTable' => 'roles_users'
            ]
        );
        $this->hasOne('PrimaryRole', [
            'className' => 'Roles',
            'foreignKey' => 'id',
            'bindingKey' => 'primary_role',
            'propertyName' => 'primary_role'
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
        return $validator
            ->notEmpty('username', __('Een gebruikersnaam is verplicht'))
            ->notEmpty('password', __('Een wachtwoord is verplicht'))
            ->add('password_verify', 'matches', [
                'rule' => ['compareWith', 'password'],
                'message' => __('De gegeven wachtwoorden komen niet overeen')
            ])
            ->notEmpty('dob', __('Je geboortedag is verplicht'))
            ->notEmpty('email', __('Een e-mail adres is verplicht'));

    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['username']));
        $rules->add($rules->isUnique(['email']));
        return $rules;
    }
}
