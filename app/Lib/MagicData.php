<?php
return [
 [[0x25,0x50,0x44,0x46,0x2D],'application/pdf',0,[".pdf"]]
,[[0x7b,0x5c,0x72,0x74,0x66,0x31],'text/rtf',0,[".rtf",".doc"]]
,[[0x4d,0x53,0x57,0x6f,0x72,0x64,0x44,0x6f,0x63],'application/msword',0x840,[".doc"]]
,[[0xd0,0xcf,0x11,0xe0],[".xls"=>"application/vnd.ms-excel",".doc"=>'application/msword'],0,false]
,[[0xff,0xd8,0xff,0xe0],"image/jpeg",0,[".jpg",".jpeg"]]
,[[0xff,0xd8,0xff,0xe1],"image/jpeg",0,[".jpg",".jpeg"]]
,[[0xff,0xd8,0xff,0xfe],"image/jpeg",0,[".jpg",".jpeg"]]
,[[0x47,0x49,0x46,0x38,0x39,0x61,0x00],"image/gif",0,[".gif"]]
,[[0x42,0x4d],[".bmp"=>"image/bmp"],0,[".bmp"]]
,[[0x89,0x50,0x4e,0x47],"image/png",0,[".png"]]
,[[0x50,0x4b,0x3,0x4],[
    ".zip"=>'application/zip',
    ".odt"=>'application/vnd.oasis.opendocument.text',
    ".docx"=>"application/vnd.openxmlformats-officedocument.wordprocessingml.document",
    ".xlsx"=>"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
    ".pptx"=>"application/vnd.openxmlformats-officedocument.presentationml.presentation"],0,false]
];
?>