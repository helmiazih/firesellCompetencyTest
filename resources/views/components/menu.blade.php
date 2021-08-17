<nav class="navbar navbar-expand-md navbar-light bg-light shadow-sm">
    <div class="container">
        <div class="navbar-brand d-block d-sm-none">
            <span class="">Menu</span>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent2" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent2">
            <ul class="navbar-nav">
                @if(Auth::user()->isAdmin())
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">Dashboard</a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('todoList') }}">Todo List</a>
                </li>
            </ul>
        </div>
    </div>
</nav>