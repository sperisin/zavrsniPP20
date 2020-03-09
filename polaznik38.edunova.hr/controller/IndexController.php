<?php

class IndexController extends Controller
{

    public function prijava()
    {
        $this->view->render('zapocniregistraciju');
    }

    public function autorizacija()
    {
        if(!isset($_POST['username']) || 
        !isset($_POST['lozinka'])){
            $this->view->render('zapocniregistraciju',[
                'poruka'=>'Nisu postavljeni pristupni podaci',
                'email' =>''
            ]);
            return;
        }

        if(trim($_POST['username'])==='' || 
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
                      where username=:username');
        $izraz->execute(['username'=>$_POST['username']]);
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
                'poruka'=>'Nepostojeći korisnik',
                'username'=>$_POST['username']
            ]);
            Partner::readAll();
            return;
        }
        if(!password_verify($_POST['lozinka'],$rezultat->lozinka)){
            $this->view->render('zapocniregistraciju',[
                'poruka'=>'Neispravna kombinacija email i lozinka',
                'username'=>$_POST['username']
            ]);
            Partner::readAll();
            return;
        }

        unset($rezultat->lozinka);
        $_SESSION['operater']=$rezultat;
        $this->view->render('pocetna');
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
        $poruka='hello iz kontrolera';
        $kod=22;

       
        $this->view->render('pocetna',[
            'p'=>$poruka,
            'k'=>$kod]
        );


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
     echo password_hash('e',PASSWORD_BCRYPT);
      // echo md5('mojaMala'); NE KORISTITI
    } 
}