<?php
//library phpqrcode
include "qrlib.php";

//direktory tempat menyimpan hasil generate qrcode jika folder belum dibuat maka secara otomatis akan membuat terlebih dahulu
$tempdir = "temp/"; 
if (!file_exists($tempdir))
    mkdir($tempdir);

    //isi QRCode saat discan
    $isi_teks = $_GET['id'];
    //direktori dan nama logo
    $logopath = 'log/mini.png';
    //namafile setelah jadi qrcode
    $namafile = "qr_".$_GET['id'].".png";
    //kualitas dan ukuran qrcode
    $quality = 'H'; 
    $ukuran = 4; 
    $padding = 0;

    QRCode::png($isi_teks,$tempdir.$namafile,QR_ECLEVEL_H,$ukuran,$padding);
    $filepath = $tempdir.$namafile;
    $QR = imagecreatefrompng($filepath);

    $logo = imagecreatefromstring(file_get_contents($logopath));
    $QR_width = imagesx($QR);
    $QR_height = imagesy($QR);

    $logo_width = imagesx($logo);
    $logo_height = imagesy($logo);

    //besar logo
    $logo_qr_width = $QR_width/2.5;
    $scale = $logo_width/$logo_qr_width;
    $logo_qr_height = $logo_height/$scale;

    //posisi logo
    imagecopyresampled($QR, $logo, $QR_width/3.3, $QR_height/2.5, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);

    imagepng($QR,$filepath);
  ?>