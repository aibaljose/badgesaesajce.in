<?php
require_once 'api_services/index.php';

$main_user = [];

function getLoginPost()
{
    if (mCall("isAuthUser", $_POST)) {
        if (isset($_POST['checksum'])) {
            $_encKey = substr($_POST['checksum'], -40);
            $_encData = substr($_POST['checksum'], 0, -40);
            $_encIV = substr(SHA1($_encKey), -16);
            $main_user = json_decode(openssl_decrypt(base64_decode($_encData), "AES-256-CBC", $_encKey, 0, ($_encIV)), true);
            return json_decode(openssl_decrypt(base64_decode($_encData), "AES-256-CBC", $_encKey, 0, ($_encIV)), true);
        } else {
            return [];
        }
    }
}


function getLoginSession()
{
    if (__authUser) {
        if (isset($_SESSION['auth_user']['checksum'])) {
            $_encKey = substr($_SESSION['auth_user']['checksum'], -40);
            $_encData = substr($_SESSION['auth_user']['checksum'], 0, -40);
            $_encIV = substr(SHA1($_encKey), -16);
            $main_user = json_decode(openssl_decrypt(base64_decode($_encData), "AES-256-CBC", $_encKey, 0, ($_encIV)), true);
            return json_decode(openssl_decrypt(base64_decode($_encData), "AES-256-CBC", $_encKey, 0, ($_encIV)), true);
        } else {
            return [];
        }
    }
}



route('/', function () {
    if (__authUser) {
        $main_user = getLoginSession();
        // return json_encode(['role' => $main_user['role']]);
        if ($main_user['role'] == "student") {
            require_once __DIR__ . '/public/views/student/layout/header.php';
            require_once __DIR__ . '/public/views/student/layout/sidebar.php';
            require_once __DIR__.'/public/views/student/home.php';
            // require_once __DIR__ . '/public/views/student/test_home.php';

            require_once __DIR__ . '/public/views/student/layout/footer.php';
        } else {
?> <script>
                window.location.href = "http://login.aesajce.in/?key=62cf2ab552f339d1929f98e9429314592f038bad";
            </script> <?php
                    }
                } else {
                        ?> <script>
            window.location.href = "http://login.aesajce.in/?key=62cf2ab552f339d1929f98e9429314592f038bad";
        </script> <?php
                }
            });
            route('/api/?', function () {
                if (isset($_POST['method'])) {
                    global $methods;
                    $fn = $_POST['method'];
                    if (method_exists($methods, $fn)) {
                        echo json_encode($methods->$fn($_POST));
                    } else {
                        echo json_encode(array("status" => false, "message" => "Method $fn does not exists"));
                    }
                }
            });








            route('/dologin/?', function () {

                // return [$_SESSION['auth_user']];
                if (mCall("isAuthUser", $_POST)) {
                    $main_user = getLoginPost();
                    // return json_encode(['role' => $main_user['role']]);
                    if ($main_user['role'] == "student") {
                    ?> <script>
                window.location.href = "/";
            </script> <?php
                    } else { ?>
            <script>
                window.location.href = "/teacher/";
            </script><?php
                    }
                } else {
                        ?> <script>
            window.location.href = "https://www.aesajce.in/";
        </script> <?php
                }
            });




            route('/student/?', function () {
                if (__isAuth) {
                    require_once __DIR__ . '/public/views/student/layout/header.php';
                    require_once __DIR__ . '/public/views/student/layout/sidebar.php';
                    require_once __DIR__ . '/public/views/student/home.php';
                    require_once __DIR__ . '/public/views/student/layout/footer.php';
                } else {
                    ?> <script>
            window.location.href = "http://login.aesajce.in/?key=62cf2ab552f339d1929f98e9429314592f038bad";
        </script> <?php
                }
            });

            route('/upload_certificate/?', function () {
                if (__isAuth) {
                    require_once __DIR__ . '/public/views/student/layout/header.php';
                    require_once __DIR__ . '/public/views/student/layout/sidebar.php';
                    require_once __DIR__ . '/public/views/student/certificate-upload.php';
                    require_once __DIR__ . '/public/views/student/layout/footer.php';
                } else {
                    ?> <script>
            window.location.href = "http://login.aesajce.in/?key=62cf2ab552f339d1929f98e9429314592f038bad";
        </script> <?php
                }
            });


            route('/badges/?', function () {
                if (__isAuth) {
                    require_once __DIR__ . '/public/views/student/layout/header.php';
                    require_once __DIR__ . '/public/views/student/layout/sidebar.php';
                    require_once __DIR__ . '/public/views/student/badges.php';
                    require_once __DIR__ . '/public/views/student/layout/footer.php';
                } else {
                    ?> <script>
            window.location.href = "http://login.aesajce.in/?key=62cf2ab552f339d1929f98e9429314592f038bad";
        </script> <?php
                }
            });

            route('/view_certificates', function () {
                if (__isAuth) {
                    require_once __DIR__ . '/public/views/student/layout/header.php';
                    require_once __DIR__ . '/public/views/student/layout/sidebar.php';
                    require_once __DIR__ . '/public/views/student/certificate-list.php';
                    require_once __DIR__ . '/public/views/student/layout/footer.php';
                } else {
                    ?>
        <script>
            window.location.href = "http://login.aesajce.in/?key=62cf2ab552f339d1929f98e9429314592f038bad";
        </script>
    <?php
                }
            });



            route('/teacher/?', function () {
                //   if(__isAuth){

                // if ($_SESSION['auth_user']['role'] == "staff") {
                //     echo "<script>console.log(" . json_encode($_SESSION['auth_user']['role']) . ");</script>";
                // }
                $main_user1 = getLoginSession();
                if (__isAuth && $main_user1['role'] == "staff") {
                    $studentData = mCall('getCTCoCTInfo', ['scode' => $main_user1['staff_code']]);
                    $type = json_decode($studentData[0], true)[0]['type'];
                    // echo '<pre>';
                    // print_r($type);
                    // echo '</pre>';
                    // return [$studentData['username']];




                    if ($type=="ct" || $type=="co") {
                        require_once __DIR__ . '/public/views/teacher/layout/header.php';
                        require_once __DIR__ . '/public/views/student/layout/sidebar.php';
                        require_once __DIR__ . '/public/views/teacher/home.php';
                        require_once __DIR__ . '/public/views/teacher/layout/footer.php';
                    }else{
                        echo "<script>alert('Login is only for CT, Co')</script>";
                        ?>
        <script>
            window.location.href = "http://login.aesajce.in/?key=62cf2ab552f339d1929f98e9429314592f038bad";
        </script>
    <?php
                    }
                    
                    
                    
                } else {
    ?>
        <script>
            window.location.href = "http://login.aesajce.in/?key=62cf2ab552f339d1929f98e9429314592f038bad";
        </script>
    <?php
                }
            });


            route('/certificate-view/?', function () {
                 $main_user1 = getLoginSession();
                if (__isAuth && $main_user1['role'] == "staff") {
                        require_once __DIR__ . '/public/views/teacher/layout/header.php';
                        require_once __DIR__ . '/public/views/teacher/view-certificate.php';
                        require_once __DIR__ . '/public/views/teacher/layout/footer.php';
                } else {
    ?>
        <script>
            window.location.href = "http://login.aesajce.in/?key=62cf2ab552f339d1929f98e9429314592f038bad";
        </script>-->
    <?php
                }
            });




            // route('/certificate-view/?', function(){
            //     if (__isAuth() && isset($_SESSION['auth_user']) && $_SESSION['auth_user']['role'] === 'staff') {
            //         require_once __DIR__.'/public/views/teacher/layout/header.php';
            //         require_once __DIR__.'/public/views/teacher/view-certificate.php';
            //         require_once __DIR__.'/public/views/teacher/layout/footer.php';
            //     } else {
            //         echo '<script>window.location.href = "http://login.aesajce.in/?key=62cf2ab552f339d1929f98e9429314592f038bad";</script>';
            //     }
            // });






            route('/admin/?', function () {
                if (__isAuth) {

                    require_once __DIR__ . '/public/views/admin/layout/headeradmin.php';
                    require_once __DIR__ . '/public/views/admin/adminlanding.php';
                } else {
    ?>
        <script>
            window.location.href = "http://login.aesajce.in/?key=62cf2ab552f339d1929f98e9429314592f038bad";
        </script>
    <?php
                }
            });
            route('/admin/dashboard', function () {
                if (__isAuth) {
                    if (mCall("isAuthUser", $_POST)) {
                        require_once __DIR__ . '/public/views/admin/layout/headeradmin.php';
                        require_once __DIR__ . '/public/views/admin/adminlanding.php';
                    }
                } else {
    ?>
        <script>
            window.location.href = "http://login.aesajce.in/?key=62cf2ab552f339d1929f98e9429314592f038bad";
        </script>
    <?php
                }
            });
            route('/admin/badges', function () {
                if (__isAuth) {

                    require_once __DIR__ . '/public/views/admin/layout/headeradmin.php';
                    require_once __DIR__ . '/public/views/admin/badges.php';
                } else {
    ?>
        <script>
            window.location.href = "http://login.aesajce.in/?key=62cf2ab552f339d1929f98e9429314592f038bad";
        </script>
    <?php
                }
            });
            route('/admin/students', function () {
                if (mCall("isAuthUser", $_POST)) {
                    require_once __DIR__ . '/public/views/admin/layout/headeradmin.php';
                    require_once __DIR__ . '/public/views/admin/studentprofile.php';
                }
            });
            route('/admin/departments', function () {
                if (mCall("isAuthUser", $_POST)) {
                    require_once __DIR__ . '/public/views/admin/layout/headeradmin.php';
                    require_once __DIR__ . '/public/views/admin/departmentstudent.php';
                }
            });
            route('/logout/?', function () {
                mCall("logUserActivityLogout");
                session_destroy();
    ?> <script>
        sessionStorage.clear();
        localStorage.clear();
        window.location.href = "https://www.aesajce.in/";
    </script> <?php
            });
                ?>