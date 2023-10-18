<?php
// Debugging
ini_set('error_reporting', E_ALL);

// DATABASE INFORMATION
define('DATABASE_HOST', getenv('IP'));
define('DATABASE_NAME', 'invoicemgsys');
define('DATABASE_USER', 'root');
define('DATABASE_PASS', '');

date_default_timezone_set("Africa/Juba");
$today = date("d-m-Y H:i:s");


// COMPANY INFORMATION
define('COMPANY_LOGO', 'images/Picture3.png');
define('COMPANY_LOGO_WIDTH', '300');
define('COMPANY_LOGO_HEIGHT', '90');
define('COMPANY_NAME','MEKANE HIWOT INVOICE');
define('COMPANY_ADDRESS_1','Mahta-Yie, Juba-South Sudan');
define('COMPANY_ADDRESS_2','Neemra Talata, Near MCC Building');
define('COMPANY_ADDRESS_3','kush');
define('COMPANY_COUNTY','Juba, South Sudan');
define('COMPANY_POSTCODE',' ');
define('COMPANY_SIZE_PAPER','A4');
define('COMPANY_Header','<img src="images/Picture3.png" width="100%" height="100px"/>');

//define('COMPANY_Footer','<img src="images/Picture3.png" width="100%" height="100px"/>');
//define('COMPANY_Footer','<img src="images/Picture3.png" width="100%" height="100px"/>'.$today." ".COMPANY_NAME." ".COMPANY_ADDRESS_1." ".COMPANY_COUNTY);

define('COMPANY_Footer',$today." ".COMPANY_NAME." ".COMPANY_ADDRESS_1." ".COMPANY_COUNTY);
define('COMPANY_NUMBER','Company No: +211(0)923341686'); // Company registration number
define('COMPANY_NUMBER2', 'Company No2: +211(0)917787911'); // Company TAX/VAT number


// EMAIL DETAILS
define('EMAIL_FROM', 'sales@inms.ccc'); // Email address invoice emails will be sent from
define('EMAIL_NAME', 'Invoice Mg System'); // Email from address
define('EMAIL_SUBJECT', 'Invoice default email subject'); // Invoice email subject
define('EMAIL_BODY_INVOICE', 'Invoice default body'); // Invoice email body
define('EMAIL_BODY_QUOTE', 'Quote default body'); // Invoice email body
define('EMAIL_BODY_RECEIPT', 'Receipt default body'); // Invoice email body

// OTHER SETTINFS
define('INVOICE_PREFIX', 'MD'); // Prefix at start of invoice - leave empty '' for no prefix
define('INVOICE_INITIAL_VALUE', '1'); // Initial invoice order number (start of increment)
define('INVOICE_THEME', '#222222'); // Theme colour, this sets a colour theme for the PDF generate invoice
define('TIMEZONE', 'America/Los_Angeles'); // Timezone - See for list of Timezone's http://php.net/manual/en/function.date-default-timezone-set.php
define('DATE_FORMAT', 'DD/MM/YYYY'); // DD/MM/YYYY or MM/DD/YYYY
define('CURRENCY', 'SSP'); // Currency symbol
define('DISCOUNT', 'readonly'); // Currency symbol
define('ENABLE_VAT', false); // Enable TAX/VAT
define('VAT_INCLUDED', false); // Is VAT included or excluded?
define('VAT_RATE', '10'); // This is the percentage value


define('PAYMENT_DETAILS', 'Mekane-Hiwot Invoice Mg System.<br>Location: Mahta-Yei<br>email:mekae_hiwot_123@gmail.com'); // Payment information

define('FOOTER_NOTE', 'Mekane Hiwot Patient Management System');





// CONNECT TO THE DATABASE
$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);



 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "invoicemgsys";


// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}



?>