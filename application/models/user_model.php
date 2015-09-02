<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model{
    /*вытаскивает все данный про пользователя из бд*/
    public function get_user_info(){
        $user_info = $this->db->get('users');
        return $user_info->result_array();
    }

    /*записывает инфу про пользлвателя в бд*/
    public function add_user($data){
        $this->db->insert('users', $data);
    }

    /*ишет логин в базе данных если он есть  */
    public function authorization_log($login){
        $this->db->select('login,email');
         $this->db->where('login',$login);
         $this->db->or_where('email',$login);
        $query=$this->db->get('users');

        if($query->num_rows() > 0) {
            return $query->result_array();
        } else {return FALSE;}
    }

    /*ишет мыло в базе данных если он есть  */
    public function authorization_email($email){
        $this->db->select('email');
        $query = $this->db->get_where('users', array('email'=>$email));
        if($query->num_rows() > 0) {
            return $query->result_array();
        } else {return FALSE;}
    }

    /*проверяет на уникальность логина в базе данных*/
    public function check_login($login){
        $this->db->select('login');
        $query = $this->db->get_where('users', array('login'=> $login));
        if($query->num_rows() > 0) {
            return TRUE;
        }
        else {return FALSE;}
    }

    /*проверяет на уникальность мыло в базе данных*/
    public function check_email($email){
        $this->db->select('email');
        $query = $this->db->get_where('users', array('email'=> $email));
        if($query->num_rows() > 0) {return TRUE;}
        else {return FALSE;}
    }


   /*выбирает пароль по логину для отправки на мыло*/
    public function search_mail($login){
        $this->db->select('email,login');
        $query = $this->db->get_where('users', array('login'=> $login));
        if($query->num_rows() > 0) {return TRUE;}
        else {return FALSE;}
    }


    /*выбирает пароль для напоминаия*/
    public function check_pass($login){
        $this->db->select('password');
         $this->db->where('login',$login);
         $this->db->or_where('email',$login);
        $query=$this->db->get('users');
        if($query->num_rows() > 0) {
            return $query->result_array();
        } else {return FALSE;}
    }


    /*добавляет в базу данныйх время отправки письма на почту*/
    public function add_datatime($data,$check_login){
        $this->db->where('login', $check_login);
        $this->db->update('users', $data);
    }

    /*получает время добавленое в базу во время отправки письма*/
    public function get_avtivation_link_from_bd($email){
        $this->db->select('data');
        $query = $this->db->get_where('users', array('email'=>$email));
        if($query->num_rows() > 0) {
            return $query->result_array();
        } else {return FALSE;}
    }

    public function select_email($email){
        $this->db->select('email');
        $this->db->where('login',$email);
        $this->db->or_where('email',$email);
        $query=$this->db->get('users');
        if($query->num_rows() > 0) {
            return $query->result_array();
        } else {return FALSE;}
    }

    public function update_password($data,$login){
        $this->db->where('login', $login);
        $this->db->update('users', $data);
    }
}

