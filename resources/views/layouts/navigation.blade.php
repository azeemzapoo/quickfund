<nav class="border-b border-gray-200 bg-white">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
        <a href="{{ url('/') }}" class="text-2xl font-bold text-emerald-600">
            QuickFund
        </a>

        <div class="flex items-center gap-6 text-sm font-medium text-gray-700">
            <a href="{{ url('/') }}" class="hover:text-emerald-600">Home</a>

            @auth
                <a href="{{ route('dashboard') }}" class="hover:text-emerald-600">Dashboard</a>
                <a href="{{ route('ideas.index') }}" class="hover:text-emerald-600">Ideas</a>
                <a href="{{ route('profile.edit') }}" class="hover:text-emerald-600">Profile</a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="rounded-md bg-emerald-600 px-4 py-2 text-white hover:bg-emerald-700">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="hover:text-emerald-600">Login</a>
                <a href="{{ route('register') }}" class="rounded-md bg-emerald-600 px-4 py-2 text-white hover:bg-emerald-700">
                    Register
                </a>
            @endauth
        </div>
    </div>
</nav>
