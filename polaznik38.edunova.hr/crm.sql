drop database if exists crm;
create database crm;
use crm;

create table operater
(
    operater_id int not null primary key auto_increment,
    username varchar(50) not null,
    lozinka varchar(100) not null,
    ime varchar(50) not null,
    prezime varchar(50) not null,
    email varchar(50) not null,
	uloga varchar(50) not null,
    oib varchar(50),
	tvrtka_id int
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

create table tvrtka
(
    tvrtka_id int not null primary key auto_increment,
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
    operater_id int not null,
    kontaktdatum datetime
);

alter table partner
add foreign key (mjesto_id) references mjesto(mjesto_id);

alter table mjesto 
add foreign key (drzava_id) references drzava(drzava_id);

alter table napomena
add foreign key (partner_id) references partner(partner_id);

alter table napomena 
add foreign key (operater_id) references operater(operater_id);

alter table operater 
add foreign key (tvrtka_id) references tvrtka(tvrtka_id);

alter table tvrtka 
add foreign key (mjesto_id) references mjesto(mjesto_id);

insert into operater (lozinka, ime, prezime, email, uloga, tvrtka_id, oib) values 
('$2y$10$Cnmx9GphnfYtiUTDg.xbdu.6Ly2HnKmHYjpeRCUhfuOl.wqY1ONV.', 'operime1', 'operprezime1', 'oper1@email.com', 'admin', 2, '12345678910'),
('$2y$10$y0KhoJ7oTXwVs3NBqyajte2ikFn2W8IQfaBpWlSyj.mRIyanR5kc.', 'operime2', 'operprezime2', 'oper2@email.com', 'oper', 3, '12345678910'),
('$2y$10$3mhr9aC6neV4NCQAOEaRO.iqX5N3OcAtxhVaNWZHnYEVObpOyKLWa', 'operime3', 'operprezime3', 'oper3@email.com', 'admin', 4, '12345678910'),
('$2y$10$GtFv4F.qhsKIx0cW9ebGK./PvxcylZ4ygDz8Z4kbeQhvth3P0FUtK', 'operime4', 'operprezime4', 'oper4@email.com', 'oper', 2, '12345678910');

insert into partner (naziv, oib, adresa, telefon, email, mjesto_id) values
('test_partner1', '123123123', 'adresa neka', '031130301', 'partner@email.com', 1),
('test_partner2', '11111111111', 'neka adresa', '123321213', 'nesto@nestoo.hr', 1),
('test_partner3', '222222222222', 'opet neka adresa', '123321321', 'opetnesto@nestoopet.com', 1);

insert into drzava (naziv, oznaka) values 
('Republika Hrvatska', 'HR');

insert into mjesto (postanskibroj , naziv , drzava_id ) values
('31000', 'Osijek', 1);

insert into tvrtka (naziv, oib, adresa, telefon, email, mjesto_id) values
('test_tvrtka1', '123123123', 'adresa neka', '031130301', 'partner@email.com', 1),
('test_tvrtka2', '11111111111', 'neka adresa', '123321213', 'nesto@nestoo.hr', 1),
('test_tvrtka3', '222222222222', 'opet neka adresa', '123321321', 'opetnesto@nestoopet.com', 1);