<?php

class OperaterController extends AdminController
{

    private $viewDir = 'privatno' . 
    DIRECTORY_SEPARATOR . 'operater' .
    DIRECTORY_SEPARATOR;

    public function index()
    {
        $this->view->render($this->viewDir . 'index',[
         'podaci'=>Operater::readAll()
     ]);
    }

    public function novi()
    {
        $this->view->render($this->viewDir . 'novi',
            ['poruka'=>'Popunite sve tražene podatke']
        );
    }

    public function dodajnovi()
    {
        //prvo dođu sve silne kontrole
        if (($_POST['pass'] === $_POST['lozinkaponovo']) && ($_POST['email'] != '') && ($_POST['username'] != '')){
            Operater::create();
            $this->index();
        }
        else if (($_POST['email'] != '') && ($_POST['username'] != '') && ($_POST['pass'] != $_POST['lozinkaponovo']))
        {
            echo '<script> function myFunction() {
                alert("Niste potvrdili lozinku");
              } </script>';
            header('location: ' . APP::config('url'));
        } 

    }

    public function obrisi()
    {
        //prvo dođu silne kontrole
        if(Operater::delete()){
            header('location: /operater/index');
        }
        
    }

    public function promjena()
    {
        $operater = Operater::read($_GET['sifra']);
        if(!$operater){
            $this->index();
            exit;
        }

        $this->view->render($this->viewDir . 'promjena',
            ['operater'=>$operater,
                'poruka'=>'Promjenite željene podatke']
        );
     
    }

    public function promjeni()
    {
        // I OVDJE DOĐU SILNE KONTROLE
        Operater::update();
        header('location: /operater/index');
    }
}