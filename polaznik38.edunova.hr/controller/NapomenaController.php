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
            'partneri' => Partner::readSTvrtka($_SESSION['operater']->tvrtka_id),
            'javascript'=>'<script src="' . APP::config('url') . 'public/js/napomena/datepicker.js' . '"></script>' . PHP_EOL . '<script src="' . APP::config('url') . 'public/js/napomena/main.js' . '"></script>',
            'css'=>'<link href="' . APP::config('url') . 'public/css/datepicker.css" rel="stylesheet">' . PHP_EOL . '<link href="' . APP::config('url') . 'public/css/main.css" rel="stylesheet">'
        ]);
        }
        else{
            $this->view->render($this->viewDir . 'napomenanovi', [
                'partneri' => Partner::readAll(),
                'javascript'=>'<script src="' . APP::config('url') . 'public/js/napomena/datepicker.js' . '"></script>' . PHP_EOL . '<script src="' . APP::config('url') . 'public/js/napomena/main.js' . '"></script>',
                'css'=>'<link href="' . APP::config('url') . 'public/css/datepicker.css" rel="stylesheet">' . PHP_EOL . '<link href="' . APP::config('url') . 'public/css/main.css" rel="stylesheet">'
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
        $_POST['date'] = str_replace('/', '-', $_POST['date']);
        $_POST['date'] = DateTime::createFromFormat('d-m-Y', $_POST['date']);
        $_POST['date'] = $_POST['date']->format('Y-m-d'); 
        if (!isset($_POST['date']) || !isset($_POST['napomena']) || $_POST['partner'] == '0'){
            $this->view->render($this->viewDir . 'napomenanovi', [
                'alertPoruka'=>'Unesite potrebne podatke!',
                'partneri' => Partner::readSTvrtka($_SESSION['operater']->tvrtka_id),
                'javascript'=>'<script src="' . APP::config('url') . 'public/js/napomena/datepicker.js' . '"></script>' . PHP_EOL . '<script src="' . APP::config('url') . 'public/js/napomena/main.js' . '"></script>',
                'css'=>'<link href="' . APP::config('url') . 'public/css/datepicker.css" rel="stylesheet">' . PHP_EOL . '<link href="' . APP::config('url') . 'public/css/main.css" rel="stylesheet">'
            ]);
            return;
        }

        if (trim($_POST['date']) == '' || trim($_POST['napomena']) == '' || $_POST['partner'] == '0'){
            $this->view->render($this->viewDir . 'napomenanovi', [
                'alertPoruka'=>'Unesite potrebne podatke!',
                'partneri' => Partner::readSTvrtka($_SESSION['operater']->tvrtka_id),
                'javascript'=>'<script src="' . APP::config('url') . 'public/js/napomena/datepicker.js' . '"></script>' . PHP_EOL . '<script src="' . APP::config('url') . 'public/js/napomena/main.js' . '"></script>',
                'css'=>'<link href="' . APP::config('url') . 'public/css/datepicker.css" rel="stylesheet">' . PHP_EOL . '<link href="' . APP::config('url') . 'public/css/main.css" rel="stylesheet">'
            ]);
            return;
        }
        $_POST['napomena'] = htmlentities($_POST['napomena']);
        Napomena::create();
        $this->index();
    }

    public function obrisi()
    {
        if (Napomena::delete($_GET['napomena_id'])){
            $this->index();
        }
    }

    public function promjena()
    {
        $this->view->render($this->viewDir . 'napomenaedit', [
            'napomena'=>Napomena::read($_GET['napomena_id']),
            'partneri' => Partner::readSTvrtka($_SESSION['operater']->tvrtka_id),
            'javascript'=>'<script src="' . APP::config('url') . 'public/js/napomena/datepicker.js' . '"></script>' . PHP_EOL . '<script src="' . APP::config('url') . 'public/js/napomena/main.js' . '"></script>',
            'css'=>'<link href="' . APP::config('url') . 'public/css/datepicker.css" rel="stylesheet">' . PHP_EOL . '<link href="' . APP::config('url') . 'public/css/main.css" rel="stylesheet">'
        ]);
    }

    public function edit()
    {
        $_POST['date'] = str_replace('/', '-', $_POST['date']);
        $_POST['date'] = DateTime::createFromFormat('d-m-Y', $_POST['date']);
        $_POST['date'] = $_POST['date']->format('Y-m-d'); 
        if (!isset($_POST['date']) || !isset($_POST['napomena']) || $_POST['partner'] == '0'){
            $this->index();
            return;
        }

        if (trim($_POST['date']) == '' || trim($_POST['napomena']) == '' || $_POST['partner'] == '0'){
            $this->index();
            return;
        }
        $_POST['napomena'] = htmlentities($_POST['napomena']);
        Napomena::update();
        $this->index();
    }
}