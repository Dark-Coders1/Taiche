<?php

class UPME_Roles {

    private $user_roles;

    function __construct() {
        
    }

    /* Returns the available user roles for the application. */
    public function upme_get_available_user_roles() {
        global $wp_roles;

        $roles = $wp_roles->get_names();

        return $roles;
    }

    /* Get the roles of the given user */
    public function upme_get_user_roles_by_id($user_id) {
        $user = new WP_User($user_id);
        if (!empty($user->roles) && is_array($user->roles)) {
            $this->user_roles = $user->roles;
            return $user->roles;
        } else {
            $this->user_roles = array();
            return array();
        }
    }

    /* Load fields with empty data based on user show permission */
    public function upme_empty_fields_by_user_role($show_to_user_role, $show_to_user_role_list) {
        global $upme;

        $show_status = FALSE;
        if ('0' == $show_to_user_role) {
            $show_status = TRUE;
        } else {
            $show_to_user_role_list = explode(',', $show_to_user_role_list);

            foreach ($this->user_roles as $role) {
                if (in_array($role, $show_to_user_role_list)) {
                    $show_status = TRUE;
                }
            }
        }


        return $show_status;

    }

    /* Check the permission to show/edit given field by user Id */
    public function upme_fields_by_user_role($user_role, $user_role_list) {

        $show_status = FALSE;
        if ('0' == $user_role) {
            $show_status = TRUE;
        } else {
            $user_role_list = explode(',', $user_role_list);

            foreach ($this->user_roles as $role) {
                if (in_array($role, $user_role_list)) {
                    $show_status = TRUE;
                }
            }
        }


        return $show_status;
    }

}

$upme_roles = new UPME_Roles();