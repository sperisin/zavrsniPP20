<?php 
     
class PartnerController extends AutorizacijaController
{
    private $viewDir = 'privatno' . DIRECTORY_SEPARATOR . 'partner' . DIRECTORY_SEPARATOR;

    public function index()
    {
        $this->view->render($this->viewDir . 'index', [
            'partneri' => Partner::readSTvrtka($_SESSION['operater']->tvrtka_id)
        ]);
    }

    public function novi()
    {
        $this->view->render($this->viewDir . 'partnerinovi', [
            'mjesta'=>Sifarnik::mjestoReadall()
        ]);
    }

    public function spremi()
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

    public function edit()
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
        $this->index();
    }
}