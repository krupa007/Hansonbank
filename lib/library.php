<?php

class DemoLib {
    /*
     * Register Register.php
     */

    public function Register($name, $email, $username, $password) {
        try {
            $db = DB();
            $query = $db->prepare("INSERT INTO users(name, email, username, password) VALUES (:name,:email,:username,:password)");
            $query->bindParam("name", $name, PDO::PARAM_STR);
            $query->bindParam("email", $email, PDO::PARAM_STR);
            $query->bindParam("username", $username, PDO::PARAM_STR);
            $enc_password = hash('sha256', $password);
            $query->bindParam("password", $enc_password, PDO::PARAM_STR);
            $query->execute();
            return $db->lastInsertId();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
     * Login index.php
     */

    public function Login($username, $password) {
        try {
            $db = DB();
            $query = $db->prepare("SELECT user_id FROM users WHERE (username=:username OR email=:username) AND password=:password");
            $query->bindParam("username", $username, PDO::PARAM_STR);
            $enc_password = hash('sha256', $password);
            $query->bindParam("password", $enc_password, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() === 1) {
                $result = $query->fetch(PDO::FETCH_OBJ);
                return $result->user_id;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
     * Check Username
     */

    public function isUsername($username) {
        try {
            $db = DB();
            $query = $db->prepare("SELECT user_id FROM users WHERE username=:username");
            $query->bindParam("username", $username, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
     * Check Email
     */

    public function isEmail($email) {
        try {
            $db = DB();
            $query = $db->prepare("SELECT user_id FROM users WHERE email=:email");
            $query->bindParam("email", $email, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
     * Login
     */

    public function CustomerLogin($username, $password) {
        try {
            $db = DB();
            $query = $db->prepare("SELECT user_id,name FROM hansonUsers WHERE (username=:username OR email=:username) AND password=:password");
            $query->bindParam("username", $username, PDO::PARAM_STR);
            $enc_password = hash('sha256', $password);
            $query->bindParam("password", $enc_password, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() === 1) {
                $result = $query->fetch(PDO::FETCH_ASSOC);
                $result = json_encode($result);
                $final = json_decode($result, true);
                $finalId = $final['user_id'];
                $finalUsername = $final['name'];
                $getHash = $this->insertHash($finalId);

                $bind = array("token" => $getHash, "name" => $finalUsername);
                $finalBind = json_encode($bind);
                return $finalBind;
            } else {
                return "Incorrect details";
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
     * get User Details
     */

    public function UserDetails($user_id) {
        try {
            $db = DB();
            $query = $db->prepare("SELECT user_id, name, username, email,last_login FROM users WHERE user_id=:user_id");
            $query->bindParam("user_id", $user_id, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() > 0) {
                return $query->fetch(PDO::FETCH_OBJ);
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
     * get User Details
     */

    public function CustomerDetails($user_id) {
        try {
            $db = DB();


            $query = $db->prepare("SELECT hansonCustomer.customer_id, hansonCustomer.name, hansonCustomer.type, hansonCustomer.last_login, hansonUsers.email, hansonUsers.username,hansonUsersNumbers.debitnumber,hansonUsersNumbers.creditnumber,hansonUsersNumbers.accountnumber FROM hansonCustomer INNER JOIN hansonUsers ON hansonCustomer.customer_id = hansonUsers.user_id INNER JOIN hansonUsersNumbers ON hansonUsersNumbers.user_id = hansonUsers.user_id WHERE hansonUsers.user_id = :user_id");
            $query->bindParam("user_id", $user_id, PDO::PARAM_STR);
            $query->execute();
            $getBasic = $query->fetch(PDO::FETCH_OBJ);
            $getCustomerId = $getBasic->customer_id;
            $getName = $getBasic->name;
            
            $getType = $getBasic->type;
            $getEmail = $getBasic->email;
            $getLastLogin = $getBasic->last_login;
            $getUsername = $getBasic->username;
            $getDebitNum = $getBasic->debitnumber;
            $getCreditNum = $getBasic->creditnumber;
            $getAccountNum = $getBasic->accountnumber;
            
            $getLastTransaction = $this->lastTransaction($getName);
            $decodePassbook = json_decode($getLastTransaction, true);
            $getDebit = $decodePassbook['balance'];
            $getLastTransactionCredit = $this->lastTransactionCredit($getName);
            $decodePassbookCredit = json_decode($getLastTransactionCredit, true);
            $getCredit = $decodePassbookCredit['balance'];
            $bind = Array("id" => $getCustomerId, "name" => $getName, "type" => $getType, "email" => $getEmail, "debit" => $getDebit, "credit" => $getCredit, "last_login" => $getLastLogin, "username" => $getUsername, "debitnumber" => $getDebitNum, "creditnumber" => $getCreditNum, "accountnumber" => $getAccountNum);
 
            $finalBind = json_encode($bind);



            return $finalBind;
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }



    /*
     * get User Details
     */

    public function CustomerPersonalDetails($user_id) {
        try {
            $db = DB();


            $query = $db->prepare("SELECT hansonCustomer.customer_id,hansonCustomer.name, hansonCustomer.lastname, hansonCustomer.gender, hansonCustomer.dob, hansonCustomer.address, hansonCustomer.mobile, hansonUsers.email, hansonUsers.username FROM hansonCustomer INNER JOIN hansonUsers ON hansonCustomer.customer_id = hansonUsers.user_id WHERE hansonUsers.user_id = :user_id");
            $query->bindParam("user_id", $user_id, PDO::PARAM_STR);
            $query->execute();
            $getBasic = $query->fetch(PDO::FETCH_OBJ);
            $getCustomerId = $getBasic->customer_id;
            $getName = $getBasic->name;
             $getLastName = $getBasic->lastname;
            $getGender = $getBasic->gender;
            $getDOB = $getBasic->dob;
            $getAddress = $getBasic->address;
            $getMobile = $getBasic->mobile;
            $getEmail = $getBasic->email;
            $getUsername = $getBasic->username;
           
            $bind = Array("id" => $getCustomerId, "name" => $getName, "lastname" => $getLastName, "gender" => $getGender, "dob" => $getDOB, "address" => $getAddress, "mobile" => $getMobile, "email" => $getEmail, "username" => $getUsername);
 
            $finalBind = json_encode($bind);



            return $finalBind;
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    
    
    /*
     * get User Details
     */

    public function UpdateCustomerPersonalDetails($user_id,$lastname,$gender,$dob,$address,$mobile,$email) {
        try {
            $db = DB();

     
           $query = $db->prepare("UPDATE hansonCustomer INNER JOIN hansonUsers  ON hansonCustomer.customer_id = hansonUsers.user_id SET  hansonCustomer.lastname=:lastname , hansonCustomer.gender=:gender, hansonCustomer.dob=:dob, hansonCustomer.address=:address, hansonCustomer.mobile=:mobile, hansonUsers.email=:email WHERE hansonUsers.user_id =:user_id");
           $query->bindParam("user_id", $user_id, PDO::PARAM_STR);
            $query->bindParam("lastname", $lastname, PDO::PARAM_STR);
            $query->bindParam("gender", $gender, PDO::PARAM_STR);
            $query->bindParam("dob", $dob, PDO::PARAM_STR);
            $query->bindParam("address", $address, PDO::PARAM_STR);
            $query->bindParam("mobile", $mobile, PDO::PARAM_STR);
            $query->bindParam("email", $email, PDO::PARAM_STR);
       
            $query->execute();
            return 'success';
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
    
    
    /*
     * Add to token list
     */

    public function insertHash($customer_id) {
        try {
            $db = DB();
            $token = substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(20 / strlen($x)))), 1, 20);
            $query = $db->prepare("INSERT INTO tokenOnline(token, customer_id) VALUES (:token,:customer_id)");
            $query->bindParam("token", $token, PDO::PARAM_STR);
            $query->bindParam("customer_id", $customer_id, PDO::PARAM_STR);
            $query->execute();

            return $token;
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
     * get details from token
     */

    public function checkHash($token) {
        try {
            $db = DB();

            $query = $db->prepare("SELECT customer_id FROM tokenOnline WHERE token=:token");
            $query->bindParam("token", $token, PDO::PARAM_STR);

            $query->execute();

            $raw = $query->fetch(PDO::FETCH_ASSOC);
            $result = json_encode($raw);
            $final = json_decode($result, true);
            $final_id = $final['customer_id'];
            return $final_id;
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
     * Delete token
     */

    public function deleteHash($token) {
        try {
            $db = DB();

            $query = $db->prepare("Delete FROM tokenOnline WHERE token=:token");
            $query->bindParam("token", $token, PDO::PARAM_STR);

            $query->execute();


            return 'Success';
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
     * Check Customer Username
     */

    public function isCustomerUsername($username) {
        try {
            $db = DB();
            $query = $db->prepare("SELECT customer_id FROM hansonCustomer WHERE username=:username");
            $query->bindParam("username", $username, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
     * Check Staff Email
     */

    public function isCustomerEmail($email) {
        try {
            $db = DB();
            $query = $db->prepare("SELECT user_id FROM hansonUsers WHERE email=:email");
            $query->bindParam("email", $email, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
     * Edit Delete customer main Page
     */

    public function editDeleteCustomer() {
        try {
            $db = DB();
            $query = $db->prepare("SELECT * FROM hansonCustomer order by customer_id");


            $query->execute();

            $result = $query->fetch(PDO::FETCH_OBJ);
            return $result;
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
     * Add Beneficiary
     */

    public function Add_Beneficiary($session, $receiver_name, $receiver_id, $receiver_email, $receiver_username) {
        try {

            $getName = $this->CustomerDetails($session);
            $decode = json_decode($getName, true);
            $sender = $decode['id'];

            $customer_id = $receiver_id;
            $checkBeneficiary = $this->CheckBeneficiary($sender, $receiver_id);
            if ($session == $receiver_id) {
                echo '<script>alert("You cant add yourself as a beneficiery!");';
                echo 'window.location= "AddRemoveBeneficiary.php";</script>';
            } else if ($checkBeneficiary == true) {

                echo '<script>alert("You cant add a beneficiery twice!");';
                echo 'window.location= "AddRemoveBeneficiary.php";</script>';
            } else if ($checkBeneficiary == false) {
                $getReceiverDetails = $this->CustomerDetails($receiver_id);
                $decodeReceiver = json_decode($getReceiverDetails, true);


                if ($decodeReceiver['name'] != $receiver_name) {
                    echo '<script>alert("Name Not Found!\nPlease enter correct details");';
                    echo 'window.location= "AddBeneficiary.php";</script>';
                } else if ($decodeReceiver['id'] != $receiver_id) {
                    echo '<script>alert("Account number not found!\nPlease enter correct details");';
                    echo 'window.location= "AddBeneficiary.php";</script>';
                } else if ($decodeReceiver['username'] != $receiver_username) {
                    echo '<script>alert("username not found!\nPlease enter correct details");';
                    echo 'window.location= "AddBeneficiary.php";</script>';
                } else if ($decodeReceiver['email'] != $receiver_email) {
                    echo '<script>alert("Email not found!\nPlease enter correct details");';
                    echo 'window.location= "AddBeneficiary.php";</script>';
                } else {
                    
                    echo $sender,$decodeReceiver['name'];

                    $sender_id = $decode['id'];
                    $sender_name = $decode['name'];
                    $db = DB();

                    $status = "PENDING";
                    $query = $db->prepare("INSERT INTO Beneficiary(sender_id, sender_name, receiver_id, receiver_name, status ) VALUES (:sender_id,:sender_name,:receiver_id,:receiver_name,:status)");
                    $query->bindParam("sender_id", $sender_id, PDO::PARAM_STR);
                    $query->bindParam("sender_name", $sender_name, PDO::PARAM_STR);
                    $query->bindParam("receiver_id", $receiver_id, PDO::PARAM_STR);
                    $query->bindParam("receiver_name", $receiver_name, PDO::PARAM_STR);
                    $query->bindParam("status", $status, PDO::PARAM_STR);
                    $query->execute();
                    return 'success';
                    header("location:AddRemoveBeneficiary.php");
                }
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
     * Add Staff Member
     */

    public function Add_New_Customer($name,$lastname, $gender, $dob, $type, $debit, $credit, $address, $mobile, $email, $username, $password) {
        try {
            $db = DB();
            $query = $db->prepare("INSERT INTO hansonCustomer(name,lastname, gender, dob, type, address, mobile) VALUES (:name,:lastname,:gender,:dob,:type,:address,:mobile)");
            $query->bindParam("name", $name, PDO::PARAM_STR);
             $query->bindParam("lastname", $lastname, PDO::PARAM_STR);
            $query->bindParam("gender", $gender, PDO::PARAM_STR);
            $query->bindParam("dob", $dob, PDO::PARAM_STR);
            $query->bindParam("type", $type, PDO::PARAM_STR);
            $query->bindParam("address", $address, PDO::PARAM_STR);
            $query->bindParam("mobile", $mobile, PDO::PARAM_STR);


            $queryprivate = $db->prepare("INSERT INTO hansonUsers(name, email, username, password) VALUES (:name,:email,:username,:password)");
            $queryprivate->bindParam("name", $name, PDO::PARAM_STR);
            $queryprivate->bindParam("email", $email, PDO::PARAM_STR);
            $queryprivate->bindParam("username", $username, PDO::PARAM_STR);
            $enc_password = hash('sha256', $password);
            $queryprivate->bindParam("password", $enc_password, PDO::PARAM_STR);


            $query->execute();
            $queryprivate->execute();

            //Account History Statment DB
            $queryNewPassbook = $this->newPassbook($name);
            $queryNewCreditHistory = $this->newcreditHistory($name);

            //update passbook
            $date = date("Y-m-d");
            $withdrawl = 0;
            $balance = $debit;
            $narration = 'Account Open';

            $updatePassbook = $this->UpdatePassbook($date, $name, $withdrawl, $debit, $balance, $narration);
            $debitBalance = 0;
            $creditTotalBalance = $credit;
            $updateCredit = $this->UpdateCredit($date, $name, $debitBalance, $credit, $creditTotalBalance, $narration);

            $generateNumbers = $this->generateDebitCreditAccountNumber($name);

            return 'success';
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
     * update Customer
     */

    public function Update_Customer($id, $name, $gender, $dob, $type, $debit, $credit, $address, $mobile, $email, $username) {
        try {
            $db = DB();
            $query = $db->prepare("UPDATE hansonCustomer SET name='$name', gender='$gender', dob='$dob', type='$type', debit='$debit', credit='$credit', address='$address', mobile='$mobile', email='$email', username='$username' WHERE customer_id = $id");
            $query->bindParam("name", $name, PDO::PARAM_STR);
            $query->bindParam("gender", $gender, PDO::PARAM_STR);
            $query->bindParam("dob", $dob, PDO::PARAM_STR);
            $query->bindParam("type", $type, PDO::PARAM_STR);
            $query->bindParam("debit", $debit, PDO::PARAM_STR);
            $query->bindParam("credit", $credit, PDO::PARAM_STR);
            $query->bindParam("address", $address, PDO::PARAM_STR);
            $query->bindParam("mobile", $mobile, PDO::PARAM_STR);
            $query->bindParam("email", $email, PDO::PARAM_STR);
            $query->bindParam("username", $username, PDO::PARAM_STR);
            $query->execute();
            return 'success';
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
     * create new passbook
     */

    public function newPassbook($name) {
        try {
            $db = DB();
            $query = $db->prepare("CREATE TABLE passbook_" . $name . " 
    (transactionid int(10) AUTO_INCREMENT, transactiondate date, name VARCHAR(255), withdrawl float(10,2), deposit float(10,2), balance float(10,2), narration VARCHAR(255), PRIMARY KEY (transactionid))");

            $query->execute();
            return 'success';
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
     * create new credit history
     */

    public function newcreditHistory($name) {
        try {
            $db = DB();
            $query = $db->prepare("CREATE TABLE credit_" . $name . " 
    (credittransactionid int(10) AUTO_INCREMENT, credittransactiondate date, name VARCHAR(255), debit float(10,2), credit float(10,2), balance float(10,2), narration VARCHAR(255), PRIMARY KEY (credittransactionid))");

            $query->execute();
            return 'success';
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
     * Get Beneficiary detail
     */

    private function CheckBeneficiary($sender_id, $receiver_id) {
        try {
            $db = DB();
            $query = $db->prepare("SELECT beneficiary_id FROM Beneficiary WHERE sender_id= :sender_id AND receiver_id= :receiver_id");
            $query->bindParam("sender_id", $sender_id, PDO::PARAM_STR);
            $query->bindParam("receiver_id", $receiver_id, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
     * display added beneficiary
     */

    public function viewAddedBeneficiary($session) {
        try {


            $getId = $this->CustomerDetails($session);
            $decode = json_decode($getId, true);
            $sender = $decode['id'];
            $db = DB();
            $sender_id = $sender;


            $query = $db->prepare("SELECT * FROM Beneficiary WHERE sender_id=:sender_id");
            $query->bindParam("sender_id", $sender_id, PDO::PARAM_STR);

            $query->execute();
            if ($query->rowCount() > 0) {
                $result = $query->fetchAll(PDO::FETCH_OBJ);
                return $result;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
    
    
    
    
    /*
     * display Mini Statment
     */

    public function MiniStatement($session) {
        try {
            $db = DB();


            $getName = $this->CustomerDetails($session);
            $decode = json_decode($getName, true);
            $name = $decode['name'];
            $test = "passbook_" . $name;

            $query = $db->prepare("SELECT * FROM $test WHERE name = :name LIMIT 10");
            $query->bindParam("name", $name, PDO::PARAM_STR);

            $query->execute();
            if ($query->rowCount() > 0) {
                $result = $query->fetchAll(PDO::FETCH_OBJ);
                return $result;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }



    /*
     * get shoppong requests
     */

    public function getShoppingTrack() {
        try {
            $db = DB();
            $query = $db->prepare("SELECT * FROM shoppingTrack ORDER BY id DESC;");

            $query->execute();
            if ($query->rowCount() > 0) {
                $result = $query->fetchAll(PDO::FETCH_OBJ);
                return $result;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
     * display full Statement
     */

    public function FullStatement($session, $startDate, $endDate) {
        try {
            $db = DB();


            $getName = $this->CustomerDetails($session);
            $decode = json_decode($getName, true);
            $name = $decode['name'];
            $test = "passbook_" . $name;

            $query = $db->prepare("SELECT * FROM $test WHERE transactiondate BETWEEN :startDate AND :endDate");
            $query->bindParam("startDate", $startDate, PDO::PARAM_STR);
            $query->bindParam("endDate", $endDate, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() > 0) {
                $result = $query->fetchAll(PDO::FETCH_OBJ);
                return $result;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
     * display full Statement
     */

    public function FullCreditStatement($session) {
        try {
            $db = DB();


            $getName = $this->CustomerDetails($session);
 $decode = json_decode($getName, true);
            $name = $decode['name'];
            $test = "credit_" . $name;

            $query = $db->prepare("SELECT * FROM $test ORDER BY credittransactiondate");
            $query->execute();
            if ($query->rowCount() > 0) {
                $result = $query->fetchAll(PDO::FETCH_OBJ);
                return $result;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
     * pay credit card bill
     */

    public function payCredit($session, $transferAmount) {
        try {
            $db = DB();


            $getName = $this->CustomerDetails($session);
            $decode = json_decode($getName, true);
            $name = $decode['name'];
            
            $getLastTranscation = $this->lastTransactionCredit($name);
            $decodeLastTransactionCredit = json_decode($getLastTranscation, true);
            $test = "credit_" . $name;

            $balance = $decodeLastTransactionCredit['balance'];
            $balance = $balance + $transferAmount;
            $debitbal = 0;
            $credit = $transferAmount;
            $date = date("Y-m-d");
            $narration = "Paid";
            $getRecordPassbook = $this->lastTransaction($name);
            $decodeLastTransactionPassbook = json_decode($getRecordPassbook, true);
            $getSavingsBalance = $decodeLastTransactionPassbook['balance'];
            $finalSavingsBalance = $getSavingsBalance - $transferAmount;
            $finalWithdrawalAmount = $transferAmount;
            $finalNarration = "Paid in Credit";


            $updatePassbook = $this->UpdatePassbook($date, $name, $finalWithdrawalAmount, 0, $finalSavingsBalance, $finalNarration);

            $updateCredit = $this->UpdateCredit($date, $name, $debitbal, $credit, $balance, $narration);
//        
            return TRUE;
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
     * display full Statement
     */

    public function creditDetails($session) {
        try {
            $db = DB();
            $totalCredit = 1000;

            $getName = $this->CustomerDetails($session);
            $decode = json_decode($getName, true);
            $name = $decode['name'];
            $getLastTransacion = $this->lastTransactionCredit($name);
            $decodeLast = json_decode($getLastTransacion, true);
            $availableCredit = $decodeLast['balance'];
            $balanceOwing = $totalCredit - $availableCredit;
            $result = array("totalCredit" => $totalCredit, "availableBalance" => $availableCredit, "balanceOwing" => $balanceOwing);
            $result = json_encode($result);
            return $result;
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
     * display added beneficiary
     */

    public function Transfer($session, $receiver_id, $amount) {
        try {
            $db = DB();
            
            //get sender details
            $sender_details = $this->CustomerDetails($session);
            $decode = json_decode($sender_details, true);
            $senderId = $decode['id'];
             $senderName = $decode['name'];
           
     
            //get receiver details
            $receiver_details = $this->CustomerDetails($receiver_id);
             $decodeReceiver = json_decode($receiver_details, true);
            $receiverName = $decodeReceiver['name'];
              
           
        
            //get senders last transaction from passbook
            $sender_passbookLastTransaction = $this->lastTransaction($senderName);
             $decodeSenderPassbook = json_decode($sender_passbookLastTransaction, true);
            //test senders passbook
           
            $LastSenderTotalBalance = $decodeSenderPassbook['balance'];

            if ($amount <= $LastSenderTotalBalance) {
                if ($LastSenderTotalBalance == 0 || $LastSenderTotalBalance <= 100) {
                    
                } else {

                    //get receivers last transaction from passbook
                    $receiver_passbookLastTransaction = $this->lastTransaction($receiverName);
                      $decodeReceiverPassbook = json_decode($receiver_passbookLastTransaction, true);
                    echo '</br>';
                    //test receivers passbook
                    
                    $LastReceiverTotalBalance = $decodeReceiverPassbook['balance'];
                    echo '</br>';
                    //subtract from senders passbook and 
                     $newSenderBalance = $LastSenderTotalBalance - $amount;
                     $date = date("Y-m-d");

                    //update sender passbook starts here
                    $senderWithdrawl = $amount;
                    $newSenderDeposit = 0;
                    $senderNarration = 'e-transfer(To ' . $receiverName . ')';
                    $updateSenderPassbook = $this->UpdatePassbook($date, $senderName, $senderWithdrawl, $newSenderDeposit, $newSenderBalance, $senderNarration);
                     $updateSenderPassbook;


                    //update receiver passbook starts here
                    $newReceiverBalance = $LastReceiverTotalBalance + $amount;
                    $receiverWithdrawl = 0;
                    $newreceiverDeposit = $amount;
                    $receiverNarration = 'e-transfer(By ' . $senderName . ')';
                    $updateReceiverPassbook = $this->UpdatePassbook($date, $receiverName, $receiverWithdrawl, $newreceiverDeposit, $newReceiverBalance, $receiverNarration);
                    $updateReceiverPassbook;

                
                    return;
                }
            } else {
                echo '<script>alert("Not enough balance to transfer!");';
                echo 'window.location= "customer_transfer.php";</script>';
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
     * get last transaction from passbook
     */

    public function lastTransaction($name) {
        try {

            $test = "passbook_" . $name;
            $db = DB();
            $query = $db->prepare("SELECT * FROM $test ORDER BY transactionid DESC LIMIT 1");
            $query->execute();
            if ($query->rowCount() > 0) {
                $result = $query->fetch(PDO::FETCH_OBJ);
                $transactionId = $result->transactionid;
                $transactionDate = $result->transactiondate;
                $transactionName = $result->name;
                $transactionWithdrawl = $result->withdrawl;
                $transactionDeposit = $result->deposit;
                $transactionBalance = $result->balance;

                $bind = Array("id" => $transactionId, "date" => $transactionDate, "name" => $transactionName, "withdrawl" => $transactionWithdrawl, "deposit" => $transactionDeposit, "balance" => $transactionBalance);
                $final = json_encode($bind);



                return $final;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
     * get last transaction from passbook
     */

    public function lastTransactionCredit($name) {
        try {

            $test = "credit_" . $name;
            $db = DB();
            $query = $db->prepare("SELECT * FROM $test ORDER BY credittransactionid DESC LIMIT 1");


            $query->execute();
            if ($query->rowCount() > 0) {
                $result = $query->fetch(PDO::FETCH_OBJ);
                $transactionId = $result->credittransactionid;
                $transactionDate = $result->credittransactiondate;
                $transactionName = $result->name;
                $transactionDebit = $result->debit;
                $transactionCredit = $result->credit;
                $transactionBalance = $result->balance;

                $bind = Array("id" => $transactionId, "date" => $transactionDate, "name" => $transactionName, "debit" => $transactionDebit, "credit" => $transactionCredit, "balance" => $transactionBalance);
                $final = json_encode($bind);



                return $final;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
     * update balance in passbook
     */

    public function UpdatePassbook($transactiondate, $name, $withdrawl, $deposit, $balance, $narration) {
        try {
            $test = "passbook_" . $name;
            $db = DB();
            $query = $db->prepare("INSERT INTO $test(transactiondate, name, withdrawl, deposit,balance,narration) VALUES (:transactiondate,:name,:withdrawl,:deposit,:balance,:narration)");
            $query->bindParam("transactiondate", $transactiondate, PDO::PARAM_STR);
            $query->bindParam("name", $name, PDO::PARAM_STR);
            $query->bindParam("withdrawl", $withdrawl, PDO::PARAM_STR);
            $query->bindParam("deposit", $deposit, PDO::PARAM_STR);
            $query->bindParam("balance", $balance, PDO::PARAM_STR);
            $query->bindParam("narration", $narration, PDO::PARAM_STR);
            $query->execute();
            return 'success';
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }


    /*
     * add to track shopping
     */

    public function updateShoppingTrack($date, $customername, $cardnumber, $amountpaid, $narration) {
        try {
            $db = DB();
            $query = $db->prepare("INSERT INTO shoppingTrack(date, customername, cardnumber,amountpaid,narration) VALUES (:date,:customername,:cardnumber,:amountpaid,:narration)");
            $query->bindParam("date", $date, PDO::PARAM_STR);
            $query->bindParam("customername", $customername, PDO::PARAM_STR);
            $query->bindParam("cardnumber", $cardnumber, PDO::PARAM_STR);
            $query->bindParam("amountpaid", $amountpaid, PDO::PARAM_STR);
            $query->bindParam("narration", $narration, PDO::PARAM_STR);
            $query->execute();
            return 'success';
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
     * update credit DB
     */

    public function UpdateCredit($credittransactiondate, $name, $debit, $credit, $balance, $narration) {
        try {
            $test = "credit_" . $name;
            $db = DB();
            $query = $db->prepare("INSERT INTO $test(credittransactiondate, name,debit, credit,balance,narration) VALUES (:credittransactiondate,:name,:debit,:credit,:balance,:narration)");
            $query->bindParam("credittransactiondate", $credittransactiondate, PDO::PARAM_STR);
            $query->bindParam("name", $name, PDO::PARAM_STR);
            $query->bindParam("debit", $debit, PDO::PARAM_STR);
            $query->bindParam("credit", $credit, PDO::PARAM_STR);
            $query->bindParam("balance", $balance, PDO::PARAM_STR);
            $query->bindParam("narration", $narration, PDO::PARAM_STR);
            $query->execute();
            return 'success';
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
     * get User Details
     */

    public function customerCheckPassword($user_id,$password) {
        try {
            $db = DB();
            $query = $db->prepare("SELECT user_id,name FROM hansonUsers WHERE  user_id=:user_id AND password=:password");
            $query->bindParam("user_id", $user_id, PDO::PARAM_STR);
            $enc_password = hash('sha256', $password);
            $query->bindParam("password", $enc_password, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() === 1) {
                $result = $query->fetch(PDO::FETCH_ASSOC);
                $result = json_encode($result);
                $final = json_decode($result, true);
                $finalId = $final['user_id'];
                $finalUsername = $final['name'];
                return 'success';
            } else {
                return 'fail';
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }


    /*
     * update password
     */

    public function customerUpdatePassword($user_id,$password) {
        try {
            $db = DB();
            $query = $db->prepare("UPDATE hansonUsers SET password=:password WHERE user_id =:user_id");
            $query->bindParam("user_id", $user_id, PDO::PARAM_STR);
            $enc_password = hash('sha256', $password);
            $query->bindParam("password", $enc_password, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() === 1) {
                return TRUE;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
     * Add to token list
     */

    public function generateDebitCard() {
        try {
            $db = DB();
            $len = 16;
            do{
            $tokendebit = $code=sprintf("%0".$len."d", mt_rand(1, str_pad("", $len,"9")));
            $query = $db->prepare("SELECT  tokendebit from tokenDebit where tokendebit=:tokendebit");
            $query->bindParam("tokendebit", $tokendebit, PDO::PARAM_STR);
            $query->execute();
            if($query->rowCount() == 0){
                $insertQuery = $db->prepare("INSERT INTO tokenDebit (tokendebit) VALUES (:tokendebit)");
                $insertQuery->bindParam("tokendebit", $tokendebit, PDO::PARAM_STR);
                $insertQuery->execute();
                $result = 'true';
            }else{
                $result = 'false';
            }
            } while($result ==='false');
            
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }


    /*
     * Add to token list
     */

    public function generateDebitCreditAccountNumber($name) {
        try {
            $db = DB();
            $len = 16;
            $len2 = 10;
            $expdate = "01/24";
            do{
            $debitnumber = $code=sprintf("%0".$len."d", mt_rand(1, str_pad("", $len,"9")));
            $creditnumber = $code=sprintf("%0".$len."d", mt_rand(1, str_pad("", $len,"9")));
            $accountnumber = $code=sprintf("%0".$len2."d", mt_rand(1, str_pad("", $len2,"9")));
            $cvv =  mt_rand(100,999);
            if($debitnumber == $creditnumber){
                $result = 'false';
            }else {
            $query = $db->prepare("SELECT  debitnumber,creditnumber,accountnumber from hansonUsersNumbers where debitnumber=:debitnumber or creditnumber=:creditnumber or accountnumber=:accountnumber");
            $query->bindParam("debitnumber", $debitnumber, PDO::PARAM_STR);
             $query->bindParam("creditnumber", $creditnumber, PDO::PARAM_STR);
              $query->bindParam("accountnumber", $accountnumber, PDO::PARAM_STR);

            $query->execute();
            
            if($query->rowCount() == 0){
              
                $insertQuery = $db->prepare("INSERT INTO hansonUsersNumbers (name,debitnumber,creditnumber,accountnumber,cvv,expdate) VALUES (:name,:debitnumber,:creditnumber,:accountnumber,:cvv,:expdate)");
                $insertQuery->bindParam("name", $name, PDO::PARAM_STR);
                $insertQuery->bindParam("debitnumber", $debitnumber, PDO::PARAM_STR);
                $insertQuery->bindParam("creditnumber", $creditnumber, PDO::PARAM_STR);
              $insertQuery->bindParam("accountnumber", $accountnumber, PDO::PARAM_STR);
              $insertQuery->bindParam("cvv", $cvv, PDO::PARAM_STR);
                $insertQuery->bindParam("expdate", $expdate, PDO::PARAM_STR);
                $insertQuery->execute();
        
                $result = 'true';
            }else{
                $result = 'false';
            }
        }
            } while($result ==='false');
            
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }


    /*
     * shopping checkout
     */

    public function shoppingCheckout($cardnumber,$cvv,$amount,$expiredate) {
        try {
            
           $year = date('y', strtotime($expiredate));

           $month = date('m', strtotime($expiredate));
           $expdate = $month."/".$year;
            $db = DB();
            $query = $db->prepare("SELECT * FROM hansonUsersNumbers WHERE (debitnumber=:debitnumber OR creditnumber=:creditnumber) AND cvv=:cvv");
            $query->bindParam("debitnumber", $cardnumber, PDO::PARAM_STR);
             $query->bindParam("creditnumber", $cardnumber, PDO::PARAM_STR);
            $query->bindParam("cvv", $cvv, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() === 1) {
                $result = $query->fetch(PDO::FETCH_ASSOC);
                $result = json_encode($result);
                $final = json_decode($result, true);
                
                $finalId = $final['user_id'];
                $finalUsername = $final['name'];
                 $finalDebitCard = $final['debitnumber'];
                $finalCreditCard = $final['creditnumber'];
                $finalCvv = $final['cvv'];
                $finalExpDate = $final['expdate'];
                
                if($cardnumber == $finalDebitCard){
                   
                   $getBalance = $this->lastTransaction($finalUsername);
                   $decode= json_decode($getBalance,true);
                   $balanceFromAccount = $decode['balance'];

                   if($balanceFromAccount < $amount){
                    return "not enough balance in account!!";
                }else {
                     $date = date("Y-m-d");

                    //update  passbook
                    $Balance = $balanceFromAccount - $amount;
                    $Withdrawl = $amount;
                    $Deposit = 0;
                    $Narration = 'Online Shopping(Nivin&Group)';
                    $updatePassbook = $this->UpdatePassbook($date, $finalUsername, $Withdrawl, $Deposit, $Balance, $Narration);
                    $updateShoppingTrack = $this->updateShoppingTrack($date,$finalUsername,$cardnumber,$amount,$Narration);
                    return "Success!!";
                }
                }else if($cardnumber == $finalCreditCard){
                  
                    $getBalance = $this->lastTransactionCredit($finalUsername);
                   $decode= json_decode($getBalance,true);
                   $balanceFromAccount = $decode['balance'];

                   if($balanceFromAccount < $amount){
                    return "not enough balance in account!!";
                }else {
                     $date = date("Y-m-d");
                    //update credit 
                    $Balance = $balanceFromAccount - $amount;
                    $Withdrawl = $amount;
                    $Deposit = 0;
                    $Narration = 'Online Shopping(Nivin&Group)';
                    $updatePassbook = $this->UpdateCredit($date, $finalUsername, $Withdrawl, $Deposit, $Balance, $Narration);
                    $updateShoppingTrack = $this->updateShoppingTrack($date,$finalUsername,$cardnumber,$amount,$Narration);
                    return "Success!!";

                }
                }
                
            } else {
                return "Incorrect details";
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
     * Bank request to DB
     */

    public function otherBankTransfer($email,$amount,$securityquestion,$securityanswer,$sendername,$senderemail) {
        try {
            $db = DB();
            $query = $db->prepare("SELECT name FROM hansonUsers WHERE email=:email");
            $query->bindParam("email", $email, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() === 1) {
                $result = $query->fetch(PDO::FETCH_ASSOC);
                $result = json_encode($result);
                $final = json_decode($result, true);
                
                $name = $final['name'];
                $status = 'PENDING';
                $insertQuery = $db->prepare("INSERT INTO TransferFromOther (name,email,amount,securityquestion,securityanswer,status,sendername,senderemail) VALUES (:name,:email,:amount,:securityquestion,:securityanswer,:status,:sendername,:senderemail)");
                $insertQuery->bindParam("name", $name, PDO::PARAM_STR);
                 $insertQuery->bindParam("email", $email, PDO::PARAM_STR);
                $insertQuery->bindParam("amount", $amount, PDO::PARAM_STR);
                $insertQuery->bindParam("securityquestion", $securityquestion, PDO::PARAM_STR);
              $insertQuery->bindParam("securityanswer", $securityanswer, PDO::PARAM_STR);
              $insertQuery->bindParam("status", $status, PDO::PARAM_STR);
                $insertQuery->bindParam("sendername", $sendername, PDO::PARAM_STR);
              $insertQuery->bindParam("senderemail", $senderemail, PDO::PARAM_STR);
                $insertQuery->execute();
                return 'Transfer Accepted and in Process!!';
                
            } else {
                return "Incorrect details";
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

        /*
     * pending transfer cleared
     */

    public function otherBankTransferAccept($session,$transfer_id,$sendername,$senderemail,$amount) {
        try {
            $db = DB();
           
            $receiver_details = $this->CustomerDetails($session);
             $decodeReceiver = json_decode($receiver_details, true);
            $receiverName = $decodeReceiver['name'];
              
           
        
            //get senders last transaction from passbook
            $receiver_passbookLastTransaction = $this->lastTransaction($receiverName);
             $decodeReceiverPassbook = json_decode($receiver_passbookLastTransaction, true);
            //test senders passbook
           
            $LastReceiverTotalBalance = $decodeReceiverPassbook['balance'];
           
           
             //update receiver passbook starts here
                    $date = date("Y-m-d");
                    $newReceiverBalance = $LastReceiverTotalBalance + $amount;
                    $receiverWithdrawl = 0;
                    $newreceiverDeposit = $amount;
                    $receiverNarration = 'e-transfer(By ' . $sendername . ')';
                    $updateReceiverPassbook = $this->UpdatePassbook($date, $receiverName, $receiverWithdrawl, $newreceiverDeposit, $newReceiverBalance, $receiverNarration);
                    
                    $status = "ACCEPTED";
                    $updateTranferFromOtherBank = $this->updateTransferFromOther($transfer_id,$status);

                    return 'success';
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
     * update Transfer from other
     */

    public function updateTransferFromOther($transfer_id,$status) {
        try {
           
            $db = DB();
            $query = $db->prepare("UPDATE TransferFromOther SET status=:status WHERE transfer_id =:transfer_id");
            $query->bindParam("status", $status, PDO::PARAM_STR);
            $query->bindParam("transfer_id", $transfer_id, PDO::PARAM_STR);
            $query->execute();
            return 'success';
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
}
