<?php 
session_start();       //������� ������
define('TEST_SITE', TRUE);   // ������� ��������� ��� ������� ������� *.php ������ ��������.

// ���������� �������� ����� � ������

include_once('controllers/site.php');  
include_once('models/main_models.php'); 

// ������� �������� ������

$Site = new Site;




    
?>