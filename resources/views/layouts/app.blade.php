<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <title>Job Portal</title>
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <nav class="navbar bg-dark border-bottom navbar-expand-lg border-body" data-bs-theme="dark">
        <div class="container">
          <a class="navbar-brand" href="#">Navbar</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 ms-auto mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/user">Home</a>
              </li>
               @if(!Auth::check())
                <li class="nav-item">
                  <a class="nav-link" href="{{route('login')}}">Login</a>
                </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{route('create.seeker')}}">Job Seeker</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{route('create.employer')}}">Employer</a>
                  </li>
              @endif
              @if (Auth::check())
              <li class="nav-item">
                <a class="nav-link"  id="logout"  href="{{route('logout')}}">Logout</a>
              </li>
              <form action="{{route('logout')}}" id="logout-form">@csrf</form>
              @endif
            </ul>
          </div>
        </div>
      </nav>
      <script>
        let logout = document.getElementById('logout')
        let form = document.getElementById('logout-form')
          logout.addEventListener('click',function(){
            form.submit()
          })
      </script>
      @yield('content')
</body>
</html>