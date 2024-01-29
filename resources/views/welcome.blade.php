<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Lista psów</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <a href="{{ url('/create-pet') }}" class="btn btn-primary mr-2">Dodaj psa</a>
    <a href="{{ url('/pets/5/edit') }}" class="btn btn-warning mr-2">Edytuj psa</a>
    <a href="{{ url('/pets/search') }}" class="btn btn-info mr-2">Wyszukaj peta po statusie</a>
    <a href="{{ url('/pets/5/show') }}" class="btn btn-success mr-2">Wyszukaj peta po id</a>
    <a href="{{ url('/pets/5/delete') }}" class="btn btn-danger mr-2">Usuń psa</a>
    <a href="{{ url('/pets/upload-foto') }}" class="btn btn-secondary">Dodaj zdjęcie</a>
</div>
</body>
</html>
