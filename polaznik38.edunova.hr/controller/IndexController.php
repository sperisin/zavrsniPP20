<?php

class IndexController extends Controller
{

    public function prijava()
    {
        $this->view->render('zapocniregistraciju');
    }

    public function autorizacija()
    {
        if(!isset($_POST['email']) || 
        !isset($_POST['lozinka'])){
            $this->view->render('zapocniregistraciju');
            return;
        }

        if(trim($_POST['email'])==='' || 
        trim($_POST['lozinka'])===''){
            $this->view->render('zapocniregistraciju');
            return;
        }

        //$veza = new PDO('mysql:host=localhost;dbname=edunovapp20;charset=utf8',
        //'edunova','edunova');

        $veza = DB::getInstanca();

        	    //sql INJECTION PROBLEM
        //$veza->query('select lozinka from operater 
        //              where email=\'' . $_POST['email'] . '\';');
        $izraz = $veza->prepare('select * from operater 
                      where email=:email');
        $izraz->execute(['email'=>$_POST['email']]);
        //$rezultat=$izraz->fetch(PDO::FETCH_OBJ);
        $rezultat=$izraz->fetch();
/*
        if($rezultat==null){
            $this->view->render('prijava',[
                'poruka'=>'Nepostojeći korisnik',
                'email'=>$_POST['email']
            ]);
            return;
        }

        if(!password_verify($_POST['lozinka'],$rezultat->pass)){
            $this->view->render('prijava',[
                'poruka'=>'Neispravna kombinacija email i lozinka',
                'email'=>$_POST['email']
            ]);
            return;
        }*/
        //unset($rezultat->pass);
        if($rezultat==null){
            $this->view->render('zapocniregistraciju',[
                'alertPoruka'=>'Nepostojeći korisnik'
            ]);
            return;
        }
        if(!password_verify($_POST['lozinka'],$rezultat->lozinka)){
            $this->view->render('zapocniregistraciju',[
                'alertPoruka'=>'Neispravan email/lozinka'
            ]);
            return;
        }

        unset($rezultat->lozinka);
        $_SESSION['operater']=$rezultat;
        $this->view->render('pocetna', [
            'poruka'=>'Dobrodošli natrag ' . $_SESSION['operater']->ime . ' ' . $_SESSION['operater']->prezime . '!'
        ]);
        //$this->view->render('privatno' . DIRECTORY_SEPARATOR . 'nadzornaPloca');
    }

    public function odjava()
    {
        unset($_SESSION['operater']);
        session_destroy();
        header('location: ' . APP::config('url'));
    }

    public function index()
    {   
        if (isset($_SESSION['operater'])){
            $por = 'Dobrodošli nazad ' . $_SESSION['operater']->ime . ' ' . $_SESSION['operater']->prezime . '!';
        }
        else{
            $por = 'Niste prijavljeni';
        }
        $this->view->render('pocetna', [
            'poruka'=>$por
        ]);
    }
    public function onama()
    {
        $this->view->render('onama');
    }

    public function json()
    {
        $niz=[];
        $s=new stdClass();
        $s->naziv='PHP programiranje';
        $s->sifra=1;
        $niz[]=$s;
        //$this->view->render('onama',$niz);
        echo json_encode($niz);
    }

    public function test()
    {
        echo password_hash('to1', PASSWORD_BCRYPT);
        echo '<hr>';
        echo password_hash('to2', PASSWORD_BCRYPT);
        echo '<hr>';
        echo password_hash('to3', PASSWORD_BCRYPT);
        echo '<hr>';
        echo password_hash('to4', PASSWORD_BCRYPT);
        echo '<hr>';
        // echo md5('mojaMala'); NE KORISTITI
        echo '<pre>';
        print_r(Operater::readForAdmin());
        echo '</pre>';
    } 

    public function zapocniregistraciju()
    {
        $this->view->render('zapocniregistraciju');
    }

    public function zavrsiregistraciju()
    {
        if(trim($_POST['email'])==='' || trim($_POST['lozinka'])==='' || trim($_POST['lozinkaponovo']) === ''){
            $this->view->render('zapocniregistraciju', [
            'alertPoruka'=>'Popunite podatke'
            ]);
            return;
        }

        if(!isset($_POST['email']) || !isset($_POST['lozinka']) || !isset($_POST['lozinkaponovo'])){
            $this->view->render('zapocniregistraciju', [
            'alertPoruka'=>'Popunite podatke'
            ]);
            return;
        }

        if ($_POST['lozinka'] !== $_POST['lozinkaponovo']){
            $this->view->render('zapocniregistraciju', [
                'alertPoruka'=>'Potvrda lozinke ne podudara se s lozinkom'
            ]);
            return;
        }

        else{
            unset($_POST['lozinkaponovo']);
            $_SESSION['email'] = $_POST['email'];
            $_POST['lozinka'] = password_hash($_POST['lozinka'], PASSWORD_BCRYPT);
            $_SESSION['lozinka'] = $_POST['lozinka'];
            Operater::registrirajnovi();
            $this->view->render('zapocniregistraciju', [
                'alertPoruka'=>'Provjerite svoj email'
                ]);
            return;
        }
    }

    public function registrirajse()
    {
        if ($_GET['id'] == session_id()){
            $this->view->render('registracija', [
                'tvrtke'=>Tvrtka::readAll()
        ]);
        }
        else{
            $this->view->render('pocetna', [
                'alertPoruka'=>'Došlo je do pogreške prilikom registracije. Pokušajte ponovo'
            ]);
            return;
        }
    }

    public function registracija()
    {
        if (trim($_POST['ime']) === '' || trim($_POST['prezime']) === '' || trim($_POST['oib']) === '' || $_POST['tvrtka'] == '0'){
            $this->view->render('registracija', [
                'alertPoruka'=>'Unesite potrebne podatke!',
                'tvrtke'=>Tvrtka::readAll()
            ]);
            return;
        }

        if (!isset($_POST['ime']) || !isset($_POST['prezime']) || !isset($_POST['oib']) || $_POST['tvrtka'] == '0'){
            $this->view->render('registracija', [
                'alertPoruka'=>'Unesite potrebne podatke!',
                'tvrtke'=>Tvrtka::readAll()
            ]);
            return;
        }

        if (strlen($_POST['oib']) !== 11){
            $this->view->render('registracija', [
                'tvrtke'=>Tvrtka::readAll(),
                'alertPoruka'=>'OIB sadržava 11 znamenaka!'
            ]);
            return;
        }

        Operater::create();
        
        $this->view->render('pocetna', [
            'alertPoruka'=>'Registracija uspješna!'
        ]);

    }

    public function omeni()
    {
        $this->view->render('omeni');
    }

    public function ERA()
    {
        $this->view->render('ERA');
    }

}