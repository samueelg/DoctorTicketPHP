<!DOCTYPE html>
<html lang="ptbr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DoctorTicket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
      <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
      <span class="fs-4">DoctorTicket</span>
    </a>

    <ul class="nav nav-pills">
        <li class="nav-item"><a href="{{ route('home') }}" class="nav-link active" aria-current="page">Inicio</a></li>
        <li class="nav-item"><a href="{{ route('usersList') }}" class="nav-link">Lista de Usuários</a></li>
    </ul>
</header>

<body>
    @yield('content')
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
<footer>
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show text-center mx-auto mt-3"
         style="max-width: 400px;" role="alert" id="alert-success">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show text-center mx-auto mt-3"
         style="max-width: 400px;" role="alert" id="alert-error">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
     <div class="col-md-4 d-flex align-items-center"> 
        <a href="/" class="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1" aria-label="Bootstrap">
             <svg class="bi" width="30" height="24" aria-hidden="true"><use xlink:href="#bootstrap"></use></svg> 
        </a> 
        <span class="mb-3 mb-md-0 text-body-secondary">© 2025 Oral Sin Franchising</span> 
    </div> 
    <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
         <li class="ms-3">
            <a class="text-body-secondary" href="#" aria-label="Instagram">
                <svg class="bi" width="24" height="24" aria-hidden="true"><use xlink:href="#instagram"></use></svg>
            </a>
        </li>
        <li class="ms-3"><a class="text-body-secondary" href="#" aria-label="Facebook">
            <svg class="bi" width="24" height="24"><use xlink:href="#facebook"></use></svg>
        </a></li>
    </ul> 
</footer>
</html>