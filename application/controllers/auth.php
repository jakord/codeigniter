<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {

    /*главний изначальный вид*/
    public function index()
    {
       $this->load->model('user_model');
       $data['user_info']=$this->user_model->get_user_info();
        $this->load->view('myform',$data);
    }

    /*авторизирует пользователя если он есть*/
    public function authorization (){
        $this->load->model('user_model');
             $data['user']=$this->session->userdata('username');
            if(empty($data['user'])){
                $auth=$this->input->post('auth');
                $auth=isset($auth);
                if($auth==true){
                    if($auth==true){
                        $login=$this->input->post('auth_on_log');
                        $login=isset($login);
                        if($login==true){
                            $login=$this->input->post('auth_on_log');
                            $auth_log=$this->user_model->authorization_log($login);
                            $data['login']=$auth_log;
                            $newdata = array(
                                'username'  => $login,
                                'logged_in' => TRUE
                            );
                            $this->session->set_userdata($newdata);
                            $this->load->view('authorization',$data);
                        }
                    }else{
                        $this->load->view('authorization');
                    }
                }
                else{
                    $this->load->view('authorization');
                }
            }
            else{
                $this->load->view('myform',$data);
            }

    }

    /*отправляет письмо если нажата кнопкка востановить*/
    public function send_mail($email){
        $this->load->model('user_model');
        $auth_email=$this->user_model->authorization_email($email);
        $from="tasks.ru";
        $to=$auth_email;
    }

    /*регистрирует пользователя + валидация*/
    public function registration (){
        $this->load->library('form_validation');
        $send=isset($_POST['send']);
        if( $send==TRUE){
            $this->load->model('user_model');
            $data['user_info']=$this->user_model->get_user_info();
            $this->load->model('rules_model');
            $this->form_validation->set_rules($this->rules_model->rules);
            $check=$this->form_validation->run();
            $login=trim($this->input->post('login'));
            $email=trim($this->input->post('email'));
            $pasword=$this->input->post('password');
            $r_password=$this->input->post('r_password');
            $check_login=$this->user_model->check_login($login);
            $check_email=$this->user_model->check_email($email);
            if($pasword==$r_password){
                if($check==TRUE &&  $check_login==false && $check_email==false){
                    $user['login']="$login";
                    $user['password']="$r_password";
                    $user['email']="$email" ;
                    $this->user_model->add_user($user);
                    redirect(base_url());
                }
                else{
                    $this->load->view('registration');
                }
            }else{
                echo "пароли не совпали";
                $this->load->view('registration');
            }

        }
        else{
            $this->load->view('registration');
        }
    }

    /*отпраляет пароль и сылку в письму */
    public function rem_password(){
        $str=($this->input->post('rem_pas'));
        $str=isset($str);
        if($str==true){
            $login=$this->input->post('login');
            $this->load->model('user_model');
            $check_login=$this->user_model->check_pass($login);

             if(!empty($check_login)){
                 $login=$this->user_model->authorization_log($login);
                 foreach($login as $item) {$seach_login=$item['login'];}
                 $datatime=time();
                 $data['data']=$datatime;
                 $this->user_model->add_datatime($data,$seach_login);


                 $email=$this->input->post('login');;
                 $to=$this->user_model->search_mail($email);
                 $from=base_url();
                 foreach($check_login as $item){
                     $item['password'];
                 }
                 foreach ($login as $val) {
                     $log=$val['login'];
                 }

                 $pass=$item['password'];
                 $subject="repair or change the password";
                 $link=(md5($pass));
                 $message='ваш пароль '.$pass.' либо вы можете создать новый '.$from.'auth/check_link?key='.$link.'&log='.$log.'';
                 mail($to,$from,$message,$subject);
             }
            $data['login']=$check_login;

            $this->load->view('rem_password',$data);
        }

    }

    /*проверяет сыку полученню из почты*/
    public function check_link(){
        if(isset($_GET['key'])&& $_GET !== '' ){
            $data['time']= time();
            $data['log']=$_GET['log'];
        }

        $this->load->model('user_model');
        $email='jakord1@mail.ru';
        $data_from_bd= $this->user_model->get_avtivation_link_from_bd($email);
        $data['data']=$data_from_bd;
        $this->load->view('link',$data);


    }

    /*обновляет пароль */
    public function update_password(){
            $submit=$this->input->post('r_submit');
            $submit=isset($submit);
             if($submit==true){
            $this->load->model('user_model');
            $new_pswd=$this->input->post('mod_pswd');
            $r_pswd=$this->input->post('r_pswd');


                if($new_pswd==$r_pswd){
                    $data['password']=$r_pswd;
                    $login = $this->session->flashdata('log');

                    $this->user_model->update_password($data,$login);

                }
                else{
                    $data['error']='пароли не совпали';
                    $this->load->view('update_pasword',$data);
                }

            }

    }




}