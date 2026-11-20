<?php
echo view('header.php');
echo view('sidebar.php');
if($view){
    echo view($view);
}
echo view('footer.php');


?>