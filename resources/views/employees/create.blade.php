<!DOCTYPE html>
<html>
<head>
    <title>Ajouter un employé</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

@extends('layouts.template')


@section('content')


<div class="container text-center">
    <h2 style="color: #043275ff; text-align: center;align-items:center; ">AJOUTER UN(E) EMPLOYE(E)S</h2>


    <form action="{{ route('employees.store') }}" method="POST">
        @csrf
        
        @include('employees.form')

        <button class="btn btn-success">Enregistrer</button>
        <a href="{{ route('employees.index') }}" class="btn btn-secondary">Retour</a>
    </form>
</div>
@endsection
</body>
</html>
