<h2>Sikeres regisztráció</h2>

<p>Szia {{ $user->name }}!</p>

<p>A regisztrációd sikeres volt a Munkaruha Raktár rendszerben.</p>

<p><strong>Belépési adatok:</strong></p>
<ul>
    <li>Felhasználónév: {{ $user->name }}</li>
    <li>Email: {{ $user->email }}</li>
    <li>Jelszó: {{ $plainPassword }}</li>
</ul>

<p>Üdv,<br>Rendszer</p>
