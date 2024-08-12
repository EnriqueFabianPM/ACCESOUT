@extends('layouts.app')

@section('title', 'Registros (Logs)')

@section('content')

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encabezado con Secciones</title>
    <link rel="stylesheet" href="Encabezado.css">
</head>
<body>
    <header>
        <div class="logo">
            <a href="#">MiSitio</a>
        </div>
        <nav class="nav-menu">
            <ul>
                <li><a href="#">Inicio</a></li>
                <li><a href="#">Servicios</a></li>
                <li><a href="#">Sobre Nosotros</a></li>
                <li><a href="#">Contacto</a></li>
            </ul>
        </nav>
        <div class="logout-button">
            <button type="button">Salir</button>
        </div>
    </header>
</body>
@endsection