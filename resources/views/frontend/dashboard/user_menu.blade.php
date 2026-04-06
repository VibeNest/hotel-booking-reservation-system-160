@php
    // Lấy id người đang đăng nhập (User)
    $id = Auth::user()->id;
    // Lấy thông tin của người đăng nhập (User) thông qua id
    $profileData = App\Models\User::find($id);
@endphp

<div class="service-side-bar">
    <div class="services-bar-widget">
        <div class="side-bar-categories">
            <img src="{{ (!empty($profileData->photo)) ? url("upload/user_images/{$profileData->photo}") : url("upload/no_image.jpeg")}}"
                class="mx-auto d-block rounded-circle p-1 bg-primary" alt="Image" style="width:110px; height:110px;">
            <center>
                <h5>{{ $profileData->name }}</h5>
                <h5>{{ $profileData->email }}</h5>
            </center>
            <br>
            <ul>

                <li>
                    <a href="{{ route('dashboard') }}">User Dashboard</a>
                </li>
                <li>
                    <a href="{{ route('user.profile') }}">User Profile </a>
                </li>
                <li>
                    <a href="#">Change Password</a>
                </li>
                <li>
                    <a href="#">Booking Details </a>
                </li>
                <li>
                    <a href="#">Logout </a>
                </li>
            </ul>
        </div>
    </div>
</div>