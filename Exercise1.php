<?php


class MySeleniumSuite extends PHPUnit_Extensions_Selenium2TestCase {

    public function setUp() {
// Configuration  using config folder
        $this -> configHost = require __DIR__ . "/config/host.php";
        $this -> configEnvironment = require __DIR__ . "/config/environment.php";
        $this -> configUserAgent = require __DIR__ . "/config/userAgent.php";
        $this -> configWindowSize = require __DIR__ . "/config/windowSize.php";
        $this -> configCredentials = require __DIR__ . "/config/credentials.php";
// Set host,browser, port and url
        $this -> setHost($this -> configHost["host"]);
        $this -> setBrowser("chrome");
        $this -> setPort($this -> configHost["port"]);
        $this -> setBrowserUrl($this -> configEnvironment["production"]);
        $this -> assertTrue(true);
        $windowSize = $this -> configWindowSize["Desktop"];
        $userAgent = $this -> configUserAgent["Desktop"];
        $chromeOptionsArr = array(
            "args" => array(
                //'--headless',
                "--window-size=$windowSize",
                "--user-agent=$userAgent",
            ),
        );
        $param = array(
            "acceptInsecureCerts" => true,
            "chromeOptions" => $chromeOptionsArr,
            "goog:chromeOptions" => $chromeOptionsArr,
        );
        $this -> setDesiredCapabilities($param);
// Creating Test Report
        $this -> filename = __DIR__ . "/reports/test-results.html";
        $this -> fp = fopen($this -> filename, 'w');
// HTML Structure of Customized report
        $data = '<!DOCTYPE html>
<html>
    <head>
        <!-- Bootstrap core CSS-->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom fonts for this template-->
        <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <!-- Page level plugin CSS-->
        <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
        <!-- Custom styles for this template-->
        <link href="css/sb-admin.css" rel="stylesheet">
        <style>
            table {
                font-family: arial, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }

            td{
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }
            thead tr {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
                background-color: navy;
                color: white;
            }
        </style>
    </head>
    <body>
        <div class="container-fluid">
            <div class="card mb-3">
                <div class="card-header">
                    <i class=""></i>Test Results</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Scenario</th>
                                    <th>Expected Result</th>
                                    <th>Actual Result</th>
                                    <th>Status</th>
                                    <th>Screenshot</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Scenario</th>
                                    <th>Expected Result</th>
                                    <th>Actual Result</th>
                                    <th>Status</th>
                                    <th>Screenshot</th>
                                </tr>
                            </tfoot>
                            <tbody>';

        fwrite($this->fp, $data);
    }
    public function testAscenda() {

        $this -> validateMyAccount();

        $data = '</tbody></table>
                    </div>
                </div>
                <div class="card-footer small text-muted"></div>
            </div>
        </div>
        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
        <!-- Page level plugin JavaScript-->
        <script src="vendor/datatables/jquery.dataTables.js"></script>
        <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin.min.js"></script>
        <!-- Custom scripts for this page-->
        <script src="js/sb-admin-datatables.min.js"></script>
        </body>
        </html>';
        fwrite($this->fp, $data);
        fclose($this->fp);
    }

// Validate Test Scenarios
    public function validateMyAccount() {

        $this -> cookie() -> clear();
        $this -> url("/");
        $this -> login();
        $this->credentials();
        $this->userprofile();
        $this->editUserProfile();

        }

    public function login() {
        sleep(10);
        $scenario = "Validate login button";
        $expected = "present";
        $screenshot = "-";
        $loginBtn = $this -> byCssSelector("#login-signup");
        if ($loginBtn -> displayed() == true) {
            $actual = "present";
            echo "\nLogin button is displayed \n";
            $loginBtn -> click();

        } else {
            $actual = "not present";
            echo "\n\n Login button is not displayed \n";
// Create Screenshot for failed scenarios
            $timestamp = strtotime('now');
            $screenshotFile = $timestamp . ".png";
            $this -> createScreenshot($screenshotFile);
            $screenshot = "<a href=\"javascript:void(window.open('../screenshots/" . $screenshotFile . "','name','scrollbars=1,height=600,width=800'));\"><img src=\"../screenshots/" . $screenshotFile . "\" width=\"50\" height=\"50\" border=\"1\"><br>Click Here to enlarge.</a>'";
        }
        $this->writeReport($scenario, $expected, $actual, $screenshot);
    }

    public function credentials(){
          $username = $this -> configCredentials["username"];
          $password = $this -> configCredentials["password"];

          $scenario = "Validate email address";
          $expected = "present";
          $screenshot = "-";
          $email = $this->byCssSelector("#user_email");
          if($email->displayed() == true){
            $actual = "present";
            echo "\n Email textbox is present \n";
// config/credentials.php for updating $username
            $email->value($username);
          } else {
            $actual = "not present";
            echo "Email textbox is not present";
            $timestamp = strtotime('now');
            $screenshotFile = $timestamp . ".png";
            $this -> createScreenshot($screenshotFile);
            $screenshot = "<a href=\"javascript:void(window.open('../screenshots/" . $screenshotFile . "','name','scrollbars=1,height=600,width=800'));\"><img src=\"../screenshots/" . $screenshotFile . "\" width=\"50\" height=\"50\" border=\"1\"><br>Click Here to enlarge.</a>'";
          }
          $this->writeReport($scenario, $expected, $actual, $screenshot);

          $scenario = "Validate password";
          $expected = "present";
          $screenshot = "-";
          $email = $this->byCssSelector("#user_password");
          if($email->displayed() == true){
            $actual = "present";
            echo "\n Password textbox is present \n";
// config/credentials.php for updating $password
            $email->value($password);
          } else {
            $actual = "not present";
            echo "\n Password textbox is not present \n";
            $timestamp = strtotime('now');
            $screenshotFile = $timestamp . ".png";
            $this -> createScreenshot($screenshotFile);
            $screenshot = "<a href=\"javascript:void(window.open('../screenshots/" . $screenshotFile . "','name','scrollbars=1,height=600,width=800'));\"><img src=\"../screenshots/" . $screenshotFile . "\" width=\"50\" height=\"50\" border=\"1\"><br>Click Here to enlarge.</a>'";
          }
          $this->writeReport($scenario, $expected, $actual, $screenshot);
          sleep(5);
          $scenario = "Validate Login Credentials";
          $expected = "valid credentials";
          $screenshot = "-";
          $signIn = $this->byCssSelector("button.btn-action:nth-child(1)");
          $signIn->click();

          if($username === "hiqualitytester@gmail.com" && $password === "tester@1234"){
            $actual = "valid credentials";
            echo "\n Successfully login to account! \n";
          } else {
            $actual = "invalid credentials";
            echo "\n Invalid Login credentials \n";
            $timestamp = strtotime('now');
            $screenshotFile = $timestamp . ".png";
            $this -> createScreenshot($screenshotFile);
            $screenshot = "<a href=\"javascript:void(window.open('../screenshots/" . $screenshotFile . "','name','scrollbars=1,height=600,width=800'));\"><img src=\"../screenshots/" . $screenshotFile . "\" width=\"50\" height=\"50\" border=\"1\"><br>Click Here to enlarge.</a>'";
          }
          $this->writeReport($scenario, $expected, $actual, $screenshot);

    }

    public function userprofile() {
        sleep(5);
        $scenario = "Validate Myaccount button";
        $expected = "present";
        $screenshot = "-";
        $myaccount = $this->byCssSelector(".top-nav > a:nth-child(2)");
        if ($myaccount->displayed() == true) {
            $actual = "present";
            echo "\n Myaccount button is displayed \n";
            $myaccount->click();
            sleep(3);

        } else {
            $actual = "not present";
            echo "\n\n Myaccount button is not displayed \n";
            $timestamp = strtotime('now');
            $screenshotFile = $timestamp . ".png";
            $this -> createScreenshot($screenshotFile);
            $screenshot = "<a href=\"javascript:void(window.open('../screenshots/" . $screenshotFile . "','name','scrollbars=1,height=600,width=800'));\"><img src=\"../screenshots/" . $screenshotFile . "\" width=\"50\" height=\"50\" border=\"1\"><br>Click Here to enlarge.</a>'";
        }
        $this->writeReport($scenario, $expected, $actual, $screenshot);

        $scenario = "Validate Edit button";
        $expected = "present";
        $screenshot = "-";
        $editProfileBtn = $this -> byCssSelector("button.btn:nth-child(2)");
        if ($editProfileBtn->displayed() == true) {
            $actual = "present";
            echo "\n Edit Profile button is displayed \n";
            $editProfileBtn->click();
            sleep(3);

        } else {
            $actual = "not present";
            echo "\n\n Edit Profile button is not displayed \n";
            $timestamp = strtotime('now');
            $screenshotFile = $timestamp . ".png";
            $this -> createScreenshot($screenshotFile);
            $screenshot = "<a href=\"javascript:void(window.open('../screenshots/" . $screenshotFile . "','name','scrollbars=1,height=600,width=800'));\"><img src=\"../screenshots/" . $screenshotFile . "\" width=\"50\" height=\"50\" border=\"1\"><br>Click Here to enlarge.</a>'";
        }
        $this->writeReport($scenario, $expected, $actual, $screenshot);


    }

    public function editUserProfile(){

        $scenario = "Edit user title";
        $expected = "present";
        $screenshot = "-";
        $titleSelect = $this->byCssSelector("#title");
        $userTitle = $this->byCssSelector("#title > option:nth-child(3)");
        $userFname = $this->byCssSelector("#first-name");
        $userLname = $this->byCssSelector("#last-name");
        $userBirthday = $this->byCssSelector("#dob-day > option:nth-child(10)");
        $userBirthMonth = $this->byCssSelector("#dob-month > option:nth-child(6)");
        $userBirthYear = $this->byCssSelector("#dob-year > option:nth-child(10)");
        $userAddress = $this->byCssSelector("#address");
        $userCity = $this->byCssSelector("#city");
        $userZipcode = $this->byCssSelector("#zip");
        $userCountry = $this->byCssSelector("#s2id_country");
        $userCompany = $this->byCssSelector("#company");
        $userDetails = $this->byCssSelector("#company-details > input:nth-child(1)");
        $Save = $this->byCssSelector("div.clearfix:nth-child(14) > button:nth-child(1)");


        if ($titleSelect->displayed() == true) {
            $actual = "present";
            echo "\n User Title is present \n";
            $titleSelect->click();
            $userTitle->click();
            sleep(3);

        } else {
            $actual = "not present";
            echo "\n\n User Title is not present \n";
            $timestamp = strtotime('now');
            $screenshotFile = $timestamp . ".png";
            $this -> createScreenshot($screenshotFile);
            $screenshot = "<a href=\"javascript:void(window.open('../screenshots/" . $screenshotFile . "','name','scrollbars=1,height=600,width=800'));\"><img src=\"../screenshots/" . $screenshotFile . "\" width=\"50\" height=\"50\" border=\"1\"><br>Click Here to enlarge.</a>'";
        }
        $this->writeReport($scenario, $expected, $actual, $screenshot);

        if ($userFname->displayed() == true) {
            $actual = "present";
            echo "\n User First name is present \n";
            $userFname->clear();
            $userFname->value("Kaligo");
            sleep(3);

        } else {
            $actual = "not present";
            echo "\n\n User First name is not present \n";
            $timestamp = strtotime('now');
            $screenshotFile = $timestamp . ".png";
            $this -> createScreenshot($screenshotFile);
            $screenshot = "<a href=\"javascript:void(window.open('../screenshots/" . $screenshotFile . "','name','scrollbars=1,height=600,width=800'));\"><img src=\"../screenshots/" . $screenshotFile . "\" width=\"50\" height=\"50\" border=\"1\"><br>Click Here to enlarge.</a>'";
        }
        $this->writeReport($scenario, $expected, $actual, $screenshot);

        if ($userLname->displayed() == true) {
            $actual = "present";
            echo "\n User Last name is present \n";
            $userLname->clear();
            $userLname->value("Testing");
            sleep(3);

        } else {
            $actual = "not present";
            echo "\n\n User Last name is not present \n";
            $timestamp = strtotime('now');
            $screenshotFile = $timestamp . ".png";
            $this -> createScreenshot($screenshotFile);
            $screenshot = "<a href=\"javascript:void(window.open('../screenshots/" . $screenshotFile . "','name','scrollbars=1,height=600,width=800'));\"><img src=\"../screenshots/" . $screenshotFile . "\" width=\"50\" height=\"50\" border=\"1\"><br>Click Here to enlarge.</a>'";
        }
        $this->writeReport($scenario, $expected, $actual, $screenshot);

        if ($userBirthday->displayed() == true) {
            $actual = "present";
            echo "\n User Birth day is present \n";
            $userBirthday->click();
            sleep(3);

        } else {
            $actual = "not present";
            echo "\n\n User Birth name is not present \n";
            $timestamp = strtotime('now');
            $screenshotFile = $timestamp . ".png";
            $this -> createScreenshot($screenshotFile);
            $screenshot = "<a href=\"javascript:void(window.open('../screenshots/" . $screenshotFile . "','name','scrollbars=1,height=600,width=800'));\"><img src=\"../screenshots/" . $screenshotFile . "\" width=\"50\" height=\"50\" border=\"1\"><br>Click Here to enlarge.</a>'";
        }
        $this->writeReport($scenario, $expected, $actual, $screenshot);

        if ($userBirthMonth->displayed() == true) {
            $actual = "present";
            echo "\n User Birth Month is present \n";
            $userBirthMonth->click();
            sleep(3);

        } else {
            $actual = "not present";
            echo "\n\n User Birth Month is not present \n";
            $timestamp = strtotime('now');
            $screenshotFile = $timestamp . ".png";
            $this -> createScreenshot($screenshotFile);
            $screenshot = "<a href=\"javascript:void(window.open('../screenshots/" . $screenshotFile . "','name','scrollbars=1,height=600,width=800'));\"><img src=\"../screenshots/" . $screenshotFile . "\" width=\"50\" height=\"50\" border=\"1\"><br>Click Here to enlarge.</a>'";
        }
        $this->writeReport($scenario, $expected, $actual, $screenshot);

        if ($userBirthYear->displayed() == true) {
            $actual = "present";
            echo "\n User Birth Year is present \n";
            $userBirthYear->click();
            sleep(3);

        } else {
            $actual = "not present";
            echo "\n\n User Birth Year is not present \n";
            $timestamp = strtotime('now');
            $screenshotFile = $timestamp . ".png";
            $this -> createScreenshot($screenshotFile);
            $screenshot = "<a href=\"javascript:void(window.open('../screenshots/" . $screenshotFile . "','name','scrollbars=1,height=600,width=800'));\"><img src=\"../screenshots/" . $screenshotFile . "\" width=\"50\" height=\"50\" border=\"1\"><br>Click Here to enlarge.</a>'";
        }
        $this->writeReport($scenario, $expected, $actual, $screenshot);

        if ($userAddress->displayed() == true) {
            $actual = "present";
            echo "\n User Address is present \n";
            $userAddress->clear();
            $userAddress->value("Clarke Quay");
            sleep(3);

        } else {
            $actual = "not present";
            echo "\n\n User Address is not present \n";
            $timestamp = strtotime('now');
            $screenshotFile = $timestamp . ".png";
            $this -> createScreenshot($screenshotFile);
            $screenshot = "<a href=\"javascript:void(window.open('../screenshots/" . $screenshotFile . "','name','scrollbars=1,height=600,width=800'));\"><img src=\"../screenshots/" . $screenshotFile . "\" width=\"50\" height=\"50\" border=\"1\"><br>Click Here to enlarge.</a>'";
        }
        $this->writeReport($scenario, $expected, $actual, $screenshot);

        if ($userCity->displayed() == true) {
            $actual = "present";
            echo "\n User City is present \n";
            $userCity->clear();
            $userCity->value("Singapore");
            sleep(3);

        } else {
            $actual = "not present";
            echo "\n\n User City is not present \n";
            $timestamp = strtotime('now');
            $screenshotFile = $timestamp . ".png";
            $this -> createScreenshot($screenshotFile);
            $screenshot = "<a href=\"javascript:void(window.open('../screenshots/" . $screenshotFile . "','name','scrollbars=1,height=600,width=800'));\"><img src=\"../screenshots/" . $screenshotFile . "\" width=\"50\" height=\"50\" border=\"1\"><br>Click Here to enlarge.</a>'";
        }
        $this->writeReport($scenario, $expected, $actual, $screenshot);

        if ($userZipcode->displayed() == true) {
            $actual = "present";
            echo "\n User ZipCode is present \n";
            $userZipcode->clear();
            $userZipcode->value("90746");
            sleep(3);

        } else {
            $actual = "not present";
            echo "\n\n User Zipcode is not present \n";
            $timestamp = strtotime('now');
            $screenshotFile = $timestamp . ".png";
            $this -> createScreenshot($screenshotFile);
            $screenshot = "<a href=\"javascript:void(window.open('../screenshots/" . $screenshotFile . "','name','scrollbars=1,height=600,width=800'));\"><img src=\"../screenshots/" . $screenshotFile . "\" width=\"50\" height=\"50\" border=\"1\"><br>Click Here to enlarge.</a>'";
        }
        $this->writeReport($scenario, $expected, $actual, $screenshot);
        if ($userCountry->displayed() == true) {
            $actual = "present";
            echo "\n User Country is present \n";
            $userCountry->click();
            $select2Drop = $this->byCssSelector("#select2-drop > div:nth-child(1) > input:nth-child(1)");

            $select2Drop->value("Singapore");
            sleep(3);
            $select2Result = $this->byCssSelector("#select2-results-2");
            $select2Result->click();

        } else {
            $actual = "not present";
            echo "\n\n User Country is not present \n";
            $timestamp = strtotime('now');
            $screenshotFile = $timestamp . ".png";
            $this -> createScreenshot($screenshotFile);
            $screenshot = "<a href=\"javascript:void(window.open('../screenshots/" . $screenshotFile . "','name','scrollbars=1,height=600,width=800'));\"><img src=\"../screenshots/" . $screenshotFile . "\" width=\"50\" height=\"50\" border=\"1\"><br>Click Here to enlarge.</a>'";
        }
        $this->writeReport($scenario, $expected, $actual, $screenshot);

        if ($userCompany->displayed() == true) {
            $actual = "present";
            echo "\n User Company is present \n";
            $userCompany->clear();
            $userCompany->value("Ascenda");
            sleep(3);

        } else {
            $actual = "not present";
            echo "\n\n User Company is not present \n";
            $timestamp = strtotime('now');
            $screenshotFile = $timestamp . ".png";
            $this -> createScreenshot($screenshotFile);
            $screenshot = "<a href=\"javascript:void(window.open('../screenshots/" . $screenshotFile . "','name','scrollbars=1,height=600,width=800'));\"><img src=\"../screenshots/" . $screenshotFile . "\" width=\"50\" height=\"50\" border=\"1\"><br>Click Here to enlarge.</a>'";
        }
        $this->writeReport($scenario, $expected, $actual, $screenshot);

        if ($userDetails->displayed() == true) {
            $actual = "present";
            echo "\n User Company Details is present \n";
            $userDetails->clear();
            $userDetails->value("leading provider of sustainable urban development");
            sleep(3);

        } else {
            $actual = "not present";
            echo "\n\n User Company Details is not present \n";
            $timestamp = strtotime('now');
            $screenshotFile = $timestamp . ".png";
            $this -> createScreenshot($screenshotFile);
            $screenshot = "<a href=\"javascript:void(window.open('../screenshots/" . $screenshotFile . "','name','scrollbars=1,height=600,width=800'));\"><img src=\"../screenshots/" . $screenshotFile . "\" width=\"50\" height=\"50\" border=\"1\"><br>Click Here to enlarge.</a>'";
        }
        $this->writeReport($scenario, $expected, $actual, $screenshot);

        if ($Save->displayed() == true) {
            $actual = "present";
            echo "\n Save Change button is present \n";
            $Save->click();
            sleep(3);

        } else {
            $actual = "not present";
            echo "\n\n Save Change button is not present \n";
            $timestamp = strtotime('now');
            $screenshotFile = $timestamp . ".png";
            $this -> createScreenshot($screenshotFile);
            $screenshot = "<a href=\"javascript:void(window.open('../screenshots/" . $screenshotFile . "','name','scrollbars=1,height=600,width=800'));\"><img src=\"../screenshots/" . $screenshotFile . "\" width=\"50\" height=\"50\" border=\"1\"><br>Click Here to enlarge.</a>'";
        }
        $this->writeReport($scenario, $expected, $actual, $screenshot);

    }

// Error handling
    public function onNotSuccessfulTest(Throwable $e) {

        $this -> createScreenshot("thereIsError.png");
        echo $e -> getMessage() . "\n\n";
        echo $e -> getTraceAsString();
    }
// Create screenshot
    public function createScreenshot($fileName = "fileNameNotSet.png") {
        $screenshotDir = __DIR__ . "/screenshots/";
        $base64 = base64_decode($this -> screenshot());
        file_put_contents($screenshotDir . $fileName, $base64);
    }
// Validating Passed and Failed Scenarios
    public function writeReport($scenario, $expected, $actual, $screenshot) {
        if (is_bool($expected) and ( $expected == true)) {
            $expected_text = "true";
        } elseif (is_bool($expected) and ( $expected == false)) {
            $expected_text = "false";
        } else {
            $expected_text = "$expected";
        }

        if (is_bool($actual) && ($actual == true)) {
            $actual_text = "true";
        } elseif (is_bool($actual) && ($actual == false)) {
            $actual_text = "false";
        } else {
            $actual_text = $actual;
        }
        if ($expected == $actual) {
            $status = "Passed";
            $color = "#629632";
        } else {
            $status = "Failed";
            $color = "#FF0000";
        }
// Header of Customized Report
        $data = '<tr>
                               <td>' . $scenario . '</td>
                               <td>' . $expected_text . '</td>
                               <td>' . $actual_text . '</td>
                               <td><b><font color =' . $color . '>' . $status . '</font></b></td>
                               <td>' . $screenshot . '</td>
                             </tr>';

        fwrite($this->fp, $data);
    }

}

?>
