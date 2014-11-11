<?php
 
// this file must be stored in:
// protected/components/WebUser.php
 
class WebUser extends CWebUser {
 
  // Store model to not repeat query.
  private $_model;
 
  // Return first name.
  // access it by Yii::app()->user->first_name
  function getFirst_Name(){
    $user = $this->loadUser(Yii::app()->user->id);
    return $user->first_name;
  }
 
  // This is a function that checks the field 'role'
  // in the User model to be equal to 1, that means it's admin
  // access it by Yii::app()->user->isAdmin()
  function isAdmin(){
    $user = $this->loadUser(Yii::app()->user->id);
    
    if($user != null && $user->perfil == 'admin') {
        return true;
    }
    return false;
  }
 
  // This is a function that checks the field 'role'
  // in the User model to be equal to 1, that means it's admin
  // access it by Yii::app()->user->isAdmin()
  function isMaster(){
    $user = $this->loadUser(Yii::app()->user->id);
    
    if($user != null && strtolower($user->perfil) == 'master') {
        return true;
    }
    return false;
  }
  
  function isChefe(){
    $user = $this->loadUser(Yii::app()->user->id);
    
    if($user != null && $user->corretor_chefe == 1) {
        return true;
    }
    return false;
  }
  
  function isAlmoxarife(){
    $user = $this->loadUser(Yii::app()->user->id);
    
    if($user != null && strtolower($user->perfil) == 'almoxarife') {
        return true;
    }
    return false;
  }
  
  function isEngenheiro(){
    $user = $this->loadUser(Yii::app()->user->id);
    
    if($user != null && strtolower($user->perfil) == 'engenheiro') {
        return true;
    }
    return false;
  }
  
  function isEmpreiteiro(){
    $user = $this->loadUser(Yii::app()->user->id);
    
    if($user != null && strtolower($user->perfil) == 'empreiteiro') {
        return true;
    }
    return false;
  }
 
  // Load user model.
  protected function loadUser($id=null)
    {
        if($this->_model===null)
        {
            if($id!==null)
                $this->_model=Usuario::model()->findByPk($id);
        }
        return $this->_model;
    }
}
?>