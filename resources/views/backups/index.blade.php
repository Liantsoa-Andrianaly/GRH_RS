<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Liste des employés</title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/bootstrap.min.css') }}">
    <!--script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script-->
    <script src="{{ asset('assets/sweetalert2/sweetalert2.min.js') }}"></script>

    <!--script src="https://code.jquery.com/jquery-3.6.0.min.js"></script-->
    <script src="{{ asset('assets/jquery/jquery.min.js') }}"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap');
*{
    font-family: 'poppins', 'sans-serif';
    margin:0;
    padding:0;
    box-sizing:border-box;
}
    </style>
</head>
<body>
    @extends('layouts.template')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-center text-primary" style="font-family:poppins">LISTES DES EMPLOYEES SUPPRIMES</h2><br>
        <div class="col">
            <a href="{{route('employees.index')}}" class="btn btn-danger">Revenir à la liste des employés</a>

        </div><br>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Matricule</th>
                <th>Nom</th>
                <th>Prénom</th>
                <!--th>Date de naissance</th-->
                <th>Poste</th>
                <th>Téléphone</th>
                <th>Adresse</th>
                <th>Date de suppression</th>
            </tr>
        </thead>
        <tbody>
            @foreach($backups as $backup)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $backup->matricule ?? 'Non défini' }}</td>
                    <td>{{ $backup->nom }}</td>
                    <td>{{ $backup->prenom }}</td>
                    <!--td>{{ $backup->date_naissance }}</td-->
                    <td>{{ $backup->poste?->nom ?? 'Non défini' }}</td>

                    <td>{{ $backup->telephone }}</td>
                    <td>{{ $backup->adresse }}</td>
                    <td>
                        {{ \Carbon\Carbon::parse($backup->deleted_at)
                            ->timezone(config('app.timezone'))
                            ->format('d/m/Y') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $backups->links() }}
</div>
@endsection
</body>