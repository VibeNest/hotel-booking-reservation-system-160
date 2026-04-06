<header class="top-header top-header-bg">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-2 pr-0">
                <div class="language-list">
                    <select class="language-list-item">
                        <option>English</option>
                        <option>Tiếng Việt</option>
                    </select>
                </div>
            </div>

            <div class="col-lg-9 col-md-10">
                <div class="header-right">
                    <ul>
                        <li>
                            <i class='bx bx-home-alt'></i>
                            <a href="#">123 số 2 B1, Phù Cừ, Hưng Yên</a>
                        </li>
                        <li>
                            <i class='bx bx-phone-call'></i>
                            <a href="tel:+1-(123)-456-7890">0376734165</a>
                        </li>
                        <li>
                            <i class='bx bx-envelope'></i>
                            <a href="mailto:hello@atoli.com">tungvuvanthanh@gmail.com</a>
                        </li>

                        @auth
                            <li>
                                <i class='bx bx-home-alt'></i>
                                <a href="{{ route('dashboard') }}">Dashboard</a>
                            </li>
                            <li>
                                <i class='bx bx-log-out'></i>
                                <a href="{{ route('user.logout') }}">Logout</a>
                            </li>
                        @else
                            <li>
                                <i class='bx bx-log-in'></i>
                                <a href="{{ route('login') }}">Login</a>
                            </li>
                            <li>
                                <i class='bx bx-user-plus'></i>
                                <a href="{{ route('register') }}">Register</a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>