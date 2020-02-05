<?php
// DB Params
define('DB_HOST', 'localhost');
define('DB_USER', 'appiahmakuta');
define('DB_PASS', 'gmail300');
define('DB_NAME', 'sms');
define('DB_PARAMS', ['db' => DB_NAME, 'host'=> DB_HOST, 'username'=>DB_USER, 'password' => DB_PASS, 'charset' => 'utf8mb4']);
define('APP_ROOT', dirname(__FILE__, 2));
define('SITE_NAME', 'Nzema Monthly Report');
define('APP_NAME', 'NMR');
define('APP_VERSION', '3.0.0');
define('NAVBAR_MT', '109.516px');
define('PROFILE_PIC_DIR', URL_ROOT . '/public/assets/images/profile_pics/');
define('DATE_FORMATS', [
    'back_end' => 'Y-m-d',
    'front_end' => 'd-m-Y',
    'num_sm' => 'Y/m/d',
    'num_xs' => 'Y/n/j',
]);

const NO_PROFILE = 'no_profile.jpg';
const DEFAULT_PROFILE_PIC = 'no_profile.jpg';
const INTRANET = 'http://intranet.arlgh.com';
const DFF = 'd-m-Y';
const DFB = 'Y-m-d';
const DFF_DT = 'd-m-Y h:i a';
const DFB_DT = 'Y-m-d H:i:s';
const MEDIA_FILE_TYPES = 'image/*,  video/*, audio/*';
const PHOTO_FILE_TYPES = 'image/*';
const VIDEO_FILE_TYPES = 'video/*';
const AUDIO_FILE_TYPES = 'audio/*';
const DOC_MIME_TYPES = ['.csv', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel', 'application/msword', 'application/pdf', 'text/plain', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
const HTML_NEW_LINE = '<br/>';
const EMAIL_SUBJECT = 'Nzema Monthly Report';
const SALT = 'archangel';
const ROLE_MANAGER = 'Manager';
const ROLE_SUPERINTENDENT = 'Superintendent';
const CURRENCY_GHS = 'GH₵';
const ADMIN = [
    'Superintendent',
    'Manager'
];
const ROLE_SECRETARY = 'Secretary';
const FILE_UPLOAD_PATH = APP_ROOT . '/uploads/files';
const IMAGE_UPLOAD_PATH = APP_ROOT . '/uploads/images';
const THUMBNAIL_PATH = APP_ROOT . '/uploads/thumbnails';

// DB Table Names
const TABLE_NMR_SPREADSHEET_TEMPLATES = 'nmr_spreadsheet_templates';
const TABLE_NMR_SAVED_SPREADSHEETS = 'nmr_saved_spreadsheets';
const ICON_PATH = URL_ROOT . '/public/assets/images/icons/icons.svg';
const PAGE_TITLE_DRAFT_REPORT = 'Draft Report';
const CKFILEFINDER_CONNECTOR_PATH = "/public/assets/js/ckfinder/core/connector/php/connector.php";