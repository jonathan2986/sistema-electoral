<?php 

namespace App\Traits;

trait CoordinadorTrait {

    public function getCoordinadorAttribute()
    {
       $coordiandor =  \App\Votantes::join('users','users.votantes_id','=','votantes.id')
            ->join('roles_users','roles_users.users_id','=','users.id')
            ->join('roles', 'roles.id','=','roles_users.roles_id')
            ->where('roles_users.entity', $this->entity)
            ->where('roles_users.entity_id', $this->id)
            ->where('roles.name', $this->rolName)
            ->select('votantes.*')
            ->first();
    
        return $coordiandor ? $coordiandor->fist_name.' '.$coordiandor->last_name : ' ';
    }
}