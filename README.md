# FIELDLABS

maandag - 16/6/2024 15:00

## REQUIREMENTS
-> Xampp [XAMPP](https://www.apachefriends.org/download.html).</br>

## SETUP DATABASE 

Voor het opzetten van fieldlabs app moet je een database opzetten. Hieronder vind je hoe dat moet.</br></br>

-> Open Xampp</br>
-> In de rij van apache en MySQL klik allebei op starten</br>
-> Navigeer dan naar deze link: http://localhost/phpmyadmin/index.php?route=/server/sql</br>
-> Kopieer en plak daarna de import.sql (te vinden in appeltaart-recensie-app/database/import.sql) in het vak</br>
-> Als dat gedaan is klik dan op Starten</br>

## RUNNEN OP LOCALHOST
-> Als Apache open staat (te herkennen als bij apache "stop" staat) navigeer dan in de browser naar http://localhost/ of klik [HIER](http://localhost/)</br>
-> Zoek in het scherm dat je ziet fieldlabs/fieldlabs/</br></br>

De website zou nu volledig bruikbaar zijn.

## INLOGGEN OP HET ADMIN ACCOUNT
-> Open de applicatie op localhost
-> Open daarna de phpmyadmin pagina door naar http://localhost/phpmyadmin/index.php of klik [HIER] (http://localhost/phpmyadmin/index.php)</br>
-> Maak op de applicatie / website een nieuw account aan</br>
-> Navigeer naar fieldlabs -> users</br>
-> Refresh de phpmyadmin pagina</br>
-> Verander dan de role in de rij van het net aangemaakte account naar 'admin'</br>
-> Log daarna in op het net aangemaakte account</br></br>

# COMMIT TEMPLATE

- wat (waar) uitleg
- (eventuele extra details)
<br>

- Update = Iets ge-update of veranderd
- Create = folder / file aangemaakt
- Add = Iets toegevoegd aan een folder of file
- Feature = een feature aangemaakt
- Style = styling aangemaakt of verbeterd
- Delete = iets verwijderd / weggehaald
- Fix = Iets verbeterd of gerepareerd