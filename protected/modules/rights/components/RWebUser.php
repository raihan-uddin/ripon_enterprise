<?php

/**
 * Rights web user class file.
 *
 * @author Christoffer Niska <cniska@live.com>
 * @copyright Copyright &copy; 2010 Christoffer Niska
 * @since 0.5
 */
class RWebUser extends CWebUser
{
    /**
     * Actions to be taken after logging in.
     * Overloads the parent method in order to mark superusers.
     * @param boolean $fromCookie whether the login is based on cookie.
     */
    public function afterLogin($fromCookie)
    {
        parent::afterLogin($fromCookie);

        // Set User Roles here
        $this->setState('current_roles', Rights::getArrayRoles($this->getId()));

        // Mark the user as a superuser if necessary.
        if (Rights::getAuthorizer()->isSuperuser($this->getId()) === true)
            $this->isSuperuser = true;
    }

    /**
     * Performs access check for this user.
     * Overloads the parent method in order to allow superusers access implicitly.
     * @param string $operation the name of the operation that need access check.
     * @param array $params name-value pairs that would be passed to business rules associated
     * with the tasks and roles assigned to the user.
     * @param boolean $allowCaching whether to allow caching the result of access checki.
     * This parameter has been available since version 1.0.5. When this parameter
     * is true (default), if the access check of an operation was performed before,
     * its result will be directly returned when calling this method to check the same operation.
     * If this parameter is false, this method will always call {@link CAuthManager::checkAccess}
     * to obtain the up-to-date access result. Note that this caching is effective
     * only within the same request.
     * @return boolean whether the operations can be performed by this user.
     */
    public function checkAccess($operation, $params = array(), $allowCaching = true)
    {
        // Allow superusers access implicitly and do CWebUser::checkAccess for others.
        return $this->isSuperuser === true ? true : parent::checkAccess($operation, $params, $allowCaching);
        //return $this->isSuperuser===true ? true : $this->checkAccessWithCache($operation, $params, $allowCaching);
    }

    /**
     * @param boolean $value whether the user is a superuser.
     */
    public function setIsSuperuser($value)
    {
        $this->setState('Rights_isSuperuser', $value);
    }

    /**
     * @return boolean whether the user is a superuser.
     */
    public function getIsSuperuser()
    {
        return $this->getState('Rights_isSuperuser');
    }

    /**
     * @param array $value return url.
     */
    public function setRightsReturnUrl($value)
    {
        $this->setState('Rights_returnUrl', $value);
    }

    /**
     * Returns the URL that the user should be redirected to
     * after updating an authorization item.
     * @param string $defaultUrl the default return URL in case it was not set previously. If this is null,
     * the application entry URL will be considered as the default return URL.
     * @return string the URL that the user should be redirected to
     * after updating an authorization item.
     */
    public function getRightsReturnUrl($defaultUrl = null)
    {
        if (($returnUrl = $this->getState('Rights_returnUrl')) !== null)
            $this->returnUrl = null;

        return $returnUrl !== null ? CHtml::normalizeUrl($returnUrl) : CHtml::normalizeUrl($defaultUrl);
    }


    public function checkAccessWithCache($operation, $params = array(), $allowCaching = true)
    {
        $permissions = Yii::app()->cache->get('permission-cache');
        if ($permissions !== false) {
            if (!array_key_exists($operation, $permissions)) {
                return false;
            }
            if ($this->executeBizRule($permissions[$operation]['bizrule'], $params, $permissions[$operation]['data'])) {
                //Check with default Roles
                if (in_array(Yii::app()->authManager->defaultRoles, $permissions[$operation]['roles'])) {
                    return true;
                }
                //Check if allow user id for current operation
                if (array_key_exists($this->getId(), $permissions[$operation]['users'])) {
                    $uid = $this->getId();
                    if ($this->executeBizRule($permissions[$operation]['users'][$uid]['bizrule'], $params, $permissions[$operation]['users'][$uid]['data']))
                        return true;
                }
                //Check if allow user id for current operation
                $check_roles = array_intersect($this->getState('current_roles'), $permissions[$operation]['roles']);
                return count($check_roles) > 0;
            }
        } else {
            parent::checkAccess($operation, $params, $allowCaching);
        }
    }


    public function executeBizRule($bizRule, $params, $data)
    {
        return $bizRule === '' || $bizRule === null || ($this->showErrors ? eval($bizRule) != 0 : @eval($bizRule) != 0);
    }

    /**
     * @return array flash message keys array
     */
    public function getFlashKeys()
    {
        $counters=$this->getState(self::FLASH_COUNTERS);
        if(!is_array($counters)) return array();
        return array_keys($counters);
    }



}
