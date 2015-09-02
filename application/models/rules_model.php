<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rules_model extends CI_Model{
    public $rules=array(
        array(
            'field'   => 'login',
            'label'   => '',
            'rules'   => 'required|min_length[6]|max_length[16]|is_unique[users.login]'
        ),
        array(
            'field'   => 'password',
            'label'   => '',
            'rules'   => 'required|min_length[6]|max_length[16]|trim'
        ),
        array(
            'field'   => 'r_password',
            'label'   => '',
            'rules'   => 'required|min_length[6]|max_length[16]|trim'
        ),
        array(
            'field'   => 'email',
            'label'   => '',
            'rules'   => 'required|valid_email|is_unique[users.email]'
        ),
    );


    public $rules_pswd=array(
        array(
            'field'   => 'mod_pswd"',
            'label'   => '',
            'rules'   => 'required|min_length[6]|max_length[16]|trim'
        ),
        array(
            'field'   => 'r_pswd',
            'label'   => '',
            'rules'   => 'required|min_length[6]|max_length[16]|trim'
        ),
    );

}