<div id="sidebar-wrapper">
    <ul class="sidebar-nav">

        <li class="{{ Request::is('admin') ? 'active' : '' }}">
            <a href="{{ route('admin') }}">
                <i class="ion-speedometer"></i>
                Tableau de bord
            </a>
        </li>

        <li class="{{ Request::is('admin/tables*') ? 'active' : '' }}">
            <a href="/admin/tables">
                <i class="ion-ios-people"></i>
                Tables
            </a>
        </li>

        <li class="{{ Request::is('admin/billets*') ? 'active' : '' }}">
            <a href="/admin/billets">
                <i class="ion-levels"></i>
                Billets
            </a>
        </li>

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
