<?php 

class SifarnikController extends AutorizacijaController
{
    private $viewDir = 'sifarnik' . DIRECTORY_SEPARATOR;
    public function drzave()
    {
        $this->view->render($this->viewDir . 'drzave', [
            'drzave'=>Sifarnik::drzavaReadall()
        ]);
    }

    public function mjesta()
    {
        $this->view->render($this->viewDir . 'mjesta', [
            'mjesta'=>Sifarnik::mjestoReadall()
        ]);
    }

    public function drzavapromjena()
    {
        $drzava = Sifarnik::drzavaRead($_GET['drzava_id']);
        $this->view->render($this->viewDir . 'drzaveedit', [
            'drzava'=>$drzava
        ]);
    }

    public function drzavaedit()
    {
        if (trim($_POST['nazivdrzave']) == '' || trim($_POST['oznakadrzave']) == ''){
            $this->view->render($this->viewDir . 'drzave', [
                'alertPoruka'=>'Unesite potrebne podatke!',
                'drzave'=>Sifarnik::drzavaReadall()
            ]);
            return;
        }

        if (!isset($_POST['nazivdrzave']) || !isset($_POST['oznakadrzave'])){
            $this->view->render($this->viewDir . 'drzave', [
                'alertPoruka'=>'Unesite potrebne podatke!',
                'drzave'=>Sifarnik::drzavaReadall()
            ]);
            return;
        }
        Sifarnik::drzavaUpdate($_POST['drzava_id']);
        $this->drzave();
    }

    public function drzavanova()
    {
        $this->view->render($this->viewDir . 'drzavenova');
    }

    public function drzavaspremi()
    {
        if (trim($_POST['nazivdrzave']) == '' || trim($_POST['oznakadrzave']) == ''){
            $this->view->render($this->viewDir . 'drzavenova', [
                'alertPoruka'=>'Unesite potrebne podatke!'
            ]);
            return;
        }

        if (!isset($_POST['nazivdrzave']) || !isset($_POST['oznakadrzave'])){
            $this->view->render($this->viewDir . 'drzavenova', [
                'alertPoruka'=>'Unesite potrebne podatke!'
            ]);
            return;
        }
        Sifarnik::drzavaCreate();
        $this->drzave();
    }

    public function mjestopromjena()
    {
        $mjesto = Sifarnik::mjestoRead($_GET['mjesto_id']);
        $this->view->render($this->viewDir . 'mjestaedit', [
            'mjesto'=>$mjesto,
            'drzave'=>Sifarnik::drzavaReadall()
        ]);
    }

    public function mjestoedit()
    {
        if (trim($_POST['postanskibroj']) == '' || trim($_POST['nazivmjesta']) == '' || $_POST['drzava'] == '0'){
            $this->view->render($this->viewDir . 'mjesta', [
                'alertPoruka'=>'Unesite potrebne podatke!',
                'drzave'=>Sifarnik::drzavaReadall(),
                'mjesta'=>Sifarnik::mjestoReadall()
            ]);
            return;
        }

        if (!isset($_POST['postanskibroj']) || !isset($_POST['nazivmjesta']) || $_POST['drzava'] == '0'){
            $this->view->render($this->viewDir . 'mjesta', [
                'alertPoruka'=>'Unesite potrebne podatke!',
                'drzave'=>Sifarnik::drzavaReadall(),
                'mjesta'=>Sifarnik::mjestoReadall()
            ]);
            return;;
        }
        Sifarnik::mjestoUpdate($_POST['mjesto_id']);
        $this->mjesta();
    }

    public function drzavaobrisi()
    {
        if (Sifarnik::drzavaDelete($_GET['drzava_id'])){
            $this->drzave();
        }
        else{
            $this->drzave();
        }
    }

    public function mjestoobrisi()
    {
        if (Sifarnik::mjestoDelete($_GET['mjesto_id'])){
            $this->mjesta();
        }
    }

    public function mjestonovi()
    {
        $this->view->render($this->viewDir . 'mjestanovi', [
            'drzave'=>Sifarnik::drzavaReadall()
        ]);
    }

    public function mjestospremi()
    {
        if (trim($_POST['postanskibroj']) == '' || trim($_POST['nazivmjesta']) == '' || $_POST['drzava'] == '0'){
            $this->view->render($this->viewDir . 'mjestanovi', [
                'drzave'=>Sifarnik::drzavaReadall(),
                'alertPoruka'=>'Unesite potrebne podatke!'
            ]);
            return;
        }

        if (!isset($_POST['postanskibroj']) || !isset($_POST['nazivmjesta']) || $_POST['drzava'] == '0'){
            $this->view->render($this->viewDir . 'mjestanovi', [
                'drzave'=>Sifarnik::drzavaReadall(),
                'alertPoruka'=>'Unesite potrebne podatke!'
            ]);
            return;
        }
        Sifarnik::mjestoCreate();
        $this->mjesta();
    }
}