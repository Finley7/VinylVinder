<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UserRole Entity.
 *
 * @property int $user_id
 * @property \App\Model\Entity\User $user
 * @property int $role_id
 * @property \App\Model\Entity\Role $role
 */
class UserRole extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'user_id' => false,
        'role_id' => false,
    ];
}
