<?php

class Tvrtka
{

    public static function read($id)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select * from tvrtka where tvrtka_id = :id order by naziv');
        $izraz->execute(['id'=>$id]);
        return $izraz->fetch();
    }

    public static function readAll()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select * from tvrtka order by naziv');
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function readForSuperadmin()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select a.tvrtka_id, a.naziv as nazivtvrtke, a.oib, a.adresa, a.telefon, a.email, b.naziv as imemjesta, b.postanskibroj, c.naziv as imedrzave 
                                from tvrtka a
                                inner join mjesto b on a.mjesto_id = b. mjesto_id 
                                inner join drzava c on b.drzava_id = c.drzava_id 
                                order by a.naziv');
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public function create()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('insert into tvrtka (naziv, oib, adresa, telefon, email, mjesto_id) values
                                (:naziv, :oib, :adresa, :telefon, :email, :mjesto_id)');
        $izraz->execute(['naziv'=>$_POST['nazivtvrtke'], 'oib'=>$_POST['oibtvrtke'], 'adresa'=>$_POST['adresatvrtke'], 'telefon'=>$_POST['telefontvrtke'], 
                        'email'=>$_POST['emailtvrtke'], 'mjesto_id'=>$_POST['mjesto']]);
    }

    public static function update($id)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('update tvrtka set naziv = :naziv, oib = :oib, adresa = :adresa, telefon = :telefon, email = :email,
                                mjesto_id = :mjesto_id where tvrtka_id = :tvrtka_id');
        $izraz->execute(['naziv'=>$_POST['nazivtvrtke'], 'oib'=>$_POST['oibtvrtke'], 'adresa'=>$_POST['adresatvrtke'], 'telefon'=>$_POST['telefontvrtke'], 
                        'email'=>$_POST['emailtvrtke'], 'mjesto_id'=>$_POST['mjesto'], 'tvrtka_id'=>$id]);
    }

    public static function delete()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('delete from tvrtka where tvrtka_id = :tvrtka_id');
        try{
            $izraz->execute($_GET);
        }
        catch(PDOException $e){
            echo $e->getMessage();
            return false;        
        }
        return true;
    }
}