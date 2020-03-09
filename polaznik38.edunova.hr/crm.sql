drop database if exists crm;
create database crm;
use crm;

create table operater
(
    operater_id int not null primary key auto_increment,
    username varchar(50) not null,
    pass varchar(50) not null,
    ime varchar(50) not null,
    prezime varchar(50) not null,
    email varchar(50) not null 
);

create table partner 
(
    partner_id int not null primary key auto_increment,
    naziv varchar(100) not null,
    oib varchar(15),
    adresa varchar(50),
    telefon varchar(25),
    email varchar(100),
    mjesto_id int not null 
);

create table mjesto 
(
    mjesto_id int not null primary key auto_increment,
    postanskibroj varchar(10) not null,
    naziv varchar(100) not null,
    drzava_id int not null
);

create table drzava
(
    drzava_id int not null primary key auto_increment,
    naziv varchar(100) not null,
    oznaka varchar(5) not null
);

create table napomena
(
    napomena_id int not null primary key auto_increment,
    poruka text not null,
    partner_id int not null,
    sysdatum datetime default now(),
    operater_id int not null
);

alter table partner
add foreign key (mjesto_id) references mjesto(mjesto_id);

alter table mjesto 
add foreign key (drzava_id) references drzava(drzava_id);

alter table napomena
add foreign key (partner_id) references partner(partner_id);

alter table napomena 
add foreign key (operater_id) references operater(operater_id);