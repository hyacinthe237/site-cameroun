<div id="sidebar-wrapper">
    <ul class="sidebar-nav">

        <li class="{{ Request::is('admin') ? 'active' : '' }}">
            <a href="{{ route('admin') }}">
                <i class="ion-speedometer"></i>
                Dashboard
            </a>
        </li>

        <li class="{{ Request::is('admin/stagiaires*') ? 'active' : '' }}">
            <a href="/admin/stagiaires">
                <i class="ion-ios-people"></i>
                Etudiants
            </a>
        </li>

        <li class="{{ Request::is('admin/niveaux*') ? 'active' : '' }}">
            <a href="/admin/niveaux">
                <i class="ion-levels"></i>
                Niveaux
            </a>
        </li>

        <li class="{{ Request::is('admin/formations*') ? 'active' : '' }}">
            <a href="/admin/formations">
                <i class="ion-university"></i>
                Formations
            </a>
        </li>

        <li class="{{ Request::is('admin/formateurs*') ? 'active' : '' }}">
            <a href="/admin/formateurs">
                <i class="ion-ios-person"></i>
                Formateurs
            </a>
        </li>

        <li class="{{ Request::is('admin/evaluations*') ? 'active' : '' }}">
            <a href="/admin/evaluations">
                <i class="ion-ios-bookmarks"></i>
                Evaluations
            </a>
        </li>

        @if (Auth::user()->role->name === 'admin')
            <li class="{{ Request::is('admin/users*') ? 'active' : '' }}">
                <a href="/admin/users">
                    <i class="ion-android-people"></i>
                    Utilisateurs
                </a>
            </li>
        @endif

        <li class="{{ Request::is('admin/sessions*') ? 'active' : '' }}">
            <a href="/admin/sessions">
                <i class="ion-ios-person"></i>
                Semestres
            </a>
        </li>

        @if (Auth::user()->role->name === 'editor')
            <li class="{{ Request::is('admin/users*') ? 'active' : '' }}">
              <a href="{{ route('users.show', Auth::user()->number) }}">
                  <i class="ion-android-people"></i>
                  Mon Profil
              </a>
            </li>
        @endif

        <li class="separer"></li>

        <li>
            <a href="/" target="_blank">
                <i class="ion-ios-world-outline"></i>
                Aller sur le site
            </a>
        </li>

        <li>
            <a href="{{ route('admin.logout') }}">
                <i class="ion-power"></i>
                Déconnexion
            </a>
        </li>
    </ul>
</div>
