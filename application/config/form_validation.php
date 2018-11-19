<?php

        $config = array(
        'login' => array(
                array(
                        'field' => 'email',
                        'label' => 'Email',
                        'rules' => 'required|valid_email|trim|isNotUniqueMail|isConfirmed'
                ),
                array(
                        'field' => 'password',
                        'label' => 'Password',
                        'rules' => 'trim|required'
                )  
        ),
        'signup' => array(
                array(
                        'field' => 'email',
                        'label' => 'Email',
                        'rules' => 'required|valid_email|trim|isUniqueMail'
                ),
                array(
                        'field' => 'name',
                        'label' => 'Name',
                        'rules' => 'required|alpha',
                ),
                array(
                        'field' => 'password',
                        'label' => 'Password',
                        'rules' => 'trim|required'
                ),
                array(
                        'field' => 'repassword',
                        'label' => 'Confirm password',
                        'rules' => 'trim|required|matches[password]'
                )
        )
        );

?>