<nav class="navbar navbar-dark bg-dark">

    <div class="container-fluid">

        <span class="navbar-brand mb-0 h1">

            🌶 Masala Store Admin

        </span>

        <form action="{{ route('admin.logout') }}" method="POST">

            @csrf

            <button class="btn btn-danger">

                Logout

            </button>

        </form>

    </div>

</nav>