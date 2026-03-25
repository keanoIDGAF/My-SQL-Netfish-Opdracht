<?php
// Start de huidige sessie zodat PHP weet welke gebruiker er momenteel actief is
session_start();

// Verwijderd alle gegevens die in de sessie zijn opgeslagen (zoals 'user' en 'isAdmin')
// Hierdoor wordt de gebruiker effectief uitgelogd
session_destroy();

// Stuurt de gebruiker direct terug naar de inlogpagina
header("Location: login.php");

// Stopt het script onmiddellijk om te voorkomen dat er nog code wordt uitgevoerd
exit;