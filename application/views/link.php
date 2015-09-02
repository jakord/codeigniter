<?php
print_r($time);
foreach ($data as $item) {
  echo "<br/>".$item['data'];
}
if($time-$item['data']<300){
    $this->session->set_flashdata('log', $log);
    redirect('/auth/update_password');
}

else {
    echo 'ваша сылка устарела надо';
}