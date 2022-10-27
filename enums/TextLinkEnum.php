<?php

namespace app\enums;

enum TextLinkEnum: string
{
    case KEMBALI = '<i class="bi bi-arrow-left-circle"></i> Kembali';
    case UPDATE = '<i class="bi bi-pencil"></i> Update';
    case PRINT = '<i class="bi bi-printer-fill"></i> Print';
    case HAPUS = '<i class="bi bi-trash-fill"></i> Hapus';
    case BUAT_LAGI = '<i class="bi bi-plus-circle"></i> Buat Lagi';
    case LIST = '<i class="bi bi-list-ol"></i> Index';
    case BUAT_FOLDER = '<i class="bi bi-folder-plus"></i> Buat Folder';
    case UPLOAD_FILE = '<i class="bi bi-cloud-upload"></i> Upload File';
    case DOWNLOAD = '<i class="bi bi-cloud-download"></i> Download';
}