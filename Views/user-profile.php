<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Cafe Management System</title>
        <!-- Font -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Lao:wght@100..900&display=swap" rel="stylesheet">

    <!-- Favicon -->
    <link rel="shortcut icon" href="../assets/images/favicon.ico" />
    <link rel="stylesheet" href="../assets/css/libs.min.css">
    <link rel="stylesheet" href="../assets/css/tecdig.css?v=1.0.0">
</head>

<body class="  ">
    <!-- loader Start -->
    <div id="loading">
        <div class="loader simple-loader">
            <div class="loader-body"></div>
        </div>
    </div>
    <!-- loader END -->
<?php include './sidebar.php' ?>
    <main class="main-content" style="font-family: Noto Sans Lao;">
        <div class="position-relative">
            <!--Nav Start-->
<?php include './navbar.php'?>
            <!--Nav End-->
        </div>
        <div class="conatiner-fluid content-inner mt-5 py-0">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="iq-header-img">
                            <img src="../assets/images/icons/15.png" alt="header" class="img-fluid w-100 h-100" style="object-fit: contain;">
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-wrap align-items-center justify-content-between">
                                <div class="d-flex flex-wrap align-items-center">
                                    <div class="profile-img position-relative me-3 mb-3 mb-lg-0">
                                        <img src="../assets/images/avatars/01.png" class="img-fluid rounded-pill bg-white avatar-100" alt="profile-image">
                                    </div>
                                    <div class="d-flex flex-wrap align-items-center mb-3 mb-sm-0">
                                        <h4 class="me-2 h4">PX Developer</h4>
                                        <span> - Admin</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <div class="header-title">
                                <h4 class="card-title">ການເຄື່ອນໄຫວມື້ນີ້</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <ul class="list-inline m-0 p-0">
                                <li class="d-flex mb-2">
                                    <div class="news-icon me-3">
                                        <svg width="21" height="22" viewBox="0 0 21 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 2C1 1.44772 1.44772 1 2 1H19C19.5523 1 20 1.44772 20 2V15C20 15.5523 19.5523 16 19 16H12L7 20V16H2C1.44772 16 1 15.5523 1 15V2Z" stroke="#AAA1AA" />
                                        </svg>

                                    </div>
                                    <p class="news-detail mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                </li>
                                <li class="d-flex">
                                    <div class="news-icon me-3">
                                        <svg width="21" height="22" viewBox="0 0 21 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 2C1 1.44772 1.44772 1 2 1H19C19.5523 1 20 1.44772 20 2V15C20 15.5523 19.5523 16 19 16H12L7 20V16H2C1.44772 16 1 15.5523 1 15V2Z" stroke="#AAA1AA" />
                                        </svg>

                                    </div>
                                    <p class="news-detail mb-0">Lorem Ipsum has been the industry's standard dummy text ever since the 1500s when an unknown printer.</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div class="header-title">
                                <h4 class="card-title">Social media</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="twit-feed">
                                <div class="d-flex align-items-center mb-2">
                                    <img class="rounded-pill img-fluid avatar-40 me-2 p-1 bg-soft-success" src="../assets/images/icons/06.png" alt="">
                                    <div class="media-support-info">
                                        <h6 class="mb-0">Whatsapp</h6>
                                        <p class="mb-0">@phonexai
                                            <span class="text-primary">
                                                <svg width="15" viewBox="0 0 24 24">
                                                    <path fill="currentColor" d="M10,17L5,12L6.41,10.58L10,14.17L17.59,6.58L19,8M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z" />
                                                </svg>
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="media-support-body ">
                                    <p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
                                    <div class="twit-date mt-2">07 Jan 2021</div>
                                </div>
                            </div>
                            <hr class="my-4">
                            <div class="twit-feed">
                                <div class="d-flex align-items-center mb-2">
                                    <img class="rounded-pill img-fluid avatar-40 me-3 p-1 bg-soft-info" src="../assets/images/icons/04.png" alt="">
                                    <div class="media-support-info">
                                        <h6 class="mb-0">Linkedin</h6>
                                        <p class="mb-0">@jane59
                                            <span class="text-primary">
                                                <svg width="15" viewBox="0 0 24 24">
                                                    <path fill="currentColor" d="M10,17L5,12L6.41,10.58L10,14.17L17.59,6.58L19,8M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z" />
                                                </svg>
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="media-support-body">
                                    <p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
                                    <div class="twit-date mt-2">18 Feb 2021</div>
                                </div>
                            </div>
                            <hr class="my-4">
                            <div class="twit-feed">
                                <div class="d-flex align-items-center mb-2">
                                    <img class="rounded-pill img-fluid avatar-40 me-3 p-1 bg-soft-primary" src="../assets/images/icons/02.png" alt="">
                                    <div class="mt-2">
                                        <h6 class="mb-0">Facebook</h6>
                                        <p class="mb-0">@facebook59
                                            <span class="text-primary">
                                                <svg width="15" viewBox="0 0 24 24">
                                                    <path fill="currentColor" d="M10,17L5,12L6.41,10.58L10,14.17L17.59,6.58L19,8M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z" />
                                                </svg>
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="media-support-body">
                                    <p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
                                    <div class="twit-date mt-2">15 Mar 2021</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="profile-content tab-content">
                        <div id="profile-feed" class="tab-pane fade active show">
                        </div>
                        <div id="profile-activity" class="tab-pane fade">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <div class="header-title">
                                        <h4 class="card-title">Activity</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="iq-timeline0 m-0 d-flex align-items-center justify-content-between position-relative">
                                        <ul class="list-inline p-0 m-0">
                                            <li>
                                                <div class="timeline-dots timeline-dot1 border-primary text-primary"></div>
                                                <h6 class="float-left mb-1">Client Login</h6>
                                                <small class="float-right mt-1">24 November 2019</small>
                                                <div class="d-inline-block w-100">
                                                    <p>Bonbon macaroon jelly beans gummi bears jelly lollipop apple</p>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="timeline-dots timeline-dot1 border-success text-success"></div>
                                                <h6 class="float-left mb-1">Scheduled Maintenance</h6>
                                                <small class="float-right mt-1">23 November 2019</small>
                                                <div class="d-inline-block w-100">
                                                    <p>Bonbon macaroon jelly beans gummi bears jelly lollipop apple</p>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="timeline-dots timeline-dot1 border-danger text-danger"></div>
                                                <h6 class="float-left mb-1">Dev Meetup</h6>
                                                <small class="float-right mt-1">20 November 2019</small>
                                                <div class="d-inline-block w-100">
                                                    <p>Bonbon macaroon jelly beans <a href="#">gummi bears</a>gummi bears jelly lollipop apple</p>
                                                    <div class="iq-media-group iq-media-group-1">
                                                        <a href="#" class="iq-media-1">
                                                            <div class="icon iq-icon-box-3 rounded-pill">SP</div>
                                                        </a>
                                                        <a href="#" class="iq-media-1">
                                                            <div class="icon iq-icon-box-3 rounded-pill">PP</div>
                                                        </a>
                                                        <a href="#" class="iq-media-1">
                                                            <div class="icon iq-icon-box-3 rounded-pill">MM</div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="timeline-dots timeline-dot1 border-primary text-primary"></div>
                                                <h6 class="float-left mb-1">Client Call</h6>
                                                <small class="float-right mt-1">19 November 2019</small>
                                                <div class="d-inline-block w-100">
                                                    <p>Bonbon macaroon jelly beans gummi bears jelly lollipop apple</p>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="timeline-dots timeline-dot1 border-warning text-warning"></div>
                                                <h6 class="float-left mb-1">Mega event</h6>
                                                <small class="float-right mt-1">15 November 2019</small>
                                                <div class="d-inline-block w-100">
                                                    <p>Bonbon macaroon jelly beans gummi bears jelly lollipop apple</p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="profile-friends" class="tab-pane fade">
                            <div class="card">
                                <div class="card-header">
                                    <div class="header-title">
                                        <h4 class="card-title">Friends</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <ul class="list-inline m-0 p-0">
                                        <li class="d-flex mb-4 align-items-center">
                                            <img src="../assets/images/avatars/01.png" alt="story-img" class="rounded-pill avatar-40">
                                            <div class="ms-3 flex-grow-1">
                                                <h6>Paul Molive</h6>
                                                <p class="mb-0">Web Designer</p>
                                            </div>
                                            <div class="dropdown">
                                                <span class="dropdown-toggle" id="dropdownMenuButton9" data-bs-toggle="dropdown" aria-expanded="false" role="button">
                                                </span>
                                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton9">
                                                    <a class="dropdown-item " href="javascript:void(0);">Unfollow</a>
                                                    <a class="dropdown-item " href="javascript:void(0);">Unfriend</a>
                                                    <a class="dropdown-item " href="javascript:void(0);">block</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="d-flex mb-4 align-items-center">
                                            <img src="../assets/images/avatars/05.png" alt="story-img" class="rounded-pill avatar-40">
                                            <div class="ms-3 flex-grow-1">
                                                <h6>Paul Molive</h6>
                                                <p class="mb-0">trainee</p>
                                            </div>
                                            <div class="dropdown">
                                                <span class="dropdown-toggle" id="dropdownMenuButton10" data-bs-toggle="dropdown" aria-expanded="false" role="button">
                                                </span>
                                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton10">
                                                    <a class="dropdown-item " href="javascript:void(0);">Unfollow</a>
                                                    <a class="dropdown-item " href="javascript:void(0);">Unfriend</a>
                                                    <a class="dropdown-item " href="javascript:void(0);">block</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="d-flex mb-4 align-items-center">
                                            <img src="../assets/images/avatars/02.png" alt="story-img" class="rounded-pill avatar-40">
                                            <div class="ms-3 flex-grow-1">
                                                <h6>Anna Mull</h6>
                                                <p class="mb-0">Web Developer</p>
                                            </div>
                                            <div class="dropdown">
                                                <span class="dropdown-toggle" id="dropdownMenuButton11" data-bs-toggle="dropdown" aria-expanded="false" role="button">
                                                </span>
                                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton11">
                                                    <a class="dropdown-item " href="javascript:void(0);">Unfollow</a>
                                                    <a class="dropdown-item " href="javascript:void(0);">Unfriend</a>
                                                    <a class="dropdown-item " href="javascript:void(0);">block</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="d-flex mb-4 align-items-center">
                                            <img src="../assets/images/avatars/03.png" alt="story-img" class="rounded-pill avatar-40">
                                            <div class="ms-3 flex-grow-1">
                                                <h6>Paige Turner</h6>
                                                <p class="mb-0">trainee</p>
                                            </div>
                                            <div class="dropdown">
                                                <span class="dropdown-toggle" id="dropdownMenuButton12" data-bs-toggle="dropdown" aria-expanded="false" role="button">
                                                </span>
                                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton12">
                                                    <a class="dropdown-item " href="javascript:void(0);">Unfollow</a>
                                                    <a class="dropdown-item " href="javascript:void(0);">Unfriend</a>
                                                    <a class="dropdown-item " href="javascript:void(0);">block</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="d-flex mb-4 align-items-center">
                                            <img src="../assets/images/avatars/04.png" alt="story-img" class="rounded-pill avatar-40">
                                            <div class="ms-3 flex-grow-1">
                                                <h6>Barb Ackue</h6>
                                                <p class="mb-0">Web Designer</p>
                                            </div>
                                            <div class="dropdown">
                                                <span class="dropdown-toggle" id="dropdownMenuButton13" data-bs-toggle="dropdown" aria-expanded="false" role="button">
                                                </span>
                                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton13">
                                                    <a class="dropdown-item " href="javascript:void(0);">Unfollow</a>
                                                    <a class="dropdown-item " href="javascript:void(0);">Unfriend</a>
                                                    <a class="dropdown-item " href="javascript:void(0);">block</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="d-flex mb-4 align-items-center">
                                            <img src="../assets/images/avatars/05.png" alt="story-img" class="rounded-pill avatar-40">
                                            <div class="ms-3 flex-grow-1">
                                                <h6>Greta Life</h6>
                                                <p class="mb-0">Tester</p>
                                            </div>
                                            <div class="dropdown">
                                                <span class="dropdown-toggle" id="dropdownMenuButton14" data-bs-toggle="dropdown" aria-expanded="false" role="button">
                                                </span>
                                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton14">
                                                    <a class="dropdown-item " href="javascript:void(0);">Unfollow</a>
                                                    <a class="dropdown-item " href="javascript:void(0);">Unfriend</a>
                                                    <a class="dropdown-item " href="javascript:void(0);">block</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="d-flex mb-4 align-items-center">
                                            <img src="../assets/images/avatars/03.png" alt="story-img" class="rounded-pill avatar-40">
                                            <div class="ms-3 flex-grow-1">
                                                <h6>Ira Membrit</h6>
                                                <p class="mb-0">Android Developer</p>
                                            </div>
                                            <div class="dropdown">
                                                <span class="dropdown-toggle" id="dropdownMenuButton15" data-bs-toggle="dropdown" aria-expanded="false" role="button">
                                                </span>
                                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton15">
                                                    <a class="dropdown-item " href="javascript:void(0);">Unfollow</a>
                                                    <a class="dropdown-item " href="javascript:void(0);">Unfriend</a>
                                                    <a class="dropdown-item " href="javascript:void(0);">block</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="d-flex mb-4 align-items-center">
                                            <img src="../assets/images/avatars/02.png" alt="story-img" class="rounded-pill avatar-40">
                                            <div class="ms-3 flex-grow-1">
                                                <h6>Pete Sariya</h6>
                                                <p class="mb-0">Web Designer</p>
                                            </div>
                                            <div class="dropdown">
                                                <span class="dropdown-toggle" id="dropdownMenuButton16" data-bs-toggle="dropdown" aria-expanded="false" role="button">
                                                </span>
                                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton16">
                                                    <a class="dropdown-item " href="javascript:void(0);">Unfollow</a>
                                                    <a class="dropdown-item " href="javascript:void(0);">Unfriend</a>
                                                    <a class="dropdown-item " href="javascript:void(0);">block</a>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div id="profile-profile" class="tab-pane fade">
                            <div class="card">
                                <div class="card-header">
                                    <div class="header-title">
                                        <h4 class="card-title">Profile</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="text-center">
                                        <div class="user-profile">
                                            <img src="../assets/images/avatars/01.png" alt="profile-img" class="rounded-pill avatar-130 img-fluid">
                                        </div>
                                        <div class="mt-3">
                                            <h3 class="d-inline-block">Austin Robertson</h3>
                                            <p class="d-inline-block pl-3"> - Web developer</p>
                                            <p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <div class="header-title">
                                        <h4 class="card-title">About User</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="user-bio">
                                        <p>Tart I love sugar plum I love oat cake. Sweet roll caramels I love jujubes. Topping cake wafer.</p>
                                    </div>
                                    <div class="mt-2">
                                        <h6 class="mb-1">Joined:</h6>
                                        <p>Feb 15, 2021</p>
                                    </div>
                                    <div class="mt-2">
                                        <h6 class="mb-1">Lives:</h6>
                                        <p>United States of America</p>
                                    </div>
                                    <div class="mt-2">
                                        <h6 class="mb-1">Email:</h6>
                                        <p><a href="#" class="text-body"> austin@gmail.com</a></p>
                                    </div>
                                    <div class="mt-2">
                                        <h6 class="mb-1">Url:</h6>
                                        <p><a href="#" class="text-body" target="_blank"> www.bootstrap.com </a></p>
                                    </div>
                                    <div class="mt-2">
                                        <h6 class="mb-1">Contact:</h6>
                                        <p><a href="#" class="text-body">(001) 4544 565 456</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <div class="header-title">
                                <h4 class="card-title">About</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <p>Lorem ipsum dolor sit amet, contur adipiscing elit.</p>
                            <div class="mb-1">Email: <a href="#" class="ms-3">nikjone@demoo.com</a></div>
                            <div class="mb-1">Phone: <a href="#" class="ms-3">001 2351 256 12</a></div>
                            <div>Location: <span class="ms-3">USA</span></div>
                        </div>
                    </div>
                </div>
            </div>
            
        <footer class="footer">
            <div class="footer-body">
                <ul class="left-panel list-inline mb-0 p-0">
                    <li class="list-inline-item"><a href="../dashboard/extra/privacy-policy.html">Privacy Policy</a></li>
                    <li class="list-inline-item"><a href="../dashboard/extra/terms-of-service.html">Terms of Use</a></li>
                </ul>
                <div class="right-panel">
                    ©<script>
                        document.write(new Date().getFullYear())
                    </script> TecDig, Made with
                    <span class="text-gray">
                        <svg width="15" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M15.85 2.50065C16.481 2.50065 17.111 2.58965 17.71 2.79065C21.401 3.99065 22.731 8.04065 21.62 11.5806C20.99 13.3896 19.96 15.0406 18.611 16.3896C16.68 18.2596 14.561 19.9196 12.28 21.3496L12.03 21.5006L11.77 21.3396C9.48102 19.9196 7.35002 18.2596 5.40102 16.3796C4.06102 15.0306 3.03002 13.3896 2.39002 11.5806C1.26002 8.04065 2.59002 3.99065 6.32102 2.76965C6.61102 2.66965 6.91002 2.59965 7.21002 2.56065H7.33002C7.61102 2.51965 7.89002 2.50065 8.17002 2.50065H8.28002C8.91002 2.51965 9.52002 2.62965 10.111 2.83065H10.17C10.21 2.84965 10.24 2.87065 10.26 2.88965C10.481 2.96065 10.69 3.04065 10.89 3.15065L11.27 3.32065C11.3618 3.36962 11.4649 3.44445 11.554 3.50912C11.6104 3.55009 11.6612 3.58699 11.7 3.61065C11.7163 3.62028 11.7329 3.62996 11.7496 3.63972C11.8354 3.68977 11.9247 3.74191 12 3.79965C13.111 2.95065 14.46 2.49065 15.85 2.50065ZM18.51 9.70065C18.92 9.68965 19.27 9.36065 19.3 8.93965V8.82065C19.33 7.41965 18.481 6.15065 17.19 5.66065C16.78 5.51965 16.33 5.74065 16.18 6.16065C16.04 6.58065 16.26 7.04065 16.68 7.18965C17.321 7.42965 17.75 8.06065 17.75 8.75965V8.79065C17.731 9.01965 17.8 9.24065 17.94 9.41065C18.08 9.58065 18.29 9.67965 18.51 9.70065Z" fill="currentColor"></path>
                        </svg>
                    </span> by <a href="https://iqonic.design/">IQONIC Design</a>.
                </div>
            </div>
        </footer>
    </main>

    <!-- Wrapper End-->
    <!-- offcanvas start -->

    <!-- Backend Bundle JavaScript -->
    <script src="../assets/js/libs.min.js"></script>
    <!-- widgetchart JavaScript -->
    <script src="../assets/js/charts/widgetcharts.js"></script>
    <!-- mapchart JavaScript -->
    <script src="../assets/js/charts/vectore-chart.js"></script>
    <script src="../assets/js/charts/dashboard.js"></script>
    <!-- fslightbox JavaScript -->
    <script src="../assets/js/fslightbox.js"></script>
    <!-- settings JavaScript -->
    <script src="../assets/js/setting.js"></script>
    <!-- Form Wizard Script -->
    <script src="../assets/js/form-wizard.js"></script>
    <!-- app JavaScript -->
    <script src="../assets/js/app.js"></script>

</body>

</html>