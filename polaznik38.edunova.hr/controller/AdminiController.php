<?php

class AdminiController extends AdminController
{

    private $viewDir = 'admin' . DIRECTORY_SEPARATOR;

    public function operateri()
    {
        if ($_SESSION['operater']->uloga == 'Admin'){
            if ($_SESSION['operater']->tvrtka_id != NULL){
                $this->view->render($this->viewDir . 'operateri', [
                    'operateri'=>Operater::readForAdmin()
                ]);
                }
                else{
                    $this->view->render('pocetna');
                }
            }
            else if ($_SESSION['operater']->uloga == 'superadmin'){
                $this->view->render($this->viewDir . 'operateri', [
                    'operateri'=>Operater::readForSuperadmin()
                ]);
            }
    }

    public function tvrtke()
    {
        if ($_SESSION['operater']->uloga == 'superadmin'){
            $this->view->render($this->viewDir . 'tvrtke', [
                'tvrtke'=>Tvrtka::readForSuperadmin()
            ]);
        }
    }

    public function partneri()
    {
        if ($_SESSION['operater']->uloga == 'superadmin'){
            $this->view->render($this->viewDir . 'partneri', [
                'partnerizasa'=>Partner::readAll()
            ]);
        }
        else if ($_SESSION['operater']->uloga == 'Admin'){
            $temppart = Partner::readSTvrtka($_SESSION['operater']->tvrtka_id);
            if ($temppart == NULL){
                $this->view->render($this->viewDir . 'partneri', [
                    'partneri'=>$temppart,
                    'alertPoruka'=>'Nemate unesene partnere'
                ]);
            }
            else{
                $this->view->render($this->viewDir . 'partneri', [
                    'partneri'=>$temppart,
                ]);
            }
        }
    }

    public function tvrtkapromjena()
    {
        $id = $_GET['tvrtka_id'];
        $this->view->render($this->viewDir . 'tvrtkeedit', [
            'tvrtka'=>Tvrtka::read($id),
            'mjesta'=>Sifarnik::mjestoReadall()
        ]);
    }

    public function novatvrtka()
    {
        $this->view->render('tvrtkenovi', [
            'mjesto'=>Sifarnik::mjestoReadall()
        ]);
    }

    public function tvrtkespremi()
    {
        if (trim($_POST['nazivtvrtke']) == '' || trim($_POST['oibtvrtke']) == '' || trim($_POST['adresatvrtke']) == '' || trim($_POST['emailtvrtke']) == '' || $_POST['mjesto'] == '0'){
            $this->view->render($this->viewDir . 'tvrtkenovi', [
                'alertPoruka'=>'Unesite potrebne podatke!',
                'mjesta'=>Sifarnik::mjestoReadall()
            ]);
            return;
        }

        if (!isset($_POST['nazivtvrtke']) || !isset($_POST['oibtvrtke']) || !isset($_POST['adresatvrtke']) || !isset($_POST['emailtvrtke']) || $_POST['mjesto'] == '0'){
            $this->view->render($this->viewDir . 'tvrtkenovi', [
                'alertPoruka'=>'Unesite potrebne podatke!',
                'mjesta'=>Sifarnik::mjestoReadall()
            ]);
            return;
        }

        if (strlen($_POST['oibtvrtke']) != 11){
            $this->view->render($this->viewDir . 'tvrtkenovi', [
                'alertPoruka'=>'OIB sadržava 11 znamenaka!', 
                'mjesta'=>Sifarnik::mjestoReadall()
            ]);
            return;
        } 
        Tvrtka::create();
        $this->tvrtke();
    }

    public function partnerinovi()
    {
        $this->view->render($this->viewDir . 'partnerinovi');
    }

    public function partneripromjena()
    {
        $id = $_GET['partner_id'];
        $this->view->render($this->viewDir . 'partneriedit', [
            'partner'=>Partner::read($id),
            'mjesta'=>Sifarnik::mjestoReadall()
        ]);
    }

    public function partneriedit()
    {
        if (trim($_POST['nazivpartnera']) == '' || trim($_POST['oibpartnera']) == '' || trim($_POST['adresapartnera']) == '' || trim($_POST['emailpartnera']) == '' || $_POST['mjesto'] == '0'){
            $this->partneri();
            return;
        }

        if (!isset($_POST['nazivpartnera']) || !isset($_POST['oibpartnera']) || !isset($_POST['adresapartnera']) || !isset($_POST['emailpartnera']) || $_POST['mjesto'] == '0'){
            $this->partneri();
            return;
        }

        if (strlen($_POST['oibpartnera']) != 11){
            $this->view->render($this->viewDir . 'partneri', [
                'alertPoruka'=>'OIB sadržava 11 znamenaka!', 
                'mjesta'=>Sifarnik::mjestoReadall()
            ]);
            return;
        } 

        Partner::update($_POST['partner_id']);
        $this->partneri();
    }

    public function partneriobrisi()
    {
        if (Partner::delete($_GET['partner_id'])){
            $this->partneri();
        }
    }

    public function partnerispremi()
    {
        if (trim($_POST['nazivpartnera']) == '' || trim($_POST['oibpartnera']) == '' || trim($_POST['adresapartnera']) == '' || trim($_POST['emailpartnera']) == '' || $_POST['mjesto'] == '0'){
            $this->view->render($this->viewDir . 'partnerinovi', [
                'alertPoruka'=>'Unesite potrebne podatke!',
                'mjesta'=>Sifarnik::mjestoReadall()
            ]);
            return;
        }

        if (!isset($_POST['nazivpartnera']) || !isset($_POST['oibpartnera']) || !isset($_POST['adresapartnera']) || !isset($_POST['emailpartnera']) || $_POST['mjesto'] == '0'){
            $this->view->render($this->viewDir . 'partnerinovi', [
                'alertPoruka'=>'Unesite potrebne podatke!',
                'mjesta'=>Sifarnik::mjestoReadall()
            ]);
            return;
        }

        if (strlen($_POST['oibpartnera']) != 11){
            $this->view->render($this->viewDir . 'partnerinovi', [
                'alertPoruka'=>'OIB sadržava 11 znamenaka!', 
                'mjesta'=>Sifarnik::mjestoReadall()
            ]);
            return;
        } 

        Partner::create();
        $this->partneri();
    }

    public function tvrtkeedit()
    {
        if (trim($_POST['nazivtvrtke']) == '' || trim($_POST['oibtvrtke']) == '' || trim($_POST['adresatvrtke']) == '' || trim($_POST['emailtvrtke']) == '' || $_POST['mjesto'] == '0'){
            $this->partneri();
            return;
        }

        if (!isset($_POST['nazivtvrtke']) || !isset($_POST['oibtvrtke']) || !isset($_POST['adresatvrtke']) || !isset($_POST['emailtvrtke']) || $_POST['mjesto'] == '0'){
            $this->partneri();
            return;
        }

        if (strlen($_POST['oibtvrtke']) != 11){
            $this->view->render($this->viewDir . 'tvrtke', [
                'alertPoruka'=>'OIB sadržava 11 znamenaka!', 
                'mjesta'=>Sifarnik::mjestoReadall()
            ]);
            return;
        } 

        Tvrtka::update($_POST['tvrtka_id']);
        $this->partneri();   
    }

    public function tvrtkaobrisi()
    {
        if (Tvrtka::delete($_GET['tvrtka_id'])){
            $this->partneri();
        }
    }

    public function operaterobrisi()
    {
        if (Operater::delete($_GET['operater_id'])){
            $this->operateri();
        }
    }

    public function operaterpromjena()
    {
        $id = $_GET['operater_id'];
        $this->view->render($this->viewDir . 'operateriedit', [
            'operater'=>$id
        ]);
    }

    public function operateredit()
    {
        if (trim($_POST['email']) == '' || trim($_POST['OIB']) == '' || trim($_POST['uloga']) == ''){
            $this->operateri();
            return;
        }

        if (!isset($_POST['email']) || !isset($_POST['OIB']) || !isset($_POST['uloga'])){
            $this->operateri();
            return;
        }

        Operater::update();
        $this->operateri();
    }
}