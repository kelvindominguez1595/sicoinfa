<?php

use App\Models\Notificaciones;

function verifiedCountState(){
    return Notificaciones::where('estado', 'activo')->count();
}

function listNotification(){
    return Notificaciones::all();
}

