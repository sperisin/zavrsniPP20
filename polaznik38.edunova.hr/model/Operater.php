<?php

class Operater
{
    public static function read()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select * from operater');
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function readAll()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select * from operater');
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function readForAdmin()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select a.operater_id, concat(a.ime, \' \', a.prezime) as osoba, a.email, a.uloga, a.oib from operater a 
                                where a.tvrtka_id = :tvrtka_id
                                order by a.prezime, a.ime');
        $izraz->execute(['tvrtka_id'=>$_SESSION['operater']->tvrtka_id]);
        return $izraz->fetchAll();
    }

    public static function readForSuperadmin()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select a.operater_id, concat(a.ime, \' \', a.prezime) as osoba, a.email, a.uloga, a.oib, b.naziv from operater a
                                inner join tvrtka b on a.tvrtka_id = b.tvrtka_id
                                order by b.naziv, a.prezime, a.ime');
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function create()
    {
        $veza = DB::getInstanca();
        $izraz=$veza->prepare('insert into operater 
        (lozinka, ime, prezime, email, uloga, tvrtka_id, oib) values 
        (:lozinka, :ime, :prezime, :email, :uloga, :tvrtka_id, :oib)');

        $izraz->bindParam('lozinka', $_SESSION['lozinka']);
        $izraz->bindParam('ime', $_POST['ime']);
        $izraz->bindParam('prezime', $_POST['prezime']);
        $izraz->bindParam('email', $_SESSION['email']);
        $izraz->bindParam('oib', $_POST['oib']);
        $izraz->bindParam('tvrtka_id', $_POST['tvrtka']);
        $izraz->bindValue('uloga', 'oper', PDO::PARAM_STR);


        $izraz->execute();
        /* NAČIN 2
        $izraz->execute([
            'email' => $_POST['email'],
            'lozinka' => $_POST['lozinka'],
            'ime' => $_POST['ime'],
            'prezime' => $_POST['prezime'],
            'uloga' => $_POST['uloga'],
        ]);
                */
    }

    public static function delete()
    {
        try{
            $veza = DB::getInstanca();
            $izraz=$veza->prepare('delete from operater where operater_id = :operater_id');
            $izraz->execute($_GET);
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    public static function registrirajnovi()
    {
        $email = $_SESSION['email'];
        $headers = "From: CRM završni <herkul@polaznik38.edunova.hr>\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        mail($email,'Registracija na CRM završni',
                '<a target="_blank" href="' . App::config('url') . 
                'index/registrirajse?id=' . session_id() .'">Završi registraciju na CRM završni</a>', $headers);   
            
    }

    public static function update()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('update operater set uloga = :uloga, email = :email, oib = :oib where operater_id = :id');
        $izraz->execute(['uloga'=>$_POST['uloga'], 'id'=>$_POST['operater_id'], 'email'=>$_POST['email'], 'oib'=>$_POST['OIB']]);
    }


}