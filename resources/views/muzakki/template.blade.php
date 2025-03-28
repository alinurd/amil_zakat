<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle }}</title>
    <!-- Tambahkan link ke file CSS atau asset lain -->
</head>
<body>
    <div class="container">
        <h1>{{ $pageTitle }}</h1>
        {!! $filter !!}
        {!! $hideFilter !!}
        {!! $dataTable->table(['class' => 'table table-striped table-bordered'], true) !!}
    </div>
</body>
</html>
