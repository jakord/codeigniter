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

    /*вход на личный кабинет*/
    public function personal_cab(){
        $this->load->model('user_model');
        $country=$this->input->post('country');
        $country=isset($country);
           if($country==true){
               $value=$this->user_model->select_sity($this->input->post('countr'));
               $data['value']=$value;
           }
        $login=$this->session->userdata('username');
        $info=$this->user_model->get_user_info();
        if(!empty($city)&& !empty($town)){
            $data['city']=$city;
            $data['country']=$town;
            $this->user_model->add_country_city($data,$login);
        }

        $data['info']=$info;
        $this->load->view('personal_area',$data);
    }
    /*выризавет картинку из загруженойо картинки*/
    public function crop(){
        $this->load->model('user_model');
        $login=$this->session->userdata('username');
        $image= $this->user_model->get_user_avatar($login);
        foreach($image as $item){$item['img'];}
        $data['img']=$item['img'];
        $filename = $item['img'];;
        $new_filename = $item['img'];;

        list($current_width, $current_height) = getimagesize($filename);
        $x1    = $_POST['x1'];
        $y1    = $_POST['y1'];
        $x2    = $_POST['x2'];
        $y2    = $_POST['y2'];
        $w    = $_POST['w'];
        $h    = $_POST['h'];
        $crop_width = 120;
        $crop_height = 120;

        $new = imagecreatetruecolor($crop_width, $crop_height);
        $current_image = imagecreatefromjpeg($filename);
        imagecopyresampled($new, $current_image, 0, 0, $x1, $y1, $crop_width, $crop_height, $w, $h);
        imagejpeg($new, $new_filename, 95);
        $this->load->view('crop',$data);
    }
    /*загрузка изображений*/
    public function upload(){
        $upload=($this->input->post('upload'));
        if(!empty($upload)){
        $config['upload_path'] = './image/';
		$config['allowed_types'] = 'jpg|png';
		$config['max_size']	= '400';
		$config['max_width']  = '800';
		$config['max_height']  = '400';
        $config['encrypt_name']  = TRUE;
        $config['remove_spaces']  = TRUE;

		$this->load->library('upload', $config);
        $this->upload->do_upload();

        $image=$this->upload->data();
        $data['img']=$image['file_name'];
        $this->load->model('user_model');
        $login=$this->session->userdata('username');
        $this->user_model->upload_img($data,$login);

        }
        $this->load->view('upload');
    }
   /*проеверяет номер телефона на коректность ввода и записывает его в базу в слечае правильного присланых пароля*/
    public function check_number(){
        // $_POST['userPhone'] - номер телефона получаемый из формы
        // Данная проверка принимает только 10 значные номера (9031234567) состоящие только из цифр,
        // без скобок, дефисов и пробелов
        // {10,10} - показывает диопазон допустимой длинны номера, если нужно проверять номер на 11 знаков,
        // то нужно изменить на {10,11}
        $btn=$this->input->post('send');
        $btn=isset($btn);
        if($btn==true){if(!preg_match("/^[0-9]{11,11}+$/", $_POST['userPhone'])) echo ("Телефон задан в неверном формате");
                // Добавляем восьмерку к номеру телефону, если мы рассылаем по Украине.
                $_POST['userPhone'] = "8".$_POST['userPhone'];
                $first = substr($_POST['userPhone'], "0",1);
                if($first == 8) {
                    $num=6;
                    function generate_pass($num){
                        $arr = array('a','b','c','d','e','f',
                            'g','h','i','j','k','l',
                            'm','n','o','p','r','s',
                            't','u','v','x','y','z',
                            'A','B','C','D','E','F',
                            'G','H','I','J','K','L',
                            'M','N','O','P','R','S',
                            'T','U','V','X','Y','Z',
                            '1','2','3','4','5','6',
                            '7','8','9','0');
                        // Генерируем пароль для смс
                        $pass = "";
                        for($i = 0; $i < $num; $i++) {
                            // Вычисляем произвольный индекс из массива
                            $index = rand(0, count($arr) - 1);
                            $pass .= $arr[$index];
                        }
                        return $pass;
                    }
                    $newpass =  generate_pass(6);
                    $data['pass']=$newpass;
                    $login=$this->session->userdata('username');


                    /*скприпт отправвки смс*/
                        $password=$newpass;
                        $phone=$first;
                        $text='введите ваш пароль на сайте'.$newpass;
                        function send($host, $port, $login, $password, $phone, $text, $sender = false, $wapurl = false )
                        {
                            $fp = fsockopen($host, $port, $errno, $errstr);
                            if (!$fp) {
                                return "errno: $errno \nerrstr: $errstr\n";
                            }
                            fwrite($fp, "GET /messages/v2/send/" .
                                "?phone=" . rawurlencode($phone) .
                                "&text=" . rawurlencode($text) .
                                ($sender ? "&sender=" . rawurlencode($sender) : "") .
                                ($wapurl ? "&wapurl=" . rawurlencode($wapurl) : "") .
                                "  HTTP/1.0\n");
                            fwrite($fp, "Host: " . $host . "\r\n");
                            if ($login != "") {
                                fwrite($fp, "Authorization: Basic " .
                                    base64_encode($login. ":" . $password) . "\n");
                            }
                            fwrite($fp, "\n");
                            $response = "";
                            while(!feof($fp)) {
                                $response .= fread($fp, 1);
                            }
                            fclose($fp);
                            list($other, $responseBody) = explode("\r\n\r\n", $response, 2);
                            return $responseBody;
                        }
                        echo send("api.smsfeedback.ru", 80, $login, $password,
                        $phone, $text, "TEST-SMS");
                }else {echo ("Ваш номер телефон начинается не на восьмерку");}

                $num_p=$this->input->post('num_p');
                $num_p=isset($num_p);
                if($num_p==true){
                    $input_pass=$this->input->post('num_pass');
                     if($input_pass==$newpass){

                         $this->load->model('user_model');
                         $data['mob_t']=$first;
                         $this->user_model->add_phone_number($this->session->userdata('username'),$data);
                     }
                }
            }
          $this->load->view('phone_number',$data);
        }

}