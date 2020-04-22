<?php 
     
class Napomena
{
    public static function readAll()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select a.napomena_id, LEFT(a.poruka, 30) as porukaskraceno, a.poruka, b.naziv as nazivpartnera, a.sysdatum, concat(c.ime, \' \', c.prezime) as operater, a.kontaktdatum from napomena a
                                inner join partner b on a.partner_id = b.partner_id
                                inner join operater c on a.operater_id = c.operater_id
                                where c.tvrtka_id = :tvrtka_id
                                order by a.sysdatum desc');
        $izraz->execute(['tvrtka_id' => $_SESSION['operater']->tvrtka_id]);
        return $izraz->fetchAll();
    }

    public static function readSA()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select a.napomena_id, LEFT(a.poruka, 30) as porukaskraceno, b.naziv as nazivpartnera, b.telefon, a.sysdatum, concat(c.ime, \' \', c.prezime) as operater, a.kontaktdatum, d.naziv from napomena a
                                inner join partner b on a.partner_id = b.partner_id
                                inner join operater c on a.operater_id = c.operater_id
                                inner join tvrtka d on c.tvrtka_id = d.tvrtka_id
                                order by a.sysdatum desc');
        $izraz->execute();
        return $izraz->fetchAll();
    }

    public static function prikaziporuku($id)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select poruka from napomena where napomena_id = :id');
        $izraz->execute(['id'=>$id]);
        return $izraz->fetchColumn();
    }

    public static function delete($id)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('delete from napomena where napomena_id = :id');
        try{
            $izraz->execute(['id'=>$id]);
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
        $izraz = $veza->prepare('insert into napomena (poruka, partner_id, operater_id, kontaktdatum) values 
                                (:poruka, :partner_id, :operater_id, :kontaktdatum)');
        $izraz->execute(['poruka'=>$_POST['napomena'], 'partner_id'=>$_POST['partner'], 'operater_id'=>$_SESSION['operater']->operater_id, 'kontaktdatum'=>$_POST['date']]);
    }

    public static function update()
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('update napomena set partner_id = :partner_id, poruka = :poruka, kontaktdatum = :kontaktdatum where napomena_id = :napomena_id');
        $izraz->execute(['poruka'=>$_POST['napomena'], 'partner_id'=>$_POST['partner'], 'napomena_id'=>$_POST['napomena_id'], 'kontaktdatum'=>$_POST['date']]);
    }
    
    public static function read($id)
    {
        $veza = DB::getInstanca();
        $izraz = $veza->prepare('select a.napomena_id, LEFT(a.poruka, 30) as porukaskraceno, a.poruka, b.naziv, a.sysdatum, concat(c.ime, \' \', c.prezime) as operater, a.kontaktdatum from napomena a
                                inner join partner b on a.partner_id = b.partner_id
                                inner join operater c on a.operater_id = c.operater_id
                                where a.napomena_id = :id
                                order by a.sysdatum desc');
        $izraz->execute(['id' => $id]);
        return $izraz->fetch();
    }
}