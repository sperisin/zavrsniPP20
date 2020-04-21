<?php 

class NapomenaController extends AutorizacijaController
{
    private $viewDir = 'privatno' . DIRECTORY_SEPARATOR . 'napomena' . DIRECTORY_SEPARATOR;

    public function index()
    {
        if ($_SESSION['operater']->uloga != 'superadmin'){
            $this->view->render($this->viewDir . 'index', [
            'napomene' => Napomena::readAll(),
            'javascript'=>'<script src="' . APP::config('url') . 'public/js/napomena/index.js' . '"></script>'
        ]);
        }
        else{
            $this->view->render($this->viewDir . 'index', [
                'napomene' => Napomena::readSA(),
                'javascript'=>'<script src="' . APP::config('url') . 'public/js/napomena/index.js' . '"></script>'
            ]);
        }
    }

    public function novi()
    {
        if ($_SESSION['operater']->uloga != 'superadmin'){
            $this->view->render($this->viewDir . 'napomenanovi', [
            'partneri' => Partner::readSTvrtka($_SESSION['operater']->tvrtka_id)
        ]);
        }
        else{
            $this->view->render($this->viewDir . 'napomenanovi', [
                'partneri' => Partner::readAll(),
                'javascript'=>'<script src="' . APP::config('url') . 'public/js/napomena/novi.js' . '"></script>'
            ]);
        }
    }

    public function poruka()
    {
        echo Napomena::prikaziporuku($_GET['id']);
    }

    public function dodaj()
    {
        /* DODAVANJE NAPOMENE */
    }

    public function obrisi()
    {
        if (Napomena::obrisi($_GET['napomena_id'])){
            $this->index();
        }
    }
}