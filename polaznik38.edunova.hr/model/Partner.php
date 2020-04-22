<?php

class Partner
{
    public static function readAll()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select a.partner_id, a.naziv as nazivtvrtke, a.oib, a.adresa, a.telefon, a.email, b.naziv as imemjesta, b.postanskibroj, c.naziv as imedrzave 
                                from partner a
                                inner join mjesto b on a.mjesto_id = b. mjesto_id 
                                inner join drzava c on b.drzava_id = c.drzava_id 
                                order by a.naziv');
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function read($id)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select a.partner_id, a.naziv as nazivtvrtke, a.oib, a.adresa, a.telefon, a.email, b.naziv as imemjesta, b.postanskibroj, c.naziv as imedrzave 
                                from partner a
                                inner join mjesto b on a.mjesto_id = b. mjesto_id 
                                inner join drzava c on b.drzava_id = c.drzava_id 
                                where a.partner_id = :id
                                order by a.naziv');
        $izraz->execute(['id'=>$id]);
        return $izraz->fetch();
    }

    public static function readSTvrtka($id)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select a.partner_id, a.naziv as nazivtvrtke, a.oib, a.adresa, a.telefon, a.email, b.naziv as imemjesta, b.postanskibroj, c.naziv as imedrzave 
                                from partner a
                                inner join mjesto b on a.mjesto_id = b. mjesto_id 
                                inner join drzava c on b.drzava_id = c.drzava_id 
                                where a.tvrtka_id = :id
                                order by a.naziv');
        $izraz->execute(['id'=>$id]);
        return $izraz->fetchAll();
    }

    public static function update($id)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('update partner set naziv = :naziv, oib = :oib, adresa = :adresa, telefon = :telefon, email = :email,
                                mjesto_id = :mjesto_id, tvrtka_id = :tvrtka_id where partner_id = :partner_id');
        $izraz->execute(['naziv'=>$_POST['nazivpartnera'], 'oib'=>$_POST['oibpartnera'], 'adresa'=>$_POST['adresapartnera'], 'telefon'=>$_POST['telefonpartnera'], 
                        'email'=>$_POST['emailpartnera'], 'mjesto_id'=>$_POST['mjesto'], 'tvrtka_id'=>$_POST['tvrtka_id'], 'partner_id'=>$id]);
    }

    public static function delete()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('delete from partner where partner_id = :partner_id and partner_id not in (select partner_id from napomena where partner_id = :partner_id)');
        try{
            $izraz->execute($_GET);
        }
        catch(PDOException $e){
            echo $e->getMessage();
            return false;        
        }
        return true;
    }

    public static function create()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('insert into partner (naziv, oib, adresa, telefon, email, mjesto_id, tvrtka_id) values
                                (:naziv, :oib, :adresa, :telefon, :email, :mjesto_id, :tvrtka_id)');
        $izraz->execute(['naziv'=>$_POST['nazivpartnera'], 'oib'=>$_POST['oibpartnera'], 'adresa'=>$_POST['adresapartnera'], 'telefon'=>$_POST['telefonpartnera'], 
                        'email'=>$_POST['emailpartnera'], 'mjesto_id'=>$_POST['mjesto'], 'tvrtka_id'=>$_SESSION['operater']->tvrtka_id]);
    }
}