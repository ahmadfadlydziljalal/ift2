<?php

namespace app\enums;

enum TextLinkEnum: string
{
    case KEMBALI = '<i class="bi bi-arrow-left-circle"></i> Kembali';
    case UPDATE = '<div class="d-flex flex-nowrap gap-1"> <i class="bi bi-pencil"></i> Update </div>';
    case PRINT = '<div class="d-flex flex-nowrap gap-1"><i class="bi bi-printer-fill"></i> Print</div>';
    case HAPUS = '<div class="d-flex flex-nowrap gap-1"><i class="bi bi-trash-fill"></i> Hapus</div>';
    case BUAT_LAGI = '<div class="d-flex flex-nowrap gap-1"><i class="bi bi-plus-circle"></i> Buat Lagi</div>';
    case LIST = '<div class="d-flex flex-nowrap gap-1"><i class="bi bi-list-ol"></i> Index</div>';
    case BUAT_FOLDER = '<div class="d-flex flex-nowrap gap-1"><i class="bi bi-folder-plus"></i> Buat Folder</div>';
    case UPLOAD_FILE = '<div class="d-flex flex-nowrap gap-1"><i class="bi bi-cloud-upload"></i> Upload File</div>';
    case DOWNLOAD = '<div class="d-flex flex-nowrap gap-1"><i class="bi bi-cloud-download"></i> Download</div>';
    case VIEW = '<div class="d-flex flex-nowrap gap-1"><i class="bi bi-eye-fill"></i> View</div>';
    case DELETE = '<div class="d-flex flex-nowrap gap-1"><i class="bi bi-trash-fill"></i> Delete</div>';
    case SEARCH = '<div class="d-flex flex-nowrap gap-1"><i class="bi bi-search"></i> Search</div>';
    case TAMBAH = '<div class="d-flex flex-nowrap gap-1"><i class="bi bi-plus-circle"></i> Tambah</div>';
}