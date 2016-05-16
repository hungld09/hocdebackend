<?php
if(!defined("FAKE_MSISDN")) define("FAKE_MSISDN", "84980000000"); //dung khi xem trailer (ko tinh thgian free 3G)
if(!defined("CPS_OK")) define("CPS_OK", "0"); //Lenh thuc hien thanh cong
if(!defined("NOK_NO_MORE_CREDIT_AVAILABLE")) define("NOK_NO_MORE_CREDIT_AVAILABLE", "401"); //Khong du tien trong tai khoan de tru
if(!defined("NOK_CPS_INVALID_REQUEST_PARAMETERS")) define("NOK_CPS_INVALID_REQUEST_PARAMETERS", "201"); //Tham so request ko hop le
if(!defined("NOK_VAS_REQUEST_FAIL")) define("NOK_VAS_REQUEST_FAIL", "202"); //VAS request fail
if(!defined("NOK_SUBSCRIBER_NOT_IN_BILLING_SYSTEM")) define("NOK_SUBSCRIBER_NOT_IN_BILLING_SYSTEM", "402"); //Subscriber kchua dc dang ky trong he thong thanh toan
if(!defined("NOK_SUBSCRIBER_NOT_EXIST")) define("NOK_SUBSCRIBER_NOT_EXIST", "403"); //Subscriber kchua dc dang ky trong he thong thanh toan
if(!defined("NOK_SUBSCRIBER_MSISDN_NOT_AVAILABLE")) define("NOK_SUBSCRIBER_MSISDN_NOT_AVAILABLE", "404"); //SO dien thoai khong ton tai
if(!defined("NOK_SUBSCRIBER_TWO_WAY_BLOCKED")) define("NOK_SUBSCRIBER_TWO_WAY_BLOCKED", "409"); //Subscriber bi khoa hai chieu
if(!defined("NOK_CPS_GENERAL_ERROR")) define("NOK_CPS_GENERAL_ERROR", "440"); 
if(!defined("NOK_SUBSCRIBER_MSISDN_CHANGE_OWNER")) define("NOK_SUBSCRIBER_MSISDN_CHANGE_OWNER", "405"); //So dien thoai thay doi ngoi dang ky
if(!defined("NOK_SUBSCRIBER_NOT_REGISTERED_SERVICE")) define("NOK_SUBSCRIBER_NOT_REGISTERED_SERVICE", "501"); //So dien thoai chua dang ky dich vu

if(!defined("NOK_BAD_PROFILE")) define("NOK_BAD_PROFILE", "CPS-1003"); //Profile khong hop le
if(!defined("NOK_BAD_ACCOUNT_STATUS")) define("NOK_BAD_ACCOUNT_STATUS", "CPS-1004"); //Trang thai thue bao khong hop le
if(!defined("NOK_EMPTY_VALUE")) define("NOK_EMPTY_VALUE", "CPS-1005"); //Tham so khong duoc de trong
if(!defined("NOK_IN_TIMED_OUT")) define("NOK_IN_TIMED_OUT", "CPS-1006"); //Thuc hien lenh timeout tren he thong IN
if(!defined("NOK_ACCOUNT_NOT_EXISTED")) define("NOK_ACCOUNT_NOT_EXISTED", "CPS-1007"); //Thue bao khong ton tai
if(!defined("NOK_COMMAND_NOT_EXISTED")) define("NOK_COMMAND_NOT_EXISTED", "CPS-1008"); //Lenh khong ton tai
if(!defined("NOK_DENIED_CREDIT_VALUE")) define("NOK_DENIED_CREDIT_VALUE", "CPS-1009"); //Gia tri tai khoan khong duoc phep
if(!defined("NOK_DENIED_PROFILE")) define("NOK_DENIED_PROFILE", "CPS-1010"); //Profile khong duoc phep su dung
if(!defined("NOK_IN_COMMAND_NOT_AVAILABLE")) define("NOK_IN_COMMAND_NOT_AVAILABLE", "CPS-1011"); //Lenh khong duoc ho tro tren IN
if(!defined("NOK_BUNDLE_NOT_EXISTED")) define("NOK_BUNDLE_NOT_EXISTED", "CPS-1012"); //Tai khoan khong ton tai
if(!defined("NOK_BAD_SYNTAX")) define("NOK_BAD_SYNTAX", "CPS-1013"); //Cau truc lenh khong dung
if(!defined("NOK_MISSING_PARAMETER")) define("NOK_MISSING_PARAMETER", "CPS-1014"); //Tham so lenh thieu
if(!defined("NOK_NO_COMMAND_PERMISSION")) define("NOK_NO_COMMAND_PERMISSION", "CPS-2001"); //User khong co quyen thuc hien lenh
if(!defined("NOK_NO_IN_COMMAND_PERMISION")) define("NOK_NO_IN_COMMAND_PERMISION", "CPS-2002"); //User khong co quyen thuc hien lenh tren IN
if(!defined("NOK_NO_USER_PERMISSION")) define("NOK_NO_USER_PERMISSION", "CPS-2003"); //User khong co quyen truy nhap he thong
if(!defined("NOK_CPS_TIMED_OUT")) define("NOK_CPS_TIMED_OUT", "CPS-2004"); //Thuc hien lenh timeout tren he thong Charging Proxy
if(!defined("NOK_NO_IN_AVAILABLE")) define("NOK_NO_IN_AVAILABLE", "CPS-2005"); //Ket noi den he thong IN khong san sang
if(!defined("NOK_USER_DOES_NOT_EXISTED")) define("NOK_USER_DOES_NOT_EXISTED", "CPS-2006"); //User khong ton tai
if(!defined("NOK_BAD_PASSWORD")) define("NOK_BAD_PASSWORD", "CPS-2007"); //Mat khau khong dung
if(!defined("NOK_EXPIRED_PASSWORD")) define("NOK_EXPIRED_PASSWORD", "CPS-2008"); //Mat khau da het han su dung
if(!defined("NOK_BAD_IPADDRESS")) define("NOK_BAD_IPADDRESS", "CPS-2009"); //IP truy nhap khong hop le
if(!defined("NOK_NO_USER_PERMISSION_AT_MOMENT")) define("NOK_NO_USER_PERMISSION_AT_MOMENT", "CPS-2010"); //User khong duoc phep truy nhap tai thoi diem nay
if(!defined("NOK_INVALID_SESSION_ID")) define("NOK_INVALID_SESSION_ID", "CPS-2011"); //Ma phien giao dich khong hop le
if(!defined("NOK_LOGIN_DENIED_BY_CPS")) define("NOK_LOGIN_DENIED_BY_CPS", "CPS-2012"); //Khong duoc phep truy nhap vao he thong CPS
if(!defined("NOK_MESSAGE_TIMED_OUT")) define("NOK_MESSAGE_TIMED_OUT", "CPS-2013"); //Message timed out
if(!defined("NOK_NO_CPS_AVAILABLE")) define("NOK_NO_CPS_AVAILABLE", "CPS-2014"); //He thong CPS chua san sang
if(!defined("NOK_EXCEEDED_MAX_CONNECTION")) define("NOK_EXCEEDED_MAX_CONNECTION", "CPS-2015"); //So luong ket noi da vuot qua so ket noi cho phep
if(!defined("NOK_UNDEFINED_ERROR")) define("NOK_UNDEFINED_ERROR", "CPS-3000"); //Loi khong xac dinh
if(!defined("NOK_IN_ERROR")) define("NOK_IN_ERROR", "CPS-3001"); //Loi tu he thong IN
if(!defined("NOK_CPS_ERROR")) define("NOK_CPS_ERROR", "CPS-3002"); //Loi tu he thong Charging Proxy
# Our add-on errors
if(!defined("NOK_CONNECTION_ERROR")) define("NOK_CONNECTION_ERROR", "CPS-9000"); //Ket noi den Charging Proxy bi loi
if(!defined("NOK_XML_ERROR")) define("NOK_XML_ERROR", "CPS-9001"); //Khong phan tich duoc tai lieu XML tra ve tu Charging Proxy

if(!defined("CHANNEL_TYPE_WEB")) define("CHANNEL_TYPE_WEB", "WEB");
if(!defined("CHANNEL_TYPE_WAP")) define("CHANNEL_TYPE_WAP", "WAP");
if(!defined("CHANNEL_TYPE_SMS")) define("CHANNEL_TYPE_SMS", "SMS");
if(!defined("CHANNEL_TYPE_APP")) define("CHANNEL_TYPE_APP", "CLIENT");
if(!defined("CHANNEL_TYPE_UNSUB")) define("CHANNEL_TYPE_UNSUB", "UNSUB");
if(!defined("CHANNEL_TYPE_CSKH")) define("CHANNEL_TYPE_CSKH", "CSKH");
if(!defined("CHANNEL_TYPE_MAXRETRY")) define("CHANNEL_TYPE_MAXRETRY", "MAXRETRY");
if(!defined("CHANNEL_TYPE_SUBNOTEXIST")) define("CHANNEL_TYPE_SUBNOTEXIST", "SUBNOTEXIST");
if(!defined("CHANNEL_TYPE_SYSTEM")) define("CHANNEL_TYPE_SYSTEM", "SYSTEM");

if(!defined("USING_TYPE_REGISTER")) define("USING_TYPE_REGISTER", 1);
if(!defined("USING_TYPE_WATCH")) define("USING_TYPE_WATCH", 2);
if(!defined("USING_TYPE_DOWNLOAD")) define("USING_TYPE_DOWNLOAD", 3);
if(!defined("USING_TYPE_SEND_GIFT")) define("USING_TYPE_SEND_GIFT", 4);
if(!defined("USING_TYPE_RECEIVE_GIFT")) define("USING_TYPE_RECEIVE_GIFT", 5);
if(!defined("USING_TYPE_EXTEND_TIME")) define("USING_TYPE_EXTEND_TIME", 6); //gia han thgian xem mien phi 3G
if(!defined("USING_TYPE_CHARGING_SMS")) define("USING_TYPE_CHARGING_SMS", 7); //thu phi 100d cho sms

if(!defined("SERVICE_PHONE_NUMBER")) define("SERVICE_PHONE_NUMBER", "1579");

define("PURCHASE_TYPE_NEW", 1);
define("PURCHASE_TYPE_RECUR", 2);
define("PURCHASE_TYPE_CANCEL", 3);
define("PURCHASE_TYPE_FORCE_CANCEL", 4);
define("PURCHASE_TYPE_EXTEND_TIME", 5); //ko dung
define("PURCHASE_TYPE_PENDING", 6); // ko dung
define("PURCHASE_TYPE_RESTORE", 7); // ko dung
define("PURCHASE_TYPE_RETRY_EXTEND", 10);

define("SERVICE_1", 4);
define("SERVICE_2", 5);
define("SERVICE_3", 6);

define("ACTION_CLICK_MOBILE_ADS", 8);
?>