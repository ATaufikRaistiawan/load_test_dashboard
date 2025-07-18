<footer style="margin-top: 40px; padding: 20px; background-color: #f1f1f1; text-align: center;">
    <nav>
        <a href="{{ route('dashboard') }}" 
           style="margin-right: 20px; text-decoration: none; color: {{ request()->is('dashboard') ? 'blue' : 'black' }};">
            🖥 Dashboard
        </a>

        <a href="{{ route('history') }}" 
           style="text-decoration: none; color: {{ request()->is('history') ? 'blue' : 'black' }};">
            📜 History
        </a>
    </nav>
</footer>
