<?php 
class ProfilController extends AutorizacijaController
{
    private $viewDir = 'profil' . DIRECTORY_SEPARATOR;

    public function index()
    {
        $tvrtka = Tvrtka::read($_SESSION['operater']->tvrtka_id);
        if ($tvrtka == NULL){
            $this->view->render($this->viewDir . 'index', [
                'tvrtka'=>''
            ]);
        }
        else{
            $this->view->render($this->viewDir . 'index', [
                'tvrtka'=>$tvrtka->naziv
            ]);
        }
    }

    public function edit()
    {
        // render edit podataka 
        $this->view->render($this->viewDir . 'edit', [
            'operater'=>Operater::read($_SESSION['operater']->operater_id)
        ]);
    }

    public function pristupedit()
    {
        // render edit pristupnih podataka 
        $this->view->render($this->viewDir . 'pristupedit', [
            'operater'=>Operater::read($_SESSION['operater']->operater_id)
        ]);
    }

    public function promjena()
    {
        // spremanje promjene
        if (trim($_POST['prezime']) == '' || trim($_POST['ime']) == ''){
            $this->view->render($this->viewDir . 'edit', [
                'alertPoruka'=>'Unesite potrebne podatke!'
            ]);
            return;
        }

        if (!isset($_POST['prezime']) || !isset($_POST['ime'])){
            $this->view->render($this->viewDir . 'edit', [
                'alertPoruka'=>'Unesite potrebne podatke!'
            ]);
            return;
        }
        $_SESSION['operater']->prezime = $_POST['prezime'];
        $_SESSION['operater']->ime = $_POST['ime'];
        Operater::updateOsnovno();
        $this->index();
    }

    public function pristuppromjena()
    {
        // spremanje promjene pristupnih podataka
        if (trim($_POST['email']) == '' || trim($_POST['lozinka']) == '' || trim($_POST['lozinkaponovo'])){
            $this->view->render($this->viewDir . 'pristupedit', [
                'alertPoruka'=>'Unesite potrebne podatke!'
            ]);
            return;
        }

        if (!isset($_POST['email']) || !isset($_POST['lozinka']) || !isset($_POST['lozinkaponovo'])){
            $this->view->render($this->viewDir . 'pristupedit', [
                'alertPoruka'=>'Unesite potrebne podatke!'
            ]);
            return;
        }

        if ($_POST['lozinka'] != $_POST['lozinkaponovo']){
            $this->view->render($this->viewDir . 'pristupedit', [
                'alertPoruka'=>'Potvrdite željenu lozinku!'
            ]);
            return;
        }
        $_SESSION['operater']->email = $_POST['email'];
        unset($_POST['lozinkaponovo']);
        $_POST['lozinka'] = password_hash($_POST['lozinka'], PASSWORD_BCRYPT);
        Operater::updatePristupni();
        $this->index();
    }

}