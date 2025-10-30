<?php
class APIMethods
{
    private $pdo;
    private $_key, $_iv;
    private $_skey, $_siv;
    public function __construct()
    {
        try {
            $host = "localhost";
            $uname = "badgesaesajce_root";
            $pword = "}E+3_N=CdvnE";
            $db = "badgesaesajce_db";
            $this->pdo = new PDO("mysql:host=$host;dbname=$db", $uname, $pword);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if (session_status() == PHP_SESSION_NONE && !isset($_SESSION)) {
                session_start();
            }
            if (!$this->_key || !$this->_iv) {
                $this->_key = $_SESSION['ENC_KEY'] ?? $_SESSION['ENC_KEY'] = SHA1(time());
                $this->_iv = substr(SHA1($this->_key), -16);
                $this->_skey = SHA1("pay.aesajce.in");
                $this->_siv = substr(SHA1($this->_skey), -16);
            }
        } catch (PDOException $e) {
            echo 'connection failed: ' . $e->getMessage();
        }
    }
    function enc($_value, $_static = false)
    {
        return base64_encode(openssl_encrypt($_value, "AES-256-CBC", ($_static ? $this->_skey : $this->_key), 0, ($_static ? $this->_siv : $this->_iv)));
    }
    function dec($_value, $_static = false)
    {
        return openssl_decrypt(base64_decode($_value), "AES-256-CBC", ($_static ? $this->_skey : $this->_key), 0, ($_static ? $this->_siv : $this->_iv));
    }




    //login desc session data

    function getLoginPost()
    {
        if (isset($_POST['checksum'])) {
            $_encKey = substr($_POST['checksum'], -40);
            $_encData = substr($_POST['checksum'], 0, -40);
            $_encIV = substr(SHA1($_encKey), -16);
            return json_decode(openssl_decrypt(base64_decode($_encData), "AES-256-CBC", $_encKey, 0, ($_encIV)), true);
        } else {
            return [];
        }
    }
    
    
    
function getLoginSession()
{

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


    function authUser()
    {
        return isset($_SESSION['auth_user']) ? getLoginSession() : array("status" => false);
    }
    function setAuthUser($_params)
    {
        
      $_SESSION['auth_user'] = $_params;
      
        // if ($_params[role] == "staff") {

        //     $_SESSION['auth_user'] = $_params;
            
        // }

        // if (_params[role] == "student") {


        //     function getLoginPost()
        //     {
        //         if (isset($_params['checksum'])) {
        //             $_encKey = substr($_params['checksum'], -40);
        //             $_encData = substr($_params['checksum'], 0, -40);
        //             $_encIV = substr(SHA1($_encKey), -16);
        //             return json_decode(openssl_decrypt(base64_decode($_encData), "AES-256-CBC", $_encKey, 0, ($_encIV)), true);
        //         } else {
        //             return [];
        //         }
        //     }
        //     $_SESSION['auth_user']=getLoginPost();
            
        // }
    }
    function isAuthUser($_params)
    {
        if (isset($_params['aeslink'])) {
            $__vals = explode("#", $_params['aeslink']);
            $_params['staff_code'] = openssl_decrypt(base64_decode($__vals[1]), "AES-256-CBC", $__vals[0], 0, substr(SHA1($__vals[0]), -16));
        }
        $this->setAuthUser($_POST);
        return true;
    }









    function getStudInfo($params)
    {

        $url = "https://api.aesajce.in";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "Origin: https://badges.aesajce.in",
            "Content-Type: application/x-www-form-urlencoded",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $data = "method=getStudentInfo&admno={$params['scode']}";

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);
        // var_dump($resp);


        return [
            'status' => true,
            'data' => $resp
        ];
    }
    
    
        function badgeClassStudentsInfo1($params)
    {
        
        $mainuser =getLoginSession();

       $url = "https://api.aesajce.in";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "Origin: https://badges.aesajce.in",
   "Content-Type: application/x-www-form-urlencoded",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

$data = "method=badgeClassStudentsInfo&scode={$mainuser['staff_code']}";

curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);

//   echo '<pre>';
//                      print_r($resp);
//                     echo '</pre>';


        return [
            'status' => true,
            'data' => $resp
        ];
    }


    function getCTCoCTInfo($params)
    {

        $url = "https://api.aesajce.in";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "Origin: https://badges.aesajce.in",
            "Content-Type: application/x-www-form-urlencoded",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $data = "method=getCTCoCTInfo&scode={$params['scode']}";

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);
        // var_dump($resp);


        return [
          $resp
        ];
    }


























    //student Functions

    public function storeStudentDetails($data)
    {
        try {
            // Debug logging
            error_log("Starting storeStudentDetails with data: " . print_r($data, true));
            error_log("Files received: " . print_r($_FILES, true));

            // Get authenticated user
            $authUser = $this->authUser();
            error_log("Auth user data: " . print_r($authUser, true));

            if (!$authUser || !$authUser['status']) {
                throw new Exception("User not authenticated");
            }

            // Ensure we have a student_id
            $student_id = $data['student_id'] ?? $authUser['admission_no'];
            if (empty($student_id)) {
                throw new Exception("Student ID is required");
            }

            // Validate required fields
            $required_fields = ['certification_title', 'certification_desc', 'start_date', 'end_date', 'certification_mode'];
            foreach ($required_fields as $field) {
                if (empty($data[$field])) {
                    throw new Exception("$field is required");
                }
            }

            // Validate file upload
            if (!isset($_FILES["certification_file"]) || $_FILES["certification_file"]["error"] !== UPLOAD_ERR_OK) {
                throw new Exception("Certificate file upload failed with error code: " . ($_FILES["certification_file"]["error"] ?? 'No file uploaded'));
            }

            // Create uploads directory if it doesn't exist
            $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/public/uploads/";
            if (!file_exists($targetDir)) {
                if (!mkdir($targetDir, 0777, true)) {
                    throw new Exception("Failed to create upload directory");
                }
            }

            // Generate unique filename to prevent overwrites
            $fileExtension = strtolower(pathinfo($_FILES["certification_file"]["name"], PATHINFO_EXTENSION));
            $uniqueFilename = uniqid() . '_' . time() . '.' . $fileExtension;
            $targetFile = $targetDir . $uniqueFilename;

            // Validate file type
            $allowedTypes = ['pdf', 'jpg', 'jpeg', 'png'];
            if (!in_array($fileExtension, $allowedTypes)) {
                throw new Exception("Invalid file type. Allowed types: " . implode(', ', $allowedTypes));
            }

            // Move uploaded file
            if (!move_uploaded_file($_FILES["certification_file"]["tmp_name"], $targetFile)) {
                error_log("File upload failed. Upload info: " . print_r($_FILES["certification_file"], true));
                throw new Exception("Failed to move uploaded file");
            }

            // Begin transaction
            $this->pdo->beginTransaction();

            try {
                $stmt = $this->pdo->prepare("
                        INSERT INTO badges_certificate_list (
                            student_id,
                            certification_title,
                            certificate_categories,
                            issue_date,
                            issue_sem,
                            certification_file, 
                            certification_desc, 
                            start_date, 
                            end_date, 
                            certification_mode,
                            status
                        ) 
                        VALUES (
                            :student_id,
                            :certification_title,
                            :certificate_categories,
                            :issue_date,
                            :issue_sem,
                            :certification_file, 
                            :certification_desc, 
                            :start_date, 
                            :end_date, 
                            :certification_mode,
                            :status
                        )
                    ");

                $params = [
                    ':student_id' => $student_id,
                    ':certification_title' => $data['certification_title'],
                    ':certificate_categories' => $data['certificate_categories'],
                    ':issue_date' => $data['issue_date'],
                    ':issue_sem' => $data['issue_sem'],
                    ':certification_desc' => $data['certification_desc'],
                    ':start_date' => $data['start_date'],
                    ':end_date' => $data['end_date'],
                    ':certification_mode' => $data['certification_mode'],
                    ':certification_file' => '/public/uploads/' . $uniqueFilename,
                    ':status' => $data['status'] ?? 'pending'
                ];


                error_log("Executing SQL with params: " . print_r($params, true));
                $stmt->execute($params);

                if ($stmt->rowCount() > 0) {
                    $this->pdo->commit();
                    return ["status" => true, "message" => "Certificate uploaded successfully"];
                } else {
                    throw new Exception("Failed to insert record into database");
                }
            } catch (Exception $e) {
                $this->pdo->rollBack();
                throw $e;
            }
        } catch (Exception $e) {
            error_log("Error in storeStudentDetails: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());

            // If there was an error and we uploaded a file, remove it
            if (isset($targetFile) && file_exists($targetFile)) {
                unlink($targetFile);
            }

            return ["status" => false, "message" => $e->getMessage()];
        }
    }

//     public function getTeacherCertificates($data)
//     {
//         try {
//             $students=[];
//             $staff=getLoginSession();
//   $response = $this->badgeClassStudentsInfo1(1317);

// // First, decode the "data" string inside the response
// if ($response['status'] && isset($response['data'])) {
//     $data = json_decode($response['data'], true);  // <- decode the inner JSON

//     if (isset($data['students']) && is_array($data['students'])) {
//         $admissionNumbers = array_column($data['students'], 'admissionno');
// //         return ['status' => true, 'data' => $admissionNumbers];
//      } else {
//       return ['status' => false, 'message' => 'Decoded data missing students array'];
// //     }
// } }else {
//   return ['status' => false, 'message' => 'Invalid response from badgeClassStudentsInfo1'];
//  }

//     $placeholders = implode(',', array_fill(0, count($admissionNumbers), '?'));


            
            
            
            
            
            
//               $query = "
//         SELECT *
//         FROM badges_certificate_list
//         WHERE student_id IN ($placeholders)
//         ORDER BY created_at DESC
//     ";

//             $params = [];

//             if (!empty($data['status'])) {
//                 $query .= " AND status = :status";
//                 $params[':status'] = $data['status'];
//             }

//             if (!empty($data['search'])) {
//                 $query .= " AND certification_title LIKE :search";
//                 $params[':search'] = "%{$data['search']}%";
//             }

//             $query .= " ORDER BY created_at DESC";

//             $stmt = $this->pdo->prepare($query);
//             $stmt->execute($admissionNumbers);

//             return array(
//                 "status" => true,
//                 "data" => $stmt->fetchAll(PDO::FETCH_ASSOC)
//             );
//         } catch (Exception $e) {
//             return array(
//                 "status" => false,
//                 "message" => $e->getMessage()
//             );
//         }
//     }




public function getTeacherCertificates($data)
{
    try {
        $staff = getLoginSession();
        $response = $this->badgeClassStudentsInfo1(1317);

        if ($response['status'] && isset($response['data'])) {
            $decoded = json_decode($response['data'], true);
            if (isset($decoded['students']) && is_array($decoded['students'])) {
                $admissionNumbers = array_column($decoded['students'], 'admissionno');
            } else {
                return ['status' => false, 'message' => 'Decoded data missing students array'];
            }
        } else {
            return ['status' => false, 'message' => 'Invalid response from badgeClassStudentsInfo1'];
        }

        if (empty($admissionNumbers)) {
            return ['status' => false, 'message' => 'No students found'];
        }

        // Build placeholders for IN clause
        $placeholders = implode(',', array_fill(0, count($admissionNumbers), '?'));
        $query = "
            SELECT *
            FROM badges_certificate_list
            WHERE student_id IN ($placeholders)
        ";

        $params = $admissionNumbers;

        // Dynamic filters
        if (!empty($data['status'])) {
            $query .= " AND status = ?";
            $params[] = $data['status'];
        }

        if (!empty($data['search'])) {
            $query .= " AND certification_title LIKE ?";
            $params[] = "%" . $data['search'] . "%";
        }

        $query .= " ORDER BY created_at DESC";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);

        return [
            "status" => true,
            "data" => $stmt->fetchAll(PDO::FETCH_ASSOC)
        ];
    } catch (Exception $e) {
        return [
            "status" => false,
            "message" => $e->getMessage()
        ];
    }
}










    public function getCertificateDetails($data)
    {
        try {
            $stmt = $this->pdo->prepare("
                    SELECT *
                    FROM badges_certificate_list
                    WHERE id = :cert_id
                ");

            $stmt->execute([':cert_id' => $data['cert_id']]);
            $cert = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$cert) {
                throw new Exception("Certificate not found");
            }

            return array(
                "status" => true,
                "data" => $cert
            );
        } catch (Exception $e) {
            return array(
                "status" => false,
                "message" => $e->getMessage()
            );
        }
    }





    // public function getStudentCertificateStats()
    // {
    //     try {
    //         $studentId = $_SESSION['auth_user']['admission_no'] ?? null;
    //         if (!$studentId) {
    //             throw new Exception("Student not authenticated.");
    //         }

    //         $stmt = $this->pdo->prepare("
    //         SELECT status, COUNT(*) as count
    //         FROM badges_certificate_list 
    //         WHERE student_id = :student_id
    //         GROUP BY status
    //     ");
    //         $stmt->execute([':student_id' => $studentId]);
    //         $db_counts = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

    //         $stats = ['approved' => 0, 'pending'  => 0, 'rejected' => 0, 'reverted' => 0];

    //         // Merge DB results with defaults
    //         $finalStats = array_replace($stats, $db_counts);

    //         // Return a success response with the data
    //         return ['status' => true, 'data' => $finalStats];
    //     } catch (Exception $e) {
    //         error_log($e->getMessage());
    //         // Return a failure response with an error message
    //         return ['status' => false, 'message' => $e->getMessage()];
    //     }
    // }
    
    
public function getStudentCertificateStats()
{
    try {
        $studentId = $_SESSION['auth_user']['admission_no'] ?? null;
        if (!$studentId) {
            throw new Exception("Student not authenticated.");
        }

        // 1. Get status-wise certificate counts
        $stmt = $this->pdo->prepare("
            SELECT status, COUNT(*) as count
            FROM badges_certificate_list 
            WHERE student_id = :student_id
            GROUP BY status
        ");
        $stmt->execute([':student_id' => $studentId]);
        $db_counts = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

        $stats = ['approved' => 0, 'pending' => 0, 'rejected' => 0, 'reverted' => 0];
        $finalStats = array_replace($stats, $db_counts);
        $finalStats['total'] = array_sum($finalStats);

        // 2. Get count of assigned badges (i.e., assigned_badge_id is not null)
        $badgeStmt = $this->pdo->prepare("
            SELECT COUNT(*) 
            FROM badges_certificate_list 
            WHERE student_id = :student_id AND assigned_badge_id IS NOT NULL
        ");
        $badgeStmt->execute([':student_id' => $studentId]);
        $badgesCount = $badgeStmt->fetchColumn();

        // 3. Add badges count to the final stats
        $finalStats['badges'] = (int)$badgesCount;

        return ['status' => true, 'data' => $finalStats];
    } catch (Exception $e) {
        error_log($e->getMessage());
        return ['status' => false, 'message' => $e->getMessage()];
    }
}





    public function getStudentCertificatesByStatus($data)
    {
        try {
            $studentId = $_SESSION['auth_user']['admission_no'] ?? null;
            $status = $data['status'] ?? null;

            if (!$studentId || !$status) {
                throw new Exception("Missing student ID or status");
            }

            if ($status == "all") {
                $stmt = $this->pdo->prepare("
            SELECT * 
            FROM badges_certificate_list 
            WHERE student_id = :student_id
        ");

                $stmt->execute([
                    ':student_id' => $studentId
                ]);
            } else {
                $stmt = $this->pdo->prepare("
            SELECT * 
            FROM badges_certificate_list 
            WHERE student_id = :student_id AND status = :status
        ");

                $stmt->execute([
                    ':student_id' => $studentId,
                    ':status' => $status
                ]);
            }







            $certificates = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [
                'status' => true,
                'data' => $certificates
            ];
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
    }




    public function getBadgeCategories()
    {
        try {
            // Updated to use the correct table 'tbl_badge_categories_all' and columns 'id', 'name'.
            $stmt = $this->pdo->prepare("
            SELECT id, name,created_by_staff_name,icon_class
            FROM tbl_badge_categories 
            ORDER BY name ASC
        ");

            $stmt->execute();

            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return [
                'status' => true,
                'data' => $categories
            ];
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
    }
    
    
    
    
    
// public function getStudentBadgeCategoryStats()
// {
//     try {
//         if (!isset($_SESSION['auth_user']['checksum'])) {
//             throw new Exception("No session checksum found.");
//         }

//         // Decrypt session checksum
//         $checksum = $_SESSION['auth_user']['checksum'];
//         $_encKey = substr($checksum, -40);
//         $_encData = substr($checksum, 0, -40);
//         $_encIV = substr(sha1($_encKey), -16);
//         $decrypted = openssl_decrypt(base64_decode($_encData), "AES-256-CBC", $_encKey, 0, $_encIV);
//         $user_data = json_decode($decrypted, true);

//         if (!isset($user_data['username'])) {
//             throw new Exception($user_data['username']);
//         }

//         $stmt = $this->pdo->prepare("
//             SELECT 
//     bc.id,
//     bc.name,
//     bc.icon_class,
//     bc.created_by_staff_name,
//     COUNT(*) AS badge_count
// FROM 
//     tbl_student_badges sb
// JOIN 
//     tbl_badge_list bl ON sb.badge_id = bl.badge_id
// JOIN 
//     tbl_badge_categories bc ON bl.badge_cate_id = bc.id
// WHERE 
//     sb.student_id = ?
// GROUP BY 
//     bc.id, bc.name, bc.icon_class, bc.created_by_staff_name
// ORDER BY 
//     badge_count DESC

//         ");

//         $stmt->execute([$user_data['stud_admno']]);
//         $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

//         return [
//             'status' => true,
//             'data' => $categories
//         ];
//     } catch (Exception $e) {
//         return [
//             'status' => false,
//             'message' => 'Failed to fetch badge categories: ' . $e->getMessage()
//         ];
//     }
// }



public function getStudentBadgeCategoryStats()
{
    try {
        if (!isset($_SESSION['auth_user']['checksum'])) {
            throw new Exception("No session checksum found.");
        }

        // Decrypt session checksum
        $checksum = $_SESSION['auth_user']['checksum'];
        $_encKey = substr($checksum, -40);
        $_encData = substr($checksum, 0, -40);
        $_encIV = substr(sha1($_encKey), -16);
        $decrypted = openssl_decrypt(base64_decode($_encData), "AES-256-CBC", $_encKey, 0, $_encIV);
        $user_data = json_decode($decrypted, true);

        if (!$user_data['username']) {
            throw new Exception("Student ID not found in session.");
        }

        $stmt = $this->pdo->prepare("
            SELECT 
                bc.id AS category_id,
                bc.name AS category_name,
                bc.icon_class,
                COUNT(*) AS badge_count
            FROM 
                tbl_student_badges sb
            JOIN 
                tbl_badge_list bl ON sb.badge_id = bl.badge_id
            JOIN 
                tbl_badge_categories bc ON bl.badge_cate_id = bc.id
            WHERE 
                sb.student_id = ?
            GROUP BY 
                bc.id, bc.name, bc.icon_class
            ORDER BY 
                badge_count DESC
        ");

        $stmt->execute([$user_data['username']]);
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'status' => true,
            'data' => $categories
        ];
    } catch (Exception $e) {
        return [
            'status' => false,
            'message' => 'Failed to fetch badge categories: ' . $e->getMessage()
        ];
    }
}


    
    
    
    
    
    
    
    
    
    
    
    



    public function getBadgesStudent($data)
    {
        try {
            $studentId = $_SESSION['auth_user']['admission_no'] ?? null;
            $categoryId = $data['category_id'] ?? null;
            $status = $data['status'] ?? null;


            if (!$studentId) {
                throw new Exception("Missing student ID");
            }

            // Final query using all provided table schemas.
            // It joins student badges -> badge details -> badge categories.
            $baseQuery = "
            SELECT 
                sb.*, 
                b.badge_name,
                b.badge_description,
                b.badge_icon,
                bc.name AS category_name,
                bc.id AS category_id -- <<< ADD THIS LINE
            FROM 
                tbl_student_badges AS sb
            LEFT JOIN 
                tbl_badge_list AS b ON sb.badge_id = b.badge_id
            LEFT JOIN 
                tbl_badge_categories AS bc ON b.badge_cate_id = bc.id
            WHERE 
                sb.student_id = :student_id
                AND b.badge_status = 1
        ";

            $params = [':student_id' => $studentId];

            // Handle category filter using the category ID.
            if ($categoryId && $categoryId !== 'all') {
                $baseQuery .= " AND bc.id = :category_id";
                $params[':category_id'] = $categoryId;
            }

            // Handle status filter for the student's awarded badge status.
            if ($status && $status !== 'all') {
                $baseQuery .= " AND sb.status = :status";
                $params[':status'] = $status;
            }

            $baseQuery .= " ORDER BY sb.awarded_date DESC";

            $stmt = $this->pdo->prepare($baseQuery);
            $stmt->execute($params);

            $badges = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return [
                'status' => true,
                'data' => $badges
            ];
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
    }














    public function updateStatus($data)
    {
        try {
            if (empty($data['certificate_id'])) {
                throw new Exception('Certificate ID is required');
            }
            if (empty($data['status_action'])) {
                throw new Exception('Status action is required');
            }



            // Begin transaction
            $this->pdo->beginTransaction();

            try {
                // Convert action to status
                switch ($data['status_action']) {
                    case 'approve':
                        if (empty($data['badge_id'])) {
                            throw new Exception('Badge selection is required for approval');
                        }
                        $newStatus = 'approved';

                        // Update certificate status and store badge assignment
                        $stmt = $this->pdo->prepare("
                                UPDATE badges_certificate_list 
                                SET 
                                    status = ?,
                                    assigned_badge_id = ?,
                                    reviewed_at = NOW()
                                WHERE id = ?
                            ");

                        $stmt->execute([
                            $newStatus,
                            $data['badge_id'],
                            intval($data['certificate_id'])
                        ]);

                        // Get certificate details for student badge assignment
                        $certDetails = $this->getCertificateDetails(['cert_id' => $data['certificate_id']]);
                        if (!$certDetails['status']) {
                            throw new Exception('Failed to fetch certificate details');
                        }

                        // Insert into student badges table
                        $stmt = $this->pdo->prepare("
                                INSERT INTO tbl_student_badges (
                                    student_id,
                                    badge_id,
                                    certificate_id,
                                    awarded_staff_code,
                                    awarded_staff_name,
                                    awarded_date,
                                 
                                    status
                                ) VALUES (?, ?, ? ,? , ?, NOW(), 'active')
                            ");

                        $stmt->execute([
                            $certDetails['data']['student_id'],
                            $data['badge_id'],
                            $data['certificate_id'],
                            $_SESSION['auth_user']['staff_code'],
                            $_SESSION['auth_user']['staff_name']

                        ]);
                        break;

                    case 'reject':
                        if (empty($data['rejection_reason'])) {
                            throw new Exception('Rejection reason is required');
                        }
                        $newStatus = 'rejected';

                        // Update with rejection reason
                        $stmt = $this->pdo->prepare("
                                UPDATE badges_certificate_list 
                                SET 
                                    status = ?,
                                    rejection_reason = ?,
                                    reviewed_at = NOW()
                                WHERE id = ?
                            ");

                        $stmt->execute([
                            $newStatus,
                            trim($data['rejection_reason']),
                            intval($data['certificate_id'])
                        ]);
                        break;

                    case 'revert':
                        if (empty($data['revert_reason'])) {
                            throw new Exception('Revert reason and suggestions are required');
                        }
                        $newStatus = 'reverted';

                        // Update with revert reason and suggestions
                        $stmt = $this->pdo->prepare("
                                UPDATE badges_certificate_list 
                                SET 
                                    status = ?,
                                    revert_reason = ?,
                                    reviewed_at = NOW()
                                WHERE id = ?
                            ");

                        $stmt->execute([
                            $newStatus,
                            trim($data['revert_reason']),
                            intval($data['certificate_id'])
                        ]);
                        break;

                    default:
                        throw new Exception('Invalid status action');
                }

                if ($stmt->rowCount() === 0) {
                    throw new Exception('Certificate not found or no changes made');
                }

                // Commit the transaction
                $this->pdo->commit();

                return [
                    'status' => true,
                    'message' => 'Certificate status updated successfully'
                ];
            } catch (Exception $e) {
                // Rollback on error
                $this->pdo->rollBack();
                throw $e;
            }
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    //Admin functions
    public function createBadgeCategory($data)
    {
        try {
            // Setup for badge icon upload
            $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/public/uploads/badges/";
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }



            // return ["status" => false, "message" =>getLoginPost()];

            function getLoginPost()
            {
                if (isset($_SESSION['auth_user']['checksum'])) {
                    $_encKey = substr($_SESSION['auth_user']['checksum'], -40);
                    $_encData = substr($_SESSION['auth_user']['checksum'], 0, -40);
                    $_encIV = substr(SHA1($_encKey), -16);
                    return json_decode(openssl_decrypt(base64_decode($_encData), "AES-256-CBC", $_encKey, 0, ($_encIV)), true);
                } else {
                    return [
                        "status" => false,
                        "message" => "Failed to fetch badge categories: " . $e->getMessage()
                    ];
                }
            }
            $user_data = getLoginPost();
            // console_log("Warning: $asdasd");
            // return [
            //         "status" => true, 
            //         "message" => "Badge category created successfully", 
            //         "login" => $asdasd
            //     ];



            // Process badge icon if provided
            $imagePath = null;
            if (isset($_FILES['badge_icon']) && $_FILES['badge_icon']['error'] !== UPLOAD_ERR_NO_FILE) {
                if ($_FILES['badge_icon']['error'] !== UPLOAD_ERR_OK) {
                    error_log("Upload error code: " . $_FILES['badge_icon']['error']);
                    throw new Exception("File upload error: " . $this->getUploadErrorMessage($_FILES['badge_icon']['error']));
                }

                try {
                    $imagePath = $this->handleImageUpload($_FILES['badge_icon']);
                } catch (Exception $e) {
                    error_log("Image upload error details: " . $e->getMessage());
                    throw $e;
                }
            }

            // First check if the badge category already exists
            $checkStmt = $this->pdo->prepare("
                    SELECT badge_id FROM tbl_badge_list
                    WHERE badge_name = :badge_name
                ");
            $checkStmt->execute([':badge_name' => $data['badge_name']]);

            if ($checkStmt->rowCount() > 0) {
                throw new Exception("Badge category with this name already exists");
            }

            // Start a transaction
            $this->pdo->beginTransaction();

            // Insert the new badge category
            $stmt = $this->pdo->prepare("
                    INSERT INTO tbl_badge_list (
                        badge_name,
                        badge_description,
                        badge_icon,
                        badge_status,
                        created_by_staff_code,
                        created_by_staff_name,
                        created_by_staff_dept_code
                        
                    ) 
                    VALUES (
                        :badge_name,
                        :description,
                        :badge_icon,
                        :status,
                        :created_by_staff_code,
                        :created_by_staff_name,
                        :created_by_staff_dept_code
                    )
                ");

            $params = [
                ':badge_name' => $data['badge_name'],
                ':description' => $data['badge_description'],
                ':badge_icon' => $imagePath,
                ':status' => $data['badge_status'] ?? '0',
                ':created_by_staff_code' =>  $user_data['staff_code'],
                ':created_by_staff_name' =>  $user_data['staff_name'],
                ':created_by_staff_dept_code' =>  $user_data['dept_code'],


            ];

            $stmt->execute($params);

            $badgeId = null;
            if ($stmt->rowCount() > 0) {
                $badgeId = $this->pdo->lastInsertId();

                // If this badge was created from a request, update the request with the badge ID
                if (isset($data['from_request_id']) && !empty($data['from_request_id'])) {
                    $requestId = $data['from_request_id'];

                    // Update the badge request to link it to the created badge
                    $updateStmt = $this->pdo->prepare("
                            UPDATE tbl_badge_requests
                            SET created_badge_id = :badge_id
                            WHERE id = :request_id AND status = 'approved'
                        ");

                    $updateStmt->execute([
                        ':badge_id' => $badgeId,
                        ':request_id' => $requestId
                    ]);

                    // If no rows were affected, the request might not exist or not be approved
                    if ($updateStmt->rowCount() === 0) {
                        error_log("Warning: Could not update badge request ID $requestId with badge ID $badgeId");
                    }
                }

                // Commit the transaction
                $this->pdo->commit();

                return [
                    "status" => true,
                    "message" => "Badge category created successfully",
                    "badge_id" => $badgeId
                ];
            } else {
                // Rollback if no badge was created
                $this->pdo->rollBack();
                throw new Exception("Failed to create badge category");
            }
        } catch (Exception $e) {
            // Rollback on error
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }

            error_log($e);
            // If there was an error and we uploaded a file, remove it
            if (isset($targetFile) && file_exists($targetFile)) {
                unlink($targetFile);
            }
            return ["status" => false, "message" => $e->getMessage()];
        }
    }
    private function handleImageUpload($file)
    {
        $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/public/uploads/badges/";

        // Generate a unique file name
        $fileExt = pathinfo($file['name'], PATHINFO_EXTENSION);
        $uniqueName = uniqid('badge_', true) . '.' . strtolower($fileExt);

        $targetFile = $targetDir . $uniqueName;

        // Validate file type (optional but recommended)
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (!in_array(strtolower($fileExt), $allowedTypes)) {
            throw new Exception("Unsupported file type. Allowed types: " . implode(", ", $allowedTypes));
        }

        // Validate file size (optional)
        if ($file['size'] > 2 * 1024 * 1024) { // 2MB limit
            throw new Exception("File size exceeds 2MB limit.");
        }

        // Move uploaded file
        if (!move_uploaded_file($file['tmp_name'], $targetFile)) {
            throw new Exception("Failed to move uploaded file.");
        }

        // Return relative path to save in DB
        return "/public/uploads/badges/" . $uniqueName;
    }
    public function getBadgeList()
    {
        error_log("hi");
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM tbl_badge_list ORDER BY badge_id DESC");
            $stmt->execute();
            $badges = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log("Fetched " . count($badges) . " badge categories.");

            return [
                "status" => true,
                "badges" => $badges
            ];
        } catch (Exception $e) {
            return [
                "status" => false,
                "message" => "Failed to fetch badge categories: " . $e->getMessage()
            ];
        }
    }

    public function createBadgeRequest($data)
    {
        try {
            $authUser = $this->authUser();
            if (!$authUser || !$authUser['status']) {
                throw new Exception("User not authenticated");
            }

            $stmt = $this->pdo->prepare("
                INSERT INTO tbl_badge_requests (
                    badge_name,
                    badge_description,
                    primary_color,
                    secondary_color,
                    badge_shape,
                    badge_icon,
                    requested_by,
                    status
                ) VALUES (
                    :badge_name,
                    :description,
                    :primary_color,
                    :secondary_color,
                    :shape,
                    :icon,
                    :user_id,
                    'pending'
                )
            ");

            $params = [
                ':badge_name' => $data['badge_name'],
                ':description' => $data['badge_description'],
                ':primary_color' => $data['primary_color'],
                ':secondary_color' => $data['secondary_color'],
                ':shape' => $data['badge_shape'],
                ':icon' => $data['badge_icon'],
                ':user_id' => $authUser['staff_code']
            ];

            $stmt->execute($params);

            return [
                "status" => true,
                "message" => "Badge request submitted successfully"
            ];
        } catch (Exception $e) {
            return ["status" => false, "message" => $e->getMessage()];
        }
    }
    public function getBadgeRequests()
    {
        error_log("hi");
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM tbl_badge_requests WHERE status = 'pending' ORDER BY created_at DESC");
            $stmt->execute();
            $badges = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log("Fetched " . count($badges) . " badge categories.");

            return [
                "status" => true,
                "badges" => $badges
            ];
        } catch (Exception $e) {
            return [
                "status" => false,
                "message" => "Failed to fetch badge categories: " . $e->getMessage()
            ];
        }
    }
    public function updateBadgeRequestStatus($data)
    {
        try {
            // Validate the required fields
            if (!isset($data['id']) || !isset($data['status'])) {
                throw new Exception("Badge ID and status are required");
            }

            // Validate the status value
            $allowedStatuses = ['approved', 'rejected'];
            if (!in_array($data['status'], $allowedStatuses)) {
                throw new Exception("Invalid status value");
            }

            // Update the badge request status
            $stmt = $this->pdo->prepare("
                UPDATE tbl_badge_requests 
                SET status = :status, 
                    updated_at = NOW() 
                WHERE request_id = :id
            ");

            $params = [
                ':id' => $data['id'],
                ':status' => $data['status']
            ];

            $stmt->execute($params);

            // Check if any row was affected
            if ($stmt->rowCount() === 0) {
                throw new Exception("Badge request not found or no changes made");
            }

            // If approved, get the badge request details to return them
            if ($data['status'] === 'approved') {
                $stmt = $this->pdo->prepare("
                    SELECT * FROM tbl_badge_requests 
                    WHERE request_id = :id
                ");
                $stmt->execute([':id' => $data['id']]);
                $badgeRequest = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($badgeRequest) {
                    return [
                        "status" => true,
                        "message" => "Badge request approved successfully",
                        "badge_request" => $badgeRequest
                    ];
                }
            }

            return [
                "status" => true,
                "message" => $data['status'] === 'approved'
                    ? "Badge request approved successfully"
                    : "Badge request rejected successfully"
            ];
        } catch (Exception $e) {
            return ["status" => false, "message" => $e->getMessage()];
        }
    }


    //getCertificateCategories function for student

    public function getCertificateCategories($data)
    {
        try {
            // Optional: Auth check if needed
            $authUser = $this->authUser();
            if (!$authUser || !$authUser['status']) {
                throw new Exception("User not authenticated");
            }

            // Query active categories
            $stmt = $this->pdo->prepare("
            SELECT id, name 
            FROM tbl_certificate_categories 
            WHERE status = 1
            ORDER BY name ASC
        ");
            $stmt->execute();

            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $categories; // Direct array (not wrapped in status=>true) since your frontend expects raw array
        } catch (Exception $e) {
            error_log("Error in getCertificateCategories: " . $e->getMessage());
            return [
                "status" => false,
                "message" => "Failed to fetch categories: " . $e->getMessage()
            ];
        }
    }



    // Add new method to get available badges
    public function getAvailableBadges()
    {
        try {
            $stmt = $this->pdo->prepare("
                SELECT 
                    badge_id, 
                    badge_name, 
                    badge_description, 
                    badge_icon, 
                    badge_status
                FROM tbl_badge_list 
                WHERE badge_status = 1
                ORDER BY badge_name ASC
            ");

            $stmt->execute();
            $badges = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [
                "status" => true,
                "data" => $badges
            ];
        } catch (Exception $e) {
            return [
                "status" => false,
                "message" => $e->getMessage()
            ];
        }
    }
    
    
    
    
public function getTeacherStats()
{
    try {
        $staff = getLoginSession(); // optional, if you want to log staff usage

        // Get the students list (replace 1317 with dynamic class ID if needed)
        $response = $this->badgeClassStudentsInfo1(1317);

        if ($response['status'] && isset($response['data'])) {
            $decoded = json_decode($response['data'], true);
            if (isset($decoded['students']) && is_array($decoded['students'])) {
                $admissionNumbers = array_column($decoded['students'], 'admissionno');
            } else {
                return ['status' => false, 'message' => 'Decoded data missing students array'];
            }
        } else {
            return ['status' => false, 'message' => 'Invalid response from badgeClassStudentsInfo1'];
        }

        if (empty($admissionNumbers)) {
            return ['status' => false, 'message' => 'No students found'];
        }

        // Build placeholders and execute
        $placeholders = implode(',', array_fill(0, count($admissionNumbers), '?'));

        $stmt = $this->pdo->prepare("
            SELECT status, COUNT(*) as count
            FROM badges_certificate_list
            WHERE student_id IN ($placeholders)
            GROUP BY status
        ");
        $stmt->execute($admissionNumbers);
        $db_counts = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

        // Initialize with all possible statuses
        $stats = [
            'approved' => 0,
            'pending' => 0,
            'rejected' => 0,
            'reverted' => 0,
            'total' => 0
        ];

        // Merge fetched counts into the initialized array
        foreach ($db_counts as $status => $count) {
            $stats[$status] = $count;
            $stats['total'] += $count;
        }

        return [
            'status' => true,
            'data' => $stats
        ];
    } catch (Exception $e) {
        return [
            "status" => false,
            "message" => $e->getMessage()
        ];
    }
}

    
    
    
}
