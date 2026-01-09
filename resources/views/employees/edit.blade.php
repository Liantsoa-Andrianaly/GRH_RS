<!DOCTYPE html>
<html>
<head>
    <title>Modifier un employé</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>


@extends('layouts.template')


@section('content')


<div class="container text-center">    <h2 style="color: #043275ff; text-align: center;align-items:center; ">MODIFIER UN(E) EMPLOYE(E)S</h2>

    <form action="{{ route('employees.update', $employee->id) }}" method="POST">
        @csrf
        @method('PUT')

        @include('employees.form')

        <button class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('employees.index') }}" class="btn btn-secondary">Retour</a>
    </form>
</div>
@endsection
</body>
</html>
